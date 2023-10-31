<?php include "__header__.php"; ?>

<div class="p-3 mb-5 sticky-top text-white bg-dark">
    <h3>Sales Report</h3>
</div>
<div class="">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body justify-content-center d-flex">
                    <div class="input-group w-50">
                        <input type="daterange" name="daterange" class="form-control" id='daterange' />
                        <button class="btn btn-primary" onclick="getSalesReport()">Get Report</button>
                    </div>
                </div>
            </div>

            <div class="table-responsive my-5 card">
                <table class="table table-striped table-bordered" id="report_table">
                    <thead class="alert-info">
                        <tr>
                            <th>Sr. No</th>
                            <th>Item Name</th>
                            <th>Unit Price</th>
                            <th>Quantity</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- ITEMS REPORT -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>

<?php include "__footer__.php"; ?>


<script>
    $(document).ready(function() {
        $('#report_table').hide();
    });


    function getSalesReport() {
        daterange = $('#daterange').val();
        if (daterange.length <= 0) {
            toastr.error("Please select Date Range");
        } else {
            daterange = daterange.split(' - ');

            startDate = daterange[0];
            endDate = daterange[1];
            $.ajax({
                type: 'POST',
                url: AJAX_URL,
                data: {
                    'action': 'GET_SALES_REPORT',
                    'startDate' : startDate,
                    'endDate' : endDate,
                },
                success: function(response) {
                    response = $.parseJSON(response);
                    html = "";
                    totalAmount = 0;
                    $.each(response['report'], function(key, value) {
                        html += "<tr>";
                        html += "    <td>" + (key + 1) + "</td>";
                        html += "    <td>" + value['item_name'] + "</td>";
                        html += "    <td>PKR " + value['unit_price'] + "/-</td>";
                        html += "    <td>" + value['quantity'] + "</td>";
                        html += "    <td>PKR " + value['sub_total'] + "/-</td>";
                        html += "</tr>";

                        totalAmount+= parseInt(value['sub_total'],10);
                    });

                    html += "<tr class = 'alert-success'><th colspan = '4' style= 'text-align:right'> Total : </th><td><b>PKR "+totalAmount+"/-</b></td></tr>";

                    $('#report_table').find('tbody').html(html);
                    $('#report_table').show();
                }
            });

        }

    }
</script>