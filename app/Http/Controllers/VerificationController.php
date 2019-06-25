<?php
namespace App\Http\Controllers\Auth;


class VerificationController
{
  //  protected $redirectTo = '/';

    public function verify()
    {
        return view('welcome');
    }
}