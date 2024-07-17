@forelse($upComingSchedules as $key => $upComingSchedule)
    <div>
        @php
            // Creating a Carbon instance from the given date
            $date = \Carbon\Carbon::createFromFormat('Y-m-d', $key);
        @endphp
        <!-- Formatting the date to 'M d, Y' format -->
        <h4>{{ $date->format('M d, Y') }}</h4>

        <ul class="scheduleul">
            @forelse($upComingSchedule as $dtKey => $dtData)
                <li class="deco" id="schedule-{{$dtData->id}}" onclick="getScheduleDetail(event, {{$dtData->id}})"
                    style="list-style: none;">
                    <!-- Displaying the job title -->
                    <h5 class="text-muted" style="float: left">{{ ucfirst($dtData->jobApplication->job->title) }}</h5>
                    <div class="pull-right">
                        @if($user->cans('edit_schedule'))
                            <span style="margin-right: 15px;">
                                <button onclick="editUpcomingSchedule(event, '{{ $dtData->id }}')"
                                        class="btn btn-sm btn-info notify-button editSchedule"
                                        title="Edit"> <i class="fa fa-pencil"></i></button>
                            </span>
                        @endif
                        @if($user->cans('delete_schedule'))
                            <span style="margin-right: 15px;">
                                <button data-schedule-id="{{ $dtData->id }}"
                                        class="btn btn-sm btn-danger notify-button deleteSchedule"
                                        title="Delete"> <i class="fa fa-trash"></i></button>
                            </span>
                        @endif
                    </div>
                    <div class="clearfix"></div>
                    <!-- Displaying the applicant's full name -->
                    <div class="direct-chat-name" style="font-size: 13px">{{ ucfirst($dtData->jobApplication->full_name) }}</div>
                    <!-- Displaying the schedule time -->
                    <span class="direct-chat-timestamp" style="font-size: 13px">{{ $dtData->schedule_date->format('h:i a') }}</span>

                    @if(in_array($user->id, $dtData->employee->pluck('user_id')->toArray()))
                        @php
                            // Getting employee data
                            $empData = $dtData->employeeData($user->id);
                        @endphp

                        @if($empData->user_accept_status == 'accept')
                            <label class="float-right badge badge-success">@lang('app.accepted')</label>
                        @elseif($empData->user_accept_status == 'refuse')
                            <label class="float-right badge badge-danger">@lang('app.refused')</label>
                        @else
                            <span class="float-right">
                                <button onclick="employeeResponse({{$empData->id}}, 'accept')"
                                        class="btn btn-sm btn-success notify-button responseButton">@lang('app.accept')</button>
                                <button onclick="employeeResponse({{$empData->id}}, 'refuse')"
                                        class="btn btn-sm btn-danger notify-button responseButton">@lang('app.refuse')</button>
                            </span>
                        @endif
                    @endif
                </li>
                <!-- Adding a horizontal line between items except for the last item -->
                @if($dtKey != (count($upComingSchedule)-1))
                    <hr>
                @endif
            @empty
                <!-- No upcoming schedules found -->
            @endforelse
        </ul>
    </div>
    <hr>
@empty
    <div>
        <!-- No upcoming schedules found message -->
        <p>@lang('messages.noUpcomingScheduleFund')</p>
    </div>
@endforelse
