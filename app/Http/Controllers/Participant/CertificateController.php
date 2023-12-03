<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function __invoke(Request $request)
    {
        $certificates = Certificate::when(request()->q, function($certificates) {
            $certificates = $certificates->where('title', 'like', '%'. request()->q . '%');
        })
        ->where('nip', auth()->guard('participant')->user()->nip) // Add this line to filter by 'nip'
        ->latest()
        ->paginate(5);


        //append query string to pagination links
        $certificates->appends(['q' => request()->q]);

        // return $certificates;
        return inertia('Participant/Certificate/Index', [
        'certificates' => $certificates,
        ]);
    }

}
