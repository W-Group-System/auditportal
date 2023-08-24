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
        }
        .page-break {
            page-break-after: always;
        }
        header {
            position: fixed;
            top: -5px;
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
    
    <header>
        <table style='width:100%;' border="1" cellspacing="0" cellpadding="0">
            <tr>
                <td  align='center' width='100px' style='width:35%;' > 
                    <img src='{{ asset('images/wgroup.png')}}' width='170px' >
                </td>
                <td class='text-center' colspan='3'>
                    <span  style='font-size:8;text-align: center;'><b>Subsidiaries and Affiliates</b>
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
                    @foreach($engagement->companies as $key => $company)
                    {{$company->company->name}} @if($key+1 != count($engagement->companies)),@endif 
                    @endforeach
                    </span>
                </td>
                <td class='text-center'>
                    <span  style='font-size:9;text-align: center;'>
                   {{$engagement->code}}
                    </span>
                </td>
            </tr>
        </table>
    </header>
    <br>
    <br>
    <br>
    
    <div>
        <p style='font-size:9;'><b>ATTENTION   :</b> {{$engagement->department->user_name->name}}, {{$engagement->department->user_name->position}}</p>
    </div>
    <br>
    <br>
    <div>
        <p style='font-size:9;'><b>CC   :</b></p>
    </div>
    <br>
    <br>
    <p style='font-size:9;'>Kindly allow the following auditors whose name appears below to conduct audit of your department. The general objectives of this audit is to evaluate internal controls, compliance with organization policies, procedures and guidelines and laws and regulations, if applicable.
    </p>
    <table style='width:100%;' border="1" cellspacing="0" cellpadding="0">
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
                {{date('M d, Y',strtotime($engagement->audit_from))}} -{{date('M d, Y',strtotime($engagement->audit_to))}}
            </td>
            <td class='text-center' >
                {{strtoupper($engagement->engagement_title)}}
            </td>
            <td class='text-center' >
                {{strtoupper($engagement->scope)}}
            </td>
            <td class='text-center' >
                {{strtoupper($engagement->auditor_data->user->name)}}
            </td>
        </tr>
    </table>
    <br>
    <p style='font-size:9;'>We may collect, use, transfer, store or otherwise process information that may be linked, but are not limited to the company’s clients, owners and employees. By acknowledging this letter of authority, you agree to provide the information being asked in connection with the performance of our engagement. The information that you have provided will be used solely for the purpose for which the information was requested and that the internal auditors will take proper and reasonable measures to ensure the confidentiality of the information in compliance with our policy PR-IA-003 or Internal Audit Information Confidentiality Policy and Republic Act 10173 or Data Privacy Act of 2012.</p>
    <p style='font-size:9;'>In event that the engagement will be extended due to complexities of the audits performed, a notice regarding such will be communicated through e-mail. If you have any questions or concerns during the course of audit, please address it directly to {{strtoupper($engagement->auditor_data->user->name)}} (loc. {{strtoupper($engagement->auditor_data->user->tel_number)}}).</p>
    <p style='font-size:9;'>
We are looking forward for your departments' cooperation and assistance in making the audit engagement a success.
</p>
    <p style='font-size:9;'>Thank you!
</p>

    
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>