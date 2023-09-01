<?php

namespace App\Http\Controllers;
use App\Engagement;
use App\AuditPlanObservation;
use Illuminate\Http\Request;
use PDF;

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
        $findings = AuditPlanObservation::get();
        return view('observations',
        array(
            'observations' => $findings,
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
        ));
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
