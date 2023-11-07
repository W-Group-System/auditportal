@extends('layouts.header')
@section('css')
<link href="{{ asset('login_css/css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">
@endsection
@section('content')

<div class="wrapper wrapper-content">
    @include('error')
    <div class='row'>
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Action Plans
                        {{-- <button class="btn btn-success "  data-target="#uploadDocument" data-toggle="modal" type="button"><i class="fa fa-plus"></i>&nbsp;New Engagement</button></h5> --}}
                        
                    </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover tables" >
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Code</th>
                                    <th>Title</th>
                                    <th>Auditor</th>
                                    <th>Auditee</th>
                                    <th>Agreed Action Plan</th>
                                    <th>Target Date</th>
                                    <th>Date Completed</th>
                                    <th>Type</th>
                                    <th>Supporting Document</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                        <tbody>
                            @foreach($action_plans as $action_plan)
                            @if($action_plan->action_plan != "N/A")
                                <tr>
                                    <td>
                                        <div class="btn-group">
                                            <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="fa fa-ellipsis-v"></i> </button>
                                            <ul class="dropdown-menu">
                                                @if(auth()->user()->role == "Auditee")
                                                    <li><a title='Update' href="#view{{$action_plan->id}}" data-toggle="modal" >Upload</a></li>
                                                    <li><a title='View History' href="#view_history{{$action_plan->id}}" data-toggle="modal" >View History</a></li>
                                                @else
                                                    <li><a title='Update' href="#view{{$action_plan->id}}" data-toggle="modal" >Upload</a></li>
                                                    <li><a title='Change Target Date' href="#change{{$action_plan->id}}" data-toggle="modal" >Change Target Date</a></li>
                                                    <li><a title='Return Action Plan' href="#return{{$action_plan->id}}" data-toggle="modal" >Return Action Plan</a></li>
                                                    @if($action_plan->attachment == null)
                                                    @elseif($action_plan->iad_status == "Returned")
                                                    @else
                                                    <li><a title='Closed Action Plan' href="#closed{{$action_plan->id}}" data-toggle="modal" >Close Action Plan</a></li>
                                                    @endif
                                                    
                                                   
                                                    <li><a title='View History' href="#view_history{{$action_plan->id}}" data-toggle="modal" >View History</a></li>
                                                @endif
                                            </ul>
                                        </div>

                                    </td>
                                    <td>{{$action_plan->observation->code}}</td>
                                    <td>{{$action_plan->observation->audit_plan->engagement_title}}</td>
                                    <td>{{$action_plan->observation->created_by_user->name}}</td>
                                    <td>{{$action_plan->observation->user->name}}</td>
                                    <td>{{$action_plan->action_plan}}</td>
                                    <td @if($action_plan->target_date < date('Y-m-d')) class='bg-danger' @endif>{{$action_plan->target_date}}</td>
                                    <td>{{$action_plan->date_completed}}</td>
                                    <td>@if($action_plan->immediate == 1) Correction or Immediate Action @else Corrective Action Plan @endif</td>
                                    <td>
                                        @if($action_plan->attachment == null)
                                        <span class='text-danger'>No Proof</span>
                                        @else
                                        <a href='{{url($action_plan->attachment)}}' target='_blank'><i class='fa fa-file-pdf-o'></i></a>
                                        @endif
                                    </td>
                                    <td>
                                        @if($action_plan->attachment == null)  For Auditee Uploading </span>
                                        @elseif($action_plan->iad_status == "Returned")
                                            Returned Action Plan
                                        @else For IAD Checking 
                                        @endif
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@foreach($action_plans as $action_plan)
    @include('view_action_plan')
    @include('return_action_plan')
    @include('close_action_plan')
    @include('change_target')
    @include('view_history_action_plan')
@endforeach
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
