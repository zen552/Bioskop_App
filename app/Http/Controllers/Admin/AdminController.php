<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function films()
    {
        return view('admin.films');
    }

    public function webUsers()
    {
        return view('admin.users');
    }

    public function schedule()
    {
        return view('admin.schedule');
    }
}
