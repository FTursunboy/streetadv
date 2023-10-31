<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedbackReasons extends Model
{
    protected $primaryKey = 'feedbackReasonID';

    protected $table = 'feedback_reasons';

    public static function reasonsForJson ($reason)
    {
        $arrReason = [
            'id' => $reason->feedbackReasonID,
            'lang_id' => $reason->languageID,
            'reason_type' => $reason->reason_type
        ];

        return $arrReason;
    }

}
