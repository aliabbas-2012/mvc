<?php

// require
require_once BASE_PATH . "/config.php";
require_once BASE_PATH . "/database/DB.php";
require_once BASE_PATH . "/interfaces/validate.php";
require_once BASE_PATH . "/interfaces/crud.php";
require_once BASE_PATH . "/model/model.php";
require_once BASE_PATH . "/model/User.php";
require_once BASE_PATH . "/controller/controller.php";
require_once BASE_PATH . "/controller/indexController.php";
require_once  BASE_PATH . "/controller/loginController.php";
require_once  BASE_PATH . "/controller/UserController.php";
require_once BASE_PATH . "/router/router.php";
class bootstrap{
    public function run(){
        require_once BASE_PATH . "/routes.php";
        unset($_SESSION['user']);
        unset($_SESSION['error']);
    }
}
