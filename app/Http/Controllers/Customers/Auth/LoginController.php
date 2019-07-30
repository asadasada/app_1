<?php

namespace App\Http\Controllers\Customers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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
     だからここを"/profileに(いやhomeのままで/profileを追加すればいいのか?)"
     * @var string
     */
     // $redirectToに変数を入れる方法
     //reidrectTo()メソッドを定義すること
    // protected $redirectTo = '/{$name}/profile';
protected function redirectTo()
{
    $hoge = Auth::guard('customers')->user();
    return '/customers/'.$hoge->name.'/profile';
}
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:customers')->except('logout');
    }
    public function showLoginForm()
   {
       return view('customers.auth.login');
   }
    protected function guard()
   {
       return Auth::guard('customers');
   }
    public function logout(Request $request)
   {
       $this->guard('customers')->logout();
       // $request->session()->invalidate();
       //ここまで実行されたらtes
       return redirect('/');
    }
}
