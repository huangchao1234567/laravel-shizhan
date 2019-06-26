<?php
namespace App\Http\Controllers\Auth;
use Illuminate\Foundation\Auth\VerifiesEmails;
use App\Http\Controllers\Controller;

class VerificationController extends Controller
{
  //  protected $redirectTo = '/';

    use VerifiesEmails;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

   /* public function verify()
    {
        return view('welcome');
    }*/


}