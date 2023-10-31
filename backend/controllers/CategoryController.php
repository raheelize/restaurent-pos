<?php
require_once "DBController.php";
class CategoryController{

    public function getCategoryList(){
        $db = new DBController();
        $query = "select type_id,type_name from types where status = ?";

        try {
            $res = $db->select($query, array("active"));
            return $res;
        } catch (Exception $e) {
            return -1;
        }

    }

    public function addNewCateogry($categoryName) : bool {
        $db = new DBController();
        $query = "INSERT INTO types(type_name,status) VALUES (?,?)";
        return $db->execute($query, array($categoryName, "active"));
    }

    public function deleteCateogry($categoryId) : bool {
        $db = new DBController();
        $query = "UPDATE types set status = ? where type_id = ?";
        return $db->execute($query, array( "del",$categoryId));
    }
}
?>