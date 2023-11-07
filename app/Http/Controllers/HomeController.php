<?php

namespace App\Http\Controllers;
use App\Department;
use App\AuditPlan;
use App\ActionPlan;
use App\AuditPlanObservation;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $audits = AuditPlan::where('code','!=',null)->orderBy('audit_to','asc')->get();
        $action_plans = ActionPlan::where('status','Verified')->where('action_plan','!=',"N/A")->get();
        $reports = AuditPlanObservation::get();
        $results = $this->get_risks();
        $departments = Department::get();
        return view('home',
        array(
            'departmentResults' => $results,
            'departments' => $departments,
            'audits' => $audits,
            'reports' => $reports,
            'action_plans' => $action_plans,
        ));
    }

    public function get_risks()
    {
        $departments = Department::with(['audit_plans' => function($query) {
            $query->select('department_id','audit_plan_id');
            $query->groupBy('department_id','audit_plan_id');
        }])->get();
        $deptResult = ['x'];
        $deptFindings = ['Findings'];
        $deptRisk = ['Avg. Risk'];
        $departmentResults = [];
        foreach($departments as $department)
        {
            $observation = 0;
            $risk = 0;
            array_push($deptResult,$department->code);
            foreach($department->risk as $audit_plan)
            {
                
                $observation = count(($audit_plan)->where('findings','!=',null)) + $observation;
                if($observation != 0)
                {
                $risk = (($audit_plan)->where('findings','!=',null)->sum('overall_number')) + $risk;
                }
                else
                {
                    $risk = 0;
                }
            }
            array_push($deptFindings,$observation);
            if($observation != 0)
            {
            array_push($deptRisk,round($risk/$observation,2));
            }
            else
            {
                array_push($deptRisk,0.00);
            }
            
        }
        array_push($departmentResults,$deptResult);
        array_push($departmentResults,$deptFindings);
        array_push($departmentResults,$deptRisk);

        return $departmentResults;
    }
}
