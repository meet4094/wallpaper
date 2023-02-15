@extends('Admin.template')
@section('main-section')
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">App By Category</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Master</li>
                <li class="breadcrumb-item active" aria-current="page">App By Category List</li>
            </ol>
        </div>
        <div>
            <button type="button" class="btn btn-outline-primary rounded" id="toggler" data-toggle="modal"
                data-target="#add_app_by_image_category_modal">
                Add Category
            </button>
            <a href="#" class="btn ripple btn-primary navresponsive-toggler mb-0" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fe fe-filter mr-1"></i> Filter <i class="fas fa-caret-down ml-1"></i>
            </a>
        </div>
    </div>
    <div class="responsive-background">
        <div id="add_app_by_image_category_modal" class="modal fade" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('add_app_by_image_category') }}" class="ajax-form-submit" id="cform"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="appbycatId" id="appbycatId" value="">
                        <div class="modal-body">
                            <div class="row" style="display: flex;justify-content: center;">
                                <div class="col-12">
                                    <div class="">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="d-flex" for="appId">Select App<span
                                                                class="tx-danger">*</span></label>
                                                        <select class="form-control select_app" name="appId"
                                                            id="appId">
                                                            <option value=""></option>
                                                        </select>
                                                        <input type="hidden" name="appName" id="appName" value="">
                                                    </div>
                                                    <span class="float-left tx-danger error_text appId_error"></span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="d-flex" for="catId">Select Category<span
                                                                class="tx-danger">*</span></label>
                                                        <select class="form-control select2" name="categoryId"
                                                            id="categoryId">
                                                            <option value=""></option>
                                                        </select>
                                                        <input type="hidden" name="catName" id="catName" value="">
                                                    </div>
                                                    <span class="float-left tx-danger error_text categoryId_error"></span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="float-left" for="category">Name<span
                                                                class="tx-danger">*</span></label>
                                                        <input type="text" class="form-control" id="category"
                                                            placeholder='Enter category' name="category" value="">
                                                        <span class="float-left tx-danger error_text category_error"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="float-left" for="image">Image<span
                                                                class="tx-danger">*</span></label>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control" id="dropify_image"
                                                                name="image" accept="image/png, image/gif, image/jpeg"
                                                                data-default-file="" data-height="200">
                                                        </div>
                                                    </div>
                                                    <div class="form-group" id="profile_img_container">
                                                    </div>
                                                    <span class="float-left tx-danger error_text image_error"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="error-msg tx-danger"></div>
                                    <div class="form_proccessing tx-success float-left"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" id="save_data" type="submit" value="Submit">Submit</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="advanced-search">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">app</span></label>
                            <select class="form-control select2-flag-search select_app" id="app_id">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">categories</span></label>
                            <select class="form-control select2-flag-search select2" id="cat_id">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <a href="#" id="statusApply" class="btn btn-primary">Apply</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card custom-card">
                    <div class="card-header-divider">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table data-table table-striped table-hover table-fw-widget"
                                    id="table_list_data" width="100%">
                                    <!-- data-filter_data is static as there are different tabs for filtering that are already defined -->
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>App Name</th>
                                            <th>Main Category Name</th>
                                            <th>Sub Category Name</th>
                                            <th>Background Image</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#toggler').on('click', function() {
            $('#id').val('');
            $('#profile_img_container').html('');
            $('.modal-title').html('Add Category');
            document.getElementById("cform").reset();
            $('.dropify-clear').trigger("click");
        });

        // $("#profile_img_container").click(function() {
        //     $("#image").click();
        // });

        $(".select2").select2({
            placeholder: "Select a Category",
            // allowClear: true,
            width: "100%",
            ajax: {
                url: "{{ url('getCategory') }}",
                type: "post",
                allowClear: true,
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term, // search term
                        categoryId: $('select[name="categoryId"]').val(),
                    };
                },
                processResults: function(response) {
                    console.log(response);
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });

        $('.select2').on('change', function() {
            var data = $(".select2 option:selected").text();
            $("#catName").val(data);
        })

        $(".select_app").select2({
            placeholder: "Select a App",
            // allowClear: true,
            width: "100%",
            ajax: {
                url: "{{ url('getApp') }}",
                type: "post",
                allowClear: true,
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term, // search term
                        app_name: $('select[name="app_name"]').val(),
                    };
                },
                processResults: function(response) {
                    console.log(response);
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });

        $('.select_app').on('change', function() {
            var data = $(".select_app option:selected").text();
            $("#appName").val(data);
        })

        var loadFile = function(event) {
            var image = document.getElementById('profile_img_container');
            image.src = URL.createObjectURL(event.target.files[0]);
        };

        $(document).ready(function() {
            $('.dropify').dropify();
        });

        $('.ajax-form-submit').on('submit', function(e) {
            $('#save_data').prop('disabled', true);
            $('.error-msg').html('');
            $('.form_proccessing').html('Please wait...');
            e.preventDefault();
            var aurl = $(this).attr('action');
            var form = $(this);
            var formdata = false;
            if (window.FormData) {
                formdata = new FormData(form[0]);
            }
            $.ajax({
                type: "POST",
                url: aurl,
                cache: false,
                contentType: false,
                processData: false,
                data: formdata ? formdata : form.serialize(),
                success: function(response) {
                    console.log(response.st);
                    if (response.st == 'success') {
                        $('#add_app_by_image_category_modal').modal('toggle');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.msg,
                        }).then(() => {
                            location.reload()
                        });
                    } else {
                        $('.form_proccessing').html('');
                        $('#save_data').prop('disabled', false);
                        $.each(response.error, function(prefix, val) {
                            $('span.' + prefix + '_error').text(val).show().delay(5000)
                                .fadeOut();
                        });
                    }
                },
                error: function() {
                    $('#save_data').prop('disabled', false);
                    alert('Error');
                }
            });
            return false;
        });

        $(document).ready(function() {
            load_datatable('');
        });

        function load_datatable(category_id = '', app_id = '') {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                "order": [
                    [0, "desc"]
                ],
                ajax: {
                    url: '{{ route('app_by_image_category_list') }}',
                    data: {
                        'category_id': category_id,
                        'app_id': app_id,
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'app_name',
                        name: 'app_name'
                    },
                    {
                        data: 'catName',
                        name: 'catName'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'images',
                        name: 'images'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
            $('#statusApply').on('submit', function(e) {
                oTable.draw();
                e.preventDefault();
            });
        };

        function editable_remove(data_delete) {
            var type = 'Remove';
            var id = $(data_delete).data('val');
            var ot_title = $(data_delete).attr('title');
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            Swal.fire({
                title: 'Are you sure want to delete?',
                // text: "You won't be able to recover this data!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ url('delete_app_by_image_category') }}",
                        type: 'post',
                        data: {
                            _token: CSRF_TOKEN,
                            id: id
                        },
                        success: function(response) {
                            if (response.success == 1) {
                                Swal.fire(
                                    'Deleted!',
                                    'Your data has been deleted.',
                                    'success'
                                )
                                $('.data-table').DataTable().ajax.reload();
                            } else {
                                alert("Invalid ID.");
                            }
                        }
                    });
                } else {
                    swal.fire("Cancelled", "Your data is safe", "error");

                }
            })
        }

        function edit_app_by_image_category(edit_category) {
            var id = $(edit_category).data('val');
            $.ajax({
                type: 'POST',
                url: "{{ url('getappbyimagecategorydata') }}",
                data: {
                    id: id
                },
                success: function(response) {
                    console.log(response);
                    if (response.st == 'success') {
                        $('#profile_img_container').html('');
                        $('.modal-title').html('Edit Category');
                        $('.dropify-clear').trigger("click");
                        $('#appbycatId').val(response.msg.id);
                        $('#appId').append(
                            `<option class="d-none" value="${response.msg.appId}" selected>${response.msg.appName}</option>`
                        );
                        $('#categoryId').append(
                            `<option class="d-none" value="${response.msg.catId}" selected>${response.msg.catName}</option>`
                        );
                        $('#categoryId').val(response.msg.catId);
                        $('#category').val(response.msg.name);
                        $('#profile_img_container').append('<img width="200"; src="' +
                            response.msg.image +
                            '" />');
                        $('#add_app_by_image_category_modal').modal('show');
                    } else {
                        alert('failed');
                    }
                },
                error: function(error) {
                    $('#save_data').prop('disabled', false);
                    alert('Error');
                }
            });
        }

        $('#statusApply').click(function() {
            var category_id = $('#cat_id').val();
            var app_id = $('#app_id').val();
            if (category_id != '' || app_id != '') {
                $('#table_list_data').DataTable().destroy();
                load_datatable(category_id, app_id);
            }
        });
    </script>
@endsection
