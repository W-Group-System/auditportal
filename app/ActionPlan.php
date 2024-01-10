<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Contracts\Auditable;
class ActionPlan extends Model implements Auditable
{
    
    //
    use \OwenIt\Auditing\Auditable;

    public function teams()
    {
        return $this->hasMany(ActionPlanInvolve::class);
    }
    public function observation()
    {
        return $this->belongsTo(AuditPlanObservation::class,'audit_plan_observation_id','id');
    }
    public function histories()
    {
        return $this->hasMany(ActionPlanRemark::class)->orderBy('created_at','desc');
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function audit_plan()
    {
        return $this->belongsTo(AuditPlan::class);
    }
    public function auditor_data()
    {
        return $this->belongsTo(User::class,'auditor','id');
    }
}
