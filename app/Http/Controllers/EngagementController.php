<?php

namespace App\Http\Controllers;
use App\Engagement;
use App\AuditPlanObservation;
use App\AuditPlan;
use App\Department;
use App\AuditPlanObservationHistory;
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
    public function store(Request $request)
    {
        //
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
