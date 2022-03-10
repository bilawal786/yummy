<?php

namespace App\Http;

use App\Notify;

class NotificationHelper{

    public static function addtoNitification($s_id, $r_id, $msg, $generate_id, $activity, $country_id)
    {
        $notificationobj = new Notify();
        $notificationobj->s_id = $s_id;
        $notificationobj->r_id = $r_id;
        $notificationobj->message = $msg;
        $notificationobj->generate_id = $generate_id;
        $notificationobj->activity = $activity;
        $notificationobj->country_id = $country_id;
        $notificationobj->save();
    }
}
