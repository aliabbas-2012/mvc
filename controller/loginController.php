<?php


// /login/autohorize
class LoginController extends Controller
{

    public $userModel;
    public function __construct()
    {
        $this->userModel = new User();
    }
    public function index()
    {
        $this->renderPartial("_header");
        $this->render("login");
        $this->renderPartial("_footer");
    }
    public function autohorize()
    {

        $email = $_POST['email'];
        $pass = $_POST['pass'];

        $param = ["email" => "$email", "password" => "$pass"];
        $user = $this->userModel::login($param);
        if (isset($user->errors)) {

            $this->renderPartial("_header");
            $this->render("login");
            $this->renderPartial("_footer");
        } else {
            header('location: http://mvc.local/userList');
        }
    }
}
