<?php 
require_once "DBController.php";

class OrderController{


    public function getAllOrders(){
        $db = new DBController();

        $query = "SELECT * FROM orders where status = ? ORDER BY datetime DESC";

        $orders = $db->select($query,array("active"));

        $orderList = array();

        foreach ($orders as $order){

            $orderDetails = array();
            $query = "SELECT i.item_name, oi.unit_price, oi.quantity, oi.sub_total
            from order_items oi join items i on oi.item_id = i.item_id where oi.order_id = ?";

            $orderItems = $db->select($query,array($order['order_id']));
            
            foreach ($orderItems as $item){
                array_push(
                    $orderDetails, 
                    array(
                        "item_name"=>$item['item_name'],
                        "unit_price"=>$item['unit_price'],
                        "quantity"=>$item['quantity'],
                        "sub_total"=>$item['sub_total'],
                ));
            }

            array_push(
                $orderList,
                array(
                    "order_id" => $order['order_id'],
                    "net_total" => $order['net_total'],
                    "sales_tax" => $order['sales_tax'],
                    "discount_percentage" => $order['discount_percentage'],
                    "discount_amount" => $order['discount_amount'],
                    "grand_total" => $order['grand_total'],
                    "order_time" => $order['datetime'],
                    "operator" => $order['operator'],
                    "order_details"=>$orderDetails,
                )
            );
        }

        return $orderList;
        
    }

    public function getOrderDetails($orderId){
        $db = new DBController();

        $query = "SELECT * FROM orders where status = ? and order_id=? ORDER BY datetime DESC";

        $orders = $db->select($query,array("active",$orderId));

        $orderList = array();

        foreach ($orders as $order){

            $orderDetails = array();
            $query = "SELECT i.item_name, oi.unit_price, oi.quantity, oi.sub_total
            from order_items oi join items i on oi.item_id = i.item_id where oi.order_id = ?";

            $orderItems = $db->select($query,array($order['order_id']));
            
            foreach ($orderItems as $item){
                array_push(
                    $orderDetails, 
                    array(
                        "item_name"=>$item['item_name'],
                        "unit_price"=>$item['unit_price'],
                        "quantity"=>$item['quantity'],
                        "sub_total"=>$item['sub_total'],
                ));
            }

            array_push(
                $orderList,
                array(
                    "order_id" => $order['order_id'],
                    "net_total" => $order['net_total'],
                    "sales_tax" => $order['sales_tax'],
                    "discount_percentage" => $order['discount_percentage'],
                    "discount_amount" => $order['discount_amount'],
                    "grand_total" => $order['grand_total'],
                    "order_time" => $order['datetime'],
                    "operator" => $order['operator'],
                    "order_details"=>$orderDetails,
                )
            );
        }
        if($orderList){
            return $orderList[0];
        }else{
            return [];
        }

    }
    private function generateNewOrder(){
        $db = new DBController();
        
        $orderID = time();
        
        $query = "INSERT INTO orders(order_id,status,operator)VALUES(?,?,?)";
        
        try {
            $res = $db->execute($query, array($orderID,"active","admin"));
            if ($res){
                return $orderID;
            }else{
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    private function updateOrderAmount($orderID,$netTotal,$discountPercentage,$discountAmount,$salesTaxAmount){
        $db = new DBController();


        $discountAmount = $netTotal * $discountPercentage /100;
        $grandTotal = $netTotal+$salesTaxAmount-$discountAmount;

        $query = "UPDATE orders SET net_total=?, discount_percentage=?,discount_amount=?,sales_tax=?,grand_total=? WHERE order_id = ?";

        try {
            $res = $db->execute($query, array($netTotal,$discountPercentage,$discountAmount,$salesTaxAmount,$grandTotal,$orderID));
            if ($res){
                return $orderID;
            }else{
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function placeNewOrder($orderItemsList,$discountPercentage,$discountAmount,$salesTaxAmount){

        // GENERATE NEW ORDER
        $orderID = $this->generateNewOrder();

        // ADD ORDER ITEMS
        $netTotal = 0;
        if ($orderID){
            $db = new DBController();
            foreach($orderItemsList as $OrderItem){

                $query = "INSERT INTO order_items(order_id, item_id, quantity, unit_price, sub_total) VALUES (?,?,?,?,?)";
                $db->execute($query, array($orderID,$OrderItem['itemId'],$OrderItem['quantity'],$OrderItem['itemPrice'],$OrderItem['totalPrice']));

                $netTotal += (int)$OrderItem['totalPrice'];
            }
        }

        if($this->updateOrderAmount($orderID,$netTotal,$discountPercentage,$discountAmount,$salesTaxAmount)){
            return $orderID;
        }else{
            return false;
        }

    }

    public function clearOrder($orderId){
        $db = new DBController();

        $query = "update orders set status=? where order_id =?";

        

        try{
            $res =  $db->execute($query, array("del", $orderId));
            if($res){
                $query = "update order_items set status=? where order_id =?";
                return $db->execute($query, array("del", $orderId));
            }else{
                return false;
            }
        }catch (Exception $e) {
            return false;
        }
    }


    public function clearAllOrders(){
        $db = new DBController();

        $query = "update orders set status=? where status =?";
        try{
            $res =  $db->execute($query, array("del", "active"));
            if($res){
                $query = "update order_items set status=? where status =?";
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