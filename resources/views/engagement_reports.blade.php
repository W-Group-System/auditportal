@extends('layouts.header')
@section('css')
<link href="{{ asset('login_css/css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">
@endsection
@section('content')

<div class="wrapper wrapper-content">
    @include('error')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <form  method='GET' onsubmit='show();'  enctype="multipart/form-data" >
                        <div class="row">
                            <div class="col-lg-3">
                                
                            As of
                               <input class='form-control' type='date' name='generate_date' value='{{$generate_date}}' max='{{date('Y-m-d')}}' required>
                            </div>
                           
                            <div class="col-lg-2">
                                <br>
                                <button class="btn btn-primary mt-4" type="submit" id='submit'><i class="fa fa-check"></i>&nbsp;Generate</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Engagements
                </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover tables" >
                            <thead>
                                <tr>
                                    <th width=20%>Code</th>
                                    <th width=20%>Engagement Title</th>
                                    <th>Closed</th>
                                    <th>Delayed</th>
                                    <th>Not Yet</th>
                                    <th>Total</th>
                                    <th>%</th>
                                </tr>
                            </thead>
                        <tbody>
                            @foreach($audit_plans as $audit_plan)
                            <tr>
                                <td>{{$audit_plan->code}}</td>
                                <td>{{$audit_plan->engagement_title}}</td>
                                <td>{{count(($audit_plan->action_plans)->where('action_plan','!=',"N/A")->where('updated_at','<=',date('Y-m-d 23:59:59',strtotime($generate_date)))->where('status','Closed'))}}</td>
                                <td>{{count(($audit_plan->action_plans)->where('action_plan','!=',"N/A")->where('status','Verified')->where('target_date','<',date('Y-m-d')))}}</td>
                                <td>{{count(($audit_plan->action_plans)->where('action_plan','!=',"N/A")->where('status','Verified')->where('target_date','>=',date('Y-m-d')))+count(($audit_plan->action_plans)->where('action_plan','!=',"N/A")->where('update_at','>',date('Y-m-d 23:59:59',strtotime($generate_date)))->where('status','Closed'))}}</td>
                                @php
                                    $closed = count(($audit_plan->action_plans)->where('action_plan','!=',"N/A")->where('update_at','<=',date('Y-m-d 23:59:59',strtotime($generate_date)))->where('status','Closed'));
                                    $delayed = count(($audit_plan->action_plans)->where('action_plan','!=',"N/A")->where('status','Verified')->where('target_date','<',date('Y-m-d')));
                                    $total = $closed + $delayed;
                                    if($closed+$delayed == 0)
                                    {
                                        $percent = 1;
                                    }
                                    else
                                    {
                                        $percent = $closed/($closed+$delayed);
                                    }
                                    
                                @endphp
                                <td>{{$total+count(($audit_plan->action_plans)->where('action_plan','!=',"N/A")->where('status','Verified')->where('target_date','>=',date('Y-m-d')))+count(($audit_plan->action_plans)->where('action_plan','!=',"N/A")->where('updated_at','>',date('Y-m-d 23:59:59',strtotime($generate_date)))->where('status','Closed'))}}</td>
                                <td>
                                @if(count($audit_plan->action_plans) == 0)
                                100.00 %
                                @else
                                    {{number_format($percent*100,2)}} %
                                @endif</td>
                            </tr>
                            @endforeach
                           
                        </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('login_css/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{ asset('login_css/js/plugins/chosen/chosen.jquery.js') }}"></script>
<script>
    $(document).ready(function(){
        

        $('.cat').chosen({width: "100%"});
        $('.tables').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                { extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel', title: 'ExampleFile'},
                {extend: 'pdf', title: 'ExampleFile'},

                {extend: 'print',
                 customize: function (win){
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                }
                }
            ]

        });

    });

</script>
@endsection
