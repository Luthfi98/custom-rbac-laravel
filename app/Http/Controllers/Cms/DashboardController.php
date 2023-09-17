<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function index()
    {
        $data = ['title' => 'Dashboard'];
        return view('cms.dashboard', $data);
    }
}
