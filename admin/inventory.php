<?php include "__header__.php"; ?>


<div class="p-3 mb-5 sticky-top text-white bg-dark">
    <h3>Inventory Manager</h3>

</div>
<div class="">

    <div class="card">
        <div class="card-header">
            <h6>Add New Inventory Item</h6>
        </div>
        <div class="card-body">
            <div class="row p-3">

                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="">Enter Bill Number</label>
                        <input type="text" name="billNumber" id="billNumber" class="form-control" required>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="">Enter Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="">Enter Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" required>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="">Enter Unit</label>
                        <select name="unit" id="unit" class="form-control" required>
                            <option selected disabled value=0>PLEASE SELECT</option>
                            <option value="grams">Grams (g)</option>
                            <option value="kilograms">Kilograms (kg)</option>
                            <option value="litres">Liters</option>
                            <option value="packs">Pack(s)</option>
                            <option value="catrons">Cartons</option>
                            <option value="peices">Peices</option>
                        </select>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="">Enter Price</label>
                        <input type="number" name="price" id="price" class="form-control" required>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="form-group">
                        <label for="">Notes</label>
                        <input type="text" name="notes" id="notes" class="form-control" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <center>
                <button class="btn btn-primary btn-block w-25" id="saveNewItem">Save</button>
            </center>
        </div>
    </div>



    <div class="card mt-3">
        <div class="card-header">
            <h6>Inventory Items List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive ">
                <table class="table table-striped  table-bordered">
                    <thead class="alert-info">
                        <tr>
                            <th>Sr.#</th>
                            <th>Name</th>
                            <th>Quanity</th>
                            <th>Unit</th>
                            <th>Price</th>
                            <th>Notes</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id='itemsList'>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>


<!-- EDIT ITEM MODAL START -->

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editItemModal" id='editItemModalBtn' hidden>
</button>
<div class="modal card" tabindex="-1" role="dialog" id='editItemModal'>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content  card">
            <div class="modal-header card-header ">
                <h6>Edit Inventory Item</h6>
                <span id= 'itemId'></span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body card-body">
                <div class="row p-3">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Enter Bill Number</label>
                            <input type="text" name="billNumber" id="billNumber" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Enter Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Enter Quantity</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Enter Unit</label>
                            <select name="unit" id="unit" class="form-control" required>
                                <option selected disabled value=0>PLEASE SELECT</option>
                                <option value="grams">Grams (g)</option>
                                <option value="kilograms">Kilograms (kg)</option>
                                <option value="litres">Liters</option>
                                <option value="packs">Pack(s)</option>
                                <option value="catrons">Cartons</option>
                                <option value="peices">Peices</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">Enter Price</label>
                            <input type="number" name="price" id="price" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-lg-9">
                        <div class="form-group">
                            <label for="">Notes</label>
                            <input type="text" name="notes" id="notes" class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer card-footer">
                <button type="button" class="btn btn-primary" onclick = "saveEditedItemInfo()">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
</div>

<!-- EDIT ITEM MODAL ENDS -->

<?php include "__footer__.php"; ?>


<script>
    $(document).ready(function() {
        getInventoryItemList();
    });





    function getInventoryItemList() {
        $.ajax({
            type: 'POST',
            url: AJAX_URL,
            data: {
                'action': 'GET_INVENTORY_ITEMS',
            },
            success: function(response) {
                response = $.parseJSON(response);
                html = '';
                $.each(response['items'], function(key, value) {
                    html += `<tr>
                        <td>${value['bill_number']}</td>
                        <td>${value['item_name']}</td>
                        <td>${value['quantity']}</td>
                        <td>${value['unit']}</td>
                        <td>${value['price']}</td>
                        <td>${value['notes']}</td>
                        <td>
                        <button type= "button" class = "btn btn-danger " onclick="deleteItem(${value['id']})"><i class = "fa fa-times"></i></button>
                        <button type= "button" class = "btn btn-secondary " onclick="editItem(${value['id']},'${value['bill_number']}','${value['item_name']}','${value['quantity']}','${value['unit']}','${value['price']}','${value['notes']}')"><i class = 'fa fa-edit'></i></button>
                        </td>
                    </tr>`
                });

                $('#itemsList').html(html);
            }
        });
    }


    $('#saveNewItem').click(function() {
        var billNumber = $('#billNumber').val();
        var name = $('#name').val();
        var quantiy = $('#quantity').val();
        var unit = $('#unit').val();
        var price = $('#price').val();
        var notes = $('#notes').val();

        if (!name || name.length <= 0) {
            toastr.error("Please Enter Item Name");
            return false;
        }
        if (!quantiy || quantiy.length <= 0) {
            toastr.error("Please Enter Quanity");
            return false;
        }
        if (!unit || unit.length <= 0) {
            toastr.error("Please Enter Unit");
            return false;
        }
        if (!price || price.length <= 0) {
            toastr.error("Please Enter Price");
            return false;
        }



        form = new FormData();
        form.append("bill_number", billNumber);
        form.append("item_name", name);
        form.append("quantity", quantiy);
        form.append("unit", unit);
        form.append("price", price);
        form.append("notes", notes);

        // set action
        form.append("action", "ADD_INVENTORY_ITEM");

        $.ajax({
            type: 'POST',
            url: AJAX_URL,
            data: form,
            contentType: false,
            processData: false,
            success: function(response) {
                response = $.parseJSON(response);
                if (response['status']) {
                    $('#name').val("");
                    $('#price').val("");
                    $('#quantity').val("");
                    $('#unit').val("0");
                    $('#billNumber').val("");
                    $('#notes').val("");
                    getInventoryItemList();
                    toastr.success("Item Successfully Added");
                } else {
                    if (response['message']) {
                        toastr.error(response['message']);
                    } else {
                        toastr.error("Action Failed");
                    }

                }
            }
        });
    });

    function editItem(item_id,billNumber,name,quantiy,unit,price,notes) {
        $('#editItemModal').find('#itemId').text(item_id);
        $('#editItemModal').find('#billNumber').val(billNumber);
        $('#editItemModal').find('#name').val(name);
        $('#editItemModal').find('#quantity').val(quantiy);
        $('#editItemModal').find('#unit').val(unit);
        $('#editItemModal').find('#price').val(price);
        $('#editItemModal').find('#notes').val(notes);

        $('#editItemModalBtn').click();
    }


    function saveEditedItemInfo(){
        var item_id = $('#editItemModal').find('#itemId').text();
        var billNumber = $('#editItemModal').find('#billNumber').val();
        var name = $('#editItemModal').find('#name').val();
        var quantiy = $('#editItemModal').find('#quantity').val();
        var unit = $('#editItemModal').find('#unit').val();
        var price = $('#editItemModal').find('#price').val();
        var notes = $('#editItemModal').find('#notes').val();

        if (!item_id || item_id.length <= 0) {
            toastr.error("No Item Found");
            return false;
        }
        if (!name || name.length <= 0) {
            toastr.error("Please Enter Item Name");
            return false;
        }
        if (!quantiy || quantiy.length <= 0) {
            toastr.error("Please Enter Quanity");
            return false;
        }
        if (!unit || unit.length <= 0) {
            toastr.error("Please Enter Unit");
            return false;
        }
        if (!price || price.length <= 0) {
            toastr.error("Please Enter Price");
            return false;
        }


        form = new FormData();
        form.append("item_id",item_id);
        form.append("bill_number", billNumber);
        form.append("item_name", name);
        form.append("quantity", quantiy);
        form.append("unit", unit);
        form.append("price", price);
        form.append("notes", notes);

        // set action
        form.append("action", "EDIT_INVENTORY_ITEM");

        $.ajax({
            type: 'POST',
            url: AJAX_URL,
            data: form,
            contentType: false,
            processData: false,
            success: function(response) {
                response = $.parseJSON(response);
                if (response['status']) {
                    $('#editItemModal').find('#name').val("");
                    $('#editItemModal').find('#price').val("");
                    $('#editItemModal').find('#quantity').val("");
                    $('#editItemModal').find('#unit').val("0");
                    $('#editItemModal').find('#billNumber').val("");
                    $('#editItemModal').find('#notes').val("");
                    getInventoryItemList();
                    toastr.success("Item Successfully Updated");
                    $('#editItemModalBtn').click();
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

    function deleteItem(itemId) {
        if (itemId.length <= 0) {
            toastr.error("Item Not Found");
            return false;
        } else {
            $.ajax({
                type: 'POST',
                url: AJAX_URL,
                data: {
                    'action': 'DELETE_INVENTORY_ITEM',
                    'item_id': itemId,
                },
                success: function(response) {
                    response = $.parseJSON(response);
                    if (response['status']) {
                        getInventoryItemList();
                        toastr.success("Item Successfully Deleted");
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
    }
</script>