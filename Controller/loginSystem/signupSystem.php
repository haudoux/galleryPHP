<?php
require_once("/var/www/html/pattern/Controller/loginSystem/loggerSingleton.php");

require_once("/var/www/html/pattern/Model/dbSingleton.php");

class signupSystem
{
    public function __construct()
    {
    }
    public function signup($username, $email, $password, $passwordRepeat, $package)
    {
        $fieldFill = empty($username) || empty($email) || empty($password) || empty($passwordRepeat);
        $properEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
        $properUsername = preg_match('/^[a-zA-Z0-9]*$/', $username);

        $check = $this->checkValues($fieldFill, $properEmail, $properUsername, $password, $passwordRepeat);

        if ($check !== true) {
            return $check;
        }

        $data = dbSingleton::getInstance()->selectSQL("SELECT uid_user FROM user WHERE uid_user=?;", array($username));

        if ($data === false) {
            loggerSingleton::getInstance()->writeLog("SQL Error ", levelLogger::ERROR);
            return "sqlerror";
        }
        if (count($data) > 0) {
            loggerSingleton::getInstance()->writeLog("Existing user ", levelLogger::DEBUG);
            return "usernametaken&email=".$email;
        }
        
        $check = $this->createUser($data, $username, $email, $password, $package);

        if ($check !== true) {
            return $check;
        }
        return "success";
    }

    private function checkValues($fieldFill, $properEmail, $properUsername, $password, $passwordRepeat)
    {
        if ($fieldFill) {
            return "emptyfields&uid=".$username."&email=".$email;
        } elseif (!$properEmail && !$properUsername) {
            return "invalidemailanduid";
        } elseif (!$properEmail) {
            return "invalidemailanduid";
        } elseif (!$properUsername) {
            return "invalidemail";
        } elseif (strcmp($password, $passwordRepeat) != 0) {
            return "passwordCheck";
        }
        return true;
    }
    private function createUser($data, $username, $email, $password, $package)
    {
        $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
        loggerSingleton::getInstance()->writeLog("Pwd hash ", levelLogger::DEBUG);
        $data = dbSingleton::getInstance()->execSQL("INSERT INTO user(uid_user, email_user, password_user, fk_package_id, fk_role_id) VALUES(?,?,?,?,3);", array($username, $email, $hashedPwd, $package));

        if (!$data) {
            return "sqlerror";
        }
        return true;
    }
}
