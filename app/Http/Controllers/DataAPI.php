<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ElectricityData;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

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

    public function getCost() {
        $energy = ElectricityData::max('energy');
        $month = date('F', strtotime(Carbon::now()->subMonths(1)));
        $year = date('Y', strtotime(Carbon::now()));
        $html = Http::asForm()->post('https://www.surneco.com.ph/ratesimulation/index.php', [
            'OptYear'       => $year,
            'OptMonth'      => $month,
            'OptConsumer'   => 'Mainland',
            'KWhUse'        => $energy,
            'operator'      => 'No',
            'submit'        => 'submit',
        ]);
        $crawler = new Crawler($html);
        $match = $crawler->filter('.styfntblk20white')->reduce(function (Crawler $node) {
            return preg_match('/Php\s*\d+(\.\d+)?/', $node->text());
        })->first();

        $rateText = trim($match->text());

        return response()->json([
            'rate' => $rateText,
        ]);
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

        $cost = $this->getCost();
        $cost = json_decode($cost->getContent(), true);
        $cost = $cost['rate'];
        $data = [
            'id'        => $query->id,
            'voltage'   => $query->voltage,
            'current'   => $query->current,
            'power'     => $query->power,
            'energy'    => $query->energy,
            'dif'       => $dif,
            'cost'      => $cost,
        ];
        
        return response()->json($data);
    }
}
