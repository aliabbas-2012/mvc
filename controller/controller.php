
<?php
class Controller
{
    public function render($action)
    {
        $controller = strtolower(str_replace("controller", "", strtolower(get_class($this))));
        $view_file = BASE_PATH . "/views/$controller/$action.php";
        $error404 = BASE_PATH . '/views/404.php';

        if (is_file($view_file)) {
            require_once($view_file);
        } else {
            require_once($error404);
        }
    }
    public static function renderPartial($view_path)
    {   
        $view_file = BASE_PATH . "/views/template/$view_path.php";
        require_once($view_file);
    }
}   
?>
