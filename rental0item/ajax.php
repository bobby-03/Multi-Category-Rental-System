<?php
ob_start();
$action = isset($_GET['action']) ? $_GET['action'] : '';

include 'admin_class.php';
$crud = new Action();

if($action == 'save_item'){
    $save = $crud->save_item();
    if($save) echo $save;
}
if($action == 'save_booking'){
    $save = $crud->save_booking();
    if($save) echo $save;
}
if($action == 'delete_booking'){
    $delete = $crud->delete_booking();
    if($delete) echo $delete;
}
if($action == 'complete_booking'){
    $complete = $crud->complete_booking();
    if($complete) echo $complete;
}
if($action == 'login'){
    $login = $crud->login();
    if($login) echo $login;
}
if($action == 'logout'){
    $logout = $crud->logout();
    if($logout) echo $logout;
}
if($action == 'signup'){
    $save = $crud->signup();
    if($save) echo $save;
}
if($action == 'delete_item'){
    $delete = $crud->delete_item();
    if($delete) echo $delete;
}
if($action == 'save_category'){
    $save = $crud->save_category();
    if($save) echo $save;
}
if($action == 'delete_category'){
    $save = $crud->delete_category();
    if($save) echo $save;
}
// Add this inside ajax.php
if($action == 'cancel_booking'){
    $save = $crud->cancel_booking();
    if($save) echo $save;
}
if($action == 'save_all_items_icon'){
    $save = $crud->save_all_items_icon();
    if($save) echo $save;
}
ob_end_flush();
?>