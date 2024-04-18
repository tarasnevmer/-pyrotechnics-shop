<?php

class Admin_table extends Controller
{
    function index()
    {

        $data['page_title'] = "Aдмін-панель";

        $admin_product = $this->loadModel("product");

        $result = $admin_product->get_all_products();

        $data['products'] = $result;

        if ($_POST['type'] == 'add_product') {
            $admin_product->add_product($_POST);
        }

        if ($_POST['type'] == 'edit_product') {
            $admin_product->edit_product($_POST);
        }
        
        if ($_POST['type2'] == 'delete_product') {
            $admin_product->delete_product($_POST);
            exit();
        }

        if ($_POST['type'] == 'search_products') {
            $data['products'] = $admin_product->search_products($_POST);
        }

        if ($_POST['type'] == 'sort_products') {
            $admin_product->sort_products($_POST['sort_field'], $_POST['sort_direction']);
        }

        if ($_POST['type'] == 'get_category_products') {
            $admin_product->get_category_products($_POST);
        }

        if ($_POST['type'] == 'get_product') {
            $product_id = $_POST['id'];
            $product_data = $admin_product->get_product_by_id($product_id);
            echo json_encode($product_data);
            exit;
        }

        ob_clean();

        json_encode($result);
        if ($_SESSION['admin'])
        {
            $this->view("webstore_boom/admin_table", $data);
        }


        exit();

    }
}
