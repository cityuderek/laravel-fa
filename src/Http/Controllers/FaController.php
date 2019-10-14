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

    // eg cms_admin
    protected function getPageKey(){
        return "";
    }

    //// URL /////////////////////////////////////////////////////////////////////////
    // eg cms-admin
    protected function getPageUrlName(){
        return str_replace("_", "-", $this->getPageKey());
    }

    // eg /cms_admin
    protected function getSelfPath(){
        return "/" . $this->getPageUrlName();
    }

    //// Response //////////////////////////////////////////////////////////////////
    protected function redirectSelf($msg = ""){
        $page = redirect($this->getSelfPath());

        if($msg){
            return $page->with('msg', __($msg));
        }

        return $page;
    }

    protected function redirectSelfFail($msg){
        $page = redirect($this->getSelfPath());
        Log::warning(__METHOD__ . "; fail; msg=$msg");
        return $page->with('err_msg', __($msg));
    }

    //// View //////////////////////////////////////////////////////////////////

    //// View //////////////////////////////////////////////////////////////////
    protected function getViewData(Request $request){

        return ['title' => '', 
            'description' => '',
            'pageName' => $this->getPageKey(),
            'pageUrlName' => $this->getPageUrlName(),
            'selfPath' => $this->getSelfPath()
        ];
    }
    // protected function getViewData(){
    //     // logd("title=" . $this->getTitle());
    //     // logd("getPageKey=" . $this->getPageKey());
    //     // logd("getPageUrlName=" . $this->getPageUrlName());
    //     // logd("getSelfPath=" . $this->getSelfPath());
    //     // logd("getViewFolder=" . $this->getViewFolder());
    //     return [
    //         'title' => $this->getTitle(), 
    //         'pageKey' => $this->getPageKey(), 
    //         'pageUrlName' => $this->getPageUrlName(),
    //         'selfPath' => $this->getSelfPath()
    //     ];
    // }

    protected function getTitle() {
        return __("admin." . $this->getPageKey());
    }

    // eg cms_admin
    protected function getViewFolder(){
        return $this->getPageKey();
    }

    // eg cms_admin.index
    protected function getViewPath($viewName){
        return $this->getViewFolder() . ".$viewName";
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
}
