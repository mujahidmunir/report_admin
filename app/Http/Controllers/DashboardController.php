<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $reports = Report::whereDate('created_at', Carbon::today())->with('category', 'subCategory', 'action')->get();
        $users = User::whereIn('name', ['gayanti', 'rifaldi'])->orderBy('name')->get();
        return view('index', compact('reports', 'users'));
    }
}
