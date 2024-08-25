@extends('layouts.app')

@push('head-script')
    {{-- <link rel="stylesheet" href="{{ asset('assets/plugins/datepicker/datepicker3.css') }}"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" /> --}}

 
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
        </div><!-- /.container-fluid -->
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
                        <form class="ajax-form" method="POST" id="createForm">
                            @csrf

                            <div class="row">
                                <div class="col-md-4 pl-4 pr-4">
                                    <h5 class="required">@lang('modules.front.personalInformation')</h5>
                                </div>

                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="hidden" value="" name="job_id" id="job_id">
                                        <input type="hidden" value="" name="location_id" id="location_id">
                                        <label class="control-label">@lang('menu.jobs')</label>
                                        <select name="job_job_location_id" id="job_job_location_id" onchange="getQuestions(this.value)"
                                            class="form-control">
                                            @foreach ($locations as $location)
                                                <option value="{{ $location->id }}">
                                                    {{ ucwords($location->job->title) . '(' . ucwords($location->location->location) . ')' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label required">@lang('app.name')</label>
                                        <input class="form-control" type="text" name="full_name"
                                            placeholder="@lang('app.name')">
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label required">@lang('app.email')</label>
                                        <input class="form-control" type="email" name="email"
                                            placeholder="@lang('app.email')">
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label required">@lang('app.phone')</label>
                                        <input class="form-control" type="tel" name="phone"
                                            placeholder="@lang('app.phone')">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">@lang('app.address')</label>
                                        <textarea class="form-control" name="address"rows="4" cols="50" placeholder="@lang('app.address')"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">@lang("app.annees_experience")</label>
                                        <input class="form-control" type="text" name="annees_experience"
                                            placeholder="@lang('app.annees_experience')">
                                    </div>

                                    <!-- Payment Type Selection -->
                                    <div class="form-group">
                                        <label class="control-label">@lang('app.payment_type')</label>
                                        <select name="statut_employee" id="payment_type" class="form-control" onchange="togglePaymentFields()">
                                            <option value="salarier">@lang('app.salarier')</option>
                                            <option value="freelance">@lang('app.freelance')</option>
                                        </select>
                                    </div>

                                    <!-- Conditional Fields Based on Payment Type -->
                                    <div id="salarierFields" class="payment-fields">
                                        <div class="form-group">
                                            <label class="control-label">@lang("app.salaire_actuel")</label>
                                            <input class="form-control" type="text" name="salaire_actuel"
                                                placeholder="@lang("app.salaire_actuel")">
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">@lang("app.retention_salariale")</label>
                                            <input class="form-control" type="text" name="salaire_souhaite"
                                                placeholder="@lang("app.retention_salariale")">
                                        </div>
                                    </div>

                                    <div id="freelanceFields" class="payment-fields" style="display: none;">
                                        <div class="form-group">
                                            <label class="control-label">@lang("app.tj_actual")</label>
                                            <input class="form-control" type="text" name="tj_actual"
                                                placeholder="@lang("app.tj_actual")">
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">@lang("app.tj_souhaite")</label>
                                            <input class="form-control" type="text" name="tj_souhaite"
                                                placeholder="@lang("app.tj_souhaite")">
                                        </div>
                                    </div>

                                    <!-- Listbox for Availability, Education Level, and Status -->
                                    <div class="form-group">
                                        <label class="control-label">@lang("app.disponibilite")</label>
                                        <select id="dispo" name="disponibilite" class="form-control" onchange="togglePaymentFields()">
                                            <option value="immediate">@lang('app.immediate')</option>
                                            <option value="notice">@lang('app.notice')</option>
                                        </select>
                                    </div>

                                    <div id="preavis" class="form-group" style="display: none;">
                                        <label class="control-label">@lang("app.notice")</label>
                                        <input class="form-control" type="text" name="preavis"
                                            placeholder="@lang("app.notice")">
                                    </div>
                                    

                                    <div class="form-group">
                                        <label class="control-label">@lang("app.niveau_etudes")</label>
                                        <select name="niveau_etudes" class="form-control">
                                            <option value="highschool">@lang('app.highschool')</option>
                                            <option value="bachelor">@lang('app.bachelor')</option>
                                            <option value="master">@lang('app.master')</option>
                                            <option value="phd">@lang('app.phd')</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 px-20 pb-30 bt-1">
                                        <h5 class="required">@lang('modules.front.resume')</h5>
                                    </div>
                                    <div class="col-md-8 py-30 bt-1">
                                        <div class="form-group">
                                            <input class="select-file" accept=".png,.jpg,.jpeg,.pdf,.doc,.docx,.xls,.xlsx,.rtf"
                                                type="file" name="resume"><br>
                                            <span>@lang('modules.front.resumeFileType')</span>
                                        </div>
                                    </div>



                                </div>
                            </div>
                            

                            <div class="row">
                                <div class="col-md-4 pl-4 pr-4 pt-4 b-b" id="questionBoxTitle">
                                    <h5>@lang('modules.front.additionalDetails')</h5>
                                </div>

                                <div class="col-md-8 pt-4 b-b" id="questionBox">
                                    
                                </div>
                            </div>
                            <br>
                            <button type="button" id="save-form" class="btn btn-success"><i class="fa fa-check"></i>
                                @lang('app.save')</button>

                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer-script')

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script> --}}

    {{-- <script src="{{ asset('assets/plugins/datepicker/bootstrap-datepicker.js') }}"></script> --}}
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script> 
    <script> 
        const csrfToken = "{{ csrf_token() }}";  
 

        function togglePaymentFields() {
            const paymentType = document.getElementById('payment_type').value;
            const salarierFields = document.getElementById('salarierFields');
            const freelanceFields = document.getElementById('freelanceFields');
            
            
            const disponibilite = document.getElementById('dispo').value;
            const preavis = document.getElementById('preavis');
            if (paymentType === 'salarier') {
            salarierFields.style.display = 'block';
            freelanceFields.style.display = 'none';
        } else if (paymentType === 'freelance') {
            salarierFields.style.display = 'none';
            freelanceFields.style.display = 'block';
        }
            if (disponibilite === 'immediate') { 
                preavis.style.display = 'none';
        } else if (paymentType === 'notice') { 
            preavis.style.display = 'block';
        }
 
    }
    
    function getQuestions(id) {
        console.log('id :',id);
        var url = "{{ route('admin.job-applications.question', ':id') }}";
        url = url.replace(':id', id);

        $.easyAjax({
            type: 'GET',
            url: url,
            container: '#createForm',
            success: function(response) {
                console.log('response.jobJobLocation.job_id',response.jobJobLocation.job_id , 'response.jobJobLocation.location_id',response.jobJobLocation.location_id);
                $('#job_id').val(response.jobJobLocation.job_id)
                $('#location_id').val(response.jobJobLocation.location_id)
                if (response.status == "success") {
                    if (response.count > 0) { // Question Found for selected job
                        $('#questionBox').show();
                        $('#questionBoxTitle').show();
                        $('#questionBox').html(response.view);
                    } else { // Question Not Found for selected job
                        $('#questionBox').hide();
                        $('#questionBoxTitle').hide();
                    }
                    $('#show-columns').html(response.requiredColumnsView);
                    $('#show-sections').html(response.requiredSectionsView);
                    if (response.requiredColumnsView !== '') {
                        // var datepicker = $('.dob').datepicker({
                        //     autoclose: true,
                        //     format: 'yyyy-mm-dd',
                        //     endDate: (new Date()).toDateString(),
                        // });

                        // $('.select2').select2({
                        //     width: '100%'
                        // });

                        // var loc = new locationInfo()
                        // loc.getCountries()
                    }
                }
            }
        });
    }
    $(document).ready(function() {

        
        // $('.select2').select2({
        //     width: '100%'
        // });

        // $('#save-form').click(function() { 
        //     $.ajax({
        //         url: '{{ route('admin.job-applications.store') }}',
        //         container: '#createForm',
        //         type: "POST",
        //         redirect: true,
        //         file: true,
        //         data: $('#createForm').serialize(),
        //         error: function(response) {
        //             handleFails(response);
        //         }
        //     });
        // });
        $('#save-form').click(function() {
            $.easyAjax({
                url: '{{ route('admin.job-applications.store') }}',
                container: '#createForm',
                type: "POST",
                file: true,
                redirect: true,
                success: function(response) {
                    console.log(response);
                    
                    if (response.status == "success") {
                        var successMsg = '<div class="alert alert-success my-100" role="alert">' +
                            response.msg +
                            ' <a class="" href="{{ route('jobs.jobOpenings') }}">@lang('app.view') @lang('modules.front.jobOpenings') <i class="fa fa-arrow-right"></i></a>'
                        '</div>';
                        $('.main-content .container').html(successMsg);
                    }
                },
                error: function(response) {
                    handleFails(response);
                }
            })
        });

        var val = $('#job_job_location_id').val(); // get Current Selected Job
        if (val != '' && typeof val !== 'undefined') {
            getQuestions(val); // get Questions by question on page load
        }

        // get Questions on change Job

        function handleFails(response) {
            console.log('Error response:', response);

            var errorMessages = '';

            // Check for validation errors (status code 422)
            if (response.status === 422) {
                var errors = response.responseJSON.errors;

                for (var field in errors) {
                    if (errors.hasOwnProperty(field)) {
                        errors[field].forEach(function(error) {
                            errorMessages += '<p>' + error + '</p>';
                        });
                    }
                }
            } else {
                // Capture other types of errors
                errorMessages += '<p>Status: ' + response.status + ' (' + response.statusText + ')</p>';
                errorMessages += '<p>Error Details: ' + response.responseText + '</p>';
            }

            // Display error messages (you can customize this display)
            $('#errorMessages').html(errorMessages);

            // Optionally, log detailed information to the console
            console.error('Detailed error:', response);
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
                        // alert('Données sauvegardées avec succès');
                        window.reload();
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
  




        // Initialize visibility based on the default selected payment type
        togglePaymentFields();
    });
</script>
