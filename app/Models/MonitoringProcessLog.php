<?php

namespace App\Models;

use App\Observers\MonitoringProcessLogObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([MonitoringProcessLogObserver::class])]
class MonitoringProcessLog extends Model
{
    protected $fillable = [
        'client_id',
        'website_id',
        'last_monitored',
        'status',
        'status_code',
        'response_time',
        'failure_error',
        'response_body',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}
