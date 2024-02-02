<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class Department extends Model implements Auditable
{
    //
    use \OwenIt\Auditing\Auditable;
    public function dep_head()
    {
        return $this->hasOne(DepartmentHead::class);
    }
    public function audit_plans()
    {
        return $this->hasMany(AuditPlanDepartment::class);
    }
    public function action_plans()
    {
        return $this->hasMany(ActionPlan::class);
    }
    public function risk()
    {
        return $this->hasMany(AuditPlanObservation::class);
    }
    public function group()
    {
        return $this->hasOne(DepartmentGroup::class);
    }
}
