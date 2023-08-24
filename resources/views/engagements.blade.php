@extends('layouts.header')
@section('css')
<link href="{{ asset('login_css/css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">
@endsection
@section('content')

<div class="wrapper wrapper-content">
    @include('error')
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Engagements</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">0</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Closed Engagements</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">0</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Open Findings</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">0</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Closed Findings</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">0</h1>
                </div>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Engagements
                        {{-- <button class="btn btn-success "  data-target="#uploadDocument" data-toggle="modal" type="button"><i class="fa fa-plus"></i>&nbsp;New Engagement</button></h5> --}}
                        
                    </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover tables" >
                            <thead>
                                <tr>
                                    <th colspan='6'></th>
                                
                                    <th colspan='5' class='text-center'>Action Plans</th>
                                </tr>
                                <tr>
                                    <th>Action</th>
                                    <th>Code</th>
                                    <th>Engagement Title</th>
                                    <th>Team Involved</th>
                                    
                                    <th>Auditor</th>
                                    <th>No. of Findings</th>
                                    
                                    <th>Closed</th>
                                    <th>Delayed</th>
                                    <th>Not Yet Due</th>
                                    <th>Total</th>
                                    <th>%</th>
                                </tr>
                            </thead>
                        <tbody>
                            @foreach($engagements as $engagement)
                                <tr>
                                    <td><a href="{{url('view-engagement/'.$engagement->id)}}" target="_blank" class='btn btn-sm btn-info'><i class="fa fa-eye"></i></a></td>
                                    <td>{{$engagement->code}}</td>
                                    <td>{{$engagement->engagement_title}}</td>
                                    
                                    <td>{{$engagement->department->department_name->code}} - {{$engagement->department->user_name->name}}</td>
                                    <td>{{$engagement->auditor_data->user->name}}</td>
                                    <td>{{count($engagement->findings)}}</td>
                                    <td>{{count(($engagement->action_plans)->where('status','Closed'))}}</td>
                                    <td>{{count(($engagement->action_plans)->where('status',null)->where('target_date','<',date('Y-m-d')))}}</td>
                                    <td>{{count(($engagement->action_plans)->where('status',null)->where('target_date','=>',date('Y-m-d')))}}</td>
                                    <td>{{count($engagement->action_plans)}}</td>
                                    @php
                                        $closed = count(($engagement->action_plans)->where('status','Closed'));
                                        $delayed = count(($engagement->action_plans)->where('status',null)->where('target_date','<',date('Y-m-d')));
                                        $total = $closed + $delayed;
                                        if($closed+$delayed == 0)
                                        {
                                            $percent = 100;
                                        }
                                        else
                                        {
                                            $percent = $closed/($closed+$delayed);
                                        }
                                        
                                    @endphp
                                    <td>{{$percent}}%</td>
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
