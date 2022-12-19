<?php

define("userController", new UserController());
define("loginController", new LoginController());
define("indexController", new indexController());
$router  = new Router();
$router->get("/", function () {
    indexController->dashboard();
});
$router->get("/login", function () {
    loginController->index();
});
$router->get("/signup", function () {

    indexController->signup();
});
$router->post("/login", function () {

    loginController->autohorize();
});

$router->get("/userList", function () {

    userController->userList();
});
$router->get("/user/edit", function () {
    userController->edit();
});
$router->post("/user/update", function () {
    userController->update();
});
$router->get("/user/deletePermission", function () {
    userController->deletePermission();
});
$router->post("/user/delete", function () {
    userController->delete();
});
$router->get("/signup", function () {
    userController->signup();
});
$router->post("/user/insert", function () {
    userController->insert();
});
$router->runRouter();

?>