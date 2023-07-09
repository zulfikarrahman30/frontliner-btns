<?php

namespace App\Http\Controllers\Admin;

use App\Models\UserLog;
use Auth;

class UserLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('timeoutses');
    }

    public function index()
    {
        $data = UserLog::orderBy('created_at', 'DESC')->get();
        return view('dashboard.user.admin.log', compact('data'));
    }
}
