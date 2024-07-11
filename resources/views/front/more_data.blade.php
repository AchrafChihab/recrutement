        @foreach($jobLocations  as $location)
            <div class="col-12 col-md-6 col-lg-4 job-list" data-shuffle="item" data-groups="{{ $location->location.','.$location->job->category->name }}">
                <a href="{{ route('jobs.jobDetail', [$location->job->slug, $location->location->id]) }}" class="job-opening-card">
                <div class="card card-bordered">
                    <div class="card-block">

                        <h5 class="card-title mb-0">{{ ucwords($location->job->title) }}</h5>
                        @if($location->job->company->show_in_frontend == 'true')
                            <small class="company-title mb-50">@lang('app.by') {{ ucwords($location->job->company->company_name) }}</small>
                        @endif
                        <div class="d-flex flex-wrap justify-content-between card-location">
                            <span class="fw-400 fs-14"><i class="mr-5 fa fa-map-marker"></i>{{ ucwords($location->location->location).', '.ucwords($location->location->country->country_name) }}</span>
                            <span class="fw-400 fs-14">{{ ucwords($location->job->category->name) }}<i class="ml-5 fa fa-graduation-cap"></i></span>
                        </div> 
                    </div>
                </div>
                </a>
            </div>
        @endforeach