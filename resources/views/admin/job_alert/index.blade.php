@extends('layouts.app') @push('head-script')
    <link rel="stylesheet" href="//cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <style>
        .mb-20 {
            margin-bottom: 20px
        }
    </style>
@endpush

@section('breadcrumb')
    <section class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">
                <div class="col-md-5">
                    <h1 class="mb-xs-2">@lang('menu.jobAlert')</h1>
                </div>
                <div class="col-md-7">
                    <span class="float-sm-right">@yield('create-button')</span>
                    <ol class="breadcrumb float-sm-right mr-2 mt-xs-2">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item active">@lang('menu.jobAlert')</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-primary"><i class="icon-badge"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">@lang('modules.dashboard.totalJobsAlert')</span>
                    <span class="info-box-number">{{ number_format($totalJobAlert) }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-md-4 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="icon-badge"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">@lang('modules.dashboard.activeJobsAlert')</span>
                    <span class="info-box-number">{{ number_format($activeJobsAlert) }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-md-4 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-danger"><i class="icon-badge"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">@lang('modules.dashboard.inactiveJobsAlert')</span>
                    <span class="info-box-number">{{ number_format($inactiveJobsAlert) }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <select name="" id="filter-status" class="form-control">
                    <option value="">@lang('app.filter') @lang('app.status'): @lang('app.viewAll')</option>
                    <option value="active">@lang('app.active')</option>
                    <option value="inactive">@lang('app.inactive')</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <select name="" id="filter-location" class="form-control">
                    <option value="">@lang('app.filter') @lang('menu.locations'): @lang('app.viewAll')</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}">{{ ucwords($location->location) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive m-t-40">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('app.email')</th>
                                    <th>@lang('menu.locations')</th>
                                    <th>@lang('modules.jobs.workExperience')</th>
                                    <th>@lang('modules.jobs.jobType')</th>
                                    <th>@lang('app.status')</th>
                                    <th>@lang('app.action')</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('footer-script')
    <script src="//cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="//cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>

    <script>
        var table = $('#myTable').dataTable({
            responsive: true,
            // processing: true,
            serverSide: true,
            ajax: {
                'url': '{!! route('admin.job_alert.data') !!}',
                "data": function(d) {
                    return $.extend({}, d, {
                        "filter_status": $('#filter-status').val(),
                        "filter_location": $('#filter-location').val(),
                    });
                }
            },
            language: languageOptions(),
            "fnDrawCallback": function(oSettings) {
                $("body").tooltip({
                    selector: '[data-toggle="tooltip"]'
                });
            },
            columns: [{
                    data: 'DT_Row_Index',
                    name: 'DT_Row_Index',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'location_id',
                    name: 'location_id'
                },
                {
                    data: 'work_experience_id',
                    name: 'work_experience_id'
                },
                {
                    data: 'job_type_id',
                    name: 'job_type_id'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    width: '20%'
                }
            ]
        });

        new $.fn.dataTable.FixedHeader(table);

        $('#filter-status, #filter-location').change(function() {
            table._fnDraw();
        })

        $('body').on('click', '.sa-params', function(){
            var id = $(this).data('row-id');
            swal({
                title: "@lang('errors.areYouSure')",
                text: "@lang('errors.deleteWarning')",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "@lang('app.delete')",
                cancelButtonText: "@lang('app.cancel')",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function(isConfirm){
                if (isConfirm) {

                    let url = "{{ route('admin.job_alert.destroy', ':id') }}";
                    url = url.replace(':id', id);

                    var token = "{{ csrf_token() }}";

                    $.easyAjax({
                        type: 'POST',
                        url: url,
                        data: {'_token': token, '_method': 'DELETE'},
                        success: function (response) {
                            if (response.status == "success") {
                                $.unblockUI();
                                table._fnDraw();
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush
