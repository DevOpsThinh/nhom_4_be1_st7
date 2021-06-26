<?php
class Product extends Db{
    //Viet phuong thuc lay ra tat ca san pham noi bat, dung o index
    function getAllFeatureProducts($current_page,$perpage){
        $firstLink = (($current_page - 1) * $perpage); 
        $sql = self::$connection->prepare("SELECT * FROM `products` LIMIT $firstLink,$perpage");
        $sql->execute();//return an object
        $items = array();
        $items = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $items; 
    }
    //lay tat ca san pham, dung o cate
    function getAllProTypeProducts(){ 
        $sql = self::$connection->prepare("SELECT * FROM `products`");
        $sql->execute();//return an object
        $items = array();
        $items = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $items;        
    }   
    //viet phuong thuc lay tat ca san pham, dung cho user
    function getAllManufacTypesProducts($current_page,$perpage){
        $firstLink = (($current_page - 1) * $perpage); 
        $sql = self::$connection->prepare("SELECT * FROM `products`,`manufactures`,`protypes` WHERE products.manu_id = manufactures.manu_id AND products.type_id = protypes.type_id ORDER BY created_at DESC LIMIT $firstLink,$perpage");
        $sql->execute();//return an object
        $items = array();
        $items = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $items; 
    }  
    //lay san pham bang id
    function getProductById($id) {
        $sql = self::$connection->prepare("SELECT * FROM products,manufactures WHERE products.manu_id = manufactures.manu_id AND products.id = $id");
        $sql->execute();
        $items = array();
        $items = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $items;
    } 
    //lay san pham thong qua id, dung o insertcard
    function getProductCartById($id){
        $sql = "SELECT * FROM products,protypes,manufactures WHERE products.manu_id = manufactures.manu_id AND products.type_id = protypes.type_id And products.id = $id";
        $item = mysqli_query(self::$connection,$sql); 
        $item1 = mysqli_fetch_assoc($item);
        return $item1;
    }
    //lay so luong san pham noi bat, dung o index
    function getTotalOfProductFeature(){
        $sql = "SELECT COUNT(id) as total FROM `products`";
        $items = mysqli_query(self::$connection,$sql);
        $items1 = mysqli_fetch_assoc($items);
        return $items1;
    }
    //xuat san pham thong qua hang, gioi han 3 san pham 1 trang
    function findProductByFactureName($current_page,$perpage,$key){  
        $firstLink = (($current_page - 1) * $perpage);       
        $sql = self::$connection->prepare("SELECT * FROM `products`,`manufactures`,protypes WHERE products.manu_id = manufactures.manu_id AND products.type_id = protypes.type_id And manufactures.manu_name LIKE '%$key%' LIMIT $firstLink,$perpage");
        $sql->execute();
        $items = array();
        $items = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        return $items;
    }
    //thong qua loai
    //thong qua ten sp
    //lay so luong san pham tim duoc.
    function getTotalOfProductByFacName($key){
        $sql = "SELECT COUNT(products.id) as total FROM `products`,manufactures WHERE products.manu_id = manufactures.manu_id AND manufactures.manu_name LIKE '%$key%'";
        $items = mysqli_query(self::$connection,$sql);
        $items1 = mysqli_fetch_assoc($items);
        return $items1;
    }
    //xoa san pham = id , dung o user
    function deleteProduct($id)
    {
        $sql = self::$connection->prepare("DELETE FROM products WHERE products.id = $id");
        $sql->execute();
    }
    //them san pham moi 
    function addProduct($name,$manu_id,$type_id,$price,$pro_image,$description,$feature,$date)
    {
        $sql = self::$connection->prepare("INSERT INTO products(name,manu_id,type_id,price,pro_image,description,feature,created_at) VALUES('$name','$manu_id','$type_id','$price','$pro_image','$description','$feature','$date')");
        $sql->execute();
    }
    //update product
    function updateProduct($id,$name,$manu_id,$type_id,$price,$pro_image,$description,$feature,$date)
    {
        $sql = self::$connection->prepare("UPDATE products SET name = '$name',manu_id = '$manu_id',type_id = '$type_id',price = '$price',pro_image = '$pro_image',description = '$description',feature = '$feature',created_at = '$date' WHERE id = '$id'");
        $sql->execute();
    }
}