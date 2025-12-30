<?php

namespace App\Http\Controllers\Websentry;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\MonitoringProcessLog;
use App\Models\Website;
use App\Services\MonitoringService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MonitoringController extends Controller
{
    public function home(){

        $websites=Website::with('client')->orderBy('id','DESC')->get();

        // $websites->map(function($web){
        //     $url=$web->url;
        //     $client_id=$web->client->id;
        //     $web_id=$web->id;
        //     MonitoringService::checkWebsiteStatus($url,$client_id,$web_id);
        // });

        $monitorLogs=MonitoringProcessLog::with('client','website')->get();



        $clients=Client::select('email')->withCount('website')->get();


        return Inertia::render('websentry/Monitoring',['clients'=>$clients,'websites'=>$websites,'monitorLogs'=>$monitorLogs]);


    }
}
