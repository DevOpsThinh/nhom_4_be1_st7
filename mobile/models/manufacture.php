<?php 
    class Manufacture extends Db{
        //Viet phuong thuc lay ra ten hang san xuat
        function getAllFactureName(){
            $sql = self::$connection->prepare("SELECT * FROM manufactures");
            $sql->execute();//return an object
            $items = array();
            $items = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
            return $items; //return an array
        }
        //Viet phuong thuc lay ra 10 sp moi nhat
        
    }