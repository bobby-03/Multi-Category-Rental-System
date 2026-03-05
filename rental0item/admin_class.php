<?php
session_start();
class Action {
    private $db;

    public function __construct() {
        ob_start();
        include 'db_connect.php';
        $this->db = $conn;
    }

    function __destruct() {
        $this->db->close();
        ob_end_flush();
    }

    function login(){
        extract($_POST);
        $qry = $this->db->query("SELECT * FROM users WHERE username = '$username' AND password = '$password' ");
        if($qry->num_rows > 0){
            $res = $qry->fetch_array();
            foreach($res as $key => $value){
                if(!is_numeric($key))
                    $_SESSION['login_'.$key] = $value;
            }
            return 1;
        } else {
            return 2;
        }
    }

    function logout(){
        session_destroy();
        foreach ($_SESSION as $key => $value) {
            unset($_SESSION[$key]);
        }
        header("location:login.php");
    }

    function signup(){
        extract($_POST);
        $chk = $this->db->query("SELECT * FROM users WHERE username = '$username' ")->num_rows;
        if($chk > 0){
            return 2;
        }
        $data = " name = '$name' ";
        $data .= ", username = '$username' ";
        $data .= ", password = '$password' ";
        $data .= ", type = 2 ";
        $save = $this->db->query("INSERT INTO users SET ".$data);
        if($save){
            $this->login();
            return 1;
        }
    }

    function save_category(){
        extract($_POST);
        $data = " name = '$name' ";
        
        if(isset($_FILES['icon']) && $_FILES['icon']['name'] != ''){
            $fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['icon']['name'];
            $move = move_uploaded_file($_FILES['icon']['tmp_name'], 'assets/uploads/'. $fname);
            if($move){
                $data .= ", category_icon = '$fname' ";
            }
        }

        if(empty($id)){
            $save = $this->db->query("INSERT INTO categories SET ".$data);
        }else{
            $save = $this->db->query("UPDATE categories SET ".$data." WHERE id = ".$id);
        }
        if($save) return 1;
    }

    function delete_category(){
        extract($_POST);
        $delete = $this->db->query("DELETE FROM categories WHERE id = ".$id);
        if($delete) return 1;
    }

    // NEW FUNCTION: Manage the "All Items" default icon
    function save_all_items_icon(){
        if(isset($_FILES['icon']) && $_FILES['icon']['name'] != ''){
            // Saves as a fixed filename to overwrite the old one
            $move = move_uploaded_file($_FILES['icon']['tmp_name'], 'assets/uploads/all_items_icon.png');
            if($move) return 1;
        }
        return 0;
    }

    function save_item(){
        extract($_POST);
        $data = " item_name = '$item_name' ";
        $data .= ", category_id = '$category_id' ";
        $data .= ", price = '$price' ";
        $data .= ", description = '$description' ";

        if(isset($_FILES['img']) && $_FILES['img']['name'] != ''){
            $fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
            $move = move_uploaded_file($_FILES['img']['tmp_name'], 'assets/uploads/'. $fname);
            if($move){
                $data .= ", image_path = '$fname' ";
            }
        }

        if(empty($id)){
            $save = $this->db->query("INSERT INTO items SET ".$data);
        }else{
            $save = $this->db->query("UPDATE items SET ".$data." WHERE id = ".$id);
        }
        if($save) return 1;
    }

    function delete_item(){
        extract($_POST);
        $delete = $this->db->query("DELETE FROM items WHERE id = ".$id);
        if($delete) return 1;
    }

    function save_booking(){
        extract($_POST);
        $user_id = isset($_SESSION['login_id']) ? $_SESSION['login_id'] : 0;
        $total_amount = $price_per_day * $days;

        $data = " item_id = '$item_id' ";
        $data .= ", user_id = '$user_id' ";
        $data .= ", customer_name = '$customer_name' ";
        $data .= ", date_start = '$date_start' ";
        $data .= ", days = '$days' ";
        $data .= ", total_amount = '$total_amount' ";
        $data .= ", status = 1 ";

        $save = $this->db->query("INSERT INTO bookings SET ".$data);
        if($save) return 1;
    }

    function delete_booking(){
        extract($_POST);
        $delete = $this->db->query("DELETE FROM bookings WHERE id = ".$id);
        if($delete) return 1;
    }

    function complete_booking(){
        extract($_POST);
        $update = $this->db->query("UPDATE bookings SET status = 2 WHERE id = ".$id);
        if($update) return 1;
    }

    // Add this inside the Action class in admin_class.php
function cancel_booking(){
    extract($_POST);
    // Security: Ensure the booking belongs to the logged-in user
    $user_id = $_SESSION['login_id'];
    $delete = $this->db->query("DELETE FROM bookings WHERE id = $id AND user_id = $user_id");
    if($delete) return 1;
   }
}
?>