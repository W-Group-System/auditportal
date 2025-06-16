<?php

namespace App\Http\Controllers;
use App\ActionPlan;
use App\AuditPlan;
use App\User;
use App\Department;
use App\ActionPlanRemark;
use App\ActionPlanAttachments;
use App\AuditPlanObservation;
use App\Notifications\SubmitProof;
use App\Notifications\ActionPlanNotif;
use App\Notifications\ChangeTargetDate;
use App\Notifications\ReturnActionPlan;
use App\Notifications\CloseActionPlan;
use Illuminate\Http\Request;

use RealRashid\SweetAlert\Facades\Alert;

use PDF;
class ActionPlanController extends Controller
{
    //
    public function engagementReports (Request $request)
    {
        $date = $request->generate_date;
        if($date == null)
        {
            $date = date('Y-m-d');
        }
        $audit_plans = AuditPlan::with(['action_plans' => function($q) use ($date) {
            $q->whereDate('created_at','<=',$date);
        }])->get();
        return view('engagement_reports',
            array(
                'audit_plans' => $audit_plans,
                'generate_date' =>$date,
            )
        );
    }
    public function index(Request $request)
    {
        $default = 10;
        $limit = $request->limit;
        if($limit)
        {
            $default = $limit;
        }
        if($limit == "ALL")
        {
            $default = 10000;
        }
        $code = $request->code;
        $done_code = $request->code;
        $status = $request->status;
        $searchTerm = $request->search; 
        $dept = $request->department;
        $status_report = $request->status_report;
        $generated_date = $request->generated_date;
    
        // Base query for action plans
        $query = ActionPlan::with(['audit_plan', 'user', 'observation.created_by_user', 'files'])
            ->where('status', 'Verified')
            ->where('action_plan', '!=', 'N/A');
        
        // User role checks
        if (auth()->user()->role == "Auditee" || auth()->user()->role == "Department Head") {
            $departmentId = auth()->user()->department_id;
            $departmentIds = auth()->user()->departments->pluck('department_id');
    
            $query->where(function ($subQuery) use ($departmentId, $departmentIds) {
                $subQuery->where('department_id', $departmentId)
                    ->orWhereIn('department_id', $departmentIds);
            });
        }
        
        if ($status == "For IAD Checking") {
            $query->whereNull('iad_status')
                  ->where(function ($subQuery) {
                      $subQuery->whereNotNull('attachment') // Check old attachment column
                               ->orWhereHas('files'); // Check if related files exist
                  });
        } elseif ($status == "Open") {
            $query->where(function ($subQuery) {
                $subQuery->where('iad_status', 'Returned')
                         ->orWhere(function ($q) {
                             $q->whereNull('attachment') // Check old attachment column
                               ->whereDoesntHave('files'); // Ensure no related files exist
                         });
            });
        }

        // if ($status == "For IAD Checking") {
        //     $query->whereNull('iad_status')->whereNotNull('attachment');
        // } elseif ($status == "Open") {
        //     $query->where(function ($subQuery) {
        //         $subQuery->where('iad_status', 'Returned')
        //             ->orWhereNull('attachment');
        //     });
        // }
        // Additional filters based on code and status
        if ($code) {
            $query->where('audit_plan_id', $code);
        }
    
        // Apply status filter if applicable
        if ($status === "All") {
            // No additional filters needed for "All"
        }
        if ($searchTerm) {
            $query->where(function($q) use ($searchTerm) {
                $q->whereHas('audit_plan', function($q) use ($searchTerm) {
                    $q->where('code', 'like', "%{$searchTerm}%")
                      ->orWhere('engagement_title', 'like', "%{$searchTerm}%");
                })
                ->orWhere('action_plan', 'like', "%{$searchTerm}%")
                ->orWhereHas('auditor_data', function($q) use ($searchTerm) {
                    $q->where('name', 'like', "%{$searchTerm}%"); // Auditor's name search
                })
                ->orWhereHas('observation', function($q) use ($searchTerm) {
                    $q->whereHas('created_by_user', function($q) use ($searchTerm) {
                        $q->where('name', 'like', "%{$searchTerm}%"); // Created by user name search
                    });
                })
                ->orWhereHas('user', function($q) use ($searchTerm) {
                    $q->where('name', 'like', "%{$searchTerm}%"); // Action plan user search
                });
            });
        }
        // Get action plans with pagination
     
        if($dept)
        {
            $query = ActionPlan::with(['audit_plan', 'user', 'observation.created_by_user'])
            ->where('status', 'Verified')
            ->where('action_plan', '!=', 'N/A')
            ->where('department_id',$dept);
        }
        if($status_report == "Closed")
        {
            $query = ActionPlan::with(['audit_plan', 'user', 'observation.created_by_user'])
            ->where('action_plan','!=',"N/A")->where('status','Closed')
            ->where('action_plan','!=','N/A')
            ->where('department_id',$dept);
        }
        else if($status_report == "Delayed")
        {
            $query = ActionPlan::with(['audit_plan', 'user', 'observation.created_by_user'])
            ->where('status','Verified')
            // ->where('target_date','<',date('Y-m-d'))
            ->where('action_plan','!=','N/A')
            ->where('department_id',$dept);

            if ($generated_date) {
                $query->where('target_date', '<=', $generated_date);
            }
        }
        // else if($status_report == "Open") 
        // {
        //     $query->where('status', 'Verified')
        //         ->where('action_plan', '!=', 'N/A')
        //         ->where('department_id', $dept);

        //     if ($generated_date) {
        //         $query->where('target_date', '>=', $generated_date);
        //     }
        // }
        else if($status_report == "Open")
        {
            $query = ActionPlan::with(['audit_plan', 'user', 'observation.created_by_user'])
            ->where('action_plan','!=',"N/A")->where('status','Verified')
            ->where('department_id',$dept);
            if ($generated_date) {
                $query->where('target_date', '>=', $generated_date);
            }
        }
        if($dept)
        {
           
            $action_plans = $query->paginate($default);
            
        }
        else
        {
           
            $action_plans = $query->paginate($default);
            
        }
        // Fetch additional data
        $audit_plans = AuditPlan::orderBy('code', 'desc')->get();
        $acrs = AuditPlanObservation::all();
        $users = User::whereNull('status')->get();
    
        return view('action_plans', compact('action_plans', 'audit_plans', 'acrs', 'users', 'done_code', 'status','searchTerm','dept','default','status_report'));
    }

    public function email(Request $request)
    {
        $users = User::where('role','Auditee')->where('status',null)->get();
        // dd($users);
        foreach($users as $user)
        {
            $table = "<table style='margin-bottom:10px;' width='100%' border='1' cellspacing=0><tr><th>Agreed Action Plan #</th><th>Agreed Action Plan</th><th>Target Date</th></tr>";
            $action_plans = ActionPlan::where('department_id',$user->department_id)->where('action_plan','!=',"N/A")->where('status','Verified')->get();
            foreach($action_plans as $key => $action_plan)
            {
                if($action_plan->target_date < date('Y-m-d'))
                {
                    $status = " style='background-color:Tomato;color:white;'";
                }
                else
                {
                    $status = "";
                }
                $table .= "<tr ".$status."><td style='width:30%;'>".($key+1)."</td><td style='width:40%;'>".$action_plan->action_plan."</td><td style='width:30%;'>".date('Y-m-d',strtotime($action_plan->target_date))."</td></tr>";
            }
            $table .= "</table>";
            if($action_plans->count() > 0)
            {
                $user->notify(new ActionPlanNotif($table));
            }
    
        }
      
       return "success";
    }
    // public function new_action_plan(Request $request)
    // {
    //     $file_name = null;
    //     if($request->hasfile('file'))
    //     {
    //         $attachment = $request->file('file');
    //         $name = time() . '_' . $attachment->getClientOriginalName();
    //         $attachment->move(public_path() . '/action_plan_attachments/', $name);
    //         $file_name = '/action_plan_attachments/' . $name;
    //     }
        

    //     foreach($request->auditee as $auditee)
    //     {
    //         $user = User::findOrfail($auditee);
    //         $action_plan = new ActionPlan;
    //         $action_plan->audit_plan_id = $request->audit_plan;
    //         $action_plan->audit_plan_observation_id = $request->acr;
    //         $action_plan->action_plan = $request->action_plan;
    //         $action_plan->findings = $request->findings;
    //         $action_plan->status = $request->status;
    //         $action_plan->department_id = $user->department_id;
            
            
    //         if($file_name)
    //         {
    //             $action_plan->attachment = $file_name;
    //         }
            
            
            
    //         if($request->status == "Closed")
    //         {
    //             $action_plan->iad_status = "Closed";
    //         }
    //         $action_plan->user_id = $auditee;
    //         if($request->type == "Correction or Immediate Action")
    //         {
    //             $action_plan->immediate = 1;
    //         }
    //         $action_plan->target_date = $request->target_date;
    //         $action_plan->auditor = $request->auditor;
    //         $ac = ActionPlan::where('action_plan',$request->action_plan)->where('user_id',$auditee)->first();
    //         if($ac == null)
    //         {
    //             $action_plan->save();
    //         }
          
    //     }
        
    //     Alert::success('Successfully Created')->persistent('Dismiss');
    //     return back();
    // }

    public function new_action_plan(Request $request)
    {
        try {
            $files = $request->hasFile('file') ? $request->file('file') : [];

            // Loop over each auditee to create an action plan
            foreach ($request->auditee as $auditee) {
                $user = User::findOrFail($auditee);
                $action_plan = new ActionPlan;
                $action_plan->audit_plan_id = $request->audit_plan;
                $action_plan->audit_plan_observation_id = $request->acr;
                $action_plan->action_plan = $request->action_plan;
                $action_plan->findings = $request->findings;
                $action_plan->status = $request->status;
                $action_plan->department_id = $user->department_id;
                
                // Optionally assign a main attachment if needed (e.g., first file)
                if (!empty($files)) {
                    $firstFile = $files[0];
                    if ($firstFile->isValid()) {
                        $name = time() . '_' . $firstFile->getClientOriginalName();
                        $firstFile->move(public_path('action_plan_attachments'), $name);
                        $action_plan->attachment = '/action_plan_attachments/' . $name;
                    }
                }
                
                if ($request->status == "Closed") {
                    $action_plan->iad_status = "Closed";
                }
                $action_plan->user_id = $auditee;
                if ($request->type == "Correction or Immediate Action") {
                    $action_plan->immediate = 1;
                }
                $action_plan->target_date = $request->target_date;
                $action_plan->auditor = $request->auditor;
                
                // Check for duplicate action plan for this auditee
                $ac = ActionPlan::where('action_plan', $request->action_plan)
                    ->where('user_id', $auditee)
                    ->first();
                if ($ac == null) {
                    $action_plan->save();

                    // Now, attach all uploaded files for this action plan
                    if (!empty($files)) {
                        foreach ($files as $file) {
                            if ($file->isValid()) {
                                $actionFile = new ActionPlanAttachments();
                                $actionFile->action_plan_id = $action_plan->id;

                                $name = time() . '_' . $file->getClientOriginalName();
                                // Store file in the 'action_plan_attachments' folder in public
                                $file->move(public_path('action_plan_attachments'), $name);
                                $actionFile->attachment = '/action_plan_attachments/' . $name;
                                $actionFile->save();
                            }
                        }
                    }
                }
            }
            
            Alert::success('Successfully Created')->persistent('Dismiss');
            return back();
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
        // Get the uploaded files (if any)
        
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
    // public function edit_action_plan (Request $request,$id)
    // {
    //     $user = User::findOrFail($id);
    //     $action_plan = ActionPlan::findOrfail($id);
    //     $action_plan->action_plan = $request->action_plan;
    //     $action_plan->user_id = $request->user;
    //     $action_plan->department_id = $user->department_id;
    //     $action_plan->save();

    //     Alert::success('Successfully Updated')->persistent('Dismiss');
    //     return back();
    // }

    public function edit_action_plan(Request $request, $id)
    {
        // Fetch the action plan by ID
        $action_plan = ActionPlan::findOrFail($id);

        // Fetch the selected user
        $user = User::findOrFail($request->user);

        // Update action plan details
        $action_plan->action_plan = $request->action_plan;
        $action_plan->user_id = $user->id;
        $action_plan->department_id = $user->department_id; // Assign department ID from user
        $action_plan->save();

        Alert::success('Successfully Updated')->persistent('Dismiss');
        return back();
    }
    
    public function upload_proof(Request $request,$id)
    {
        // dd($request->all());
        $action_plan = ActionPlan::with('files')->findOrfail($id);
        // $attachment = $request->file('file');
        // $name = time() . '_' . $attachment->getClientOriginalName();
        // $attachment->move(public_path() . '/action_plan_attachments/', $name);
        // $file_name = '/action_plan_attachments/' . $name;
        // $action_plan->attachment = $file_name;
        $action_plan->iad_status = null;
        $action_plan->date_completed = $request->date_completed;
        $action_plan->save();

        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $file) {
                if ($file->isValid()) {
                    $actionFile = new ActionPlanAttachments();
                    $actionFile->action_plan_id = $action_plan->id;

                    $name = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path() . '/action_plan_attachments/', $name);
                    $file_name = '/action_plan_attachments/' . $name;
                    
                    $actionFile->attachment = $file_name;
                    $actionFile->save();
                }
            }
        }

        $history = new ActionPlanRemark;
        $history->user_id = auth()->user()->id;
        $history->action_plan_id = $id;
        $history->action = "Upload Proof";
        $history->remarks = "Upload Proof by ".auth()->user()->name." Remarks : ".$request->remarks;
        $history->save();

        $observation = "";
        if($action_plan->audit_plan_observation_id != null)
        {
            
            $observation = AuditPlanObservation::where('id',$action_plan->audit_plan_observation_id)->first();
            $user_id = $observation->created_by;
        }
        else
        {
            $user_id = $action_plan->auditor;
        }
        if($user_id != null)
        {

            $user = User::findOrfail($user_id);
            $user->notify(new SubmitProof($observation,$id));
        }

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
        $history->remarks = "Changed Target Date from ". $action_plan->target_date." to ".$request->target_date;
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
        
        $user = User::findOrfail($action_plan->user_id);
        $user->notify(new ReturnActionPlan($history->remarks,$id));
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
            if($observation)
            {
                $observation->status = "Closed";
                $observation->save();
            }
           

        }
        

        $history = new ActionPlanRemark;
        $history->user_id = auth()->user()->id;
        $history->action_plan_id = $id;
        $history->action = "Closed Action Plan";
        $history->remarks = $request->remarks;
        $history->save();  
        $observation = AuditPlanObservation::where('id',$action_plan->audit_plan_observation_id)->first();
        $user = User::findOrfail($action_plan->user_id);
        $user->notify(new CloseActionPlan($history->remarks));
        $users = User::where('role','IAD Approver')->where('status',null)->get();
        foreach($users as $userd)
        {
            $userd->notify(new CloseActionPlan($observation,$history->remarks));
        }

        Alert::success('Successfully Closed')->persistent('Dismiss');
        return back();
    }

    public function close_action_plans(Request $request)
    { 
        $action_plans = [];
        $codes = AuditPlan::get();
        $code = $request->code;
        
        if(auth()->user()->role == "Auditee")
        {
            if($request->code == "ALL")
            {

                // $action_plans = ActionPlan::where('user_id',auth()->user()->id)->where('status','Closed')->get();
                $action_plans = ActionPlan::where('department_id',auth()->user()->department_id)->where('status','Closed')->get();
            }
            else
            {
                
                // $action_plans = ActionPlan::where('user_id',auth()->user()->id)->where('audit_plan_id',$request->code)->where('status','Closed')->get();
                $action_plans = ActionPlan::where('department_id',auth()->user()->department_id)->where('audit_plan_id',$request->code)->where('status','Closed')->get();
            }

        }
        else
        {
            if($request->code == "ALL")
            {
            $action_plans = ActionPlan::where('status','Closed')->get();
            }
            else
            {
                $action_plans = ActionPlan::where('status','Closed')->where('audit_plan_id',$request->code)->get();
            }
        }
        
        return view('closed_action_plans',
            array(
                'action_plans' => $action_plans,
                'codes' => $codes,
                'done_code' => $code,
            )
        );
    }
}
