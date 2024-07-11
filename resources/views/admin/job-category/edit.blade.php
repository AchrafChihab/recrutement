@extends('layouts.app')
{{-- @section('breadcrumb')
    <section class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">
                <div class="col-md-5">
                    <h1 class="mb-xs-2">@lang('menu.jobCategories')</h1>
                </div>
                <div class="col-md-7">
                    <span class="float-sm-right">@yield('create-button')</span>
                    <ol class="breadcrumb float-sm-right mr-2 mt-xs-2">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item active">@lang('menu.jobCategories')</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection --}}

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">@lang('app.edit')</h4>

                    <form class="ajax-form" method="POST" id="createForm" onsubmit="return false;">
                        @csrf

                        <input name="_method" type="hidden" value="PUT">

                    <div id="education_fields"></div>
                    <div class="row">
                        <div class="col-sm-9 nopadding">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" name="name" value="{{ $category->name }}" class="form-control" placeholder="@lang('menu.jobCategories') @lang('app.name')">

                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="save-form" class="btn btn-success"><i class="fa fa-check"></i> @lang('app.save')</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer-script')
<script>
    var room = 1;

    // $('#add-more').click(function(){

    //     room++;
    //     var objTo = document.getElementById('education_fields')
    //     var divtest = document.createElement("div");
    //     divtest.setAttribute("class", "form-group removeclass" + room);
    //     var rdiv = 'removeclass' + room;
    //     divtest.innerHTML = '<div class="row"><div class="col-sm-9 nopadding"><div class="form-group"><div class="input-group"> <input type="text" name="name[]" class="form-control" placeholder="@lang('menu.jobCategories') @lang('app.name')"><div class="input-group-append"> <button class="btn btn-danger" type="button" onclick="remove_education_fields(' + room + ');"> <i class="fa fa-minus"></i> </button></div></div></div></div><div class="clear"></div></row>';

    //     objTo.appendChild(divtest)
    // })

    function remove_education_fields(rid) {
        $('.removeclass' + rid).remove();
    }

    $('#save-form').click(function () {
        $.easyAjax({
            url: '{{route('admin.job-categories.update', $category->id)}}',
            container: '#createForm',
            type: "POST",
            redirect: true,
            data: $('#createForm').serialize()
        })
    });
</script>
@endpush