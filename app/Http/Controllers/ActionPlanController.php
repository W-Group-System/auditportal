<?php

namespace App\Http\Controllers;
use App\ActionPlan;
use App\AuditPlan;
use App\User;
use App\ActionPlanRemark;
use App\AuditPlanObservation;
use App\Notifications\SubmitProof;
use App\Notifications\ChangeTargetDate;
use App\Notifications\ReturnActionPlan;
use App\Notifications\CloseActionPlan;
use Illuminate\Http\Request;

use RealRashid\SweetAlert\Facades\Alert;

use PDF;
class ActionPlanController extends Controller
{
    //

    public function index()
    {
        $action_plans = ActionPlan::where('status','Verified')->get();
        $audit_plans = AuditPlan::orderBy('code','desc')->get();
        $acrs = AuditPlanObservation::get();
        $users = User::where('status',null)->get();
        if(auth()->user()->role == "Auditee")
        {
            $action_plans = ActionPlan::whereHas('observation',function( $query ){
                $query->where('user_id',auth()->user()->id);
            })->where('status','Verified')->get();
        }
        return view('action_plans',
            array(
                'action_plans' => $action_plans,
                'audit_plans' => $audit_plans,
                'acrs' => $acrs,
                'users' => $users,
            )
        );
    }
    public function new_action_plan(Request $request)
    {
        $file_name = null;
        if($request->hasfile('file'))
        {
            $attachment = $request->file('file');
            $name = time() . '_' . $attachment->getClientOriginalName();
            $attachment->move(public_path() . '/action_plan_attachments/', $name);
            $file_name = '/action_plan_attachments/' . $name;
        }

        foreach($request->auditee as $auditee)
        {
            $user = User::findOrfail($auditee);
            $action_plan = new ActionPlan;
            $action_plan->audit_plan_id = $request->audit_plan;
            $action_plan->audit_plan_observation_id = $request->acr;
            $action_plan->action_plan = $request->action_plan;
            $action_plan->findings = $request->findings;
            $action_plan->status = $request->status;
            $action_plan->department_id = $user->department_id;
            
          
                if($file_name)
                {
                    $action_plan->attachment = $file_name;
                }
            

            
            if($request->status == "Closed")
            {
                $action_plan->iad_status = "Closed";
            }
            $action_plan->user_id = $auditee;
            if($request->type == "Correction or Immediate Action")
            {
                $action_plan->immediate = 1;
            }
            $action_plan->target_date = $request->target_date;
            $action_plan->auditor = $request->auditor;
            $action_plan->save();
        }
        
        Alert::success('Successfully Created')->persistent('Dismiss');
        return back();
    }
    public function upload_proof_close(Request $request,$id)
    {
            $action_plan = ActionPlan::findOrfail($id);
            $attachment = $request->file('file');
            $name = time() . '_' . $attachment->getClientOriginalName();
            $attachment->move(public_path() . '/action_plan_attachments/', $name);
            $file_name = '/action_plan_attachments/' . $name;
            
            $action_plan->attachment = $file_name;
            $action_plan->save();
            Alert::success('Successfully Uploaded.')->persistent('Dismiss');
            return back();
        
    }
    public function edit_action_plan (Request $request,$id)
    {
        $action_plan = ActionPlan::findOrfail($id);
        $action_plan->action_plan = $request->action_plan;
        $action_plan->save();

        Alert::success('Successfully Updated')->persistent('Dismiss');
        return back();
    }
    public function upload_proof(Request $request,$id)
    {
        $action_plan = ActionPlan::findOrfail($id);
        $attachment = $request->file('file');
        $name = time() . '_' . $attachment->getClientOriginalName();
        $attachment->move(public_path() . '/action_plan_attachments/', $name);
        $file_name = '/action_plan_attachments/' . $name;
        $action_plan->attachment = $file_name;
        $action_plan->iad_status = null;
        $action_plan->date_completed = $request->date_completed;
        $action_plan->save();

        $history = new ActionPlanRemark;
        $history->user_id = auth()->user()->id;
        $history->action_plan_id = $id;
        $history->action = "Upload Proof";
        $history->remarks = "Upload Proof by ".auth()->user()->name." Remarks : ".$request->remarks;
        $history->save();

        $observation = AuditPlanObservation::where('id',$action_plan->audit_plan_observation_id)->first();
        $user = User::findOrfail($observation->created_by);
        $user->notify(new SubmitProof($observation));

        Alert::success('Successfully Uploaded')->persistent('Dismiss');
        return back();

    }
    public function change_target_date(Request $request,$id)
    {
        

        $action_plan = ActionPlan::findOrfail($id);

        $history = new ActionPlanRemark;
        $history->user_id = auth()->user()->id;
        $history->action_plan_id = $id;
        $history->action = "Change Target Date";
        $history->remarks = "Change Target Date from ". $action_plan->target_date." to ".$request->target_date;
        $history->save();

        $action_plan->target_date = $request->target_date;
        $action_plan->save();

        $observation = AuditPlanObservation::where('id',$action_plan->audit_plan_observation_id)->first();
        $user = User::findOrfail($action_plan->user_id);
        if($observation == null)
        {
            $observation = [];
        }
        $user->notify(new ChangeTargetDate($observation,$history->remarks));

        Alert::success('Successfully Change')->persistent('Dismiss');
        return back();

    }

    public function return_action_plan(Request $request,$id)
    {
        $action_plan = ActionPlan::findOrfail($id);
        $action_plan->iad_status = "Returned";
        $action_plan->status = "Verified";
        $action_plan->save();

        $history = new ActionPlanRemark;
        $history->user_id = auth()->user()->id;
        $history->action_plan_id = $id;
        $history->action = "Return Action Plan";
        $history->remarks = $request->remarks;
        $history->save();

        $observation = AuditPlanObservation::where('id',$action_plan->audit_plan_observation_id)->first();
        $user = User::findOrfail($observation->user_id);
        $user->notify(new ReturnActionPlan($observation,$history->remarks));
        Alert::success('Successfully Returned')->persistent('Dismiss');
        return back();
    }

    public function close_action_plan(Request $request,$id)
    {
        $action_plan = ActionPlan::findOrfail($id);
        $action_plan->iad_status = "Closed";
        $action_plan->status = "Closed";
        $action_plan->date_completed = $request->date_completed;
        $action_plan->save();

        $action_plans = ActionPlan::where('audit_plan_observation_id',$action_plan->audit_plan_observation_id)->where('status','!=','Closed')->count();

        if($action_plans == 0)
        {
            $observation = AuditPlanObservation::where('id',$action_plan->audit_plan_observation_id)->first();
            $observation->status = "Closed";
            $observation->save();

        }
        

        $history = new ActionPlanRemark;
        $history->user_id = auth()->user()->id;
        $history->action_plan_id = $id;
        $history->action = "Closed Action Plan";
        $history->remarks = $request->remarks;
        $history->save();  
        $observation = AuditPlanObservation::where('id',$action_plan->audit_plan_observation_id)->first();
        $user = User::findOrfail($observation->user_id);
        $user->notify(new CloseActionPlan($observation,$history->remarks));
        $usera = User::findOrfail($observation->created_by);
        $usera->notify(new CloseActionPlan($observation,$history->remarks));
        $users = User::where('role','IAD Approver')->where('status',null)->get();
        foreach($users as $userd)
        {
            $userd->notify(new CloseActionPlan($observation,$history->remarks));
        }

        Alert::success('Successfully Closed')->persistent('Dismiss');
        return back();
    }

    public function close_action_plans()
    {
        if(auth()->user()->role == "Auditee")

        {
            $action_plans = ActionPlan::where('user_id',auth()->user()->id)->where('status','Closed')->get();

        }
        else
        {
            $action_plans = ActionPlan::where('status','Closed')->get();
        }
        return view('closed_action_plans',
            array(
                'action_plans' => $action_plans,
            )
        );
    }
}
