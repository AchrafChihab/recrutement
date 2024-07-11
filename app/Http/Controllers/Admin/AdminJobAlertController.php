<?php

namespace App\Http\Controllers\Admin;

use App\JobAlert;
use App\JobLocation;
use Illuminate\Http\Request;
use Froiden\Envato\Helpers\Reply;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Admin\AdminBaseController;

class AdminJobAlertController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('menu.jobAlert');
        $this->pageIcon = 'icon-badge';
    }

    public function index()
    {
        $this->totalJobAlert = JobAlert::count();
        $this->activeJobsAlert = JobAlert::where('status', 'active')->count();
        $this->inactiveJobsAlert = JobAlert::where('status', 'inactive')->count();
        $this->locations = JobLocation::all();
        return view('admin.job_alert.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(!$this->user->cans('delete_jobs'), 403);

        JobAlert::destroy($id);
        return Reply::success(__('messages.recordDeleted'));
    }

    public function data(Request $request)
    {
        abort_if(!$this->user->cans('view_jobs'), 403);

        $categories = JobAlert::with(['alertLocation', 'workExperience', 'alertCategory', 'jobType']);

        if (\request('filter_status') != "") {
            $categories->where('status', \request('filter_status'));
        }

        if ($request->filter_location != "") {
            $categories = $categories->join('job_alert_locations', 'job_alert_locations.job_alert_id', 'job_alerts.id')
                ->where('job_alert_locations.location_id', $request->filter_location);
        }

        $categories->get();

        return DataTables::of($categories)
            ->addColumn('action', function ($row) {

                $params = [$row->slug, $row->id];
                $action = '';

                if ($this->user->cans('delete_jobs')) {
                    $action .= ' <a href="javascript:;" class="btn btn-danger btn-circle sa-params"
                      data-toggle="tooltip" onclick="this.blur()" data-row-id="' . $row->id . '" data-original-title="' . __('app.delete') . '"><i class="fa fa-times" aria-hidden="true"></i></a>';
                }

                return $action;
            })
            ->editColumn('email', function ($row) {
                return ucfirst($row->email);
            })
            ->editColumn('location_id', function ($row) {
                $locations = '<ul>';
                foreach ($row->alertLocation as $value) {

                    $locations .= '<li>' . $value->location . '</li>';
                }
                $locations .= '</ul>';
                return ucfirst($locations);
            })
            ->editColumn('work_experience_id', function ($row) {
                return $row->workExperience->work_experience;
            })

            ->editColumn('job_type_id', function ($row) {
                return $row->jobType->job_type;
            })

            ->editColumn('status', function ($row) {
                if ($row->status == 'active') {
                    return '<label class="badge bg-success">' . __('app.active') . '</label>';
                }
                if ($row->status == 'inactive') {
                    return '<label class="badge bg-danger">' . __('app.inactive') . '</label>';
                }
                if ($row->status == 'expired') {
                    return '<label class="badge" style="background: #FF8C00;">' . __('app.expired') . '</label>';
                }
            })
            ->rawColumns(['status', 'action', 'location_id'])
            ->addIndexColumn()
            ->make(true);
    }
    
}
