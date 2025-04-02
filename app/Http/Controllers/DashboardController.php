<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\ElectricityData;
use Illuminate\Support\Facades\Date;

class DashboardController extends Controller
{
    public function index() {
        $data = ElectricityData::whereBetween('date', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()])
            ->orderBy("id", "asc")
            ->get();

        $maxID = ElectricityData::whereBetween('date', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()])
            ->orderBy("id","asc")
            ->max("id");

        $energy = ElectricityData::select('energy')
            ->whereBetween('date', [Carbon::today()->startOfDay(), Carbon::today()->endOfDay()])
            ->max('energy');

        $lastday = ElectricityData::select('energy')
            ->whereBetween('date', [Carbon::today()->subDays(1)->startOfDay(), Carbon::today()->startOfDay()])
            ->max('energy');

        
        $dif = 0;

        if(isset($lastday) && $lastday != null) {
            $dif = ($lastday / ($energy - $lastday)) * 100;
        }

        return view('pages.dashboard.dashboard', ['data' => $data, 'active_link' => 'dashboard', 'max_id' => $maxID, 'max_energy' => $energy, 'dif' => $dif]);
    }
}
