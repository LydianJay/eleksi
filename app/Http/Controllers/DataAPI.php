<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ElectricityData;
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
}
