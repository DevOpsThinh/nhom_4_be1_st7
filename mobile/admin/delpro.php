<?php
    require "models/user.php";
    require "models/product.php";
    require "models/protype.php";
    require "models/manufacture.php";
    require "models/page.php";
    require "models/orders.php";
    require "models/orderdetail.php";
    $product = new Product();
    $manufacture = new Manufacture();
    $protype = new Protype();
    $user = new User();
    $order = new Order();
    $orderdetail = new Orderdetail();
    //xoa san pham
    if(isset($_GET['id']))
    {
        $id = $_GET['id'];
        $product->deleteProduct($id);
        header('location:index.php');
    }
    //xoa hang
    if(isset($_GET['manu_id']))
    {
        $manu_id = $_GET['manu_id'];
        $manuarr = $manufacture->countToTalProductOfAManu($manu_id);    
        $total = $manuarr['soLuongSanPham'];    
        if($total > 0)
        {
            echo "This Manufacture has product ! .<a href='javascript: history.go(-1)'>Go Back</a>";
        }
        else {
            $manufacture->deleteManuProduct($manu_id);
            header('location:manufactures.php');
        }        
    }
    //xoa loai
    if(isset($_GET['type_id']))
    {
        $type_id = $_GET['type_id'];
        $typearr = $protype->countToTalProductOfAType($type_id);
        $total = $typearr['soLuongSanPham'];
        if($total > 0)
        {
            echo "This Protype has product ! .<a href='javascript: history.go(-1)'>Go Back</a>";
        }
        else {
            $protype->deleteTypeProduct($type_id);
            header('location:protypes.php');
        }        
    }
    //xoa user
    if(isset($_GET['user_id']))
    {
        $user_id = $_GET['user_id'];
        $user->deleteUser($user_id);
        header('location:users.php');
    } 
    //xoa cart
    if(isset($_GET['order_id']))
    {
        $order_id = $_GET['order_id'];
        $order->delteteOrderByOrderId($order_id);
        $orderdetail->delteteOrderdetailByOrderId($order_id);
        header('location:check_order.php');
    }   
?>