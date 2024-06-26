<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades;
use Illuminate\View\View;
use Modules\Comment\Models\Comment;
use Modules\Core\Helpers\Helpers;
use Modules\JobOffer\Models\Resumes;
use Modules\PurchaseAdvisor\Models\PurchaseAdvisor;
class AppServiceProvider extends ServiceProvider
{
    private function responseMacros()
    {
        Response::macro('success', function ($message, array $data = null, $httpCode = 200) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $data
            ], $httpCode);
        });

        Response::macro('error', function ($message, array $data = null, $httpCode = 400) {

            //validation error
            if ($httpCode == 422){
                return response()->json([
                    'success' => false,
                    'message' => $message,
                    'errors' => $data
                ], $httpCode);

            }
            return response()->json([
                'success' => false,
                'message' => $message,
                'data' => $data
            ] ,$httpCode);

        });
    }


    public function register(): void
    {
        $this->app->useLangPath(base_path('Modules/Core/resources/lang'));
    }


    public function boot(): void
    {
        Facades\View::composer('admin.layouts.master', function (View $view) {
            $resumes = Resumes::where('status','new')->count();
            $comments = Comment::where('status','pending')->count();
            $advisors = PurchaseAdvisor::where('status','notcalled')->count();
            $logo = Helpers::setting('logo', asset('images/logo.png'));

            $view->with(compact('logo','resumes','comments','advisors'));
        });
        $this->responseMacros();

        Gate::before(function ($user, $ability) {
            return $user->hasRole('super_admin') ? true : null;
        });
    }
}
