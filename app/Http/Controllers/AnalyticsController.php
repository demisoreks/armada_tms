<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use App\AmdUser;
use App\AmdResource;
use App\AmdRequest;

class AnalyticsController extends Controller
{
    public function ratings() {
        $input = Input::all();
        if (isset($input['from_date']) && isset($input['to_date'])) {
            $from_date = $input['from_date'];
            $to_date = $input['to_date'];
        } else {
            $from_date = date("Y-m-d");
            $to_date = date("Y-m-d");
        }
        $param = [
            'from_date' => $from_date,
            'to_date' => $to_date
        ];
        
        $ratings = [];
        $commanders = AmdUser::all();
        foreach ($commanders as $commander) {
            $name = $commander->name;
            $region = $commander->region->name;
            $sum = 0.0;
            $count = 0;
            
            $tasks = AmdResource::where('resource_type', 1)->where('resource_id', $commander->id)->whereRaw('request_id in ('.implode(',', AmdRequest::where('service_date_time', '>=', $from_date.' 00:00:00')->where('service_date_time', '<=', $to_date.' 23:59:59')->pluck('id')->toArray()).')')->get();
            foreach ($tasks as $task) {
                $request = AmdRequest::whereId($task->request->id)->first();
                if ($request->rating != null) {
                    $sum += $request->rating;
                    $count ++;
                }
            }
            if ($count > 0) {
                $average = number_format($sum/$count, 2);
            } else {
                $average = 0.00;
            }
            
            array_push($ratings, [
                'commander' => $name,
                'region' => $region,
                'average' => $average
            ]);
        }
        
        return view('analytics.ratings', compact('param', 'ratings'));
    }
}
