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
            $q->whereDate('created_at','<=',$date);
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
    $matrices = Matrix::all()->keyBy('name');
    $departments = Department::with(['risk' => function($query) {
        $query->select('department_id', 'overall_risk', 'findings');
    }])->get();

    $departmentResults = [
        ['x'], // Department codes
        ['Findings'], // Findings count
        ['Avg. Risk'], // Average Risk
    ];

    foreach ($departments as $department) {
        $observationCount = 0;
        $totalRisk = 0;

        $departmentResults[0][] = $department->code; // Add department code

        foreach ($department->risk as $audit_plan) {
            if ($audit_plan->findings) {
                $observationCount++;
                $riskRating = $matrices->get($audit_plan->overall_risk)->id ?? 0;
                $totalRisk += $riskRating;
            }
        }

        $departmentResults[1][] = $observationCount; // Add findings count
        $averageRisk = $observationCount > 0 ? round($totalRisk / $observationCount, 2) : 0.00;
        $departmentResults[2][] = $averageRisk; // Add average risk
    }

    return $departmentResults;
    }
}
