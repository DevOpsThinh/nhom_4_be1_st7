<?php
class Protype extends Db {
    //ham xuat tat ca ten protype
    function getAllProtype() {
        $sql = self::$connection->prepare("SELECT * FROM protypes");
            $sql->execute();//return an object
            $items = array();
            $items = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
            return $items; //return an array
    }
    //ham goi ten protype bang id
    function getProtypeName($type_id)
    {
        $sql = self::$connection->prepare("SELECT type_name FROM protypes,products WHERE protypes.type_id = products.type_id AND protypes.type_id = $type_id");
            $sql->execute();//return an object
            $items = array();
            $items = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
            return $items; //return an array
    }
    //xoa loai san pham, dung o id
    function deleteTypeProduct($type_id)
    {
        $sql = self::$connection->prepare("DELETE FROM protypes WHERE protypes.type_id = $type_id");
        $sql->execute();
    }
    //them loai san pham moi 
    function addProtype($type_name)
    {
        $sql1 = self::$connection->prepare("SELECT * FROM protypes");
            $sql1->execute();
            $item = array();
            $item = $sql1->get_result()->fetch_all(MYSQLI_ASSOC);       
            if($item == null)
            {
                $sql = self::$connection->prepare("INSERT INTO protypes(type_name) VALUES('$type_name')");
                    $sql->execute();
                    echo "Thêm Thành Công . <a href='javascript: history.go(-1)'>Trở lại</a>";
            }   
            else {              
                $count = 0;
                foreach ($item as $key) {
                    if($key['type_name'] == $type_name)
                    {
                        echo "Loại sản phẩm đã tồn tại . <a href='javascript: history.go(-1)'>Trở lại</a>";
                        exit;
                        $count++;
                    }                   
                }
                if($count == 0)
                {
                    $sql = self::$connection->prepare("INSERT INTO protypes(type_name) VALUES('$type_name')");
                    $sql->execute();
                    echo "Thêm Thành Công . <a href='javascript: history.go(-1)'>Trở lại</a>";             
                }
            }
    }
    //getallprotypebyid
    function getAllProtypeById($type_id)
    {
        $sql = "SELECT * FROM protypes,products WHERE protypes.type_id = products.type_id AND protypes.type_id = $type_id";
        $items = mysqli_query(self::$connection,$sql);
        $items1 = mysqli_fetch_assoc($items);
        return $items1;
    }
    //cap nhat loai san pham
    function updateProtype($type_id,$type_name)
    {
        $sql = self::$connection->prepare("UPDATE protypes SET type_name = '$type_name' WHERE type_id = '$type_id'");
        $sql->execute();
    }
    //ham lay so luong san pham cua 1 manu 
    function countToTalProductOfAType($type_id){
        $sql = "SELECT COUNT(products.id) AS soLuongSanPham FROM `protypes`,products WHERE protypes.type_id = products.type_id AND protypes.type_id = $type_id";
        $item = mysqli_query(self::$connection,$sql);
        $items1 = mysqli_fetch_assoc($item);
        return $items1;
    }
}
?>
