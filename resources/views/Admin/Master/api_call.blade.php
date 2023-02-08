@extends('Admin.template')
@section('main-section')
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">Api Call</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Master</li>
                <li class="breadcrumb-item active" aria-current="page">Api Call List</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-header-divider">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table data-table table-striped table-hover table-fw-widget" id="table_list_data"
                                width="100%">
                                <!-- data-filter_data is static as there are different tabs for filtering that are already defined -->
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Devices Id</th>
                                        <th>Package Name</th>
                                        <th>App Version</th>
                                        <th>App Version Code</th>
                                        <th>Ip Address</th>
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

        $(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                "order": [
                    [0, "desc"]
                ],
                ajax: "{{ route('api_call_list') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'device_id',
                        name: 'device_id',
                    },
                    {
                        data: 'package_name',
                        name: 'package_name',
                    },
                    {
                        data: 'app_version',
                        name: 'app_version',
                    },
                    {
                        data: 'version_code',
                        name: 'version_code',
                    },
                    {
                        data: 'ip_address',
                        name: 'ip_address',
                    },
                ]
            });
        });
    </script>
@endsection
