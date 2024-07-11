@extends('layouts.app') 

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets/node_modules/dropify/dist/css/dropify.min.css') }}">
    <style>
        .company-logo {
            max-height: 40px;
        }

        .company-logo-div {
            border-radius: 5px;
            padding: 15px 0 0 10px;
            margin-bottom: 10px;
        }
    </style>
@endpush

@section('breadcrumb')
    <section class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">
                <div class="col-md-5">
                    <h1 class="mb-xs-2">@lang('menu.companies')</h1>
                </div>
                <div class="col-md-7">
                    <span class="float-sm-right">@yield('create-button')</span>
                    <ol class="breadcrumb float-sm-right mr-2 mt-xs-2">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item active">@lang('menu.companies')</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
      
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-md-12 company-logo-div bg-dark" >
                        <p><img src="{{ $company->logo_url }}" class="img-fluid company-logo" /></p>
                    </div>
                    <div class="col-md-12 mb-3">
                        <small class="text-muted">@lang('modules.company.registeredOn') {{ $company->created_at->format('d M, Y') }}</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 b-r">
                        <label>@lang('modules.accountSettings.companyName')</label>
                        
                        <p>{{ $company->company_name }} </p>
                    </div>
                    <div class="col-md-6 pl-3">
                        <label>@lang('modules.accountSettings.companyEmail')</label>
                        <p>{{ $company->company_email }}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6 b-r">
                        <label>@lang('modules.accountSettings.companyPhone')</label>
                        <p>{{ $company->company_phone }}</p>
                    </div>
                    <div class="col-md-6 pl-3">
                        <label>@lang('modules.accountSettings.companyWebsite')</label>
                        <p>{{ $company->website }}</p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6 b-r">
                        <label>@lang('modules.accountSettings.companyAddress')</label>
                        <p>{!! $company->address !!}</p>
                    </div>
                    <div class="col-md-6 pl-3">
                        <label>@lang('app.status')</label>
                        <p>
                            @if($company->status == 'active')
                                <label class="badge bg-success">@lang('app.active')</label>
                            @else
                                <label class="badge bg-danger">@lang('app.inactive')</label>
                            @endif
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
@push('footer-script')
<script src="{{ asset('assets/node_modules/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/node_modules/bootstrap-select/bootstrap-select.min.js') }}" type="text/javascript">
</script>
<script src="{{ asset('assets/node_modules/dropify/dist/js/dropify.min.js') }}" type="text/javascript"></script>