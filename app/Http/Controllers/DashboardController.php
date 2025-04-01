<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\ElectricityData;

class DashboardController extends Controller
{
    public function index() {

        $data = ElectricityData::whereDate("date","=", Carbon::today()->toDateString())
            ->orderBy("date","desc")
            ->get();


        return view('pages.dashboard.dashboard', ['data' => $data, 'active_link' => 'dashboard']);
    }
}
