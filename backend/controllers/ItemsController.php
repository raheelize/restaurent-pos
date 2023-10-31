<?php
require_once "DBController.php";
class ItemsController{


    private function upload($image, $target_dir)
    {
        if (($image['name'] != "")) {
            $file = $image['name'];
            $path = pathinfo($file);
            $filename = $path['filename'];
            $ext = $path['extension'];
            $temp_name = $image['tmp_name'];
            $path_filename_ext = $target_dir . $filename . "." . $ext;

            if (file_exists($path_filename_ext)) {
                return false;
            } else {
                move_uploaded_file($temp_name, $path_filename_ext);
                return true;
            }
        }
    }

    public function getItemId() {
        
    }


    public function getItemList(){
        $db = new DBController();
        $query = "SELECT i.item_id, item_name, i.item_image,i.item_price,t.type_name FROM items  i
        join types  t on i.type_id = t.type_id
        WHERE i.status = ? and t.status =?";
        
        try {
            $res = $db->select($query, array("active","active"));
            return $res;
        } catch (Exception $e) {
            return -1;
        }

    }


    public function addNewItem($categoryId,$itemName,$itemPrice,$itemImage){

        $db = new DBController();
        $query = "INSERT INTO items(item_name, item_image, item_price, type_id, status)
        VALUES (?,?,?,?,?)";

        $path = "static/img/items/";
        $this->upload($itemImage, "../" . $path);

        $imagePath = $path . $itemImage['name'];


        return $db->execute($query, array($itemName,$imagePath,$itemPrice,$categoryId,"active"));

    }

    public function deleteItem($itemId){
        $db = new DBController();
        $query = "UPDATE items set status = ? where item_id = ?";
        return $db->execute($query, array( "del",$itemId));
    }
}

?>