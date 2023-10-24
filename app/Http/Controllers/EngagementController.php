<?php

namespace App\Http\Controllers;
use App\Engagement;
use App\AuditPlanObservation;
use App\AuditPlan;
use App\SummaryReport;
use App\Department;
use App\Explanation;
use App\ActionPlanRemark;
use App\ActionPlan;
use App\ActionPlanInvolve;
use App\ExplanationHistory;
use App\User;
use App\AuditPlanObservationHistory;
use App\Notifications\ACRApproved;
use Illuminate\Http\Request;
use PDF;
use RealRashid\SweetAlert\Facades\Alert;

class EngagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $audits = AuditPlan::where('code','!=',null)->orderBy('audit_to','asc')->get();
        return view('engagements',
        array(
            'audits' => $audits,
        )
    
        );
    }
    public function acr(Request $request)
    {
        //
        
        $reports = AuditPlanObservation::get();
        return view('acr',
        array(
            'reports' => $reports,
        )
    
        );
    }
    public function report(Request $request)
    {
        $audits = AuditPlan::where('code','!=',null)->orderBy('audit_to','asc')->get();
        $previous_audits = SummaryReport::where('date_needed',date("Y-m-01", strtotime("-1 months")))->get();
        $pdf = PDF::loadView('summary', array(
            'audits' => $audits,
            'previous_audits' => $previous_audits,
        ))->setPaper('legal', 'landscape');

        
        return $pdf->stream('initial_report');
    }
    public function report_each(Request $request)
    {
        $audits = AuditPlan::where('code','!=',null)->orderBy('audit_to','asc')->get();
        
        $previous_audits = SummaryReport::where('date_needed',date("Y-m-01", strtotime("-1 months")))->get();
        $pdf = PDF::loadView('summary_each', array(
            'audits' => $audits,
            'previous_audits' => $previous_audits,
        ))->setPaper('legal', 'landscape');

        
        return $pdf->stream('initial_report');
    }

    public function forExplanation()
    {
        $departments = Department::where('id','!=',auth()->user()->department_id)->get();
        $observations = AuditPlanObservation::doesntHave('explanation')->where('status','On-going')->get();
        return view('for_explanation',
            array(
                'observations' => $observations,
                'departments' => $departments,
            )
        );
    }

    public function view($id)
    {
        $finding = AuditPlanObservation::findOrfail($id);
        return view('view_observation',
            array(
                'finding' => $finding,
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        $audit_plan = AuditPlanObservation::findOrfail($id);
        $new_explanation = new Explanation;
        $new_explanation->audit_plan_observation_id = $request->id;
        $new_explanation->explanation = $request->explanation;
        $new_explanation->cause = $request->cause;
        $new_explanation->user_id = auth()->user()->id;
        $new_explanation->status = "For Approval";
        $new_explanation->department_id = auth()->user()->department_id;
        $new_explanation->save();


        $new_action_plan = new ActionPlan;
        $new_action_plan->audit_plan_observation_id = $id;
        $new_action_plan->audit_plan_id = $audit_plan->audit_plan_id;
        $new_action_plan->action_plan = $request->immediate_action;
        $new_action_plan->date_completed = $request->date_completed;
        $new_action_plan->target_date = $request->date_completed;
        $new_action_plan->user_id = auth()->user()->id;
        $new_action_plan->department_id = auth()->user()->department_id;
        $new_action_plan->status = "For Approval";
        $new_action_plan->immediate = 1;

        if($request->has('supporting_documents_immediate_action'))
        {
            $attachment = $request->file('supporting_documents_immediate_action');
            $name = time() . '_' . $attachment->getClientOriginalName();
            $attachment->move(public_path() . '/action_plan_attachments/', $name);
            $file_name = '/action_plan_attachments/' . $name;
            $new_action_plan->attachment = $file_name;
        }

        $new_action_plan->save();

        if($request->other_parties_immediate_action != null)
        {
            foreach($request->other_parties_immediate_action as $party)
            {
                $involve = new ActionPlanInvolve;
                $involve->action_plan_id = $new_action_plan->id;
                $involve->department_id =$party;
                $involve->save();
            }
        }

        $new_action_plan_second = new ActionPlan;
        $new_action_plan_second->audit_plan_observation_id = $id;
        $new_action_plan_second->action_plan = $request->action_plan;
        $new_action_plan_second->audit_plan_id = $audit_plan->audit_plan_id;
        $new_action_plan_second->target_date = $request->date_complete;
        $new_action_plan_second->user_id = auth()->user()->id;
        $new_action_plan_second->department_id = auth()->user()->department_id;
        $new_action_plan_second->status = "For Approval";

        if($request->has('supporting_documents'))
        {
            $attachment = $request->file('supporting_documents');
            $name = time() . '_' . $attachment->getClientOriginalName();
            $attachment->move(public_path() . '/action_plan_attachments/', $name);
            $file_name = '/action_plan_attachments/' . $name;
            $new_action_plan_second->attachment = $file_name;
        }

        $new_action_plan_second->save();

        if($request->other_parties_action_plan != null)
        {
            foreach($request->other_parties_action_plan as $party)
            {
                $involve = new ActionPlanInvolve;
                $involve->action_plan_id = $new_action_plan_second->id;
                $involve->department_id =$party;
                $involve->save();
            }
        }

        Alert::success('Successfully Submitted')->persistent('Dismiss');
        return back();


    //
    }

    public function verified(Request $request,$id)
    {
        $audit_plan_observation = AuditPlanObservation::findOrfail($id);
        if($request->type == "Findings")
        {
            $audit_plan_observation->findings = 1;
        }
        else
        {
            $audit_plan_observation->findings = null;
        }
        $audit_plan_observation->save();
        $new_explanation = Explanation::where('audit_plan_observation_id',$id)->first();
        $new_explanation->status = "Verified";
        $new_explanation->verified_by = auth()->user()->id;
        $new_explanation->save();

     
        foreach($request->immediate_action as $key => $action_plan)
        {
            $new_action_plan = ActionPlan::findOrfail($key);
            $new_action_plan->action_plan = $action_plan;
            $new_action_plan->date_completed = $request->date_completed[$key];
            $new_action_plan->target_date = $request->date_completed[$key];
            $new_action_plan->verified_by = auth()->user()->id;
            $new_action_plan->status = "Verified";
            
            $new_action_plan->save();
            ActionPlanInvolve::where('action_plan_id',$key)->delete();
            if($request->other_parties_immediate_action != null)
            {
                if(array_key_exists($key,$request->other_parties_immediate_action))
                {
                    foreach($request->other_parties_immediate_action[$key] as $party)
                    {
                        $involve = new ActionPlanInvolve;
                        $involve->action_plan_id = $new_action_plan->id;
                        $involve->department_id =$party;
                        $involve->save();
                    }
                }
                
            }

            $history = new ActionPlanRemark;
            $history->action_plan_id = $key;
            $history->action = $request->action;
            $history->remarks = $request->remarks;
            $history->user_id = auth()->user()->id;
            $history->save();
          
        }
        foreach($request->action_plan as $key => $action_plan)
        {
            $new_action_plan_second = ActionPlan::findOrfail($key);
            $new_action_plan_second->action_plan = $action_plan;
            $new_action_plan_second->target_date = $request->date_complete[$key];
      
            $new_action_plan_second->verified_by = auth()->user()->id;
            $new_action_plan_second->status = "Verified";

            $new_action_plan_second->save();
            ActionPlanInvolve::where('action_plan_id',$key)->delete();
            if($request->other_parties_action_plan != null)
            {
                if(array_key_exists($key,$request->other_parties_action_plan))
                {
                    foreach($request->other_parties_action_plan[$key] as $party)
                    {
                        $involve = new ActionPlanInvolve;
                        $involve->action_plan_id = $new_action_plan->id;
                        $involve->department_id =$party;
                        $involve->save();
                    }
                }
                
            }

            $history = new ActionPlanRemark;
            $history->action_plan_id = $key;
            $history->action = $request->action;
            $history->remarks = $request->remarks;
            $history->user_id = auth()->user()->id;
            $history->save();
          
        }
        $history = new ExplanationHistory;
        $history->explanation_id = $new_explanation->id;
        $history->action = $request->action;
        $history->remarks = $request->remarks;
        $history->user_id = auth()->user()->id;
        $history->save();

        Alert::success('Successfully Verified')->persistent('Dismiss');
        return back();

    }
    public function reviewed(Request $request,$id)
    {
        $new_explanation = Explanation::where('audit_plan_observation_id',$id)->first();
        $new_explanation->explanation = $request->explanation;
        $new_explanation->cause = $request->cause;
        $new_explanation->status = "For Verification";
        $new_explanation->reviewed_by = auth()->user()->id;
        $new_explanation->save();

     
        foreach($request->immediate_action as $key => $action_plan)
        {
            $new_action_plan = ActionPlan::findOrfail($key);
            $new_action_plan->action_plan = $action_plan;
            $new_action_plan->date_completed = $request->date_completed[$key];
            $new_action_plan->target_date = $request->date_completed[$key];
            $new_action_plan->reviewed_by = auth()->user()->id;
            $new_action_plan->status = "For Verification";
            
            if($request->has('supporting_documents_immediate_action'))
            {
                if(array_key_exists($key,$request->file('supporting_documents_immediate_action')))
                {
                    $attachment = $request->file('supporting_documents_immediate_action')[$key];
                    $name = time() . '_' . $attachment->getClientOriginalName();
                    $attachment->move(public_path() . '/action_plan_attachments/', $name);
                    $file_name = '/action_plan_attachments/' . $name;
                    $new_action_plan->attachment = $file_name;
                }
               
            }
            $new_action_plan->save();
            ActionPlanInvolve::where('action_plan_id',$key)->delete();
            if($request->other_parties_immediate_action != null)
            {
                if(array_key_exists($key,$request->other_parties_immediate_action))
                {
                    foreach($request->other_parties_immediate_action[$key] as $party)
                    {
                        $involve = new ActionPlanInvolve;
                        $involve->action_plan_id = $new_action_plan->id;
                        $involve->department_id =$party;
                        $involve->save();
                    }
                }
                
            }

            $history = new ActionPlanRemark;
            $history->action_plan_id = $key;
            $history->action = $request->action;
            $history->remarks = $request->remarks;
            $history->user_id = auth()->user()->id;
            $history->save();
          
        }
        foreach($request->action_plan as $key => $action_plan)
        {
            $new_action_plan_second = ActionPlan::findOrfail($key);
            $new_action_plan_second->action_plan = $action_plan;
            $new_action_plan_second->target_date = $request->date_complete[$key];
            $new_action_plan_second->reviewed_by = auth()->user()->id;
            $new_action_plan_second->status = "For Verification";
            
            if($request->has('supporting_documents'))
            {
                if(array_key_exists($key,$request->file('supporting_documents')))
                {
                    $attachment = $request->file('supporting_documents')[$key];
                    $name = time() . '_' . $attachment->getClientOriginalName();
                    $attachment->move(public_path() . '/action_plan_attachments/', $name);
                    $file_name = '/action_plan_attachments/' . $name;
                    $new_action_plan_second->attachment = $file_name;
                }
               
            }

            $new_action_plan_second->save();
            ActionPlanInvolve::where('action_plan_id',$key)->delete();
            if($request->other_parties_action_plan != null)
            {
                if(array_key_exists($key,$request->other_parties_action_plan))
                {
                    foreach($request->other_parties_action_plan[$key] as $party)
                    {
                        $involve = new ActionPlanInvolve;
                        $involve->action_plan_id = $new_action_plan->id;
                        $involve->department_id =$party;
                        $involve->save();
                    }
                }
                
            }

            $history = new ActionPlanRemark;
            $history->action_plan_id = $key;
            $history->action = $request->action;
            $history->remarks = $request->remarks;
            $history->user_id = auth()->user()->id;
            $history->save();
          
        }
        $history = new ExplanationHistory;
        $history->explanation_id = $new_explanation->id;
        $history->action = $request->action;
        $history->remarks = $request->remarks;
        $history->user_id = auth()->user()->id;
        $history->save();

        Alert::success('Successfully Reviewed')->persistent('Dismiss');
        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        $engagement = Engagement::findOrfail($id);

        return view('view_engagement',
        array(
            'engagement' => $engagement,
        )
    
        );

    }

    public function forReview()
    {
        
        $departments = Department::where('id','!=',auth()->user()->department_id)->get();
        $observations = AuditPlanObservation::whereHas('explanation',function($q){
            $q->where('status', 'For Approval');
        })->where('status','On-going')->get();
        return view('for_review',
            array(
                'observations' => $observations,
                'departments' => $departments,
            )
        );
    }
    public function forVerication()
    {
        
        $departments = Department::where('id','!=',auth()->user()->department_id)->get();
        $observations = AuditPlanObservation::whereHas('explanation',function($q){
            $q->where('status', 'For Verification');
        })->where('status','On-going')->get();
        return view('for_verification',
            array(
                'observations' => $observations,
                'departments' => $departments,
            )
        );
    }
    public function forapproval()
    {
        $observations = AuditPlanObservation::where('status','For Approval')->get();
        return view('for_approval_iad',
        array(
        'observations' => $observations,
        ));
    }
    public function action(Request $request, $id)
    {
        $observation = AuditPlanObservation::findOrfail($id);
        if($request->action == "Approved")
        {
            $user = User::findOrfail($observation->user_id);
            $user->notify(new ACRApproved($observation));
            $observation->status = "On-going";
        }
        else
        {
            $observation->status = "Declined";
        }
        $observation->save();

        $newHistory = new AuditPlanObservationHistory;
        $newHistory->audit_plan_observation_id = $id;
        $newHistory->action = "IAD ".$request->action;
        $newHistory->user_id = auth()->user()->id;
        $newHistory->remarks = $request->remarks;
        $newHistory->save();
        
        
        
        Alert::success('Successfully Submitted')->persistent('Dismiss');
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function authority($id)
    {
        $engagement = Engagement::findOrfail($id);
        $pdf = PDF::loadView('authority', array(
            'engagement' => $engagement,
        ))->set_option('isFontSubsettingEnabled', true);
        return $pdf->stream('authority_to_audit');
    }
    public function initialReport($id)
    {
        $engagement = Engagement::findOrfail($id);
        $pdf = PDF::loadView('initial_report', array(
            'engagement' => $engagement,
        ));
        return $pdf->stream('initial_report');
    }
}
