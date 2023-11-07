@extends('layouts.header')
@section('css')
<link href="{{ asset('login_css/css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">
@endsection
@section('content')

<div class="wrapper wrapper-content">
    @include('error')
    <div class="row">
        <div class="col-lg-2">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>For Audit</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{count($audits)}}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Done Audit</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{count($audits->where('status','Done'))}}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Closed Engagements</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{count($audits->where('status','Done'))}}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Open Findings</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">0</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
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
                        <a title='SUMMARY OF AUDIT STATUS' href='{{url("engagements_reports")}}' target="_blank"><button type="button"  class="btn btn-danger btn-icon btn-sm">
                            <i class="fa fa-file-pdf-o"></i>
                            </button></a>
                        <a title='STATUS REPORT' href='{{url("engagements_each")}}' target="_blank"><button type="button"  class="btn btn-info btn-icon btn-sm">
                            <i class="fa fa-file-pdf-o"></i>
                            </button></a>
                    </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover tables" >
                            <thead>
                                <tr>
                                    <th colspan='8'></th>
                                
                                    <th colspan='6' class='text-center'>Action Plans</th>
                                </tr>
                                <tr>
                                    <th>Action</th>
                                    <th>Code</th>
                                    <th>Engagement Title</th>
                                    <th>Team Involved</th>
                                    
                                    <th>Auditor</th>
                                    {{-- <th>Status</th> --}}
                                    <th>No. of Observations</th>
                                    <th>No. of Findings</th>
                                    
                                    <th>Closed</th>
                                    <th>Delayed</th>
                                    <th>Not Yet <br> Due</th>
                                    <th>Total</th>
                                    <th>%</th>
                                    <th>No. of 
                                        High Risk <br>
                                        (Open Findings)</th>
                                </tr>
                            </thead>
                        <tbody>
                            @foreach($audits as $audit)
                           
                            <tr 

                               
                            >
                                <td><a href="{{url('view-calendar/'.$audit->id)}}"  class='btn btn-sm btn-info'><i class="fa fa-eye"></i></a></td>
                                <td @if(($audit->attachments)->where('type','Closing Report')->first() != null)
                                    class='bg-primary  text-dark'
                                    @elseif(($audit->attachments)->where('type','=','Final Report')->first() != null)
                                    class='bg-warning text-dark'
                                    @elseif(($audit->attachments)->where('type','=','Initial Report')->first() != null)
                                    class='bg-danger text-dark'
                                    @else

                                    @endif>{{$audit->code}}</td>
                                <td>{{$audit->engagement_title}}</td>
                                <td><small>@foreach($audit->department as $dept) {{$dept->department_name->code}} - {{$dept->user_name->name}} <br> @endforeach</small></td>
                                <td>@foreach($audit->auditor_data as $auditor) {{$auditor->user->name}} <br>@endforeach</td>
                                {{-- <td>
                                    @if($audit->status == null)
                                    <label class='label label-primary'>For Audit</label>
                                    @else
                                    <label class='label label-danger'>{{$audit->status}}</label>
                                    
                                    @endif

                                
                                </td> --}}
                                <td>{{count(($audit->observations)->where('findings',null))}}</td>
                                <td>{{count(($audit->observations)->where('findings','!=',null))}}</td>
                                
                                <td>{{count(($audit->action_plans)->where('status','=','Closed'))}}</td>
                                <td>{{count(($audit->action_plans)->where('status','!=','Closed')->where('target_date','<',date('Y-m-d')))}}</td>
                                <td>{{count(($audit->action_plans)->where('status','!=','Closed')->where('target_date','>=',date('Y-m-d')))}}</td>
                                <td>{{count(($audit->action_plans))}}</td>
                                <td>@php
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
                                        
                                    @endphp
                                    @if(count($audit->action_plans) == 0)
                                    0.00 %
                                    @else
                                        {{$percent*100}} %
                                    @endif
                                </td>
                                <td>{{count(($audit->observations)->where('overall_risk','HIGH')->where('status','ON-GOING'))}}</td>
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
