<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ActionPlanInvolve extends Model implements Auditable
{
    //
    use \OwenIt\Auditing\Auditable;

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

}