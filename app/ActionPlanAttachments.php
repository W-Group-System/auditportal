<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ActionPlanAttachments extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $table = 'action_plan_attachments';
    protected $fillable = [
        'action_plan_id',
        'attachment',
    ];
}
