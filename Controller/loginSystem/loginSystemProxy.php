<?php

require_once("/var/www/html/pattern/Controller/loginSystem/loginSystemInterface.php");
require_once("/var/www/html/pattern/Controller/loginSystem/loginSystem.php");

class proxyLogin implements Ilogin
{
    private $login = null;

    public function __construct()
    {
        $this->login = new loginSystem();
    }

    public function logUser($username, $password)
    {
        $this->login->logUser($username, $password);
    }
}
