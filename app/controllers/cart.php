<?php
class Cart extends Controller
{
    function index()
    {
        $data['page_title'] = "Корзина";
        $basket = $this->loadModel("basket");
        $data['cart'] = $basket->get_cart_items();

        if ($_POST['type'] == 'add_count') {
            header('Content-Type: application/json');
            $data['quantity'] = $basket->add_quantity();
            echo json_encode(array('quantity' => $data['quantity'], 'sum' => $basket->get_sum()));
            exit();
        }
        if ($_POST['type'] == 'minus_count') {
            $data['quantity'] = $basket->minus_quantity();
            echo json_encode(array('quantity' => $data['quantity'], 'sum' => $basket->get_sum()));
            exit();
        }
        if ($_POST['type'] == 'input_count') {
            $data['quantity'] = $basket->set_quantity();
            echo json_encode(array('quantity' => $data['quantity'], 'sum' => $basket->get_sum()));
            exit();
        }

        if ($_POST['type'] == 'delete_product') {
            $data['cart'] = $basket->delete_product_in_cart();
            echo json_encode(array('cart' => $data['cart'], 'sum' => $basket->get_sum()));
            exit();
        }

        $data['sum'] = $basket->get_sum();
        $this->view("webstore_boom/cart", $data);
    }
}
