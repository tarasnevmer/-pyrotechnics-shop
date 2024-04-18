<?php
class User
{
    private $DB;
    public function __construct()
    {
        $this->DB = new Database();
    }
    function login($POST)
    {

        $_SESSION['error'] = "";
        $_SESSION['admin'] = false;
        if (isset($POST['username']) && isset($POST['username'])) {


            $arr['username'] = $POST['username'];
            $password = $POST['password'];
            if ($password == ADMIN_PASSWORD_1 && $arr['username'] == ADMIN_USER_1 || 
            $password == ADMIN_PASSWORD_2 && $arr['username'] == ADMIN_USER_2)
            {
                $_SESSION['admin'] = true;
            }

            $query = "select * from users where username = :username";
            $data = $this->DB->read($query, $arr);
            if (is_array($data) && password_verify($password, $data[0]->password)) {

                $_SESSION['user_name'] = $data[0]->username;
                $_SESSION['user_url'] = $data[0]->url_address;
                $_SESSION['user_id'] = $data[0]->id;

                header("Location:" . ROOT . "home");
                die;
            } else {
                $_SESSION['error'] = "wrong username or password";
            }
        } else {
            $_SESSION['error'] = "please enter a valid username and password";
        }
    }
    function signup($POST)
    {
        $_SESSION['error'] = "";
        if (isset($POST['username']) && isset($POST['password'])) {


            $arr['username'] = $POST['username'];
            $arr['password'] = password_hash($POST['password'], PASSWORD_DEFAULT);
            $arr['email'] = $POST['email'];
            $arr['url_address'] = get_random_string_max(60);
            $arr['date'] = date("Y-m-d H:i:s");

            $query = "insert into users (username, password, email, url_address, date) values (:username, :password, :email, :url_address, :date)";
            $data = $this->DB->write($query, $arr);
            if (($data)) {
                header("Location:" . ROOT . "login");
                die;
            }
        } else {
            $_SESSION['error'] = "please enter a valid username and password";
        }
    }

    function check_logged_in()
    {
        if (isset($_SESSION['user_url'])) {

            $arr['user_url'] = $_SESSION['user_url'];

            $query = "select * from users where url_address = :user_url";
            $data = $this->DB->read($query, $arr);
            if (is_array($data)) {
                $_SESSION['user_name'] = $data[0]->username;
                $_SESSION['user_url'] = $data[0]->url_address;
                $_SESSION['user_id'] = $data[0]->id;

                return true;
            }
        }

        return false;
    }

    function logout()
    {
        unset($_SESSION['user_name']);
        unset($_SESSION['user_id']);
        unset($_SESSION['user_url']);
        unset($_SESSION['admin']);
        header("Location:" . ROOT . "home");
        die;
    }
}
