@extends('Admin.template')
@section('main-section')
    <style>
        .modal-dialog {
            max-width: 600px !important;
        }
    </style>
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">Videos</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Master</li>
                <li class="breadcrumb-item active" aria-current="page">Videos List</li>
            </ol>
        </div>
        <div>
            <button type="button" class="btn btn-outline-primary rounded" id="toggler" data-toggle="modal"
                data-target="#add_Videos_modal">
                Add Videos
            </button>
            <a href="#" class="btn ripple btn-primary navresponsive-toggler mb-0" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fe fe-filter mr-1"></i> Filter <i class="fas fa-caret-down ml-1"></i>
            </a>
        </div>
    </div>
    <div class="responsive-background">
        <div id="add_Videos_modal" class="modal fade" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('add_status_videos') }}" class="ajax-form-submit" id="cform" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="videoId" id="videoId" value="">
                        <div class="modal-body">
                            <div class="row" style="display: flex;justify-content: center;">
                                <div class="col-12">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="d-flex" for="catId">Select Category<span
                                                            class="tx-danger">*</span></label>
                                                    <select class="form-control select2" name="category" id="catId">
                                                        <option value=""></option>
                                                    </select>
                                                    <input type="hidden" name="catName" id="catName" value="">
                                                </div>
                                                <span class="float-left tx-danger error_text category_error"></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="float-left" for="videos">videos<span
                                                            class="tx-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input type="file" name="videos[]" multiple="multiple"
                                                            value="" class="form-control" id="videos"
                                                            accept="video/mp4,video/x-m4v,video/*">
                                                    </div>
                                                    <span class="float-left tx-danger error_text videos_error"></span>
                                                </div>
                                                <div class="form-group" id="profile_img_container">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 text-left">
                                                <label class="" for="cname">Is New<span
                                                        class="tx-danger">*</span></label>
                                                <div class="form-control form-group">
                                                    <div class="form-check form-check-inline float-left">
                                                        <input class="form-check-input" type="radio" name="new"
                                                            id="visible1" value="1" />
                                                        <label class="form-check-label" for="visible1">True</label>
                                                    </div>
                                                    <div class="form-check form-check-inline float-left">
                                                        <input class="form-check-input" type="radio" name="new"
                                                            id="visible2" value="0" checked />
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
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="advanced-search">
                <div class="row">
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
                                            <th>Category</th>
                                            <th>Videos</th>
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
            $('#videoId').val('');
            $("#catId").val('').trigger('change');
            document.getElementById("cform").reset();
            $('.modal-title').html('Add Videos');
            $('#videos').attr('multiple', 'multiple');
            $('#profile_img_container').html('');
        });

        $(".select2").select2({
            placeholder: "Select a Category",
            // allowClear: true,
            width: "100%",
            ajax: {
                url: "{{ url('get_status_video_Category') }}",
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
                        $('#add_Videos_modal').modal('toggle');
                        $('#save_data').prop('disabled', false);
                        Swal.fire("success!", response.msg, "success");
                        $('.data-table').DataTable().ajax.reload();
                        $('.form_proccessing').html('');
                        document.getElementById("cform").reset();
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

        function load_datatable(category_id = '') {
            $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                "order": [
                    [0, "desc"]
                ],
                ajax: {
                    url: '{{ route("status_videos_list") }}',
                    data: {
                        'category_id': category_id
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'catName',
                        name: 'catName'
                    },
                    {
                        data: 'videos',
                        name: 'videos'
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
                        url: "{{ url('delete_status_videos') }}",
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

        function edit_status_video(edit_item) {
            var id = $(edit_item).data('val');
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'POST',
                url: "{{ url('get_status_videos_data') }}",
                data: {
                    _token: CSRF_TOKEN,
                    id: id
                },
                success: function(response) {
                    if (response.st == 'success') {
                        $('#profile_img_container').html('');
                        $('.modal-title').html('Edit videos');
                        $('#videoId').val(response.msg.id);
                        $('#forlink').val(response.msg.foreground);
                        $('#add_Videos_modal').modal('show');
                        $('#videos').removeAttr('multiple');
                        $('#profile_img_container').append('<video controls width="200"; src="' +
                            response.msg.video +
                            '" />');
                        var catName = response.msg.catName;
                        if (response.msg.is_new == 'true') {
                            $('#visible1').prop("checked", true);
                        } else {
                            $('#visible2').prop("checked", true);
                        }
                        $('#catId').append(
                            `<option class="d-none" value="${response.msg.catId}" selected>${catName}</option>`
                        );
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

        $('#statusApply').click(function() {
            var category_id = $('#cat_id').val();
            if (category_id != '') {
                $('#table_list_data').DataTable().destroy();
                load_datatable(category_id);
            }
        });
    </script>
@endsection
