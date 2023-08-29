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
            position: fixed; bottom: -60px; left: 0px; right: 0px; height: 50px; 
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
                    <span >TP-IAD-002 Rev.00 </span>
                </td>
            </tr>
        </table>
    </footer>
    <header>
        <table style='width:100%;' border="1" cellspacing="0" cellpadding="0">
            <tr>
                <td  align='center' width='100px' style='width:35%;' rowspan='2'> 
                    <img src='{{ asset('images/wgroup.png')}}' width='170px' >
                </td>
                <td class='text-center' colspan='3'>
                    <span  style='font-size:23;text-align: center;'><b>INTERNAL AUDIT DEPARTMENT</b>
                    </span>
                </td>
            </tr>
            <tr>
                <td class='text-center'>
                    <span  style='font-size:9;text-align: center;'>{{date('M d, Y')}}
                    </span>
                </td>
                <td class='text-center'>
                    <span  style='font-size:9;text-align: center;'>
                        {{date('F 01 - t, Y',strtotime($month))}}
                    </span>
                </td>
                <td class='text-center'>
                    <span  style='font-size:9;text-align: center;'>
                        AUDIT PLAN
                    </span>
                </td>
            </tr>
        </table>
    </header>
    <table border='1'   style='width:100%;font-size:10'  cellspacing="0" cellpadding="0" >
        <tr class='text-center'>
            <th >No.</th>
            <th>Audit Task</th>
            <th>Period Cover</th>
            <th>Company</th>
            <th>Assigned Auditor</th>
            <th>Deadline</th>
        </tr>
        @foreach($schedule_month as $key => $schedule)
        <tr class='text-center'>
            <td  style='width:5%;'>{{$key+1}}</td>
            <td>{{$schedule->engagement_title}}</td>
            <td>{{$schedule->scope}}</td>
            <td>@foreach($schedule->companies as $company) {{$company->company->code}} /@endforeach</td>
            <td>@foreach($schedule->auditor_data as $auditor) {{$auditor->user->name}} <br>@endforeach</td>
            <td>{{date('M. d, Y',strtotime($schedule->audit_to))}}</td>
        </tr>
        @endforeach
    </table>
    <br>
    <br>
    <table border='0'   style='width:100%;font-size:9;'  cellspacing="0" cellpadding="0">
        <tr class='noBorder ' align='center'  class='' >
        <th class='noBorder'  class='text-center' width='25%'>
            <p>Prepared by :</p> 
            <br>
            <b>{{auth()->user()->name}}</b><br>
            {{auth()->user()->position}}
            
        </th>
        <th class='noBorder'  class='text-center' width='25%'>
            <p>Reviewed by :</p> 
            <br>
            <b>Richsel Villaruel</b><br>
            IA Head
        </th>
        <th class='noBorder'  class='text-center' width='25%'>
            <p>Noted by :</p> 
            <br>
            <b>Cris Dela Cruz</b><br>
            Chief of Staff
        </th>
        <th class='noBorder'  class='text-center' width='25%'>
            <p>Approved by :</p> 
            <br>
            <b>Wee Lee Hiong</b><br>
            Chairman
        </th>
    </tr>
    </table>
    
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>