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
        //dung cho user
        function deleteManuProduct($manu_id)
        {
            $sql = self::$connection->prepare("DELETE FROM manufactures WHERE manufactures.manu_id = $manu_id");
            $sql->execute();
        }
        //ham them manu
        function addManu($manu_name)
        {
            $sql1 = self::$connection->prepare("SELECT * FROM manufactures");
                $sql1->execute();
                $item = array();
                $item = $sql1->get_result()->fetch_all(MYSQLI_ASSOC);       
                if($item == null)
                {
                    $sql = self::$connection->prepare("INSERT INTO manufactures(manu_name) VALUES('$manu_name')");
                        $sql->execute();
                        echo "Thêm Thành Công . <a href='javascript: history.go(-1)'>Trở lại</a>";
                }   
                else {              
                    $count = 0;
                    foreach ($item as $key) {
                        if($key['manu_name'] == $manu_name)
                        {
                            echo "Hãng đã tồn tại . <a href='javascript: history.go(-1)'>Trở lại</a>";
                            exit;
                            $count++;
                        }                   
                    }
                    if($count == 0)
                    {
                        $sql = self::$connection->prepare("INSERT INTO manufactures(manu_name) VALUES('$manu_name')");
                        $sql->execute();
                        echo "Thêm Thành Công . <a href='javascript: history.go(-1)'>Trở lại</a>";             
                    }
                }
        }
        //lay toan bo manu bang id
        function getAllFactureNameById($manu_id){
            $sql = "SELECT * FROM manufactures Where manu_id = $manu_id";
            $item = mysqli_query(self::$connection,$sql);
            $items1 = mysqli_fetch_assoc($item);
            return $items1;
        }
        //ham cap nhat manu
        function updateManu($manu_id,$manu_name)
        {
            $sql = self::$connection->prepare("UPDATE manufactures SET manu_name = '$manu_name' WHERE manu_id = '$manu_id'");
            $sql->execute();
        }
        //ham lay so luong san pham cua 1 manu 
        function countToTalProductOfAManu($manu_id){
            $sql = "SELECT COUNT(products.id) AS soLuongSanPham FROM `manufactures`,products WHERE manufactures.manu_id = products.manu_id AND manufactures.manu_id = $manu_id";
            $item = mysqli_query(self::$connection,$sql);
            $items1 = mysqli_fetch_assoc($item);
            return $items1;
        }
    }