<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailerException;
//use Session;
use Session;
use App\Models\Admin;
use App\Models\CustomerService;
use App\Models\FinancingService;
use App\Models\Manager;
use App\Models\Teller;
use App\Models\Marketing;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function loginUser(Request $request)
    {
        $email = DB::table('users')->where('email', $request->email)->first();
        if (!$email) {
            return redirect('login')->with('error','Email anda tidak ditemukan!');;
        } else {
            if (!Hash::check($request->password, $email->password)) {
                return redirect('login')->with('error','Password anda salah!');
            } else {
                $user = User::find($email->id);
                Auth::login($user);
                return redirect('home');
            }
        }
    }
}
