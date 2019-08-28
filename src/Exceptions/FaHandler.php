<?php

namespace App\Fa\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Fa\Helpers\FaHelper;
use App\Fa\Log\Flog;
use App\Fa\Http\ApiHelper;
use App\Fa\Http\ReqHelper;
use App\Fa\Http\FaApiRc;
use App\Fa\Exceptions\FaException;

class FaHandler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        if ($exception instanceof FaException) {
            //logw("FaException; path=$path; " . $exception);

        }else{
            parent::report($exception);
        }
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        try{
            // logd('exception=' . $exception);
            $path = $request->path();
            // logd("FFF isApi=" . ($isApi ? "T" : "F"));
            // logd("FFF ex=$exception; " . ($request->wantsJson() ? "T" : "F"));

            if ($exception instanceof FaException) {
                // logw("FaException; " . $exception);
                logw("FaException; path=$path; " . $exception);
                if($exception->rc == "9997"){
                    logd("TEST_ERROR_400_9997");
                    return response()->json(ApiHelper::failRespByFaEx($exception), 400);
                }
                if($exception->rc == "9998"){
                    logd("TEST_ERROR_400_x");
                    return response()->json(['error' => 'TEST_ERROR_400_x'], 400);
                }
                // $resp = response()->json(ApiHelper::failRespByFaEx($exception), 200);
                // return $resp;
            }
            $isApi = ReqHelper::isPathStartsWith($request, "api/");
            if ($isApi) {
                return $this->renderForApi($request, $exception, $path);
            }

            // if($path != "css/style.css.map"){
            //     logd("UnhandledException_PAGE; path=$path");
            //     // logd("path=" . $request->path());
            //     // logd("url=" . $request->url());
            //     // logd("fullUrl=" . $request->fullUrl());
            // }
            // return parent::render($request, $exception);
            return $this::renderForWeb($request, $exception, $path);

        }catch(\Exception $ex2){
            logd("Exception2 " . $ex2);
            varDump($ex2, 'ex2');
        }
    }

    protected function renderForWeb($request, Exception $exception, $path)
    {
        // logd('exception=' . $exception . ", path=$path");
        return parent::render($request, $exception);
    }

    protected function renderForApi($request, Exception $exception, $path)
    {
        $resp = $this::renderRespForApi($request, $exception, $path);
        if ($exception instanceof FaException) {
            return response()->json($resp, 200);
        }

        return response()->json($resp, 400);
    }

    protected function renderRespForApi($request, Exception $exception, $path)
    {
        if ($exception instanceof NotFoundHttpException || $exception instanceof MethodNotAllowedHttpException) {
            // logw("MethodNotAllowedHttpException_API; path=$path");
            return ApiHelper::failResp($exception->getMessage(), FaApiRc::WRONG_URL, "Wrong url");
        }
        if ($exception instanceof FaException) {
            // logw("MethodNotAllowedHttpException_API; path=$path");
            return ApiHelper::failResp($exception->getMessage(), $exception->rc, $exception->disp_msg);
        }

        // logd("UnhandledException_API; path=$path");
        // logw("Exception; " . $exception);
        return ApiHelper::failResp($exception->getMessage(), FaApiRc::UNK_ERROR, "Unknown error");
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }
}
