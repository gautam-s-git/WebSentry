<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailNotificationLog extends Model
{
    protected $fillable = [
        'client_id',
        'email',
        'website_id',
        'email_sent_on',
        'is_delivered',
        'failure_message',
        'email_message',
        'email_subject',
        'notification_type',
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
