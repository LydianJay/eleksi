<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\ElectricityData;
use Illuminate\Support\Facades\Date;
use App\Http\Controllers\DataAPI;
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

        $dataAPI = new DataAPI();
        $cost = $dataAPI->getCost();

        $cost = json_decode($cost->getContent(), true);
        $cost = $cost['rate'];
        if(isset($lastday) && $lastday != null) {
            $dif = 100 - (($energy - $lastday) / $energy ) * 100;
        }
        // dd($data);

        return view('pages.dashboard.dashboard', ['cost' => $cost, 'data' => $data, 'active_link' => 'dashboard', 'max_id' => $maxID, 'max_energy' => $energy, 'dif' => $dif]);
    }
}
