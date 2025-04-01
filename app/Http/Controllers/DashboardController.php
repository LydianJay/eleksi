<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\ElectricityData;
use Illuminate\Support\Facades\Date;

class DashboardController extends Controller
{
    public function index() {

        $data = ElectricityData::whereDate("date", Carbon::now())
            ->orderBy("id","asc")
            ->get();

        // dd(Carbon::now());
        $maxID = ElectricityData::whereDate("date", Carbon::now())
            ->orderBy("id","asc")
            ->max("id");

        $energy = ElectricityData::select('energy')
            ->whereDate("date", Carbon::now())
            ->max("energy");

        $lastday = ElectricityData::select('energy')
            ->whereDate("date", Carbon::now()->subDays(1))
            ->max("energy");

        

        $dif = 0;

        if(isset($lastday) && $lastday != null) {
            $dif = ($lastday / ($energy - $lastday)) * 100;
        }

        return view('pages.dashboard.dashboard', ['data' => $data, 'active_link' => 'dashboard', 'max_id' => $maxID, 'max_energy' => $energy, 'dif' => $dif]);
    }
}
