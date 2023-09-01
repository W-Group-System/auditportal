<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AuditPlan extends Model implements Auditable
{
    //
    use \OwenIt\Auditing\Auditable;
    public function procedures()
    {
        return $this->hasMany(AuditPlanProcedure::class);
    }
    public function objectives()
    {
        return $this->hasMany(AuditPlanObjective::class);
    }
    public function companies()
    {
        return $this->hasMany(AuditPlanCompany::class);
    }
    public function department(){

        return $this->hasMany(AuditPlanDepartment::class);
    }
    public function auditor_data(){

        return $this->hasMany(AuditPlanAuditor::class);
    }
    public function carbon_copies(){
        return $this->hasMany(CarbonCopy::class);
    }
    public function hbu(){
        return $this->hasMany(AuditPlanBusinessUnit::class);
    }
    public function observations(){
        return $this->hasMany(AuditPlanObservation::class);
    }
    public function action_plans()
    {
        return $this->hasMany(ActionPlan::class);
    }
}
