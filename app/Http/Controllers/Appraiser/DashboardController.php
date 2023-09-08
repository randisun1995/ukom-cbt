<?php

namespace App\Http\Controllers\Appraiser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {

        return inertia('Appraiser/Dashboard/Index', [

        ]);
    }
}

