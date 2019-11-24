<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Input;
use App\AmdUser;
use App\AmdResource;
use App\AmdRequest;
use App\Charts\DistributionChart;

class AnalyticsController extends Controller
{
    public function ratings() {
        $input = Input::all();
        if (isset($input['from_date']) && isset($input['to_date'])) {
            $from_date = $input['from_date'];
            $to_date = $input['to_date'];
        } else {
            $to_date = date("Y-m-d");
            $from_date = date("Y-m-d", strtotime('-7 days', strtotime($to_date)));
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
            $average = 0.00;
            
            if (AmdRequest::where('service_date_time', '>=', $from_date.' 00:00:00')->where('service_date_time', '<=', $to_date.' 23:59:59')->count() > 0) {
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
                }
            }
            
            array_push($ratings, [
                'commander' => $name,
                'region' => $region,
                'average' => $average
            ]);
        }
        
        $ratings_chart = new DistributionChart();
        
        $requests = AmdRequest::where('service_date_time', '>=', $from_date.' 00:00:00')->where('service_date_time', '<=', $to_date.' 23:59:59')->get();
        $no_feedback = 0;
        $excellent = 0;
        $good = 0;
        $satisfactory = 0;
        $poor = 0;
        $very_poor = 0;
        foreach ($requests as $r) {
            if ($r->rating == 5) {
                $excellent ++;
            } else if ($r->rating == 4) {
                $good ++;
            } else if ($r->rating == 3) {
                $satisfactory ++;
            } else if ($r->rating == 2) {
                $poor ++;
            } else if ($r->rating == 1) {
                $very_poor ++;
            } else {
                $no_feedback ++;
            }
        }
        $ratings_labels = ['Excellent', 'Good', 'Satisfactory', 'Poor', 'Very Poor', 'No Feedback'];
        $ratings_counts = [$excellent, $good, $satisfactory, $poor, $very_poor, $no_feedback];
        $ratings_colors = [];
        for ($i=0; $i<6; $i++) {
            array_push($ratings_colors, '#'.str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT));
        }
        
        $ratings_chart->labels($ratings_labels)->dataset('Ratings Chart', 'doughnut', $ratings_counts)->backgroundColor($ratings_colors);
        
        return view('analytics.ratings', compact('param', 'ratings', 'ratings_chart'));
    }
}
