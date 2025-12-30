<?php

namespace App\Models;

use App\Observers\WebsiteObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


#[ObservedBy([WebsiteObserver::class])]
class Website extends Model
{
     use SoftDeletes;

    protected $fillable = [
        'client_id',
        'url',
        'name',
        'active',
        'check_interval',
        'uptime_percentage',
        'last_checked_at',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
