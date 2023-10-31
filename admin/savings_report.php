<?php include "__header__.php"; ?>

<div class="p-3 mb-5 sticky-top text-white bg-dark">
    <div class="clearfix">
        <div class="float-left">
        <h3>Savings Report</h3>
        </div>
        <div class="float-right">
            <a href="previous_saving_reports.php" class="btn btn-secondary">See Previous Reports</a>
        </div>
    </div>
</div>
<div class="card p-4">
<h4>Sales Summary</h4>
    <div class="row">
        
        <div class="col-lg-3 alert-secondary">
            <div class="p-4">
                <small class="d-inline">NET TOTAL:</small>
                <h4>PKR <span id="totalAmount">20000</span>/-</h4>
            </div>
        </div>
        <div class="col-lg-3 alert-danger">
            <div class="p-4">
                <small class="d-inline">SERVICE CHARGES:</small>
                <h4>PKR <span id="totalTax">20000</span>/-</h4>
            </div>
        </div>
        <div class="col-lg-3 alert-info">
            <div class="p-4">
                <small class="d-inline">DISCOUNT:</small>
                <h4>PKR <span id="totalDiscount">20000</span>/-</h4>
            </div>
        </div>
        <div class="col-lg-3 alert-success">
            <div class="p-4">
                <small class="d-inline">GRAND TOTAL:</small>
                <h4>PKR <span id="totalSale">20000</span>/-</h4>
            </div>
        </div>


        <div class="col-lg-6 alert-info" hidden>
            <div class="p-4">
                <small class="d-inline">TOTAL SAVING:</small>
                <h4>PKR <span id="totalSavings">20000</span>/-</h4>
            </div>
        </div>

    </div>
    <hr>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="clearfix">
                        <div class="float-left">
                            <h5>Expenses</h5>
                        </div>
                        <div class="float-right">
                            <button class="btn btn-primary btn-sm" onclick="addNewExpense()"><i class="fa fa-plus"></i> Add New Expense</button>
                        </div>
                    </div>
                </div>

                <div class="card-body" id="expenseBlock">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Expense Name</th>
                                <th>Expense Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="text" name='expenseName' class="expenseName form-control">
                                </td>
                                <td>
                                    <input type="number" name='expenseValue' class="expenseValue form-control" onkeyup='calculateSaving()'>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                    <tr>
                        <td>

                        </td>
                    </tr>
                </div>
            </div>
        </div>
    </div>
    <hr>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <b>Comments</b>
            <textarea name="comments" id="comments" rows="2" class="form-control"></textarea>
            <button class="btn btn-primary btn-sm btn-block mt-3" onclick="saveRecord()">Save</button>
        </div>
    </div>


</div>

<?php include "__footer__.php"; ?>


<script>
    $(document).ready(function() {
       getSalesAmount();
    });

    $('.expenseValue').on("change keyup", function() {
        calculateSaving();
    });

    function getSalesAmount(){
        $.ajax({
            type:'POST',
            url:AJAX_URL,
            data:{
                'action' : 'GET_TOTAL_SALE_COUNT',
            },
            success:function(response){
                response = $.parseJSON(response);
                if (response['status']) {
                    if(response['sales_details']){
                        $('#totalAmount').text(response['sales_details']['net_total']);
                        $('#totalTax').text(response['sales_details']['sales_tax']);
                        $('#totalDiscount').text(response['sales_details']['discount_amount']);
                        $('#totalSale').text(response['sales_details']['grand_total']);

                        $('#totalSavings').text(response['sales_details']['grand_total']);
                    }else{
                        $('#totalSale').text(0);
                        $('#totalSavings').text(0);
                    }
                    

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


    function addNewExpense() {
        html = `
            <tr>
                <td>
                    <input type="text" name="expenseName" class="expenseName form-control">
                </td>
                <td>
                    <input type="number" name="expenseValue" class="expenseValue form-control" onkeyup='calculateSaving()'>
                </td>
                <td>
                    <button class="btn btn-sm btn-danger btn-block" class = "removeExpenseBtn" onclick="removeExpense(this)"><i class="fa fa-times"></i> Remove</button>
                </td>
            </tr>
        `;
        block = $('#expenseBlock').find('tbody').append(html);
    }

    function removeExpense(e) {


        if ($('#expenseBlock').find('tbody').children().length <= 1) {
            calculateSaving();
            return false;
        } else {
            $(e).parents('tr').remove();
            calculateSaving();
        }


    }

    function calculateSaving() {
        const expenseInputs = document.querySelectorAll('.expenseValue');
        let sum = 0;
        expenseInputs.forEach((input) => {
            const value = parseFloat(input.value);
            if (!isNaN(value)) {
                sum += value;
            }
            const totalSale = document.getElementById('totalSale');
            const savingsAmount = document.getElementById('totalSavings');
            savingsAmount.innerHTML = parseInt(totalSale.innerHTML, 10) - sum;
        });
    }


    function saveRecord() {

        const totalSale = document.getElementById('totalSale');
        const savingsAmount = document.getElementById('totalSavings');

        const totalSaleValue = parseInt(totalSale.textContent, 10);
        const savingsAmountValue = parseInt(savingsAmount.textContent, 10);

        if (isNaN(totalSaleValue)) {
            toastr.error("Invalid Sales Value");
            return false;
        }

        if (isNaN(savingsAmountValue)) {
            toastr.error("Invalid Savings Value");
            return false;
        }


        const expenseNames = document.querySelectorAll('.expenseName');
        const expenseValues = document.querySelectorAll('.expenseValue');
        const expenseList = [];
        if (expenseNames.length === expenseValues.length) {

            for (let i = 0; i < expenseNames.length; i++) {
                const name = expenseNames[i].value; // Get the text content of the element
                const value = parseFloat(expenseValues[i].value); // Convert the value to a number
                console.log(name, value);
                if (((name) || name.length > 0) && !isNaN(value)) { // Check if the value is a valid number
                    const expenseItem = {
                        name: name,
                        value: value
                    };

                    expenseList.push(expenseItem);
                } else {
                    toastr.error("Please Enter Both Expense Name and Value");
                    return false;
                }
            }
        } else {
            toastr.error("Mismatched number of elements in expenseNames and expenseValues.");
            return false;
        }


        const comments = document.getElementById("comments").value;

        $.ajax({
            type: 'POST',
            url: AJAX_URL,
            data: {
                'action': 'ADD_SAVINGS_RECORD',
                'total_sale': totalSaleValue,
                'total_saving': savingsAmountValue,
                'expense_list': expenseList,
                'comments': comments,
            },
            success: function(response) {
                response = $.parseJSON(response);
                if (response['status']) {
                    location.reload();
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
</script>