<?php

include_once("../model/connectionDB.php");
include_once("../model/Usuario.php");
Class LogoutController{
    private $usuario;

    public function __construct() {
        $this->logout();
    }
    public function logout() {
        // Crie um objeto da classe Usuario
        $usuario = new Usuario();

        // Chame o método logout da classe Usuario
        $usuario->logout();
    }
}

new LogoutController();