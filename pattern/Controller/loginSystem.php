<?php
require_once("/var/www/html/pattern/Controller/loggerSingleton.php");
require_once("/var/www/html/pattern/Model/dbSingleton.php");
require_once("/var/www/html/pattern/Controller/loginSystemInterface.php");

class loginSystem implements Ilogin
{
    public function __construct()
    {
    }
    public function logUser($username, $password)
    {
        $userData = $this->checkUser($username);
        if (gettype($userData) != "array") {
            return $userData;
        }
        $passwordToVerify   = $userData['password_user'][0];
        $id_user            = $userData['id_user'][0];
        $uid_user            = $userData['uid_user'][0];
        $role            = $userData['fk_role_id'][0];
        loggerSingleton::getInstance()->writeLog(print_r("USERDATA", true), levelLogger::DEBUG);

        loggerSingleton::getInstance()->writeLog(print_r($passwordToVerify, true), levelLogger::DEBUG);
        loggerSingleton::getInstance()->writeLog(print_r($password, true), levelLogger::DEBUG);
        $this->checkPassword($passwordToVerify, $password, $id_user, $uid_user, $role);
        return "success";
    }
    private function checkUser($username)
    {
        loggerSingleton::getInstance()->writeLog("Check user :".print_r($username, true), levelLogger::DEBUG);
        $data = dbSingleton::getInstance()->selectSQL("SELECT uid_user, id_user, fk_role_id, password_user FROM user WHERE uid_user=? OR email_user=?;", array($username,$username));
        if ($data === false) {
            loggerSingleton::getInstance()->writeLog("Login error :".print_r($data, true), levelLogger::DEBUG);
            return "sqlerror";
        } else {
            loggerSingleton::getInstance()->writeLog("Get data successfuly :".print_r($data, true), levelLogger::DEBUG);
        }
        return $data;
    }

    private function checkPassword($pwdToVerify, $userPassword, $id_user, $uid_user, $role)
    {
        $pwdCheck = password_verify($userPassword, $pwdToVerify);
        if ($pwdCheck === false) {
            loggerSingleton::getInstance()->writeLog("Error password ", levelLogger::DEBUG);
            return "nouser";
        } elseif ($pwdCheck == true) {
            loggerSingleton::getInstance()->writeLog("New user connected ", levelLogger::INFO);
            session_start();
            $_SESSION['userId']     = $id_user;
            $_SESSION['userUid']    = $uid_user;
            $_SESSION['role']       = $role;
            return "success";
        }
        return "chkpwd";
    }
}
