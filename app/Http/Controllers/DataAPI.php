<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ElectricityData;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;

class DataAPI extends Controller
{
    public function insert(Request $request){
        $Model = new ElectricityData();
        
        $data = [
            'voltage'       => $request->input('voltage'),
            'current'       => $request->input('current'),
            'power'         => $request->input('power'),
            'energy'        => $request->input('energy'),
        ];
        // ElectricityData::create($data);
        
        $Model->insert($data);
        

        return response()->json(['msg' => 'Data Inserted Successfully!']);

    }


    public function getToday() {

        $query = ElectricityData::whereDate('date', Carbon::now())
        ->orderBy('id','desc')
        ->first();

        $lastday = ElectricityData::select('energy')
        ->whereDate('date', Carbon::today()->subDays(1))
        ->max('energy');

        $dif = 0;

        if(isset($lastday) && $lastday != null) {
            $dif = 100 - (($query->energy - $lastday) / $query->energy ) * 100;
        }

        $data = [
            'id'        => $query->id,
            'voltage'   => $query->voltage,
            'current'   => $query->current,
            'power'     => $query->power,
            'energy'    => $query->energy,
            'dif'       => $dif
        ];
        
        return response()->json($query);
    }
}
