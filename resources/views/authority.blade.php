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
    <link href="https://fonts.googleapis.com/css2?family=Century%20Gothic&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">   
    <title>{{ config('app.name', 'Laravel') }}</title>
    <style type="text/css">
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
        table {
            table-layout: fixed;
            width: 390px;
            page-break-inside: avoid;
        }
        p {
  text-align: justify;
  text-justify: inter-word;
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
@font-face {
  font-family: 'a';
  font-style: normal;
  font-weight: 400;
  font-display: swap;
  src: url("https://fonts.gstatic.com/l/font?kit=Cn-vJt-LUxZV2ICofzrQFC41xsIma3M&skey=93c2fdf69b410576&v=v19") format('woff2');
  unicode-range: U+0301, U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
}
        body{
            font-family: "sans-serif"; 
            font-size: 9px;
        }
        p{
            font-family: "Century Gothic"; 
            text-align: justify;
            text-justify: inter-word;
  
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
                    <span >TP-IAD-003 Rev. 000 </span>
                </td>
            </tr>
        </table>
    </footer>
    <header>
        <table style='width:100%;' border="1" cellspacing="0" cellpadding="0">
            <tr style='height:90px;'>
                <td  align='center' width='50px' style='width:30%;' rowspan='2'> 
                    <img src='{{ asset('images/wgroup.png')}}' width='170px' >
                </td>
                <td class='text-center' colspan='3' >
                    <span  style='font-size:29;text-align: center;'><b>AUTHORITY TO AUDIT</b>
                    </span>
                </td>
            </tr>
            <tr  class='m-0 p-0'>
                <td class='text-center m-0 p-0' >
                    <span  style='font-size:9;text-align: center;'>{{date('F d, Y')}}</span>
                </td>
                <td class='text-center  m-0 p-0'>
                    <span  style='font-size:9;text-align: center;'>
                        @foreach($companies as $key => $group)
                        {{$group->group_name}} @if($key+1 != count($companies)),@endif 
                        @endforeach
                    </span>
                </td>
                <td class='text-center  m-0 p-0'>
                    <span  style='font-size:9;text-align: center;'>
                   {{$audit_plan->code}}
                    </span>
                </td>
            </tr>
        </table>
    </header>
    <div>
        <p style='font-size:9;'><b>ATTENTION   :</b> @foreach($audit_plan->department as $dept){{$dept->user_name->name}} ,{{$dept->user_name->position}} <br> 
            
            
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            @endforeach</p>
    </div>
    <div>
        <p style='font-size:9;'><b>CC   :</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;@foreach($audit_plan->carbon_copies as $carbon){{$carbon->user->name}} ,{{$carbon->user->position}} <br> 
            
            
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            @endforeach</p>
    </div>
    
    <p style='font-size:9;'>Kindly allow the following auditors whose name appears below to conduct audit of your department. The general objectives of this audit is to evaluate internal controls, compliance with organization policies, procedures and guidelines and laws and regulations, if applicable.
    </p>
    <table style='width:100%;' border="1" cellspacing="0" cellpadding="0" class='inside'>
        <tr style='background-color:rgb(201, 201, 201);font-size:9px;'>
            <td  align='center' > 
                <b>DATE</b>
            </td>
            <td class='text-center' >
                <b>ACTIVITY</b>
            </td>
            <td class='text-center' >
                <b>AUDIT COVERAGE</b>
            </td>
            <td class='text-center' >
                <b>ASSIGNED AUDITOR(S)</b>
            </td>
        </tr>
        <tr style='height: 50px'>
            <td  align='center' style='height: 75px'> 
                {{date('M d, Y',strtotime($audit_plan->audit_from))}} -{{date('M d, Y',strtotime($audit_plan->audit_to))}}
            </td>
            <td class='text-center' >
                {{strtoupper($audit_plan->engagement_title)}}
            </td>
            <td class='text-center' >
                {{strtoupper($audit_plan->scope)}}
            </td>
            <td class='text-center' >
                @foreach($audit_plan->auditor_data as $auditor) {{strtoupper($auditor->user->name)}} <br>@endforeach
            </td>
        </tr>
    </table>
    <br>
    <p style='font-size:9;'>We may collect, use, transfer, store or otherwise process information that may be linked, but are not limited to the company’s clients, owners and employees. By acknowledging this letter of authority, you agree to provide the information being asked in connection with the performance of our engagement. The information that you have provided will be used solely for the purpose for which the information was requested and that the internal auditors will take proper and reasonable measures to ensure the confidentiality of the information in compliance with our policy PR-IA-003 or Internal Audit Information Confidentiality Policy and Republic Act 10173 or Data Privacy Act of 2012.</p>
    <p style='font-size:9;'>In event that the engagement will be extended due to complexities of the audits performed, a notice regarding such will be communicated through e-mail. If you have any questions or concerns during the course of audit, please address it directly to @foreach($audit_plan->auditor_data as $key => $auditor) {{strtoupper($auditor->user->name)}} @if($key+1 != count($audit_plan->auditor_data)),@endif @endforeach loc. @foreach($audit_plan->auditor_data as $key => $auditor) {{strtoupper($auditor->user->tel_number)}} @if($key+1 != count($audit_plan->auditor_data)) / @endif @endforeach.</p>
    <p style='font-size:9;'>
We are looking forward for your departments' cooperation and assistance in making the audit engagement a success.
</p>
    <p style='font-size:9;'>Thank you!
</p>
<table border='0'   style='width:100%;font-size:8;'  cellspacing="0" cellpadding="0">
    <tr class=' text-center' align='center'>

        <th class=' text-left' style='width:25%' >
            Prepared by:
         </th>
         <th class=' text-center' style='width:5%'>
            &nbsp;
        </th>
        <th class='text-left' style='width:25%'>
            Noted By:
         </th>
         <th class=' text-center' style='width:5%'>
            &nbsp;
        </th>
    </tr>
    <tr class=' text-center' align='center'>

        <th class=' text-center' style='width:25%' >
            <br><br><br>
            {{strtoupper('Bea Bernardino')}}<br>
            <hr>
             <i  class=''>Assistant IA Head</i>
         </th>
         <th class=' text-center' style='width:5%'>
            &nbsp;
        </th>
        <th class='' style='width:25%'>
            <br><br><br>
            {{-- {{strtoupper($audit_plan->department[0]->department_name->dep_head->user->name)}} --}}
            {{strtoupper("Cris dela Cruz")}}
            <br>
            <hr>
             <i  class=''>Chief of Staff</i>
         </th>
         <th class=' text-center' style='width:5%'>
            &nbsp;
        </th>
    </tr>
</table>
<br>
<br>
<table border='0'   style='width:100%;font-size:8;'  cellspacing="0" cellpadding="0">
    <tr class=' text-left' colspan='{{count($audit_plan->hbu)*2}}' >
        <th><b>Approved By: </b>
        </th>
    </tr>
    @if(count($audit_plan->hbu) ==1)
    <tr class=' text-left' >
        @foreach($audit_plan->hbu as $hbu)
        <th class=' text-center' style='width:40%' >
            <br><br>
           {{strtoupper($hbu->business_unit->name)}}<br>
           <hr>
            <i  class=''>{{strtoupper($hbu->business_unit->position)}}</i>
        </th>
        <th class=' text-center' style='width:60%'>
            &nbsp;
        </th>
        @endforeach
    </tr>
    @else
    <tr class=' text-left' >
        @foreach($audit_plan->hbu as $hbu)
        <th class=' text-center' style='width:25%' >
            <br><br>
           {{strtoupper($hbu->business_unit->name)}}<br>
           <hr>
            <i  class=''>{{strtoupper($hbu->business_unit->position)}}</i>
        </th>
        <th class=' text-center' style='width:5%'>
            &nbsp;
        </th>
        @endforeach
    </tr>
    @endif
    
</table>
<br>
<br>
<table border='0'   style='width:100%;font-size:8;'  cellspacing="0" cellpadding="0">
    <tr class=' text-left'>
        <th colspan='{{count($audit_plan->department)*2}}'><b>Acknowledged By:</b> &nbsp;&nbsp;&nbsp;&nbsp;</th>
    </tr>
    @if(count($audit_plan->department) == 1)
    <tr class=' text-center' >
        @foreach($audit_plan->department as $dept)
        <th class=' text-center' style='width:40%;' >
           <br><br>
           {{strtoupper($dept->user_name->name)}}<br>
           <hr>
            <i  class=''>{{$dept->user_name->position}}</i>
        </th>
        <th class=' text-center' style='width:60%;'>
            &nbsp;
        </th>
        @endforeach
    </tr>
    @else
    <tr class=' text-center' >
        @foreach($audit_plan->department as $dept)
        <th class=' text-center' style='width:25%;' >
           <br><br>
           {{strtoupper($dept->user_name->name)}}<br>
           <hr>
            <i  class=''>{{$dept->user_name->position}}</i>
        </th>
        <th class=' text-center' style='width:5%;'>
            &nbsp;
        </th>
        @endforeach
    </tr>
    @endif
</table>

    
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>