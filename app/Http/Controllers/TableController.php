<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ElectricityData;
class TableController extends Controller
{
    public function index(Request $request) {

        $request->all();

        $data = [];

        $data['table_header'] = [
            'ID',
            'Date',
            'Energy',
            'Power',
            'Voltage',
            'Current',
        ];

        $data['table_rows'] = [
            'id',
            'date',
            'energy',
            'power',
            'voltage',
            'current'
        ]; 

        $limit          = 10;
        $currentPage    = 1;
        
        if(isset($request->page) && $request->page != null && $request->page != '') {
            $currentPage = $request->page;
        }


        $from   = $request->input('from');
        $to     = $request->input('to');

        $data['table_data'] = ElectricityData::orderBy('id', 'asc');
        $countQuery         = ElectricityData::orderBy('id', 'asc');

        if(isset($from) && $from != null && $from != '' && isset($to) && $to != null && $to != '') {
            $data['table_data'] = $data['table_data']->whereBetween('date', [Carbon::parse($from)->startOfDay(), Carbon::parse($to)->endOfDay()]);
            $countQuery         = $countQuery->whereBetween('date', [Carbon::parse($from)->startOfDay(), Carbon::parse($to)->endOfDay()]);
        }
        $data['count']      = $countQuery->count();
        
        $data['table_data'] = $data['table_data']->limit($limit)->offset(($currentPage - 1) * $limit)->get();
        $data['total_page'] = floor($data['count'] / $limit);
        $data['current_page'] = $currentPage;
        return view('pages.dashboard.tableview', ['data' => $data, 'active_link' => 'table']);
    }
}
