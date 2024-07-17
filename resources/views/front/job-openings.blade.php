@extends('layouts.front')

@section('header-text')
    <h1 class="text-white hidden-sm-down fs-50 mb-30">
        @if(!is_null($frontTheme->welcome_title)) 
            {{ $frontTheme->welcome_title }} 
        @else 
            @lang('modules.front.homeHeader')
        @endif 
    </h1>
    <h4 class="text-white hidden-sm-up mb-30"> 
        @if(!is_null($frontTheme->welcome_title)) 
            {{ $frontTheme->welcome_title }} 
        @else 
            @lang('modules.front.homeHeader')
        @endif 
    </h4>
    <p class="mb-40 text-white">
        @if(!is_null($frontTheme->welcome_sub_title)) 
            {!! $frontTheme->welcome_sub_title !!}  
        @else 
            @lang('modules.front.jobOpeningText') 
        @endif
    </p>
    <!-- Your search filters -->
    <div class="bg-white search-filter-top location-search d-flex rounded-pill">
        <div class="align-items-center d-flex rounded-pill location height-50">
            <select class="myselect" name="loaction" id ="location_id">
                <option value="all">@lang('modules.front.allLocation')</option>
                @foreach($locations as $location)
                    <option value="{{ $location->id }}">{{ ucfirst($location->location) }}</option>
                @endforeach
            </select>
        </div>
    
        <span class="space position-relative hidden-sm-down "></span>
    
        <div class="align-items-center d-flex rounded-pill designation height-50">
            <select class="myselect" name="category" id ="category">
                <option value="all">@lang('modules.front.allCategory')</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ ucfirst($category->name) }}</option>
                @endforeach
            </select>
        </div>
    
        <div class="align-items-center d-flex rounded-pill designation height-50">
            <select class="myselect" name="company_name" id ="company">
                <option value="all">@lang('modules.front.allCompany')</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ ucfirst($company->company_name) }}</option>
                @endforeach
            </select>
        </div>
    
        <div class="align-items-center d-flex rounded-pill location height-50">
            <select class="myselect" name="name" id ="skill">
                <option value="all">@lang('modules.front.allSkill')</option>
                @foreach($skills as $skill)
                    <option value="{{ $skill->id }}">{{ ucfirst($skill->name) }}</option>
                @endforeach
            </select>
        </div>
    
        <div class="search-btn w-25 rounded-pill align-items-center">
            <button type="button" name="search" class="my-1 mr-4 btn btn-lg btn-dark height-48 align-items-center d-flex rounded-pill justify-content-center" id="search">@lang('app.search')</button>
        </div>
    </div>
    
    
    <!-- Your search filters -->
@endsection

@section('content')
    <section class="section">
        <div class="container">
            <div class="float-right btn-group job-view-toggle" role="group">
                <button type="button" class="mr-15 btn btn-outline-dark btn-sm active" data-view="grid">
                    <i class="fa fa-th-large"></i> @lang('modules.front.gridView')
                </button>
                <button type="button" class="btn btn-outline-dark btn-sm" data-view="list">
                    <i class="fa fa-list"></i> @lang('modules.front.listView')
                </button>
            </div>
            <header class="section-header">
                <h2>@lang('modules.front.jobOpenings')</h2>
                <hr>
                <hr>
            </header>
            

            <div data-provide="shuffle" id="applicant-notes">
                <div class="row gap-y job-list-grid">
                    @forelse($jobLocations as $location)
                        <div class="col-md-4 portfolio-2">
                            <a href="{{ route('jobs.jobDetail', [$location->job->slug, $location->location->id]) }}" class="job-opening-card">
                                <div class="card card-bordered">
                                    <div class="card-block">
                                        <h5 class="mb-0 card-title">{{ ucwords($location->job->title) }}</h5>
                                        @if($location->job->company->show_in_frontend == 'true')
                                            @if($location->job->job_company_id != null && $location->job->job_company_id != '' && !is_null($location->job->jobCompany))
                                                <small class="company-title mb-50">@lang('app.by') {{ ucwords($location->job->jobCompany->company_name) }}</small>
                                            @else
                                                <small class="company-title mb-50">@lang('app.by') {{ ucwords($location->job->company->company_name) }}</small>
                                            @endif
                                        @endif
                                        <div class="flex-wrap d-flex justify-content-between card-location">
                                            <span class="fw-400 fs-14"><i class="mr-5 fa fa-map-marker"></i>{{ ucwords($location->location->location) }}</span>
                                            <span class="fw-400 fs-14">{{ ucwords($location->job->category->name) }}<i class="ml-5 fa fa-graduation-cap"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <h4 id="no-data" class="mx-auto mb-0 mb-40 mt-50 card-title">@lang('modules.front.noData')</h4>
                    @endforelse
                </div>
                <div class="row gap-y job-list-list" style="display: none;">
                    @forelse($jobLocations as $location)
                        <div class="col-md-12 portfolio-2">
                            <a href="{{ route('jobs.jobDetail', [$location->job->slug, $location->location->id]) }}" class="job-opening-card">
                                <div class="card card-bordered">
                                    <div class="card-block">
                                        <h5 class="mb-0 card-title">{{ ucwords($location->job->title) }}</h5>
                                        @if($location->job->company->show_in_frontend == 'true')
                                            @if($location->job->job_company_id != null && $location->job->job_company_id != '' && !is_null($location->job->jobCompany))
                                                <small class="company-title mb-50">@lang('app.by') {{ ucwords($location->job->jobCompany->company_name) }}</small>
                                            @else
                                                <small class="company-title mb-50">@lang('app.by') {{ ucwords($location->job->company->company_name) }}</small>
                                            @endif
                                        @endif
                                        <div class="flex-wrap d-flex justify-content-between card-location">
                                            <span class="fw-400 fs-14"><i class="mr-5 fa fa-map-marker"></i>{{ ucwords($location->location->location) }}</span>
                                            <span class="fw-400 fs-14">{{ ucwords($location->job->category->name) }}<i class="ml-5 fa fa-graduation-cap"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <h4 id="no-data" class="mx-auto mb-0 mb-40 mt-50 card-title">@lang('modules.front.noData')</h4>
                    @endforelse
                </div>
                @if ($jobLocations->count() > 0)
                    <div class="row gap-y">
                        <button type="button" name="load_more_button" class="mx-auto mb-40 btn btn-lg btn-white mt-50" id="load_more_button">@lang('modules.front.loadMore')</button>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@push('footer-script')
<script>
    $(document).ready(function() {
        var perPage = '{{ $perPage }}';
        var totalCurrentData = perPage;
        var jobCount = {{ $jobCount }};
        
        if (jobCount > perPage) {
            $('#load_more_button').show();
        } else {
            $('#load_more_button').hide();
        }
        
        // Load more functionality
        $('body').on('click', '#load_more_button', function() {
            var location_id = $('#location_id').val();
            var category = $('#category').val();
            var skill = $('#skill').val();
            var company = $('#company').val();
            var token = '{{ csrf_token() }}';
            
            $('#load_more_button').text('@lang("app.loading")...');
            
            $.easyAjax({
                url: "{{ route('jobs.more-data') }}",
                type: 'POST',
                data: {
                    '_token': token,
                    'totalCurrentData': totalCurrentData,
                    'location_id': location_id,
                    'category': category,
                    'skill': skill,
                    'company': company
                },
                success: function(response) {
                    $('#jobList').append(response.view);
                    totalCurrentData = response.data.job_current_count;
                    $('#load_more_button').text('@lang("modules.front.loadMore")');
                    
                    if (response.data.hideButton !== 'undefined' && response.data.hideButton === 'yes') {
                        $('#load_more_button').hide();
                    } else {
                        $('#load_more_button').show();
                    }
                }
            });
        });
        
        // Search functionality
        $('body').on('click', '#search', function() {
            var location_id = $('#location_id').val();
            var category = $('#category').val();
            var skill = $('#skill').val();
            var company = $('#company').val();
            var token = '{{ csrf_token() }}';
            
            $.easyAjax({
                url: "{{ route('jobs.search-job') }}",
                type: 'POST',
                data: {
                    '_token': token,
                    'location_id': location_id,
                    'category': category,
                    'skill': skill,
                    'company': company
                },
                success: function(response) {
                    $('.job-list-grid').html(response.view);
                    totalCurrentData = response.data.job_current_count;
                    
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#applicant-notes").offset().top
                    }, 2000);
                    
                    if (response.data.hideButton !== 'undefined' && response.data.hideButton === 'yes') {
                        $('#load_more_button').hide();
                    } else {
                        $('#load_more_button').show();
                    }
                }
            });
        });

        // View toggle functionality
        $('.job-view-toggle button').on('click', function() {
            var view = $(this).data('view');
            $('.job-view-toggle button').removeClass('active');
            $(this).addClass('active');

            if (view === 'grid') {
                $('.job-list-grid').show();
                $('.job-list-list').hide();
            } else if (view === 'list') {
                $('.job-list-grid').hide();
                $('.job-list-list').show();
            }
        });
    });
</script>

<style>
    .section-header hr {
    width: 70px;
    margin-bottom: 1.5rem;
    border-top: 2px solid #0f0f0f;
    margin: 3px;
}
.section-header{
    text-align: left;
}
 

</style>
@endpush
