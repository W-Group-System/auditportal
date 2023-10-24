<?php

namespace App\Console\Commands;
use App\SummaryReport;
use App\AuditPlan;
use Illuminate\Console\Command;

class getReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:get_reports';

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
        //
        info("START GET REPORTS");
        $audits = AuditPlan::where('code','!=',null)->orderBy('audit_to','asc')->get();

        foreach($audits as $audit)
        {
            $summary = SummaryReport::where('engagement_id',$audit->id)->where('date_needed',date('Y-m-01'))->first();
            if($summary == null)
            {
                $report = new SummaryReport;
            }
            else
            {
                $report = SummaryReport::findOrfail($summary->id);
            }
            $report->engagement_id = $audit->id;
            $report->date_needed = date('Y-m-01');
            $report->findings = count(($audit->observations)->where('findings','!=',null));
            $report->observations = count(($audit->observations)->where('findings',null));
            $report->closed = count(($audit->action_plans)->where('status','=','Closed'));
            $report->open_delayed = count(($audit->action_plans)->where('status','!=','Closed')->where('target_date','<',date('Y-m-d')));
            $report->open_not_yet_delayed = count(($audit->action_plans)->where('status','!=','Closed')->where('target_date','>=',date('Y-m-d')));
            $report->total = count(($audit->action_plans));

            $closed = count(($audit->action_plans)->where('status','Closed'));
            $delayed = count(($audit->action_plans)->where('status','!=','Closed')->where('target_date','<',date('Y-m-d')));
            $total = $closed + $delayed;
            if($closed+$delayed == 0)
            {
                $percent = 1;
            }
            else
            {
                $percent = $closed/($closed+$delayed);
            }
            if(count($audit->action_plans) == 0)
            {
                $percent = 0;
            }
            $report->percent = $percent*100;
            $report->no_high_risk = count(($audit->observations)->where('overall_risk','HIGH')->where('status','ON-GOING'));
            $report->save();
                                        
        }
        info("END GET REPORTS");
    }
}
