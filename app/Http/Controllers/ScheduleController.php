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
use App\AuditPlanObservation;
use App\AuditPlanObservationAttachment;
use App\AuditPlanAuditor;
use App\Consequence;
use App\Likelihood;
use App\Matrix;
use App\CarbonCopy;
use App\AuditPlanBusinessUnit;
use App\AuditPlanAttachment;
use App\UploadSign;
use App\BusinessUnit;
use App\AuditPlanObservationHistory;
use Illuminate\Http\Request;
use App\Notifications\ACRApproval;
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
    public function storeSpecial (Request $request)
    {
        // dd($request->all());
        $audit_plans = AuditPlan::where('code','like', '%' .date('Y-m',strtotime($request->audit_start)). '%')->orderBy('code','desc')->first();
        $c = $audit_plans->code;
        $c = explode("-", $c);
        $last_code = ((int)$c[count($c)-1])+1;
        $audit_plan = new AuditPlan;
        $audit_plan->code = $this->generate_code(date('Y-m',strtotime($request->audit_start)), $last_code);
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
    public function attachment(Request $request,$id)
    {
        if($request->has('file'))
        {
            $attachment = $request->file('file');
            $name = time() . '_' . $attachment->getClientOriginalName();
            $attachment->move(public_path() . '/audit_plan_attachments/', $name);
            $file_name = '/audit_plan_attachments/' . $name;

            $attachment = new AuditPlanAttachment;
            $attachment->type = $request->type;
            $attachment->audit_plan_id = $id;
            $attachment->file = $file_name;
            $attachment->user_id = auth()->user()->id;
            $attachment->save();
      
        }

        Alert::success('Successfully Uploaded')->persistent('Dismiss');
        return back();
    }
    public function generate_code($date,$id)
    {
        $first_code = "IA-";
        $year = date('Y',strtotime($date));
        $month = date('m',strtotime($date));

      
        $last_code = $id;
        $code = $first_code.$year."-".$month."-".str_pad($last_code, 2, '0', STR_PAD_LEFT);

        return $code;
    }
    public function generate_code_acr($date)
    {
        $first_code = "IA-ACR-";
        $year = date('Y',strtotime($date));
        $month = date('m',strtotime($date));

        $last_data = AuditPlanObservation::whereYear('date_audit',$year)->whereMonth('date_audit',$month)->orderBy('code','desc')->first();
        if($last_data == null)
        {
            $last_code = 1; 
        }
        else
        {
            $c = $last_data->code;
            $c = explode("-", $c);
            $last_code = ((int)$c[count($c)-1])+1;
        }
       
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
        $consequences = Consequence::get();
        $likelihoods = Likelihood::get();
        $risks = Matrix::get();
        $audit_plan = AuditPlan::findOrfail($id);
        $users = User::where('status',null)->get();
        $business_units = BusinessUnit::get();
        return view('audit_plan',
            array(
                'audit_plan' => $audit_plan,
                'users' => $users,
                'business_units' => $business_units,
                'consequences' => $consequences,
                'likelihoods' => $likelihoods,
                'risks' => $risks,
            )
        );

    }
    public function hbu(Request $request,$id)
    {
        $audit_plan = AuditPlanBusinessUnit::where('audit_plan_id',$id)->delete();

        foreach($request->hbu as $hbu)
        {
            $cc = new AuditPlanBusinessUnit;
            $cc->audit_plan_id = $id;
            $cc->business_unit_id = $hbu;
            $cc->save();
        }
      
        Alert::success('Successfully updated')->persistent('Dismiss');
        return back();
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
      
        Alert::success('Successfully updated')->persistent('Dismiss');
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

    public function forAudit(Request $request)
    {
        if((auth()->user()->role == "Administrator") || (auth()->user()->role == "IAD Approver"))
        {
            $audits = AuditPlan::where('code','!=',null)->orderBy('audit_to','asc')->get();
        }
        elseif(auth()->user()->role == "Auditor")
        {
            $audits = AuditPlan::where('code','!=',null)->whereHas('auditor_data', function ( $query)  {
                $query->where('user_id',auth()->user()->id);
            })->orderBy('audit_to','asc')->get();
        }
        else
        {
            $audits = [];
        }
        $audits = AuditPlan::where('code','!=',null)->orderBy('audit_to','asc')->get();
        return view('for_audit',
        array(
            'audits' => $audits,
        )
        );
       
    }
    public function forapproval(Request $request)
    {
       
        $audits = AuditPlan::where('code','!=',null)->orderBy('audit_to','asc')->get();
       
        return view('for_audit',
        array(
            'audits' => $audits,
        )
        );
       
    }
    public function initialReport($id)
    {
        $audit_plan = AuditPlan::findOrfail($id);
        $pdf = PDF::loadView('initial_report', array(
            'audit_plan' => $audit_plan,
        ));
        return $pdf->stream('initial_report');
    }
    public function closingReport($id)
    {
        $audit_plan = AuditPlan::findOrfail($id);
        $pdf = PDF::loadView('closing_report', array(
            'audit_plan' => $audit_plan,
        ));
        return $pdf->stream('closing_report');
    }
    public function new(Request $request,$id)
    {
        $consequences = Consequence::get();
        $likelihoods = Likelihood::get();
        $risks = Matrix::get();
        $audit_plan = AuditPlan::findOrfail($id);
        $users = User::where('status',null)->get();
        $business_units = BusinessUnit::get();
        return view('new_observation',
            array(
                'audit_plan' => $audit_plan,
                'users' => $users,
                'business_units' => $business_units,
                'consequences' => $consequences,
                'likelihoods' => $likelihoods,
                'risks' => $risks,
            )
        );
    }
    public function edit_observation(Request $request,$id)
    {
        $observation = AuditPlanObservation::findOrfail($id);
        $consequences = Consequence::get();
        $likelihoods = Likelihood::get();
        $risks = Matrix::get();
        $audit_plan = AuditPlan::findOrfail($observation->audit_plan_id);
        $users = User::where('status',null)->get();
        $business_units = BusinessUnit::get();
        return view('edit_observation',
            array(
                'audit_plan' => $audit_plan,
                'observation' => $observation,
                'users' => $users,
                'business_units' => $business_units,
                'consequences' => $consequences,
                'likelihoods' => $likelihoods,
                'risks' => $risks,
            )
        );
    }
    public function save_observation(Request $request,$id)
    {
        $consequence = explode("-",$request->consequence);
        $likelihood = explode("-",$request->likelihood);
        foreach($request->auditee as $auditee)
        {
        $risk = $likelihood[0]*$consequence[0];
        $risks = Matrix::where("from","<=",$risk)->orderBy('id','desc')->first();
        $user = User::findOrfail($auditee);
        $auditPlanObservation = new AuditPlanObservation;
        $auditPlanObservation->audit_plan_id = $id;
        $auditPlanObservation->observation = $request->observation;
        $auditPlanObservation->recommendation = $request->recommendation;
        $auditPlanObservation->risk_implication = $request->risk_implication;
        $auditPlanObservation->criteria = $request->audit_area;
        $auditPlanObservation->consequence = $consequence[1];
        $auditPlanObservation->consequence_number = $consequence[0];
        $auditPlanObservation->likelihood = $likelihood[1];
        $auditPlanObservation->likelihood_number = $likelihood[0];
        $auditPlanObservation->user_id = $auditee;
        $auditPlanObservation->created_by = auth()->user()->id;
        $auditPlanObservation->overall_number = $risk;
        $auditPlanObservation->overall_risk = $risks->name;
  
        $auditPlanObservation->code = $this->generate_code_acr($request->audit_date);
        $auditPlanObservation->date_audit = $request->audit_date;
        $auditPlanObservation->target_date = $request->target_date;
        $auditPlanObservation->department_id = $user->department_id;
        $auditPlanObservation->status = "For Approval";
        $auditPlanObservation->save();
        

        $users = User::where('role','IAD Approver')->where('status',null)->get();
        foreach($users as $user)
        {
            $user->notify(new ACRApproval($auditPlanObservation));
        }
              
        if($request->hasfile('attachments'))

        {
               foreach($request->file('attachments') as $attachment)
                {
                    $name = time() . '_' . $attachment->getClientOriginalName();
                    $attachment->move(public_path() . '/observations/', $name);
                    $file_name = '/observations/' . $name;
                    
                    $upload = new AuditPlanObservationAttachment;
                    $upload->audit_plan_observation_id = $auditPlanObservation->id;
                    $upload->attachment = $file_name;
                    $upload->user_id = auth()->user()->id;
                    $upload->save();
                }
        }
    }
        Alert::success('Successfully updated')->persistent('Dismiss');
        return redirect('view-calendar/'.$id);

    }
    public function remove_attachment($id)
    {
        $attachment = AuditPlanAttachment::findOrfail($id)->delete();
        Alert::success('Successfully deleted')->persistent('Dismiss');
        return back();

    }
    public function remove($id)
    { 
        $attachment = AuditPlanObservationAttachment::findOrfail($id)->delete();
        Alert::success('Successfully Remove')->persistent('Dismiss');
        return back();

    }   
    public function save_edit(Request $request,$id)
    {
        
        $consequence = explode("-",$request->consequence);
        $likelihood = explode("-",$request->likelihood);
        
        $risk = $likelihood[0]*$consequence[0];
        $risks = Matrix::where("from","<",$risk)->orderBy('id','desc')->first();
        $user = User::findOrfail($request->auditee);
        $auditPlanObservation = AuditPlanObservation::findOrfail($id);
        $auditPlanObservation->observation = $request->observation;
        $auditPlanObservation->recommendation = $request->recommendation;
        $auditPlanObservation->risk_implication = $request->risk_implication;
        $auditPlanObservation->criteria = $request->audit_area;
        $auditPlanObservation->consequence = $consequence[1];
        $auditPlanObservation->consequence_number = $consequence[0];
        $auditPlanObservation->likelihood = $likelihood[1];
        $auditPlanObservation->likelihood_number = $likelihood[0];
        $auditPlanObservation->user_id = $request->auditee;
        $auditPlanObservation->created_by = auth()->user()->id;
     
        $auditPlanObservation->overall_number = $risk;
        $auditPlanObservation->overall_risk = $risks->name;
        
        $auditPlanObservation->date_audit = $request->audit_date;
        $auditPlanObservation->target_date = $request->target_date;
        $auditPlanObservation->department_id = $user->department_id;
        $auditPlanObservation->status = "For Approval";
        $auditPlanObservation->save();
        

        $users = User::where('role','IAD Approver')->where('status',null)->get();
        foreach($users as $user)
        {
            $user->notify(new ACRApproval($auditPlanObservation));
        }

        $newHistory = new AuditPlanObservationHistory;
        $newHistory->audit_plan_observation_id = $id;
        $newHistory->action = "For Approval (return)";
        $newHistory->user_id = auth()->user()->id;
        $newHistory->save();

                
        if($request->hasfile('attachments'))

        {
               foreach($request->file('attachments') as $attachment)
                {
                    $name = time() . '_' . $attachment->getClientOriginalName();
                    $attachment->move(public_path() . '/observations/', $name);
                    $file_name = '/observations/' . $name;
                    
                    $upload = new AuditPlanObservationAttachment;
                    $upload->audit_plan_observation_id = $auditPlanObservation->id;
                    $upload->attachment = $file_name;
                    $upload->user_id = auth()->user()->id;
                    $upload->save();
                }
        }
              
        Alert::success('Successfully updated')->persistent('Dismiss');
        return redirect('view-calendar/'.$auditPlanObservation->audit_plan_id);

    }
    public function move(Request $request)
    {
        $observation = AuditPlanObservation::findOrfail($request->id);
        // dd($observation);
        if($observation->findings == null)
        {
            $observation->findings = 1;
        }
        else
        {
            $observation->findings = null;
        }
        $observation->save();
        return $observation;
    }
}
