<?php include "__header__.php"; ?>


<div class="p-3 mb-5 sticky-top text-white bg-dark">
    <h3>Items Manager</h3>
</div>
<div class="">

    <div class="card">
        <div class="card-header">
            <h6>Add New Item</h6>
        </div>
        <div class="card-body">
            <div class="row p-3">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="">Select Categroy</label>
                        <select name="categroy" id="category" class="form-control" required>
                            <option value="0" disabled selected>PLEASE SELECT</option>
                        </select>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="">Select Image</label>
                        <input type="file" name="item_image" id="item_image" class="form-control" accept="image/*" required>
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
                        <label for="">Enter Price</label>
                        <input type="number" name="price" id="price" class="form-control" required>
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
            <h6>Items List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive ">
                <table class="table table-striped table-bordered">
                    <thead class="alert-info">
                        <tr >
                            <th>Sr.#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id = 'itemsList'>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php include "__footer__.php"; ?>


<script>
    $(document).ready(function() {
        getCategroyList();
        getItemList();
    });


    function getCategroyList() {

        $.ajax({
            type: 'POST',
            url: AJAX_URL,
            data: {
                'action': 'GET_CATEGORY_LIST',
            },
            success: function(response) {
                response = $.parseJSON(response);

                html = '<option value="0" disabled selected>PLEASE SELECT</option>';
                $.each(response['categories'], function(key, value) {
                    html += '<option value="' + value['type_id'] + '">' + value['type_name'] + '</option>';
                });

                $('#category').html(html);
            }
        });

    }


    function getItemList() {
        $.ajax({
            type: 'POST',
            url: AJAX_URL,
            data: {
                'action': 'GET_ITEM_LIST',
            },
            success: function(response) {
                response = $.parseJSON(response);
                html = '';
                $.each(response['items'], function(key, value) {
                        html+="<tr>";
                        html+="    <td>"+(key+1)+"</td>";
                        html+="    <td><img src = '../"+value['item_image']+"' class = 'item_image' width=50 height=50/></td>";
                        html+="    <td>"+value['item_name']+"</td>";
                        html+="    <td>"+value['item_price']+"</td>";
                        html+="    <td>"+value['type_name']+"</td>";
                        html+="    <td><button type= 'button' class = 'btn btn-danger ' onclick='deleteItem("+value['item_id']+")'><i class = 'fa fa-times'></i></button></td>";
                        html+="</tr>";
                });

                $('#itemsList').html(html);
            }
        });
    }


    $('#saveNewItem').click(function() {
        var category = $('#category').val();
        var name = $('#name').val();
        var price = $('#price').val();
        var item_image = $('#item_image').val();

        if (!category || category.length <= 0) {
            toastr.error("Please Select Catergory");
            return false;
        }
        if (!name || name.length <= 0) {
            toastr.error("Please Enter Item Name");
            return false;
        }
        if (!price || price.length <= 0) {
            toastr.error("Please Enter Price");
            return false;
        }
        if (!item_image || item_image.length <= 0) {
            toastr.error("Please Select Item Image");
            return false;
        }


        if (item_image.length > 0) {
            item_image = $('#item_image').prop('files')[0];
            var fileName = document.getElementById("item_image").value;
            var idxDot = fileName.lastIndexOf(".") + 1;
            var item_imageEXT = fileName.substr(idxDot, fileName.length).toLowerCase();
        }


        form = new FormData();
        form.append("category", category);
        form.append("name", name);
        form.append("price", price);
        form.append("item_image", item_image);

        // set action
        form.append("action", "ADD_NEW_ITEM");

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
                    $('#item_image').val("");
                    $('#category').val("0");
                    getItemList();
                    toastr.success("Item Successfully Added");
                } else {
                    if (response['message']){
                        toastr.error(response['message']);
                    }else{
                        toastr.error("Action Failed");
                    }
                    
                }
            }
        });
    });


    function deleteItem(itemId){
        if (itemId.length <= 0) {
            toastr.error("Item Not Found");
            return false;
        } else {
            $.ajax({
                type: 'POST',
                url: AJAX_URL,
                data: {
                    'action': 'DELETE_ITEM',
                    'item_id': itemId,
                },
                success: function(response) {
                    response = $.parseJSON(response);
                    if (response['status']) {
                        getItemList();
                        toastr.success("Item Successfully Deleted");
                    } else {
                        if (response['message']){
                        toastr.error(response['message']);
                    }else{
                        toastr.error("Action Failed");
                    }
                    }
                }
            });
        }
    }
</script>