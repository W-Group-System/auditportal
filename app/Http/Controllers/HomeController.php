<?php

namespace App\Http\Controllers;
use App\Department;
use App\AuditPlan;
use App\ActionPlan;
use App\Matrix;
use App\ActionPlanRemark;
use App\AuditPlanObservation;
use App\DepartmentGroup;
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
    public function index(Request $request)
    {
        $date = $request->generate_date;
        if($date == null)
        {
            $date = date('Y-m-d');
        }
        $audits = AuditPlan::where('code','!=',null)->orderBy('audit_to','asc')->get();
        $companies = Department::where('company','!=',null)->groupBy('company')->pluck('company');
        $groups = DepartmentGroup::with('dep')->groupBy('name','company')->get(['name','company']);
        $remarks = ActionPlanRemark::orderBy('id','desc')->get()->take(1000);
        $action_plans = ActionPlan::where('status','Verified')->where('action_plan','!=',"N/A")->get();
        $reports = AuditPlanObservation::get();
        $results = $this->get_risks();
        $departments = Department::with(['action_plans' => function($q) use ($date) {
            $q->whereDate('created_at','<=',$date)->where('status','Verified');
        }])->where('status',null)->get();
        return view('home',
        array(
            'departmentResults' => $results,
            'departments' => $departments,
            'audits' => $audits,
            'reports' => $reports,
            'action_plans' => $action_plans,
            'remarks' => $remarks,
            'groups' => $groups,
            'companies' => $companies,
            'generate_date' => $date,
        ));
    }

    public function get_risks()
    {
        $matrices = Matrix::get();
        $departments = Department::with(['audit_plans' => function($query) {
            $query->select('department_id','audit_plan_id');
            $query->groupBy('department_id','audit_plan_id');
        }])->get();
        $deptResult = ['x'];
        $deptFindings = ['Findings'];
        $deptRisk = ['Avg. Risk'];
        $departmentResults = [];
        $a = 0;
        foreach($departments as $department)
        {
            $observation = 0;
            $risk = 0;
            
            array_push($deptResult,$department->code);
            foreach($department->risk as $audit_plan)
            {
                if($audit_plan->findings != null)
                {
                    $a = 1;
                }
                $observation = $a + $observation;
                if($observation != 0)
                {
                    if($audit_plan->findings != null)
                    {
                        $risk_rating = ($matrices->where('name',$audit_plan->overall_risk)->first())->id;
                        $risk = $risk_rating + $risk;
                    }
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
