@extends('layouts.app')
@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets/node_modules/switchery/dist/switchery.min.css') }}">
    <style>
        .dropify-wrapper,
        .dropify-preview,
        .dropify-render img {
            background-color: var(--sidebar-bg) !important;
        }

        #carousel-image-gallery .card .img-holder {
            height: 150px;
            overflow: hidden;
        }

        #carousel-image-gallery .card .img-holder img {
            height: 100%;
            object-fit: cover;
            object-position: top;
        }

        .note-group-select-from-files {
            display: none;
        }

        #captcha-detail-modal .modal-dialog {
            height: 90%;
            max-width: 100%;
        }

        #captcha-detail-modal .modal-content {
            width: 600px;
            margin: 0 auto;
        }

        .modal.show {
            padding-right: 0px !important;
        }

        #v2_captcha_container {
            margin-bottom: 1%;
        }

        #save-btn-div {
            margin-top: 2%;
        }

        #customCss {
            margin-left: 0.4%;
            margin-right: 0.4%;
        }

        .google_recaptcha_options label {
            margin-bottom: -0.5rem;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4 text-primary">@lang('app.googleRecaptchaStatus')</h4>
                    <form id="google-captcha-setting-form" class="ajax-form" method="POST">
                        <div id="alert"></div>
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="googleRecaptcha">@lang('app.googleRecaptcha')</label>

                            <div class="col-sm-4">
                                <div class="switchery-demo">
                                    <input id="googleRecaptcha" name="status" type="checkbox"
                                        @if ($credentials->status == 'active') checked @endif value="active"
                                        class="js-switch change-language-setting" data-color="#99d683" data-size="small"
                                        data-setting-id="{{ $credentials->id }}" onchange="changeStatus();" />
                                </div>
                            </div>

                        </div>

                        <div id="google-captcha-credentials">
                            <div class="form-group">
                                <label class="font-weight-bold">@lang('app.choosegooglerecaptchaversion:')</label>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label class="radio-inline"><input value="v2" id="v2" type="radio"
                                        name="version" @if ($credentials->v2_status == 'active') checked @endif>&nbsp;&nbsp;
                                    v2</label>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <label class="radio-inline"><input value="v3" id="v3" type="radio"
                                        name="version" @if ($credentials->v3_status == 'active') checked @endif>&nbsp;&nbsp;
                                    v3</label>

                            </div>

                            <div class="form-group">
                                <label class="control-label">
                                    @lang('app.checkoptionswhereyouwantstoapply')
                                </label>
                                <br>
                                <div class="row">
                                    <div class="col-md-4 google_recaptcha_options mt-3">
                                        <label class="switch">
                                            <input type="checkbox" name="job_apply_page" id="job_apply_page"
                                                @if ($credentials->job_apply_page == 'active') checked @endif
                                                value="active"class="js-switch change-language-setting" data-color="#99d683"
                                                data-size="small" data-setting-id="{{ $credentials->id }}">
                                            <span class="slider round"></span>
                                        </label>
                                        <label for="job_apply_page" class="">@lang('app.jobapplypage')</label>
                                    </div>
                                    <div class="col-md-4 google_recaptcha_options mt-3">
                                        <label class="switch">
                                            <input type="checkbox" name="login_page" id="login_page"
                                                @if ($credentials->login_page == 'active') checked @endif value="active"
                                                class="js-switch change-language-setting" data-color="#99d683"
                                                data-size="small" data-setting-id="{{ $credentials->id }}">
                                            <span class="slider round"></span>
                                        </label>
                                        <label for="login_page" class="">@lang('app.login_page')</label>
                                    </div>
                                </div>
                                <br>
                            </div>
                            <div id="google_captcha_v3">
                                <div class="form-group">
                                    <label>@lang('app.site_key')</label>
                                    <input type="text" name="v3_site_key" id="v3_google_captcha_site_key"
                                        class="form-control form-control-lg" value="{{ $credentials->v3_site_key }}">
                                </div>

                                <div class="form-group">
                                    <label>@lang('app.secret_key')</label>
                                    <input type="text" name="v3_secret_key" id="v3_google_captcha_secret"
                                        class="form-control form-control-lg" value="{{ $credentials->v3_secret_key }}">
                                </div>

                                <div class="form-group">
                                    <button type="button" class="btn btn-success" id="verify-v3"><i
                                            class="fa fa-check"></i> @lang('app.verify')
                                    </button>
                                </div>
                                <div class="col-lg-12" id="v3_captcha_container"></div>

                            </div>

                            <div id="google_captcha_v2">
                                <div class="form-group">
                                    <label>@lang('app.site_key')</label>
                                    <input type="text" name="v2_site_key" id="v2_google_captcha_site_key"
                                        class="form-control form-control-lg" value="{{ $credentials->v2_site_key }}">
                                </div>

                                <div class="form-group">
                                    <label>@lang('app.secret_key')</label>
                                    <input type="text" name="v2_secret_key" id="v2_google_captcha_secret"
                                        class="form-control form-control-lg" value="{{ $credentials->v2_secret_key }}">
                                </div>

                                <div class="col-lg-12" id="v2_captcha_container"></div>

                                <div class="form-group">
                                    <button type="button" class="btn btn-success" id="verify-v2"><i
                                            class="fa fa-check"></i> @lang('app.verify')
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('footer-script')
    <script src="{{ asset('assets/node_modules/switchery/dist/switchery.min.js') }}"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <script>
        function changeStatus() {

            var url = "{{ route('admin.security-setting.update', $credentials->id) }}";
            var status = $('#googleRecaptcha').is(':checked') ? 'active' : 'incative';
            var token = '{{ csrf_token() }}';
            $.easyAjax({
                url: url,
                type: "POST",
                data: {
                    'status': status,
                    'type': 'status',
                    '_method': "PUT",
                    '_token': token
                },
            })

            $('#google-captcha-credentials').toggle();
        }

        @if ($credentials->status == 'active')
            $('#google-captcha-credentials').show()
        @else
            $('#google-captcha-credentials').hide()
        @endif ;

        // Switchery
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function() {
            new Switchery($(this)[0], $(this).data());

        });

        // Update Mail Setting
        function saveForm() {
            var url = "{{ route('admin.security-setting.update', $credentials->id) }}";

            $.easyAjax({
                url: url,
                container: '#google-captcha-setting-form',
                type: "POST",
                data: $('#google-captcha-setting-form').serialize(),
                success: function(response) {
                    if (response.status == 'success') {
                        location.reload();
                    }
                }
            })
        }

        function errorMsg() {
            var form = $("#google-captcha-setting-form");
            var checkedValue = form.find("input[name=version]:checked").val();

            if (checkedValue == 'v3') {
                let msg = `<div class="alert alert-danger" role="alert"><i class="fa fa-info-circle"></i>
                Unexpected error occured.
                </div>`;
                $('#portlet-body').html(msg);
                $('#portlet-body').attr('data-error', true);
                $('#save-method').hide();
                return false;
            }

            swal({
                title: "Error..!",
                text: "@lang('errors.invalidReCaptcha')",
                icon: 'warning',
                showCancelButton: false,
                focusConfirm: false,
                confirmButtonText: "Ok",
                customClass: {
                    confirmButton: 'btn btn-primary mr-3',
                    cancelButton: 'btn btn-secondary'
                },
                showClass: {
                    popup: 'swal2-noanimation',
                    backdrop: 'swal2-noanimation'
                },
                buttonsStyling: false,
            }).then((willDelete) => {
                if (willDelete) {
                    location.reload();
                }
            });
        }

        $(function() {
            '{{ $credentials->v2_status }}' === 'active' ? $('#google_captcha_v2').show(): $('#google_captcha_v2')
                .hide();
            '{{ $credentials->v3_status }}' === 'active' ? $('#google_captcha_v3').show(): $('#google_captcha_v3')
                .hide();

            $('body').on('click', 'input[type="radio"]', function() {
                if ($(this).attr('id') == 'v2') {
                    $('#google_captcha_v2').show();
                    $('#google_captcha_v3').hide();
                } else {
                    $('#google_captcha_v3').show();
                    $('#google_captcha_v2').hide();
                }
            })

            $('input[type=radio][name=version]').change(function() {
                if (this.value == 'v2') {
                    $('#v2').removeClass('d-none');
                    $('#v3').addClass('d-none');
                } else if (this.value == 'v3') {
                    $('#v3').removeClass('d-none');
                    $('#v2').addClass('d-none');
                }
            });

            $(document).on('click', '#verify-v2', function() {

                let captchaContainerV2 = null;
                let key = $('#v2_google_captcha_site_key').val();
                let secret = $('#v2_google_captcha_secret').val();

                if (key === '' || secret === '') {
                    swal({
                        title: "Error..!",
                        icon: 'warning',
                        text: '@lang('errors.reCaptchaWarning')',
                    });
                    return false;
                }

                try {
                    captchaContainer = grecaptcha.render('v2_captcha_container', {
                        'sitekey': key,
                        'callback': function(response) {
                            if (response) {
                                saveForm();
                            }
                        },
                        'error-callback': function() {
                            errorMsg();
                        }
                    });
                } catch (error) {
                    errorMsg();
                }
            });

            $(document).on('click', '#verify-v3', function() {
                let key = $('#v3_google_captcha_site_key').val();
                let secret = $('#v3_google_captcha_secret').val();
                var url = "{{ route('admin.security-setting.verifyCaptcha') }}?key=" + key;
                if (key === '' || secret === '') {
                    swal({
                        title: "Error..!",
                        icon: 'warning',
                        text: '@lang('errors.reCaptchaWarning')',
                    });
                    return false;
                }
                var url = url;

                $('#modelHeading').html('@lang('app.package')');
                $('#application-lg-modal').modal('hide');
                $.ajaxModal('#application-lg-modal', url);
            });

        });
    </script>
@endpush
