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
use App\CarbonCopy;
use App\UploadSign;
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
        $uploads = UploadSign::where('month',date('Y-m-01',strtotime($month)))->get();
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
            'schedule_month' =>  $schedule_month,
            'month' =>  $month,
            'uploads' =>  $uploads,
        ));
    }
    public function edit (Request $request,$id)
    {
        // dd($request->all());
       
        $audit_plan = AuditPlan::findOrfail($id);
        $audit_plan->engagement_title = $request->engagement_title;
        $audit_plan->scope = $request->scope;
        $audit_plan->activity = $request->activity;
        $audit_plan->audit_from = $request->audit_start;
        $audit_plan->audit_to = $request->audit_end;
        // $audit_plan->code = $this->generate_code($request->audit_end);
        $audit_plan->save();
        AuditPlanCompany::where('audit_plan_id',$id)->delete();
        AuditPlanProcedure::where('audit_plan_id',$id)->delete();
        AuditPlanObjective::where('audit_plan_id',$id)->delete();
        AuditPlanAuditor::where('audit_plan_id',$id)->delete();
        AuditPlanDepartment::where('audit_plan_id',$id)->delete();


        foreach($request->company as $company)
        {
            $auditplanCompany = new AuditPlanCompany;
            $auditplanCompany->audit_plan_id = $audit_plan->id;
            $auditplanCompany->company_id = $company;
            $auditplanCompany->save();
        }
        $procedures = preg_split('/\r\n|[\r\n]/',$request->procedures);
        $objectives = preg_split('/\r\n|[\r\n]/',$request->objectives);
        foreach($procedures as $procedure)
        {
            $auditplanProcedure = new AuditPlanProcedure;
            $auditplanProcedure->audit_plan_id = $audit_plan->id;
            $auditplanProcedure->name = $procedure;
            $auditplanProcedure->save();
        }
        foreach($objectives as $objective)
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

        Alert::success('Successfully Updated')->persistent('Dismiss');
        return back();
        
    }
    public function store (Request $request)
    {
        // dd($request->all());
       
        $audit_plan = new AuditPlan;
        $audit_plan->engagement_title = $request->engagement_title;
        $audit_plan->scope = $request->scope;
        $audit_plan->activity = $request->activity;
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
        $procedures = preg_split('/\r\n|[\r\n]/',$request->procedures);
        $objectives = preg_split('/\r\n|[\r\n]/',$request->objectives);
        foreach($procedures as $procedure)
        {
            $auditplanProcedure = new AuditPlanProcedure;
            $auditplanProcedure->audit_plan_id = $audit_plan->id;
            $auditplanProcedure->name = $procedure;
            $auditplanProcedure->save();
        }
        foreach($objectives as $objective)
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

    public function generate_code($date,$id)
    {
        $first_code = "IA-";
        $year = date('Y');
        $month = date('m');

      
        $last_code = $id;
        $code = $first_code.$year."-".$month."-".str_pad($last_code, 2, '0', STR_PAD_LEFT);

        return $code;
    }
    public function monthly_report(Request $request)
    {
        // dd($request->all());
        $month = $request->month;
        $schedule_month = AuditPlan::whereYear('audit_from','=',date('Y',strtotime($month)))->whereMonth('audit_from','=',date('m',strtotime($month)))->where('status',null)->orderBy('audit_to','asc')->get();
        $pdf = PDF::loadView('monthly_report', array(
            'schedule_month' => $schedule_month,
            'month' => $month,
        ))->setPaper('letter', 'landscape');
        return $pdf->stream('Monthly Report-',date($month));


    }

    public function upload(Request $request)
    {
        if($request->has('file'))
        {
            $attachment = $request->file('file');
            $name = time() . '_' . $attachment->getClientOriginalName();
            $attachment->move(public_path() . '/monthly_reports/', $name);
            $file_name = '/monthly_reports/' . $name;
            
            $upload = new UploadSign;
            $upload->month = date('Y-m-01',strtotime($request->month));
            $upload->file = $file_name;
            $upload->user_id = auth()->user()->id;
            $upload->save();
        }

        $schedule_month = AuditPlan::whereYear('audit_from','=',date('Y',strtotime($request->month)))->whereMonth('audit_from','=',date('m',strtotime($request->month)))->where('status',null)->orderBy('audit_to','asc')->get();
        foreach($schedule_month as $key => $audit_plan)
        {
            $audit_plan->code = $this->generate_code($request->month, $key+1);
            $audit_plan->save();
        }

        
        Alert::success('Successfully Store')->persistent('Dismiss');
        return back();
    }

    public function view($id)
    {
        //

        $audit_plan = AuditPlan::findOrfail($id);
        $users = User::where('status',null)->get();
        return view('audit_plan',
        array(
            'audit_plan' => $audit_plan,
            'users' => $users,
        )
    
        );

    }
    public function carbon(Request $request,$id)
    {
        $carbon_copies = CarbonCopy::where('audit_plan_id',$id)->delete();

        foreach($request->carbon_copy as $carbon_copy)
        {
            $cc = new CarbonCopy;
            $cc->audit_plan_id = $id;
            $cc->user_id = $carbon_copy;
            $cc->save();
        }
      
        Alert::success('Successfully Store')->persistent('Dismiss');
        return back();
    }

    public function authority($id)
    {
        $audit_plan = AuditPlan::findOrfail($id);

        $audit_companies = AuditPlanCompany::where('audit_plan_id',$id)->pluck('company_id')->toArray();

        $companies = Company::whereIn('id',$audit_companies)->groupBy('group_name','group_code')->select('group_name','group_code')->get();
        $pdf = PDF::loadView('authority', array(
            'audit_plan' => $audit_plan,
            'companies' => $companies,
        ));
        return $pdf->stream('authority_to_audit');
    }
}
