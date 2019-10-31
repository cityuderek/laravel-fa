<?php

namespace Fa\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Zizaco\Entrust\EntrustFacade;
use View;
use Carbon\Carbon;
use Fa\Helpers\FaHelper;
use App\User;

class FaController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $permissions;

    public function __construct() {

        $this->middleware(function ($request, $next) {

            $this->permissions = array();

            //Gather all permissions
            if(Auth::user()) {
                $roles = Auth::user()->roles;

                foreach($roles as $role) {
                    foreach($role->perms as $permission) {
                        array_push($this->permissions, $permission->name);
                    }
                }
            }

            //set in global 
            View::share('permissions', $this->permissions);

            return $next($request);
        });
    }

    //// Route /////////////////////////////////////////////////////////////////////////
    public function defIndex(Request $request) {
        // logd("");
        return view($this->getViewPath());
    }

    public function defShow(Request $request, $id = 0)
    {
        logd("id=$id");
        $data = $this->getDetailViewData($request, 'show', $id);
        return view($this->getViewPath('detail'), $data);
    }

    public function defEdit(Request $request, $id = 0)
    {
        logd("id=$id");
        $data = $this->getDetailViewData($request, 'edit', $id);
        return view($this->getViewPath('detail'), $data);
    }


    public function defCreate(Request $request)
    {
        logd("");
        $data = $this->getDetailViewData($request, 'create', null);
        return view($this->getViewPath('detail'), $data);
    }

    //// PageInfo /////////////////////////////////////////////////////////////////////////

    // eg cms_admin
    protected function getPageKey(){
        logw("getPageKey has not override");
        return "";
    }

    protected function getTitle() {
        return __("admin." . $this->getPageKey());
    }

    //// URL /////////////////////////////////////////////////////////////////////////
    // eg cms-admin
    // protected function getPageUrlName(){
    //     return str_replace("_", "-", $this->getPageKey());
    // }

    // eg /cms_admin
    protected function getPageUrl(){
        return "/" . slug($this->getPageKey());
    }

    //// Response //////////////////////////////////////////////////////////////////
    protected function redirectSelf($msg = ""){
        $page = redirect($this->getPageUrl());

        if($msg){
            return $page->with('msg', __($msg));
        }

        return $page;
    }

    protected function redirectSelfFail($msg){
        $page = redirect($this->getPageUrl());
        Log::warning(__METHOD__ . "; fail; msg=$msg");
        return $page->with('err_msg', __($msg));
    }

    //// View //////////////////////////////////////////////////////////////////
    protected function getViewData(Request $request){

        return ['title' => $this->getTitle(), 
            'description' => '',
            'pageKey' => $this->getPageKey(),
            'pageUrl' => $this->getPageUrl()
        ];
    }

    protected function getDetailViewData(Request $request, $act, $id = 0){
        $obj = $this->getOrCreateObj($id);
        // $modUrl = url($this->getPageKey());
        $pageUrl = $this->getPageKey();
        $data = $this->getViewData($request);
        $data['act'] = $act;
        $data['obj'] = $obj;
        $data['pageUrl'] = $pageUrl;
        $data['actionUrl'] = $pageUrl . ($act == 'edit' ? '/' . $id: '');
        $data['actName'] = toTitle($act == 'show' ? 'View' : $act);
        $data['isReadOnly'] = $act == 'show';
        $data['isEdit'] = $act == 'edit';
        $data['isCreate'] = $act == 'create';

        // logd("getPageKey=" . $this->getPageKey());
        // varDump($data, 'data');

        return $data;
    }

    protected function getDetailView(Request $request, $act, $id = 0){
        $data = $this->getDetailViewData($request, $act, $id);
        // logd("getPageKey=" . $this->getPageKey());
        // varDump($data, 'data');

        return view($this->getViewPath('detail'), $data);
    }

    // eg cms_admin.index
    protected function getViewPath($viewName = 'index'){
        return snake($this->getViewFolder() . ".$viewName");
    }

    // eg cms_admin
    protected function getViewFolder(){
        return snake($this->getPageKey());
    }


    //// Permission //////////////////////////////////////////////////////////////////
    protected function hasPermission($permission) {
        return true;
        // return in_array($permission, $this->permissions);
    }
    
    protected function hasWritePermission(){
        return true;
        // return EntrustFacade::can($this->getPageKey() . '_write');
    }
    
    protected function hasReadPermission(){
        return true;
        // return EntrustFacade::can($this->getPageKey() . '_read');
    }

    protected function turnEmptyToNull($text){
        return $text == '' ? null : $text;
    }

    //// Request //////////////////////////////////////////////////////////////////
    protected function getJson(Request $request) {
        // $data = $request->json()->all();
        $body = $request->getContent();
        $data = json_decode($body, true);
        // GlobalHelper::varDump("body", $body);
        // GlobalHelper::varDump("data", $data);
        return $data;
    }

    public function isPost(Request $request) {
        return $request->method() == 'POST';
    }

    public function isGet(Request $request) {
        return $request->method() == 'GET';
    }

    //// Response //////////////////////////////////////////////////////////////////
    public function abort($code, $message = '', array $headers = []){
        if($message){
            logd("abort; code=$code, message=$message", 1);
            // Log::debug($message);
        }
        abort($code, $message, $headers);
    }

    public function redirectToHtml(Request $request) {
        return redirect()->to($request->path() . '.html');
    }

    //// Model //////////////////////////////////////////////////////////////////
    protected function getOrCreateObj($id){
        logw("getOrCreateObj has not override; id=$id");
        return null;
    }
}
