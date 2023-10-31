<?php include "__header__.php"; ?>


<style>
    .clear-search-btn {
        border: none;
        /* border-radius: 20px; */
        background-color: red;
        color: white;
        display: none;
    }
</style>

<div class="p-3 mb-5 sticky-top text-white bg-dark">
    <div class="clearfix">
        <div class="float-left">
            <h3>Orders Summary</h3>
        </div>
        <div class="float-right">
            <button onclick="clearAllOrders()" class="btn btn-danger">Clear All Orders</button>
        </div>
    </div>
</div>

<div class="input-group input-group-sm mb-3 ">
    <div class="input-group-prepend">
        <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fa fa-search"></i></span>
    </div>
    <input class="input-bar clearable form-control" placeholder="Seach Orders..." onkeyup="searchOrder(this)" id="searchInput" />
    <button type="button" class="clear-search-btn btn-outline-secondary" onclick="clearSearch()"><i class="fa fa-times"></i></button>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="orderlist">
            <!-- ORDERS HERE -->
        </div>
    </div>
</div>

<?php include "__footer__.php"; ?>


<script>
    $(document).ready(function() {
        getOrderList();
    });


    function getOrderList() {

        $.ajax({
            type: 'POST',
            url: AJAX_URL,
            data: {
                'action': 'GET_ORDER_LIST',
            },
            success: function(response) {
                response = $.parseJSON(response);
                html = "";
                $.each(response['orders'], function(key, value) {

                    html += '<div class="card my-3 orderBlock" id = "' + value['order_id'] + '">';
                    html += '    <div class="card-header">';
                    html += '        <div class="clearfix ">';
                    html += '            <div class="float-left bg-white p-2">';
                    html += '                <span class="my-0"><small><b class="d-inline">ORDER ID:</b></small> ' + value['order_id'] + '</span>&nbsp;&nbsp;&nbsp;';
                    html += '                <span class="my-0"><small><b class="d-inline">DATETIME :</b></small> ' + value['order_time'] + '</span>';
                    html += '            </div>';
                    html += '            <div class="float-right">';
                    html += '                <a href= "/burgershop/receipt.html?orderId=' + value['order_id'] + '"><button class="btn btn-sm btn-primary"><i class="fa fa-print"></i> Print</button></a>';
                    html += '                <button class="btn btn-sm btn-danger" onclick="clearOrder(' + value['order_id'] + ')"><i class="fa fa-times"></i> Clear Order</button>';
                    html += '            </div>';
                    html += '        </div>';
                    html += '    </div><div class="card-body">';
                    html += '        <h6>ORDER DETAILS</h6>';
                    html += '        <div class="table-responsive">';
                    html += '            <table class="table table-striped table-bordered">';
                    html += '                <thead>';
                    html += '                    <tr class = "alert-info">';
                    html += '                        <th>Item Name</th>';
                    html += '                        <th>Unit Price</th>';
                    html += '                        <th>Quantity</th>';
                    html += '                        <th>Sub Total</th>';
                    html += '                    </tr>';
                    html += '                </thead>';
                    html += '                <tbody>';
                    $.each(value['order_details'], function(key, item) {
                        html += '<tr>';
                        html += '    <td>' + item['item_name'] + '</td>';
                        html += '    <td>' + item['unit_price'] + '/-</td>';
                        html += '    <td>' + item['quantity'] + '</td>';
                        html += '    <td>' + item['sub_total'] + '</td>';
                        html += '</tr>';
                    });
                    html += '                    <tr class="bg-gradient-success">';
                    html += '                        <th colspan="3" style = "text-align:right">Net Total</th>';
                    html += '                        <td class = "alert-secondary text0-whi"><b>PKR ' + value['net_total'] + '/-</b></td>';
                    html += '                    </tr>';
                    html += '                    <tr class="bg-gradient-success">';
                    html += '                        <th colspan="3" style = "text-align:right">Service Charges (5%)</th>';
                    html += '                        <td class = "alert-info text0-whi"><b>PKR ' + value['grand_total'] + '/-</b></td>';
                    html += '                    </tr>';
                    html += '                    <tr class="bg-gradient-success">';
                    html += '                        <th colspan="3" style = "text-align:right">Discount (' + value['discount_percentage'] + '%)</th>';
                    html += '                        <td class = "alert-warning text0-whi"><b>PKR ' + value['discount_amount'] + '/-</b></td>';
                    html += '                    </tr>';
                    html += '                    <tr class="bg-gradient-success">';
                    html += '                        <th colspan="3" style = "text-align:right">Grand Total</th>';
                    html += '                        <td class = "alert-success text0-whi"><b>PKR ' + value['grand_total'] + '/-</b></td>';
                    html += '                    </tr>';
                    html += '                </tbody>';
                    html += '            </table>';
                    html += '        </div>';
                    html += '    </div>';
                    html += '</div>';
                });

                $('.orderlist').html(html);
            }
        });

    }


    function clearOrder(orderId) {
        $.ajax({
            type: 'POST',
            url: AJAX_URL,
            data: {
                'action': 'CLEAR_ORDER',
                'orderid': orderId,
            },
            success: function(response) {
                response = $.parseJSON(response);
                if (response['status']) {
                    toastr.success("Order Cleared");
                    getOrderList();
                } else {
                    if (response['message']) {
                        toastr.error(response['message']);
                    } else {
                        toastr.error("Action Failed");
                    }
                }
            }
        });

    }

    function clearAllOrders() {
        $.ajax({
            type: 'POST',
            url: AJAX_URL,
            data: {
                'action': 'CLEAR_ALL_ORDERS',
            },
            success: function(response) {
                response = $.parseJSON(response);
                if (response['status']) {
                    toastr.success("Orders Cleared");
                    getOrderList();
                } else {
                    if (response['message']) {
                        toastr.error(response['message']);
                    } else {
                        toastr.error("Action Failed");
                    }
                }
            }
        });

    }


    // function searchOrder() {
    //     const searchInputValue = document
    //         .getElementById("searchInput")
    //         .value.toLowerCase();

    //     // const filteredOrders = cardsData.filter((card) => {
    //     //     return card.itemName.toLowerCase().includes(filterValue);
    //     // });

    //     // displayItems(filteredOrders);

    //     if (searchInputValue.length <= 0) {
    //         document.querySelector(".clear-search-btn").style.display = "none";
    //     } else {
    //         document.querySelector(".clear-search-btn").style.display = "inline";
    //     }
    // }

    function searchOrder() {
        const searchInputValue = document.getElementById("searchInput").value.toLowerCase();
        const orders = document.querySelectorAll(".orderBlock");

        if (searchInputValue.length === 0) {
            orders.forEach(order => {
                order.style.display = "block"; // Show all orders when the search input is empty.
            });
        } else {
            orders.forEach(order => {
                // const orderID = order.querySelector(".d-inline").textContent.trim(); // Extract the order ID
                const orderID = order.id;
                if (orderID.includes(searchInputValue)) {
                    order.style.display = "block"; // Show the order that matches the search input.
                } else {
                    order.style.display = "none"; // Hide orders that don't match the search input.
                }
            });
        }
        if (searchInputValue.length <= 0) {
            document.querySelector(".clear-search-btn").style.display = "none";
        } else {
            document.querySelector(".clear-search-btn").style.display = "inline";
        }
    }

    function clearSearch() {
        document.getElementById("searchInput").value = "";
        document.querySelector(".clear-search-btn").style.display = "none";
        searchOrder();
    }
</script>