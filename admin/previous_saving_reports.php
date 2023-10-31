<?php include "__header__.php"; ?>

<div class="p-3 mb-5 sticky-top text-white bg-dark">
    <div class="clearfix">
        <div class="float-left">
        <h3>Savings Report Summary</h3>
        </div>
        <div class="float-right">
            <button onclick="clearAllRecord()" class="btn btn-danger">Clear All Records</button>
        </div>
    </div>
</div>
<div class="">
    <div class="row">
        <div class="col-lg-12">
            <div class="saving_records">
                <!-- SUMMARY HERE -->
            </div>
        </div>
    </div>


</div>

<?php include "__footer__.php"; ?>


<script>
    $(document).ready(function() {
        getSavingsRecords();
    });


    function getSavingsRecords() {

        $.ajax({
            type: 'POST',
            url: AJAX_URL,
            data: {
                'action': 'GET_SAVING_RECORDS',
            },
            success: function(response) {
                response = $.parseJSON(response);
                html = "";
                $.each(response['report'], function(key, value) {

                    html+='<div class="card my-3">';
                    html+='    <div class="card-header">';
                    html+='        <div class="clearfix ">';
                    html+='            <div class="float-left bg-white p-2">';
                    html+='                <span class="my-0"><small><b class="d-inline">TOTAL SALES:</b></small> PKR ' + value['sales_amount'] + '/-</span>&nbsp;&nbsp;&nbsp;';
                    html+='                <span class="my-0"><small><b class="d-inline">TOTAL SAVINGS :</b></small> PKR ' + value['saving_amount'] + '/-</span>';
                    html+='            </div>';
                    html+='            <div class="float-right">';
                    html+='                <button class="btn btn-sm btn-danger" onclick="clearRecord(' + value['record_id'] + ')"><i class="fa fa-times"></i> Clear Order</button>';
                    html+='            </div>';
                    html+='        </div>';
                    html+='    </div><div class="card-body">';
                    html+='        <h6>EXPENSES</h6>';
                    html+='        <div class="table-responsive">';
                    html+='            <table class="table table-striped table-bordered">';
                    html+='                <thead>';
                    html+='                    <tr class = "alert-info">';
                    html+='                        <th>Item Name</th>';
                    html+='                        <th>Item Price</th>';
                    html+='                    </tr>';
                    html+='                </thead>';
                    html+='                <tbody>';
                    $.each(value['record_details'], function(key, item) {
                                        html += '<tr>';
                                        html += '    <td>' + item['item_name'] + '</td>';
                                        html += '    <td>' + item['item_value'] + '/-</td>';
                                        html += '</tr>';
                    });
                    html+='                    <tr class="">';
                    html+='                        <td colspan="4" class = "alert-warning"><b>Comments:&nbsp;&nbsp;</b>' + value['comments'] + '</td>';
                    html+='                    </tr>';
                    html+='                </tbody>';
                    html+='            </table>';
                    html+='        </div>';
                    html+='    </div>';
                    html+='</div>';
                });

                $('.saving_records').html(html);
            }
        });

    }


    function clearRecord(record_id) {
        $.ajax({
            type: 'POST',
            url: AJAX_URL,
            data: {
                'action': 'CLEAR_SAVINGS_RECORD',
                'record_id': record_id,
            },
            success: function(response) {
                response = $.parseJSON(response);
                if (response['status']) {
                    toastr.success("Record Cleared");
                    getSavingsRecords();
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


    function clearAllRecord() {
        $.ajax({
            type: 'POST',
            url: AJAX_URL,
            data: {
                'action': 'CLEAR_ALL_SAVINGS_RECORD',
            },
            success: function(response) {
                response = $.parseJSON(response);
                if (response['status']) {
                    toastr.success("Records Cleared");
                    getSavingsRecords();
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