<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Contracts\Auditable;
class AuditPlanBusinessUnit extends Model implements Auditable
{
    //
    use \OwenIt\Auditing\Auditable;

    public function business_unit()
    {
        return $this->belongsTo(BusinessUnit::class);
    }
    public function action_plan()
    {
        return $this->belongsTo(ActionPlan::class);
    }
}