<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Contracts\Auditable;
class AuditPlanObservation extends Model implements Auditable
{
    //
    use \OwenIt\Auditing\Auditable;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function audit_plan()
    {
        return $this->belongsTo(AuditPlan::class);
    }
    public function action_plans()
    {
        return $this->hasMany(ActionPlan::class,'observation_id','id');
    }
}
