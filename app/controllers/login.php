<?php
class Login extends Controller
{
    function index()
    {
        
        $data['page_title'] = "Login";
        if(isset($_POST['email']))
        {
            $user = $this->loadModel("user");
            $user->signup($_POST);
        } 
        
        else if (isset($_POST['username']) && !isset($_POST['email'])) 
        {
            $user = $this->loadModel("user");
            $user->login($_POST);
        }
        $this->view("webstore_boom/login", $data);
    }
}
