<?php

namespace App\Http\Controllers\Examiner;

use App\Http\Controllers\Controller;
use App\Models\Examiner;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        //validate the form data
        $this->validate($request, [
            'nip'      => 'required',
            'password'  => 'required',
        ]);

        //cek nip dan password
        $examiner = Examiner::where([
            'nip'      => $request->nip,
            'password'  => $request->password
        ])->first();

        if(!$examiner) {
            return redirect()->back()->with('error', 'NIP atau Password salah');
        }

        //login the user
        auth()->guard('examiner')->login($examiner);

        //redirect to dashboard
        return redirect()->route('examiners.dashboard');
    }
}
