<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });



        //! for registration view
        Fortify::registerView(function () {
            return view('auth.register');
        });

        //! for login view
        Fortify::loginView(function () {
            return view('Dashboard.pages.samples.login');
        });
        
        //! for password view
        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.forgot-password');
        });
        
        //! for reset password view
        Fortify::resetPasswordView(function () {
            return view('auth.reset-password');
        });
      
        //! for verify email view
        Fortify::verifyEmailView(function () {
            return view('auth.verify-email');
        });
      
        //! for confirm password view
        Fortify::confirmPasswordView(function () {
            return view('auth.confirm-password');
        });
      
         //! for two factor challenge view
        Fortify::twoFactorChallengeView(function (Request $request) {
            $recovery = $request->get('recovery',false);
            return view('auth.two-factor-challenge',compact('recovery'));
        });


    }
}
