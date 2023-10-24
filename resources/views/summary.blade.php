@php
ini_set("memory_limit", "-1");
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="icon" type="image/png" href="{{ asset('/images/icon.png')}}"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://use.typekit.net/oov2wcw.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">   
    <title>{{ config('app.name', 'Laravel') }}</title>
    <style>
        .page_break { page-break-before: always; }
        body { margin-top: 63px; }
        #first 
        {
            display:none;
        }
        table { 
            border-spacing: 0;
            border-collapse: collapse;
            margin-top: 10px;
        }
        body{
            font-family: "Century Gothic", CenturyGothic, AppleGothic, sans-serif;
            font-size: 9px;
            margin-top: 65px;
        }
        @page {
            margin: 80px 50px 80px 50px;
        }
        .page-break {
            page-break-after: always;
        }
        header {
            position: fixed;
            top: -75px;
            left: 0px;
            right: 0px;
            color: black;
            text-align: left;
            background-color:#ffffff;
        }
        .text-right
        {
            text-align: right;
        }
        footer
        {
            position: fixed; bottom: -60px; left: 0px; right: 0px; height: 20px; 
        }
        .footer
        {
            position: fixed;
            top: 750px;
            left: 0px;
            right: 100px;
            height: 50px;
        }
        .footer1
        {
            position: fixed;
            top: 750px;
            left: 430px;
            right: 100px;
            height: 50px;
        }
        .footer2
        {
            position: fixed;
            top: 750px;
            left: 880px;
            /* right: 100px; */
            height: 50px;
        }
        .fixed
        {
            position: fixed;
            top: -135px;
            left: 800px;
            right: 0px;
            height: 20px;
        }
        .page-number:after { content: counter(page); }
        table{
            table-layout: fixed;
            width: 390px;
        }
        p {
  text-align: justify;
  text-justify: inter-word;
}
hr {
  /* Set the hr color */
  color: #333;  /* old IE */
  background-color: #333;  /* Modern Browsers */
}
    </style>
    
</head>
<body> 
    

    <footer>
        <table style='width:100%;' border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td class=' text-left"'>
                    <span >FOR IAD USE ONLY </span>
                </td>
                <td class='text-center'>
                    <i >HIGHLY CONFIDENTIAL</i>
                </td>
                <td class='text-right'>
                    <span >TP-IAD-010 Rev.00 </span>
                </td>
            </tr>
        </table>
    </footer>
    <header>
        <table style='width:100%;' border="1" cellspacing="0" cellpadding="0">
            <tr>
                <td  align='center' width='100px' style='width:35%;'> 
                    <img src='{{ asset('images/wgroup.png')}}' width='170px' >
                </td>
                <td class='text-center'>
                    <span  style='font-size:18;text-align: center;'><b>SUMMARY OF AUDIT STATUS</b>
                        <p style='font-size:14;text-align: center;'>as of {{date("F Y")}}</p>
                    </span>
                </td>
            </tr>
        </table>
    </header>

    <table border='1' style='width:100%;font-size:9;' id='audit'  cellspacing="0" cellpadding="0" >
        <tr style='background-color:#cfd4d1;'>
            <th class="text-center" rowspan='2'>IA Code</th>
            <th class="text-center" rowspan='2'>Engagement</th>
            <th class="text-center" rowspan='2'>Team <br>involved</th>
            <th class="text-center" rowspan='2'>No. of Findings</th>
            <th class="text-center" colspan='5'>As of {{date('F')}}  </th>
            <th class="text-center" colspan='5'>As of {{date("F", strtotime("-1 months"))}}  </th>
            <th class="text-center" rowspan='2'>No. of <br>
                High Risk <br>
                <small><i>(Open Findings)</i></small></th>
        </tr>
        <tr style='background-color:#cfd4d1;'>
            <th class="text-center" >Closed</th>
            <th class="text-center" >Open <br>Delayed</th>
            <th class="text-center" >Open <br>Not Yet Due</th>
            <th class="text-center" >Total</th>
            <th class="text-center" >%</th>
            <th class="text-center" >Closed</th>
            <th class="text-center" >Open <br>Delayed</th>
            <th class="text-center" >Open <br>Not Yet Due</th>
            <th class="text-center" >Total</th>
            <th class="text-center" >%</th>
        </tr>
        @foreach($audits as $audit)
        <tr style='font-size:8;'>
            <td style='text-align: center;'>{{$audit->code}}</td>
            <td style='text-align: center;'>{{$audit->engagement_title}}</td>
            @php
                $departments = [];
            @endphp
            <td style='text-align: center;'><small>
                @foreach($audit->department as $dept)
               
                @if(!in_array($dept->department_name->code,$departments))
                {{$dept->department_name->code}}
                <br>
                @endif
              @php
                array_push($departments,$dept->department_name->code);
            @endphp @endforeach</small></td>
            <td style='text-align: center;'>{{count(($audit->observations)->where('findings','!=',null))}}</td>
            <td style='text-align: center;'>{{count(($audit->action_plans)->where('status','=','Closed'))}}</td>
            <td style='text-align: center;'>{{count(($audit->action_plans)->where('status','!=','Closed')->where('target_date','<',date('Y-m-d')))}}</td>
            <td style='text-align: center;'>{{count(($audit->action_plans)->where('status','!=','Closed')->where('target_date','>=',date('Y-m-d')))}}</td>
            <td style='text-align: center;'>{{count(($audit->action_plans))}}</td>
            @php
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
            $previous_audit = $previous_audits->where('engagement_id',$audit->id)->first();
            if($previous_audit == null)
            {
                $closed_previous = 0;
                $open_delayed_previous = 0;
                $open_not_yet_due_previous = 0;
                $total_previous = 0;
                $percent_previous = 0;
            }
            else {
                $closed_previous = $previous_audit->closed;
                $open_delayed_previous = $previous_audit->open_delayed;
                $open_not_yet_due_previous = $previous_audit->open_not_yet_delayed;
                $total_previous = $previous_audit->total;
                $percent_previous = $previous_audit->percent;
                
            }
            @endphp
            <td style='text-align: center;'>{{number_format($percent*100)}} %</td>
            <td style='text-align: center;'>{{$closed_previous}}</td>
            <td style='text-align: center;'>{{$open_delayed_previous}}</td>
            <td style='text-align: center;'>{{$open_not_yet_due_previous}}</td>
            <td style='text-align: center;'>{{$total_previous}}</td>
            <td style='text-align: center;'>{{$percent_previous}} %</td>
            <td style='text-align: center;'>{{count(($audit->observations)->where('overall_risk','HIGH')->where('status','ON-GOING'))}}</td>
        </tr>
        @endforeach
        
    </table>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>