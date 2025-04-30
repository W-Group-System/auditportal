<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\ActionPlan;
use App\Notifications\ActionPlanNotif;

class send_email extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:actionplan_report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
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
}
