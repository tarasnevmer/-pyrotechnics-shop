<?php
class Product
{
    private $DB;
    public function __construct()
    {
        $this->DB = new Database();
    }
    function get_all_products()
    {
        $query = "select * from products order by id";

        $data = $this->DB->read($query);
        if (is_array($data)) {
            return $data;
        }

        return false;
    }

    function get_product_by_id($id)
    {
        $query = "SELECT * FROM products WHERE id = :id";
        $arr['id'] = $id;
        $data = $this->DB->read($query, $arr);

        if (is_array($data) && count($data) > 0) {
            return $data[0];
        }

        return false;
    }

    function search_products()
    {

        $arr['name'] = "%" . $_POST['search_text'] . "%";
        $arr['category'] = "%" . $_POST['search_text'] . "%";

        $query = "SELECT * FROM products WHERE name LIKE :name OR category LIKE :category";
        $data = $this->DB->read($query, $arr);

        if (is_array($data)) {
            echo json_encode($data);
            exit;
        }

        return false;
    }


    function add_product()
    {
        $_SESSION['error'] = "";

        $arr['name'] = $_POST['name'];
        $arr['description'] = $_POST['description'];
        $arr['price'] = $_POST['price'];
        $arr['count'] = $_POST['count'];
        $arr['country'] = $_POST['country'];
        $arr['category'] = $_POST['category'];
        $arr['path_image'] = $_POST['path_image'];

        $quary = "insert into products (name, description, price, count, country, category, path_image) values (:name, :description, :price, :count, :country, :category, :path_image)";
        $data = $this->DB->write($quary, $arr);

        if (!$data) {
            $_SESSION['error'] = "error";
        } else {
            $updatedData = $this->get_all_products();
            echo json_encode($updatedData);
            exit;
        }
    }

    function delete_product()
    {
        $_SESSION['error'] = "";

        $arr['id'] = $_POST['id'];

        $quary_delete_product = "DELETE FROM products WHERE id = :id";
        $data_delete_product = $this->DB->write($quary_delete_product, $arr);

        if ($data_delete_product) {
            $quary_delete_cart = "DELETE FROM cart WHERE product_id = :id";
            $data_delete_cart = $this->DB->write($quary_delete_cart, $arr);

            if ($data_delete_cart) {
                $updatedDataProduct = $this->get_all_products();
                echo json_encode($updatedDataProduct);
                exit;
            } else {
                $_SESSION['error'] = "error";
            }
        } else {
            $_SESSION['error'] = "error";
        }
    }

    function edit_product($POST)
    {
        $_SESSION['error'] = "";

        $arr['id'] = $_POST['id'];
        $arr['name'] = $_POST['name'];
        $arr['description'] = $_POST['description'];
        $arr['price'] = $_POST['price'];
        $arr['count'] = $_POST['count'];
        $arr['country'] = $_POST['country'];
        $arr['category'] = $_POST['category'];
        $arr['path_image'] = $_POST['path_image'];

        $query = "UPDATE products SET name = :name, description = :description, 
              price = :price, count = :count, country = :country, category = :category, path_image = :path_image
              WHERE id = :id";

        $data = $this->DB->write($query, $arr);

        if (!$data) {
            $_SESSION['error'] = "error";
        } else {
            $updatedData = $this->get_all_products();
            echo json_encode($updatedData);
            exit;
        }
    }

    function sort_products($sort_field, $sort_direction)
    {
        $query = "SELECT * FROM products ORDER BY $sort_field $sort_direction";

        $data = $this->DB->read($query);

        if (!$data) {
            $_SESSION['error'] = "error";
        } else {
            echo json_encode($data);
            exit;
        }
    }

    function get_category_products()
    {
        $arr = array();
        $query = "SELECT * FROM products";
        
        if(isset($_POST['category']) && !empty($_POST['category'])) {
            $arr['category'] = $_POST['category'];
            $query .= " WHERE category = :category";
        }
    
        $data = $this->DB->read($query, $arr);
    
        if (!$data) {
            $_SESSION['error'] = "error";
        } else {
            echo json_encode($data);
            exit;
        }
    }
}
