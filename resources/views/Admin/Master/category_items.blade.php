@extends('Admin.template')
@section('main-section')
<style>
    .modal-dialog {
        max-width: 600px !important;
    }
</style>
<div class="page-header">
    <div>
        <h2 class="main-content-title tx-24 mg-b-5">Images</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Master</li>
            <li class="breadcrumb-item active" aria-current="page">Images List</li>
        </ol>
    </div>
    <div class="btn btn-list">
        <button type="button" class="btn btn-outline-primary rounded" id="toggler" data-toggle="modal" data-target="#add_Images_modal">
            Add Images
        </button>
        <div id="add_Images_modal" class="modal fade" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url ('add_items') }}" class="ajax-form-submit" id="cform" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="itemId" id="itemId" value="">
                        <div class="modal-body">
                            <div class="row" style="display: flex;justify-content: center;">
                                <div class="col-12">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="d-flex" for="catId">Select Category<span class="tx-danger">*</span></label>
                                                    <select class="form-control select2" name="catId" id="catId">
                                                        <option value=""></option>
                                                    </select>
                                                    <input type="hidden" name="catName" id="catName" value="">
                                                </div>
                                                <span class="float-left tx-danger error_text catId_error"></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="float-left" for="images">Images<span class="tx-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input type="file" class="form-control" value="" name="images[]" accept="image/png, image/gif, image/jpeg" id=" images" multiple />
                                                    </div>
                                                    <span class="float-left tx-danger error_text images_error"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 text-left">
                                                <label class="" for="cname">Is New<span class="tx-danger">*</span></label>
                                                <div class="form-control form-group">
                                                    <div class="form-check form-check-inline float-left">
                                                        <input class="form-check-input" type="radio" name="new" id="visible1" value="true" />
                                                        <label class="form-check-label" for="visible1">True</label>
                                                    </div>
                                                    <div class="form-check form-check-inline float-left">
                                                        <input class="form-check-input" type="radio" name="new" id="visible2" value="false" checked />
                                                        <label class="form-check-label" for="visible2">False</label>
                                                    </div>
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
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card custom-card">
            <div class="card-header-divider">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table data-table table-striped table-hover table-fw-widget" id="table_list_data" width="100%">
                            <!-- data-filter_data is static as there are different tabs for filtering that are already defined -->
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Category</th>
                                    <th>Images</th>
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
@endsection
@section('scripts')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#toggler').on('click', function() {
        $('#itemId').val('');
        $("#catId").val('').trigger('change');
        document.getElementById("cform").reset();
        $('.modal-title').html('Add Images');
    });


    $(".select2").select2({
        placeholder: "Select a Category",
        // allowClear: true,
        width: "100%",
        ajax: {
            url: "{{ url ('getCategory') }}",
            type: "post",
            allowClear: true,
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    searchTerm: params.term, // search term
                    category: $('select[name="category"]').val(),
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
                console.log(response);
                if (response.st == 'success') {
                    $('#add_Images_modal').modal('toggle');
                    $('#save_data').prop('disabled', false);
                    Swal.fire("success!", response.msg, "success");
                    $('.data-table').DataTable().ajax.reload();
                    $('.form_proccessing').html('');
                    document.getElementById("cform").reset();
                } else {
                    $('.form_proccessing').html('');
                    $('#save_data').prop('disabled', false);
                }
            },
            error: function() {
                $('#save_data').prop('disabled', false);
                alert('Error');
            }
        });
        return false;
    });

    $(function() {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            "order": [
                [0, "desc"]
            ],
            ajax: "{{ route('items_list') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'catName',
                    name: 'catName'
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
    });

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
                    url: "{{ url ('delete_item') }}",
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

    function edit_item(edit_item) {
        var id = $(edit_item).data('val');
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'POST',
            url: '/getitemdata',
            data: {
                _token: CSRF_TOKEN,
                id: id
            },
            success: function(response) {
                if (response.st == 'success') {
                    $('.modal-title').html('Edit Images');
                    $('#itemId').val(response.msg.id);
                    $('#forlink').val(response.msg.foreground);
                    $('#add_Images_modal').modal('show');
                    var catName = response.msg.catName;
                    if (response.msg.is_new == 'true') {
                        $('#visible1').prop("checked", true);
                    } else {
                        $('#visible2').prop("checked", true);
                    }
                    $('#catId').append(`<option class="d-none" value="${response.msg.catId}" selected>${catName}</option>`);
                } else {
                    $.each(response.error, function(prefix, val) {
                        $('span.' + prefix + '_error').text(val).show().delay(5000).fadeOut();
                    });
                }
            },
            error: function(error) {
                $('#save_data').prop('disabled', false);
                alert('Error');
            }
        });
    }
</script>
@endsection