<?php
class About extends Controller
{
    function index()
    {
        $data['page_title'] = "Про нас";
        $this->view("webstore_boom/about-us", $data);
    }

}
