<?php

namespace App\Http\Controllers;
use App\Company;
use App\Department;
use App\User;
use App\AuditPlan;
use App\Engagement;
use App\EngagementDepartment;
use App\EngagementCompany;
use App\EngagementAuditor;
use App\EngagementProcedure;
use App\EngagementObjective;
use App\AuditPlanCompany;
use App\AuditPlanProcedure;
use App\AuditPlanObjective;
use App\AuditPlanDepartment;
use App\AuditPlanAuditor;
use Illuminate\Http\Request;

use PDF;
use RealRashid\SweetAlert\Facades\Alert;

class ScheduleController extends Controller
{
    //
   
    public function index(Request $request)
    {
        $month = $request->month;
        if($month == "")
        {
            $month = date('Y-m');
        }
        $departments = Department::where('status',null)->get();
        $companies = Company::where('status',null)->get();
        $users = User::where('status',null)->get();
        $schedule_month = AuditPlan::whereYear('audit_from','=',date('Y',strtotime($month)))->whereMonth('audit_from','=',date('m',strtotime($month)))->where('status',null)->orderBy('audit_to','asc')->get();
        // $engagements = Engagement::get();
        // $schedule_month = Engagement::whereYear('audit_from','=',date('Y'))->whereMonth('audit_from','=',date('m'))->get();
        return view('calendar',
        array(
            'departments' =>  $departments,
            'companies' =>  $companies,
            'users' =>  $users,
            // 'audit_plans' =>  $audit_plans,
            // 'engagements' =>  $engagements,
            'schedule_month' =>  $schedule_month,
            'month' =>  $month,
        ));
    }
    public function store (Request $request)
    {
        // dd($request->all());
       
        $audit_plan = new AuditPlan;
        $audit_plan->engagement_title = $request->engagement_title;
        $audit_plan->scope = $request->scope;
        $audit_plan->audit_from = $request->audit_start;
        $audit_plan->audit_to = $request->audit_end;
        // $audit_plan->code = $this->generate_code($request->audit_end);
        $audit_plan->save();

        foreach($request->company as $company)
        {
            $auditplanCompany = new AuditPlanCompany;
            $auditplanCompany->audit_plan_id = $audit_plan->id;
            $auditplanCompany->company_id = $company;
            $auditplanCompany->save();
        }

        foreach($request->procedures as $procedure)
        {
            $auditplanProcedure = new AuditPlanProcedure;
            $auditplanProcedure->audit_plan_id = $audit_plan->id;
            $auditplanProcedure->name = $procedure;
            $auditplanProcedure->save();
        }
        foreach($request->objectives as $objective)
        {
            $auditplanObjective = new AuditPlanObjective;
            $auditplanObjective->audit_plan_id = $audit_plan->id;
            $auditplanObjective->name = $objective;
            $auditplanObjective->save();
        }
        foreach($request->auditee as $department)
        {
            $user = User::where('id',$department)->first();
            $auditplanDepartment = new AuditPlanDepartment;
            $auditplanDepartment->user_id  = $department;
            $auditplanDepartment->department_id  = $user->department_id;
            $auditplanDepartment->audit_plan_id  = $audit_plan->id;
            $auditplanDepartment->save();
    
        }
        foreach($request->auditor as $auditor)
        {
            $auditplanAuditor = new AuditPlanAuditor;
            $auditplanAuditor->user_id  = $auditor;
            $auditplanAuditor->audit_plan_id  = $audit_plan->id;
            $auditplanAuditor->save();
    
        }

        Alert::success('Successfully Store')->persistent('Dismiss');
        return back();
        
    }

    public function generate_code($date)
    {
        $first_code = "IA-ACR-";
        $year = date('Y');
        $month = date('m');

        $engagement_latest = Engagement::whereYear('audit_to',$year)->whereMonth('audit_to',$month)->orderBy('id','desc')->first();
        if($engagement_latest == null)
        {
             $code =  $first_code.$year."-".$month."-01";
        }
        else
        {
             $c = $engagement_latest->code;
             $c = explode("-", $c);
             $last_code = ((int)$c[count($c)-1])+1;
             $code = $first_code.$year."-".$month."-".str_pad($last_code, 2, '0', STR_PAD_LEFT);
        }
        return $code;
    }
    public function monthly_report(Request $request)
    {
        // dd($request->all());
        $month = $request->month;
        $schedule_month = AuditPlan::whereYear('audit_from','=',date('Y',strtotime($month)))->whereMonth('audit_from','=',date('m',strtotime($month)))->where('status',null)->orderBy('audit_to','asc')->get();
        $pdf = PDF::loadView('monthly_report', array(
            'schedule_month' => $schedule_month,
        ));
        return $pdf->stream('Monthly Report-',date($month));


    }
}
