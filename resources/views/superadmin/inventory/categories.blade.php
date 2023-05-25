<div class="p-3">
    <!-- categories Tab -->
    <div class="page-header flex-wrap">

        <h4 class="mb-0">
            Category
        </h4>

        <div class="d-flex">
        </div>

        <div class="d-flex">
            <a href="#" class="nav-link bg-addbtn mx-2 rounded" data-toggle="modal" data-target=".addCategory"> Add Category </a>
        </div>

    </div>
    <!-- <div class="table-responsive"> -->
        <table class="table table-bordered table-responsive text-center"  id="category_main_table">
            <thead>
                <tr>
                    <th style="text-align:center;">S/N</th>
                    <th style="text-align:center;">Category Name(English)</th>
                    <th style="text-align:center;">Category Name(Chinese)</th>
                    <th style="text-align:center;">Category Image</th>
                    <th style="text-align:center;">Action</th>
                </tr>
            </thead>
        </table>
    <!-- </div> -->
        
</div>

<!-- Add Category Model -->
@include('superadmin.inventory.category-model.addCategory')
<!-- End category model -->

<!-- Edit Category Model -->
@include('superadmin.inventory.category-model.editCategory')
<!-- End category model -->

<!-- View Category Model -->
@include('superadmin.inventory.category-model.viewCategory')
<!-- End category model -->

<!-- jQuery CDN -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> -->

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
<!-- backend js file -->



<script>
    $(document).ready(function() {
        category_main_table = $('#category_main_table').DataTable({
            "aaSorting": [],
            "bDestroy": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: false,
            // "scrollX": true,
            pageLength: 10,
            dom: "Bfrtip",
            buttons: [],
            ajax: {
                url: "{{ route('SA-GetCategories') }}",
                type: 'GET',
            },
        })
        $(document).find('#category_main_table').wrap('<div style="overflow-x:auto; width:100%;"></div>')
    });

    // get a single category
    $(document).on("click", "a[name = 'editCat']", function(e) {
        let id = $(this).data("id");
        varietnsArr = [];
        getCategory(id);

        function getCategory(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-GetCategory')}}",
                data: {
                    'id': id,
                },
                success: function(response) {
                    jQuery.each(response, function(key, value) {
                        $('#categoryId').val(value["id"]);
                        $('#categoryName').val(value["name"]);
                        $('#chinesecategoryName').val(value["chinese_name"]);
                        $('#editCategoryImg').attr('src', '/category/' + value['image'].substring(value['image'].lastIndexOf('/') + 1));
                        $('#categoryStatus').val(value["status"]);

                    });
                }
            });
        }
    });

    // delete a single category using id
    $(document).on("click", "a[name = 'removeConfirmCategory']", function(e) {
        let id = $(this).data("id");
        delCategory(id);

        function delCategory(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-RemoveCategory')}}",
                data: {
                    'id': id,
                },
                success: function(response) {
                    successMsg(response.success);
                    category_main_table.ajax.reload();
                    $("#removeModalCategory .close").click();
                }
            });
        }
    });

    // view a single category using id
    $(document).on("click", "a[name = 'view']", function(e) {
        let id = $(this).data("id");
        viewCategory(id);

        function viewCategory(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-ViewCategory')}}",
                data: {
                    'id': id,
                },
                success: function(response) {
                    jQuery.each(response, function(key, value) {
                        $('#viewcategoryId').val(value["id"]);
                        $('#viewcategoryName').val(value["name"]);
                        $('#viewchinesecategoryName').val(value["chinese_name"]);
                        $('#viewCategoryImg').attr('src', '/category/' + value['image'].substring(value['image'].lastIndexOf('/') + 1));
                        $('#viewcategoryStatus').val(value["status"]);
                    });
                }
            });
        }
    });
    // End function here


    $(document).on("click", "a[name = 'deleteCat']", function(e) {
        let id = $(this).data("id");
        $('#confirmRemoveSelectedElementCat').data('id', id);
    });
</script>




<div class="modal fade" id="removeModalCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm Alert</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">DO YOU WANT TO DELETE?<span id="removeElementId"></span> </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">NO</button>
                <a name="removeConfirmCategory" class="btn btn-primary" id="confirmRemoveSelectedElementCat">
                    YES
                </a>
            </div>
        </div>
    </div>
</div>