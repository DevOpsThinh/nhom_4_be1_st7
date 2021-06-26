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
}
?>
