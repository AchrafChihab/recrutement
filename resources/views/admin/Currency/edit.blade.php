@extends('layouts.app')

@section('breadcrumb')
    <section class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">
                <div class="col-md-5">
                    <h1 class="mb-xs-2">@lang('menu.currencySetting')</h1>
                </div>
                <div class="col-md-7">
                    <span class="float-sm-right">@yield('create-button')</span>
                    <ol class="breadcrumb float-sm-right mr-2 mt-xs-2">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item active">@lang('menu.currencySetting')</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">@lang('app.edit')</h4>

                <form id="editSettings" class="ajax-form">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="company_name">@lang('modules.currency.currencyName')</label>
                        <input type="text" class="form-control" id="currency_name" name="currency_name" value="{{ $currency->currency_name }}">
                    </div>
                    <div class="form-group">
                        <label for="company_email">@lang('modules.currency.currencySymbol')</label>
                        <input type="email" class="form-control" id="currency_symbol" name="currency_symbol" value="{{ $currency->currency_symbol }}">
                    </div>
                    <div class="form-group">
                        <label for="company_phone">@lang('modules.currency.currencyCode')</label>
                        <input type="tel" class="form-control" id="currency_code" name="currency_code" value="{{ $currency->currency_code }}">
                    </div>

                    <button type="button" id="save-form" class="btn btn-success waves-effect waves-light m-r-10">
                            @lang('app.save')
                        </button>
                    <button type="reset" class="btn btn-inverse waves-effect waves-light">@lang('app.reset')</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('footer-script')

<script>

        $('#save-form').click(function () {
            $.easyAjax({
                url: '{{route("admin.currency-settings.update", $currency->id)}}',
                container: '#editSettings',
                type: "POST",
                redirect: true,
                file: true
            })
        });
</script>

@endpush