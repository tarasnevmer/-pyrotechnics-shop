<?php
class Home extends Controller
{
    function index()
    {
        $data['page_title'] = "Головна";
        $products = $this->loadModel("product");
        $basket = $this->loadModel("basket");

        $data['products']= $products->get_all_products();
        
        if ($_POST['type'] == 'products_category')
        {
            $data['products'] = $products->get_category_products();
            
        }
        if ($_POST['type'] == 'search_products')
        {
            $data['products'] = $products->search_products();
        }

        if ($_POST['type'] == 'add_to_cart')
        {
            header('Content-Type: application/json');
            $IsInCart = $basket->add_to_cart($_POST);
            echo json_encode($IsInCart);
            exit();
        }

        
        $this->view("webstore_boom/home", $data);
    }
}