<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Api\SMSController;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SendPasswordAfterRegisterNotification;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $data['phone'] = str_replace(['(', ')', '-', ' '], ['', '', '', ''], $data['phone']);

        return Validator::make($data, [
            // 'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['string', 'email', 'max:255', 'unique:users'],
            'concent_exclusive_email' => '',
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $data['password'] = $this->password(6, false, true, false);
        $data['phone'] = str_replace(['(', ')', '-', ' '], ['', '', '', ''], $data['phone']);
        $user = User::create([
            'email' => $data['email'] ?? '',
            'phone' => $data['phone'] ?? '',
            'concent_exclusive_email' => $data['concent_exclusive_email'] ?? false,
            'password' => Hash::make($data['password']),
        ]);

        $sms = new SMSController($data['phone'], $data['password'], true, '');
        $sms->sendSMS();

        // $user->notify(new SendPasswordAfterRegisterNotification($data['password']));
        return $user;
    }

    public static function password($length = 32, $letters = true, $numbers = true, $symbols = true, $spaces = false)
    {
        return (new Collection)
            ->when($letters, fn ($c) => $c->merge([
                'a',
                'b',
                'c',
                'd',
                'e',
                'f',
                'g',
                'h',
                'i',
                'j',
                'k',
                'l',
                'm',
                'n',
                'o',
                'p',
                'q',
                'r',
                's',
                't',
                'u',
                'v',
                'w',
                'x',
                'y',
                'z',
                'A',
                'B',
                'C',
                'D',
                'E',
                'F',
                'G',
                'H',
                'I',
                'J',
                'K',
                'L',
                'M',
                'N',
                'O',
                'P',
                'Q',
                'R',
                'S',
                'T',
                'U',
                'V',
                'W',
                'X',
                'Y',
                'Z',
            ]))
            ->when($numbers, fn ($c) => $c->merge([
                '0',
                '1',
                '2',
                '3',
                '4',
                '5',
                '6',
                '7',
                '8',
                '9',
            ]))
            ->when($symbols, fn ($c) => $c->merge([
                '~',
                '!',
                '#',
                '$',
                '%',
                '^',
                '&',
                '*',
                '(',
                ')',
                '-',
                '_',
                '.',
                ',',
                '<',
                '>',
                '?',
                '/',
                '\\',
                '{',
                '}',
                '[',
                ']',
                '|',
                ':',
                ';',
            ]))
            ->when($spaces, fn ($c) => $c->merge([' ']))
            ->pipe(fn ($c) => Collection::times($length, fn () => $c[random_int(0, $c->count() - 1)]))
            ->implode('');
    }
}
