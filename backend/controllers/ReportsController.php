<?php
require_once "DBController.php";
class ReportsController{

    public function getSalesReport($startDate,$endDate){

        $db = new DBController();
        $startDate = DateTime::createFromFormat('m/d/Y', $startDate)->format('Y-m-d');
        $endDate = DateTime::createFromFormat('m/d/Y', $endDate)->format('Y-m-d');

    
        $query = " SELECT i.item_name, ot.unit_price, sum(ot.quantity) quantity ,sum(ot.sub_total) sub_total 
        FROM order_items ot JOIN items i ON ot.item_id = i.item_id 
        WHERE DATE(ot.datetime) BETWEEN DATE(?) AND DATE(?)
        and ot.status = ? group by i.item_name,ot.unit_price order by sum(ot.sub_total) desc";

        return $db->select($query, array($startDate,$endDate,'active'));
    }


    public function getSalesAmount(){
        $db = new DBController();

        $query = "select 
        sum(net_total) as net_total,
        sum(sales_tax) as sales_tax,
        sum(discount_amount) as discount_amount,
        sum(grand_total) as grand_total 
        from orders where status = ?";

        $res = $db->select($query,array("active"));
        return $res[0];
    }

    public function addSavingsRecord($totalSale,$totalSaving,$expenseList,$comments){
        $db = new DBController();

        $query = "SELECT COALESCE(MAX(id) + 1, 1) AS next_id FROM saving_records";
        $res = $db->select($query);
        $record_id = $res[0]['next_id'];

        $query = "INSERT INTO saving_records(id, total_sale, total_savings, comments, operator) VALUES (?,?,?,?,?)";

        $res = $db->execute($query,array($record_id,$totalSale,$totalSaving,$comments,"admin"));
        if ($res){

            foreach($expenseList as $expense){
                $name = $expense['name'];
                $value = $expense['value'];

                $query = "INSERT INTO saving_records_items(record_id, item_name, item_value) VALUES (?,?,?)";

                $db->execute($query,array($record_id,$name,$value));
            }

            return true;


        }else{
            return false;
        }
    }


    public function getAllSavingsRecords(){
        $db = new DBController();

        $query = "SELECT * FROM saving_records where status = ? ORDER BY datetime DESC";

        $records = $db->select($query,array("active"));

        $recordsList = array();

        foreach ($records as $record){

            $recordDetails = array();
            $query = "select item_name,item_value from saving_records_items where record_id =?";

            $recordItems = $db->select($query,array($record['id']));
            
            foreach ($recordItems as $item){
                array_push(
                    $recordDetails, 
                    array(
                        "item_name"=>$item['item_name'],
                        "item_value"=>$item['item_value'],
                ));
            }

            array_push(
                $recordsList,
                array(
                    "record_id" => $record['id'],
                    "saving_amount" => $record['total_savings'],
                    "sales_amount" => $record['total_sale'],
                    "comments" => $record['comments'],
                    "datetime" => $record['datetime'],
                    "operator" => $record['operator'],
                    "record_details"=>$recordDetails,
                )
            );
        }

        return $recordsList;
        
    }


    public function clearSavingsRecord($record_id){
        $db = new DBController();

        $query = "update saving_records set status=? where id =?";

        try{
            $res =  $db->execute($query, array("del", $record_id));
            if($res){
                $query = "update saving_records_items set status=? where record_id =?";
                return $db->execute($query, array("del", $record_id));
            }else{
                return false;
            }
        }catch (Exception $e) {
            return false;
        }
    }


    public function clearAllSavingsRecords(){
        $db = new DBController();

        $query = "UPDATE saving_records set status = ? where status = ?";
        try{
            $res =  $db->execute($query, array("del", "active"));
            if($res){
                $query = "update saving_records_items set status=? where status = ?";
                return $db->execute($query, array("del", "active"));
            }else{
                return false;
            }
        }catch (Exception $e) {
            return false;
        }
    }
}
?>