<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ElectricityData;

class DashboardController extends Controller
{
    public function index() {

        $data = ElectricityData::all();

        



        return view('pages.dashboard.dashboard', ['data' => $data, 'active_link' => 'dashboard']);
    }
}
