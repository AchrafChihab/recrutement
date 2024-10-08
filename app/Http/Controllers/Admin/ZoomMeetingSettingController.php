<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\ZoomMeeting\UpdateSetting;
use App\Helper\Reply;
use App\ZoomSetting;

class ZoomMeetingSettingController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('menu.zoomSetting');;
        $this->pageIcon = 'fa fa-video-camera';
        $this->middleware(function ($request, $next) {
            abort_if(!in_array("manage_settings", $this->userPermissions),403);
            return $next($request);
        });

    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $this->zoom = ZoomSetting::first();
        return view('admin.zoom.setting', $this->data);
    }
    
    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateSetting $request, $id)
    {
        $setting = ZoomSetting::findOrFail($id);
        $setting->enable_zoom = ($request->enable_zoom)? 1:0;
        $setting->api_key = $request->api_key;
        $setting->secret_key = $request->secret_key;
        $setting->secret_token = $request->secret_token;
        $setting->meeting_app = ($request->meeting_app);
        $setting->account_id = $request->account_id;
        $setting->meeting_sdk_api_key = $request->meeting_sdk_api_key;
        $setting->meeting_sdk_api_secret = $request->meeting_sdk_api_secret;
        $setting->save();
        return Reply::success(__('messages.updatedSuccessfully'));
    }
}
