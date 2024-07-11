@extends('layouts.app')

@section('breadcrumb')
    <section class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">
                <div class="col-md-5">
                    <h1 class="mb-xs-2">@lang('menu.jobOnboard')</h1>
                </div>
                <div class="col-md-7">
                    <span class="float-sm-right">@yield('create-button')</span>
                    <ol class="breadcrumb float-sm-right mr-2 mt-xs-2">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item active">@lang('menu.jobOnboard')</li>
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

                    <form class="ajax-form" method="POST" id="createForm">
                        @csrf

                        <input name="_method" type="hidden" value="PUT">

                    <div id="education_fields"></div>
                    <div class="row">
                        <div class="col-sm-9 nopadding">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" name="question" value="{{ $question->question }}" class="form-control" placeholder="@lang('menu.jobCategories') @lang('app.name')">

                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="address">@lang('app.required')</label>
                                <select name="required" class="form-control">
                                    <option @if($question->required == 'yes') selected @endif value="yes">@lang('app.yes')</option>
                                    <option @if($question->required == 'no') selected @endif  value="no">@lang('app.no')</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="type">@lang('app.type')</label>
                                <select name="type" class="form-control">
                                    <option @if($question->type == 'text') selected @endif value="text">@lang('app.text')</option>
                                    <option @if($question->type == 'file') selected @endif value="file">@lang('app.file')</option>
                                </select>
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
    // Update Question
    $('#save-form').click(function () {
        $.easyAjax({
            url: '{{route('admin.job-onboard-questions.update', $question->id)}}',
            container: '#createForm',
            type: "POST",
            redirect: true,
            data: $('#createForm').serialize()
        })
    });
</script>
@endpush