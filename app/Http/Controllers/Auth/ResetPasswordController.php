<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Api\SMSController;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function resetPassword(Request $request)
    {
        $phone = '+'.preg_replace('/[^0-9]/', '', $request->phone);

        $user = User::where('phone', $phone)->first();

        if (isset($user)) {
            $rc = new RegisterController;
            $password = $rc->password(6, false, true, false);
            $user->password = Hash::make($password);
            $user->save();

            $sms = new SMSController($phone, $password, false, '');
            $sms->sendSMS();
        }

        return false;
    }
}
