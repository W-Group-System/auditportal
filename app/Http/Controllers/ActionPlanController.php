<?php

namespace App\Http\Controllers;
use App\ActionPlan;
use App\ActionPlanRemark;
use App\AuditPlanObservation;
use Illuminate\Http\Request;

use RealRashid\SweetAlert\Facades\Alert;

use PDF;
class ActionPlanController extends Controller
{
    //

    public function index()
    {
        $action_plans = ActionPlan::where('status','Verified')->get();
        return view('action_plans',
            array(
                'action_plans' => $action_plans,
            )
        );
    }
    public function upload_proof(Request $request,$id)
    {
        $action_plan = ActionPlan::findOrfail($id);
        $attachment = $request->file('file');
        $name = time() . '_' . $attachment->getClientOriginalName();
        $attachment->move(public_path() . '/action_plan_attachments/', $name);
        $file_name = '/action_plan_attachments/' . $name;
        $action_plan->attachment = $file_name;
        $action_plan->date_completed = $request->date_completed;
        $action_plan->save();

        $history = new ActionPlanRemark;
        $history->user_id = auth()->user()->id;
        $history->action_plan_id = $id;
        $history->action = "Upload Proof";
        $history->remarks = "Upload Proof by ".auth()->user()->name." Remarks : ".$request->remarks;
        $history->save();

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

        Alert::success('Successfully Change')->persistent('Dismiss');
        return back();

    }

    public function return_action_plan(Request $request,$id)
    {
        $action_plan = ActionPlan::findOrfail($id);
        $action_plan->iad_status = "Returned";
        $action_plan->save();

        $history = new ActionPlanRemark;
        $history->user_id = auth()->user()->id;
        $history->action_plan_id = $id;
        $history->action = "Return Action Plan";
        $history->remarks = $request->remarks;
        $history->save();

  

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

        Alert::success('Successfully Closed')->persistent('Dismiss');
        return back();
    }

    public function close_action_plans()
    {
        $action_plans = ActionPlan::where('status','Closed')->get();
        return view('closed_action_plans',
            array(
                'action_plans' => $action_plans,
            )
        );
    }
}
