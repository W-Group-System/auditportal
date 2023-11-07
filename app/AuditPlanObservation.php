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
    public function created_by_user()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }
    public function audit_plan()
    {
    return $this->belongsTo(AuditPlan::class);
    }
    public function action_plans()
    {
        return $this->hasMany(ActionPlan::class);
    }
    public function histories()
    {
        return $this->hasMany(AuditPlanObservationHistory::class);
    }
    public function explanation()
    {
        return $this->hasOne(Explanation::class);
    }
    public function attachments_data()
    {
        return $this->hasMany(AuditPlanObservationAttachment::class);
    }
}
