<?php 
require_once "DBController.php";

class InventoryController{


    public function getAllInventoryItems(){
        $db = new DBController();
        $query = "SELECT * FROM inventory where status = ? ORDER BY datetime DESC";
        $inventoryItems = $db->select($query,array("active"));
        return $inventoryItems;
    }

    public function addNewInventoryItem($bill_number,$itemName,$quantity,$unit,$price,$notes) {
        $db = new DBController();

        $query = "INSERT INTO inventory(bill_number,item_name, quantity, unit, price,notes) VALUES (?,?,?,?,?,?)";

        try {
            $res = $db->execute($query, array($bill_number,$itemName,$quantity,$unit,$price,$notes));
            return $res;
        } catch (Exception $e) {
            return -1;
        }
    }

    public function editNewInventoryItem($itemId,$bill_number,$itemName,$quantity,$unit,$price,$notes){
        $db = new DBController();
        $query = "UPDATE inventory SET bill_number=?,item_name=?,quantity=?,unit=?,price=?,notes=? WHERE id = ?";
        try {
            $res = $db->execute($query, array($bill_number,$itemName,$quantity,$unit,$price,$notes,$itemId));
            return $res;
        } catch (Exception $e) {
            return -1;
        }
    }

    public function removeInventoryItems($inventoryItemId){
        $db = new DBController();
        $query = "update inventory set status =? where id =?";
        try {
            $res = $db->execute($query, array("del",$inventoryItemId));
            return $res;
        } catch (Exception $e) {
            return -1;
        }

    }
    

}
?>