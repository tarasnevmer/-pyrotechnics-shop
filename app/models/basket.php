<?php
class Basket
{
    private $DB;
    public function __construct()
    {
        $this->DB = new Database();
    } 
      function get_cart_items()
    {
        $user_id = $_SESSION['user_id'];

        $query = "SELECT c.id as cart_id, p.*, c.quantity FROM products p JOIN cart c ON p.id = c.product_id WHERE c.user_id = :user_id";
        $arr['user_id'] = $user_id;
        $data = $this->DB->read($query, $arr);

        if (is_array($data)) {
            return $data;
        }

        return false;
    }

    function delete_product_in_cart()
    {
        $arr['basket_id'] = $_POST['basket_id'];

        $query = "DELETE FROM cart WHERE id = :basket_id";
        $data = $this->DB->write($query, $arr);
        $updatedData = $this->get_cart_items();
        return $updatedData;
    }

    function get_sum()
    {
        $arr['user_id'] = $_SESSION['user_id'];
        $query = "SELECT SUM(products.price * cart.quantity) AS total_sum
            FROM cart
            JOIN products ON cart.product_id = products.id
            WHERE cart.user_id = :user_id;";
        $sum = $this->DB->read($query, $arr);

        if ($sum !== false) {
            return $sum[0]->total_sum;
        } else {
            return 0;
        }
    }


    function set_quantity()
    {
        $arr['basket_id'] = $_POST['basket_id'];
        $arr['quantity'] = $_POST['input_value'];

        $query = "UPDATE cart SET quantity = :quantity WHERE id = :basket_id";
        $this->DB->write($query, $arr);

        return $arr['quantity'];
    }


    function minus_quantity()
    {
        $_SESSION['error'] = "";
        $arr['basket_id'] = $_POST['basket_id'];

        // Вибірка поточної кількості товару в корзині
        $current_quantity_query = "SELECT quantity FROM cart WHERE id = :basket_id";
        $current_quantity = $this->DB->read($current_quantity_query, $arr);
        if ($current_quantity) {
            if ($current_quantity[0]->quantity > 1) {
                $new_quantity = $current_quantity[0]->quantity - 1;

                // Оновлення кількості товару в корзині
                $update_query = "UPDATE cart SET quantity = :quantity WHERE id = :basket_id";
                $arr['quantity'] = $new_quantity;
                $this->DB->write($update_query, $arr);
                return $new_quantity;
            }
        } else {
            $_SESSION['error'] = "Не вдалося отримати поточну кількість продукту в корзині.";
            return false;
        }
    }  
    function add_quantity()
    {
        $_SESSION['error'] = "";
        $arr['basket_id'] = $_POST['basket_id'];

        // Вибірка поточної кількості товару в корзині
        $current_quantity_query = "SELECT quantity FROM cart WHERE id = :basket_id";
        $current_quantity = $this->DB->read($current_quantity_query, $arr);
        if ($current_quantity) {
            $new_quantity = $current_quantity[0]->quantity + 1;

            // Оновлення кількості товару в корзині
            $update_query = "UPDATE cart SET quantity = :quantity WHERE id = :basket_id";
            $arr['quantity'] = $new_quantity;
            $this->DB->write($update_query, $arr);
            return $new_quantity;
        } else {
            $_SESSION['error'] = "Не вдалося отримати поточну кількість продукту в корзині.";
            return false;
        }
    }

    function IsProductInCart($id)
    {
        $_SESSION['error'] = "";
        $arr['product_id'] = $id;
        $arr['user_id'] = $_SESSION['user_id'];

        $quary = "SELECT product_id FROM cart WHERE product_id = :product_id AND user_id = :user_id";
        $data = $this->DB->read($quary, $arr);
        
        if($data == false)
        {
            return true;
        }
        return false;
    }

    function add_to_cart($POST)
    {
        $_SESSION['error'] = "";

        $arr['product_id'] = $POST['id'];
        $arr['quantity'] = 1;
        $arr['user_id'] = $_SESSION['user_id'];
        if ($this->IsProductInCart($POST['id']))
        {
            $query = "INSERT INTO cart (product_id, quantity, user_id) VALUES (:product_id, :quantity, :user_id)";
            $this->DB->write($query, $arr);
            return array("IsInCart" => true);
        }
        return array("IsInCart" => false);
    }
}
