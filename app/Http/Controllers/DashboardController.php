<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $reports = Report::whereDate('created_at', Carbon::today())->with('category', 'subCategory')->get();
//        return $reports;
        return view('index', compact('reports'));
    }
}
