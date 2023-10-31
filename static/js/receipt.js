const $btnPrint = document.querySelector("#btnPrint");
$btnPrint.addEventListener("click", () => {
    window.print();
});


function getOrderIdFromURL() {
const url = window.location.href;
const urlSearchParams = new URLSearchParams(url.split('?')[1]);
return urlSearchParams.get('orderId');
}

function displayOrderDetails(order){

document.getElementById("orderId").innerHTML  = order['order_id'];

const inputDateString = order['order_time'];  
const [datePart, timePart] = inputDateString.split(" ");
const [year, month, day] = datePart.split("-");
const formattedDateString = `${day}-${month}-${year} <small>${timePart}</small>`;

document.getElementById("orderDatetime").innerHTML  = formattedDateString;
document.getElementById("salesTax").innerHTML  = order['sales_tax'];
document.getElementById("discountAmount").innerHTML  = order['discount_amount'];
document.getElementById("discountPercentetage").innerHTML  = order['discount_percentage'];
document.getElementById("netTotal").innerHTML  = order['net_total'];
document.getElementById("grandTotal").innerHTML  = order['grand_total'];


const orderItems = document.getElementById("orderItems");
orderItems.innerHTML = "";

order['order_details'].forEach((item) => {
const itemElement = document.createElement("tr");
itemElement.innerHTML = `
    <tr>
      <td>${item['item_name']}</td>
      <td>${item['unit_price']}</td>
      <td>${item['quantity']}</td>
      <td>${item['sub_total']}</td>
    </tr>
`;
orderItems.appendChild(itemElement);
});
}

function goBack(){
    window.history.back();
}

$(document).ready(function(){

const AJAX_URL = "backend/requestHandler.php";
const orderId = getOrderIdFromURL();

if(orderId != null && orderId.length>0){

    $.ajax({
        type: 'POST',
        url: AJAX_URL,
        data: {
            'action': 'GET_ORDER_DETAILS',
            'orderId' : orderId,
        },
        success:function(response){
            response = $.parseJSON(response);
            if(response['status']){

                displayOrderDetails(response['order']);
                window.print();
                // location.href = '/burgershop';


            }else{
                alert(response['message']);
                // location.href = '/burgershop';
                window.history.back();
            }

        }
});
    
}else{
    // location.href = '/burgershop';
    window.history.back();
}
});