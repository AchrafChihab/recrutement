@extends('layouts.app')

@push('head-script')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datepicker/datepicker3.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('breadcrumb')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-5">
                    <h1 class="mb-xs-2">@lang('menu.jobApplications')</h1>
                </div>
                <div class="col-md-7">
                    <span class="float-sm-right">@yield('create-button')</span>
                    <ol class="breadcrumb float-sm-right mr-2 mt-xs-2">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item active">@lang('menu.jobApplications')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">@lang('app.createNew')</h4>

                    @if (count($jobs) == 0)
                        <div class="alert alert-danger alert-dismissible fade show">
                            <h4 class="alert-heading"><i class="fa fa-warning"></i> Warning!</h4>
                            <p>You do not have any job created. You need to create the job first to add the job application.
                                <a href="{{ route('admin.jobs.create') }}" class="btn btn-info btn-sm m-l-15"
                                    style="text-decoration: none;"><i class="fa fa-plus-circle"></i> @lang('app.createNew')
                                    @lang('menu.jobs')</a>
                            </p>
                        </div>
                    @else
                    <form class="ajax-form" method="POST" enctype="multipart/form-data" id="createForm">
                        @csrf
                        <div class="form-group">
                            <label class="control-label required">@lang('app.name')</label>
                            <input class="form-control" type="text" name="full_name" placeholder="@lang('app.name')">
                        </div>
                        <div class="form-group">
                            <label class="control-label required">@lang('app.email')</label>
                            <input class="form-control" type="email" name="email" placeholder="@lang('app.email')">
                        </div>
                        <div class="form-group">
                            <label class="control-label required">@lang('app.phone')</label>
                            <input class="form-control" type="tel" name="phone" placeholder="@lang('app.phone')">
                        </div>
                        <div class="form-group">
                            <label class="control-label">@lang('app.address')</label>
                            <textarea class="form-control" name="address" rows="4" cols="50" placeholder="@lang('app.address')"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label">@lang('app.annees_experience')</label>
                            <input class="form-control" type="text" name="annees_experience" placeholder="@lang('app.annees_experience')">
                        </div>
                        <div class="form-group">
                            <label class="control-label">@lang('app.payment_type')</label>
                            <select name="statut_employee" id="payment_type" class="form-control" onchange="togglePaymentFields()">
                                <option value="salarier">@lang('app.salarier')</option>
                                <option value="freelance">@lang('app.freelance')</option>
                            </select>
                        </div>
                        <div id="salarierFields" class="payment-fields">
                            <div class="form-group">
                                <label class="control-label">@lang('app.salaire_actuel')</label>
                                <input class="form-control" type="text" name="salaire_actuel" placeholder="@lang('app.salaire_actuel')">
                            </div>
                            <div class="form-group">
                                <label class="control-label">@lang('app.retention_salariale')</label>
                                <input class="form-control" type="text" name="retention_salariale" placeholder="@lang('app.retention_salariale')">
                            </div>
                        </div>
                        <div id="freelanceFields" class="payment-fields" style="display: none;">
                            <div class="form-group">
                                <label class="control-label">@lang('app.tj_actual')</label>
                                <input class="form-control" type="text" name="tj_actual" placeholder="@lang('app.tj_actual')">
                            </div>
                            <div class="form-group">
                                <label class="control-label">@lang('app.tj_souhaite')</label>
                                <input class="form-control" type="text" name="tj_souhaite" placeholder="@lang('app.tj_souhaite')">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">@lang('app.disponibilite')</label>
                            <select name="disponibilite" id="dispo" class="form-control" onchange="togglePaymentFields()">
                                <option value="immediate">@lang('app.immediate')</option>
                                <option value="notice">@lang('app.notice')</option>
                            </select>
                        </div>
                        <div id="preavis" class="form-group" style="display: none;">
                            <label class="control-label">@lang('app.notice')</label>
                            <input class="form-control" type="text" name="preavis" placeholder="@lang('app.notice')">
                        </div>
                        <div class="form-group">
                            <label class="control-label">@lang('app.niveau_etudes')</label>
                            <select name="niveau_etudes" class="form-control">
                                <option value="highschool">@lang('app.highschool')</option>
                                <option value="bachelor">@lang('app.bachelor')</option>
                                <option value="master">@lang('app.master')</option>
                                <option value="doctorate">@lang('app.doctorate')</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">@lang('app.statut')</label>
                            <select name="statut" class="form-control">
                                <option value="active">@lang('app.active')</option>
                                <option value="inactive">@lang('app.inactive')</option>
                            </select>
                        </div>
                        {{-- <div class="form-group">
                            <label class="control-label">@lang('app.resume')</label>
                            <input class="form-control" type="file" name="resume" placeholder="@lang('app.resume')">
                        </div> --}}
                        <button type="button" id="save-form" class="btn btn-success waves-effect waves-light m-r-10">@lang('app.save')</button>
                    </form>
                    <div id="errorMessages" class="error-messages" style="display:none;"></div>
                    
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer-script')
    <script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('assets/node_modules/moment/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/node_modules/multiselect/js/jquery.multi-select.js') }}"></script>
    <script src="{{ asset('assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script>
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $('#job_job_location_id').change(function() {
            var jobJobLocationId = $(this).val();
            var jobId = jobJobLocationId.split('.')[0];
            var locationId = jobJobLocationId.split('.')[1];

            $('#job_id').val(jobId);
            $('#location_id').val(locationId);
        });

        $('#date_of_birth').datepicker({
            autoclose: true,
            todayHighlight: true,
            weekStart: '{{ $global->week_start }}',
            format: '{{ $global->date_picker_format }}',
        });

        $('#date_of_graduation').datepicker({
            autoclose: true,
            todayHighlight: true,
            weekStart: '{{ $global->week_start }}',
            format: '{{ $global->date_picker_format }}',
        });

        $('#send_date').datepicker({
            autoclose: true,
            todayHighlight: true,
            weekStart: '{{ $global->week_start }}',
            format: '{{ $global->date_picker_format }}',
        });

        function getQuestions(id) {
            var jobJobLocationId = id;
            var jobId = jobJobLocationId.split('.')[0];
            var locationId = jobJobLocationId.split('.')[1];

            $('#job_id').val(jobId);
            $('#location_id').val(locationId);
        }

 

        function handleFails(response) {
            if (response.status === 422) {
                var errors = response.responseJSON.errors;
                var errorMessages = '';

                for (var field in errors) {
                    if (errors.hasOwnProperty(field)) {
                        errors[field].forEach(function(error) {
                            errorMessages += '<p>' + error + '</p>';
                        });
                    }
                }

                // Affichez les messages d'erreur (vous pouvez personnaliser cet affichage)
                $('#errorMessages').html(errorMessages);
            } else {
                // Gérez d'autres types d'erreurs si nécessaire
                console.error('Une erreur est survenue:', response);
            }
        }
        $(document).ready(function() {
            $('#save-form').click(function(e) {
                e.preventDefault();  
                var formData = new FormData($('#createForm')[0]);
                console.log(formData);
                // Affichez les valeurs pour le débogage
                for (var pair of formData.entries()) {
                    console.log(pair[0]+ ', '+ pair[1]); 
                } 
                $.ajax({
                    url: '{{ route('admin.job-applications.store') }}', // URL de votre route
                    type: 'POST',
                    data: formData,
                    processData: false, // Important pour éviter la transformation automatique
                    contentType: false, // Important pour les fichiers
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Assurez-vous que le token CSRF est inclus
                    },
                    success: function(response) {
                        console.log('Réponse du serveur:', response);
                        alert('Données sauvegardées avec succès');
                        // Vous pouvez également rediriger ou réinitialiser le formulaire ici
                    },
                    error: function(xhr) {
                        console.error('Erreur de la requête:', xhr.responseText); 
                    }
                });
            });

            function togglePaymentFields() {
                var paymentType = document.getElementById('payment_type').value;
                var dispo = document.getElementById('dispo').value;

                if (paymentType === 'salarier') {
                    document.getElementById('salarierFields').style.display = 'block';
                    document.getElementById('freelanceFields').style.display = 'none';
                } else {
                    document.getElementById('salarierFields').style.display = 'none';
                    document.getElementById('freelanceFields').style.display = 'block';
                }

                if (dispo === 'notice') {
                    document.getElementById('preavis').style.display = 'block';
                } else {
                    document.getElementById('preavis').style.display = 'none';
                }
            }

            togglePaymentFields(); // Initialize visibility
      
 
        });

    </script>
@endpush
