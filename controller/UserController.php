<?php
// session_start();
class UserController extends Controller
{
    public $userModel;
    public function __construct()
    {
        $this->userModel = new User();
    }
    // show user list
    public function userList()
    {
        $this->renderPartial("_header");
        $this->render("userList");
        $this->renderPartial("_footer");
    }
    // show edite form
    public function edit()
    {
        $id = $_GET['id'];
        $user = User::get($id);
        $this->renderPartial("_header");
        $this->render("edit");
        $this->renderPartial("_footer");
    }
    // update user  data
    public function update()
    {
        $id = $_POST['id'];
        $name = $_POST["name"];
        $fatherName = $_POST["f_name"];
        $email = $_POST["email"];
        $pass = $_POST["pass"];
        $payload = ["name" => $name, "father_name" => $fatherName, "email" => $email, "password" => $pass];
        $user = User::get($id);
        $user->update($payload);
        if (isset($user->errors)) {
            $this->renderPartial("_header");
            $this->render("edit");
            $this->renderPartial("_footer");
        } else {
            $_SESSION['success'] = 'your data Updated successfully';
            header("location: /userList");
        }
    }
    // show delete permition model
    public function deletePermission()
    {
        $this->renderPartial("_header");
        $this->render("permission");
        $this->renderPartial("_footer");
    }
    // delete user
    public function delete()
    {
        echo $id = $_POST['id'];
        $user = User::get($id);
        $user->delete();
        $_SESSION['success'] = 'your data Deleted successfully';
        header('location: /userList');
    }
    // show signup form
    public function signup()
    {
        $this->renderPartial("_header");
        $this->render("signup");
        $this->renderPartial("_footer");
    }
    public function insert()
    {
        $user = new User;
        $name = $_POST["name"];
        $fatherName = $_POST["f_name"];
        $email = $_POST["email"];
        $pass = $_POST["pass"];
        $payload = ["name" => $name, "father_name" => $fatherName, "email" => $email, "password" => $pass];
        $user->create($payload);
        if (isset($user->errors)) {
            $this->renderPartial("_header");
            $this->render("signup");
            $this->renderPartial("_footer");
        } else {
            header('location: /login');
            $_SESSION['name'] = $name;
        }
    }
}
