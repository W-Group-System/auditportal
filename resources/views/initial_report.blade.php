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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.typekit.net/oov2wcw.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">   
    <title>{{ config('app.name', 'Laravel') }}</title>
    <style>
        .page_break { page-break-before: always; margin-top:100px; }
        body { margin-top: 120px; }
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
            font-family:  sans-serif;
            font-size: 9px;
        }
        @page {
            margin: 90px 50px 80px 50px;
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
            position: fixed; bottom: -60px; left: 0px; right: 0px; height: 50px; 
        }
        .footer
        {
            position: fixed;
            top: 750px;
            left: 500px;
            right: 0px;
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
        table { page-break-inside: auto; width: 100%;}
    thead { display: table-row-group; }
    tr { page-break-inside: auto; }
        p {
        text-align: justify;
        text-justify: inter-word;
        margin: 0;
        padding: 0;
        }
.upperline {
   -webkit-text-decoration-line: overline; /* Safari */
   text-decoration:overline
}

hr {
    margin-top: 0em;
   margin-bottom: 0em;
  border: none;
  height: 2px;
  /* Set the hr color */
  color: #333;  /* old IE */
  background-color: #333;  /* Modern Browsers */
}
br {
    margin: 0em;
}
hr.soft {
    margin-top: 0em;
   margin-bottom: 0em;
  border: none;
  height: .5px;
}
input[type=checkbox] { display: inline; }
tr.no-bottom-border td {
  border-bottom: none;
  border-top: none;
}
    </style>
    
</head>
<body> 
    <footer>
        <table style='width:100%;' border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td class=' text-left"'>
                    <span >TP-IAD-007 <br> Rev. 0 02/17/2023</span>
                </td>
                <td class='text-center'>
                    <i ></i>
                </td>
                <td class='text-right'>
                    <span class="page-number">Page <script type="text/php">{PAGE_NUM} of {PAGE_COUNT}</script></span>
                </td>
            </tr>
        </table>
    </footer>
    <header>
       
        <table style='width:100%;margin-bottom:10px;' border="1" cellspacing="0" cellpadding="0">
            <tr class='m-0 p-0'>
                <td  align='center' style='width:30%;' > 
                    <img src='{{ asset('images/wgroup.png')}}' width='160px' >
                </td>
                <td class='text-center m-0 p-0' align='center' style='vertical-align: center;' >
                    <span class=' m-0 p-0'  style='font-size:8;margin-top;0px;padding-top:0px;'><b>Subsidiaries and Affiliates </b>
                    </span>
                    <hr class='soft'>
                    
                    <table style='font-size:9;margin-top;0px;padding-top:0px;' style='width:100%;' border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class='text-left' style='width:15%;'></td>
                            <td class='text-left'> <input type='checkbox'> WGI</td>
                            <td class='text-left'><input type='checkbox'> WHI Carmona</td>
                            <td class='text-left'><input type='checkbox'> FMPI/FMTCC</td>
                        </tr>
                        <tr>
                            <td class='text-left' style='width:15%;'></td>
                            <td class='text-left'> <input type='checkbox'> WHI - HO</td>
                            <td class='text-left'><input type='checkbox'> CCC</td>
                            <td class='text-left'><input type='checkbox'> PBI</td>
                        </tr>
                        <tr>
                            <td class='text-left' style='width:15%;'></td>
                            <td class='text-left'> <input type='checkbox'> WLI</td>
                            <td class='text-left'><input type='checkbox'> MRDC </td>
                            <td class='text-left'><input type='checkbox'> Others:</td>
                        </tr>
                        <tr>
                            <td class='text-left' style='width:15%;'></td>
                            <td class='text-left'> <input type='checkbox'> PRI</td>
                            <td class='text-left'><input type='checkbox'> SPAI </td>
                            <td class='text-left'><input type='checkbox'> ________</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr style='border:0px;' class='no-bottom-border'>
                <td colspan='2' style='font-size:9;margin-top;0px;padding-top:0px;border:0px;'> &nbsp; Form Title :
                </td>

            </tr>
            <tr class='no-bottom-border'>
                <td colspan='2'  class='text-center' ><span style='font-size:12;margin-top;0px;padding-top:0px;'><b>INITIAL REPORT </b>
                </span>
                </td>

            </tr>
        </table>
    </header>
    <main>
<p style='font-size:12;'> 
    <b>IA Code: {{$audit_plan->code}}</b><br>
    <b>Engagement Title: {{$audit_plan->engagement_title}}</b><br>
    <b>Period Covered: {{$audit_plan->scope}}</b><br>
    <b>Audit Objectives:</b><br>
    
    @foreach($audit_plan->objectives as $key => $objective)
    <span style='font-size:10'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$key+1}}. {{$objective->name}}</span> <br class='objectives'>
    @endforeach
    <b>Audit Procedures:</b><br>
    
    @foreach($audit_plan->procedures as $key => $procedure)
    <span style='font-size:10'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$key+1}}. {{$procedure->name}}</span> <br class='objectives'>
    @endforeach



</p>
<table border='1' style='width:100%;font-size:9;' id='audit'  cellspacing="0" cellpadding="0" >
    <tr style='background-color:#C0C0C0;'>
        <th class="text-center" style='width:5%;' >No</th>
        <th class="text-center" style='width:15%;'>Audit Area</th>
        <th class="text-center" style='width:80%;'>Observations and Recommendations</th>
    </tr>
   
    @foreach(($audit_plan->observations)->where('findings','!=',null) as $key => $observation)
    <tr >
        <td class="text-center" style='width:5%;border-bottom: none;' ></td>
        <td class="text-center" style='width:15%;border-bottom: none;' ></td>
        <td class="text-left" style='width:80%;border-bottom: none;'><b>Observation</b> : <br>
            {!!$observation->observation!!}</td>
    </tr>
    <tr style='border:0px;' class='no-bottom-border'>
        <td class="text-center" style='width:5%;border-bottom: none;'>{{$key+1}}</td>
        <td class="text-center" style='width:15%;border-bottom: none;'>{{$observation->criteria}}</td>
        <td class="text-left" style='width:80%;border-bottom: none;'><b>Recommendation </b>: <br>
            {!! ($observation->recommendation) !!}
        </td>
    </tr>
    <tr >
        <td class="text-center" style='width:5%;border-top: none;'></td>
        <td class="text-center" style='width:5%;border-top: none;'></td>
        <td class="text-left" style='width:80%;border-top: none;'>
            <b>Status</b> : {{$observation->status}} <Br>
            <b>Person in Charge</b> : {{ optional($observation->user)->name }} <br>
            <b>Target Date</b> : {{date('M d, Y',strtotime($observation->target_date))}} <br>
        </td>
    </tr>
    {{-- <tr>
        <td class="text-center" style='width:5%;' rowspan='3' ></td>
        <td class="text-center" style='width:15%;' rowspan='3'></td>
     
        <td class="text-left" style='width:80%;'>
            {!! ($observation->observation) !!}</td>
        </tr>
            <tr>
                <td>
                    <b>Recommendation </b>: <br>
                    
                </td>
            </tr>
            <tr>
                <td>
                    Status : {{$observation->status}} <Br>
                    Person in Charge : {{$observation->user->name}} <br>
                    Target Date : {{date('M d, Y',strtotime($observation->target_date))}} <br>
                </td>
            </tr> --}}
    @endforeach
</table>
<br>
<br>
<br>
<table border='0'   style='width:100%;font-size:8;'  cellspacing="0" cellpadding="0">
    <tr class=' text-left'>
        <td colspan='2'><b>Prepared By:</b> </td>
        <td colspan='3' ><b>Reviewed By:</b> </td>
    </tr>
    <tr class=' text-center' align='center'>

        <td class=' text-center' style='width:25%' >
           <br><br><br>
            {{strtoupper(auth()->user()->name)}}<br>
            <hr>
             <i  class=''>{{strtoupper(auth()->user()->position)}}</i>
         </td>
         <td class=' text-center' style='width:5%'>
            &nbsp;
        </td>
        <td class='' style='width:25%'>
             <br><br><br>
            {{strtoupper("Bea Bernardino")}}<br>
            <hr>
             <i  class=''>IA ASSISTANT HEAD</i>
         </td>
         <td class=' text-center' style='width:5%'>
            &nbsp;
        </td>
        <td class='' style='width:25%'>
            <br><br><br>
            {{strtoupper("Richsel Villaruel")}}<br>
            <hr>
             <i  class=''>IA HEAD</i>
         </td>
    </tr>
</table>
<br>
<br>
<table border='0'   style='width:100%;font-size:8;'  cellspacing="0" cellpadding="0">
    <tr class=' text-left'>
        <td colspan='4'><b>Noted By:</b> &nbsp;&nbsp;&nbsp;&nbsp;</td>
    </tr>
    <tr class=' text-center' align='center'>

        <td class=' ' style='width:25%' >
          <br><br><br>
            {{strtoupper('Cris Dela Cruz')}}<br>
            <hr>
             <i  class=''>Chief of Staff</i>
         </td>
         <td class=' text-center' style='width:5%'>
            &nbsp;
        </td>
        <td class='' style='width:25%'>
            <br><br><br>
            {{strtoupper($audit_plan->department[0]->department_name->dep_head->user->name)}}<br>
            <hr>
             <i  class=''>Department Head</i>
         </td>
         <td class=' text-center' style='width:5%'>
            &nbsp;
        </td>
    </tr>
</table>
<br>
<br>
<table border='0'   style='width:100%;font-size:8;'  cellspacing="0" cellpadding="0">
    <tr class=' text-left'>
        <td colspan='{{(count($audit_plan->department)*2)+1}}'><b>Approved By:</b> &nbsp;&nbsp;&nbsp;&nbsp;</td>
    </tr>
    <tr class=' text-left' >
        @foreach($audit_plan->hbu as $hbu)
        <td class=' text-center' style='width:25%' >
          <br><br><br>
           {{strtoupper($hbu->business_unit->name)}}<br>
           <hr>
            <i  class=''>{{strtoupper($hbu->business_unit->position)}}</i>
        </td>
        <td class=' text-center' style='width:5%'>
            &nbsp;
        </td>
        @endforeach
        <td class=' text-center' style='width:25%' >
            <br><br><br>
            {{strtoupper("Wee Lee Hiong")}}<br>
            <hr>
             <i  class=''>Chairman</i>
         </td>
    </tr>
</table>

    
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>