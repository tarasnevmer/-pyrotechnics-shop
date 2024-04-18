<?php
class Contact extends Controller
{
    function index()
    {
        
        $data['page_title'] = "Контакти";
        $this->view("webstore_boom/contact", $data);
    }
}
