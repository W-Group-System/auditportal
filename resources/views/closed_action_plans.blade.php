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
                                    <th>Auditor</th>
                                    <th>Auditee</th>
                                    <th>Agreed Action Plan</th>
                                    <th>Target Date</th>
                                    <th>Date Completed</th>
                                    <th>Type</th>
                                    <th>Supporting Document</th>
                                    <th>Date Closed</th>
                                </tr>
                            </thead>
                        <tbody>
                            @foreach($action_plans as $action_plan)
                                <tr>
                                    <td>
                                        <div class="btn-group">
                                            <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="fa fa-ellipsis-v"></i> </button>
                                            <ul class="dropdown-menu">
                                                 <li><a title='View History' href="#view_history{{$action_plan->id}}" data-toggle="modal" >View History</a></li>
                                                 @if($action_plan->attachment == null)
                                                 <li><a title='View History' href="#upload_attachment{{$action_plan->id}}" data-toggle="modal" >Upload Attachment</a></li>
                                                 @endif
                                                 @if((auth()->user()->role == "IAD Approver") || (auth()->user()->role == "Administrator"))
                                                 <li><a title='Return Action Plan' href="#return{{$action_plan->id}}" data-toggle="modal" >Re-open Action Plan</a></li>
                                                @endif
                                            </ul>
                                        </div>

                                    </td>
                                    <td><small>{{$action_plan->audit_plan->code}}</small></td>
                                    <td><small>@if($action_plan->observation){{$action_plan->observation->created_by_user->name}} @else @if($action_plan->auditor_data){{$action_plan->auditor_data->name}} @endif @endif</small></td>
                                    <td><small>{{$action_plan->user->name}}</small></td>
                                    <td>{{nl2br(e($action_plan->action_plan))}}</td>
                                    <td>{{$action_plan->target_date}}</td>
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
                                        {{date('M. d, Y',strtotime($action_plan->updated_at))}}
                                    </td>
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
@foreach($action_plans as $action_plan)
    @include('view_history_action_plan')
    @include('upload_action_plan')
    @include('return_action_plan')
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
