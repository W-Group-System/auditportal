@extends('layouts.header')
@section('css')
<link href="{{ asset('login_css/css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">

<link href="{{ asset('login_css/css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">

@endsection
@section('content')

<div class="wrapper wrapper-content">
    @include('error')
   
    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content ">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>{{$audit_plan->engagement_title}} </h5>@if($audit_plan->status == null)<span class="label label-primary">Pending</span> @endif
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="m-b-md">
                                    <a href="{{url('autorithy/'.$audit_plan->id)}}" target="_blank"  class="btn btn-success btn-sm "> Authority to Audit </a>
                                    <a href="{{url('initial-report/'.$audit_plan->id)}}" target="_blank"  class="btn btn-warning btn-sm "> Initial Report </a>
                                    <a href="{{url('closing-report/'.$audit_plan->id)}}" target="_blank"  class="btn btn-danger btn-sm "> Closing/Final Report </a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <dl class="dl-horizontal">
                                    <dt>Code:</dt> <dd> <b> {{$audit_plan->code}} </b></dd>
                                    <dt>Title:</dt> <dd> <b> {{$audit_plan->engagement_title}} </b></dd>
                                    <dt>Company:</dt> <dd> <b> @foreach($audit_plan->companies as $company) {{$company->company->code}} ,@endforeach </b></dd>
                                    <dt>Auditor:</dt> <dd>@foreach($audit_plan->auditor_data as $auditor) {{$auditor->user->name}} ,@endforeach </dd>
                                    <dt>Auditee:</dt> <dd>@foreach($audit_plan->department as $dept) {{$dept->department_name->code}} - {{$dept->user_name->name}} <br> @endforeach</dd>
                                    <dt>Period Covered / Scope:</dt> <dd> {!! nl2br(e($audit_plan->scope))!!}</dd>
                                    <dt>Activity:</dt> <dd>  {!! nl2br(e($audit_plan->activity))!!}</dd>
                                    <br>
                                </dl>
                            </div>
                            <div class="col-lg-6">
                                <dl class="dl-horizontal">
                                    <dt>CC <a href='#' data-target="#carbon_copy" data-toggle="modal" title='Edit'><i class="fa fa-edit"></i></a> :</dt> <dd> <b> @foreach($audit_plan->carbon_copies as $carbon_copy){{$carbon_copy->user->name}} ,@endforeach</b></dd>
                                    <dt>HBU <a href='#' data-target="#business_unit" data-toggle="modal" title='Edit'><i class="fa fa-edit"></i></a>:</dt> <dd> <b>@foreach($audit_plan->hbu as $hbu){{$hbu->business_unit->name}} - {{$hbu->business_unit->position}} ,@endforeach</b></dd>
                                    <br>
                                    
                                <div class="panel panel-warning">
                                    <div class="panel-heading">
                                        Attachments <button class="btn btn-success "  data-target="#upload" data-toggle="modal" type="button"><i class="fa fa-plus"></i>&nbsp;Upload</button>
                                    </div>
                                    <div class="panel-body">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                              <tr>
                                                  <th>Type</th>
                                                  <th>File</th>
                                                  <th>Uploaded By</th>
                                                  <th>Share</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($audit_plan->attachments as $attachment)
                                                <tr>
                                                    <td>{{$attachment->type}}</td>
                                                    <td><a href="{{url($attachment->file)}}" target='_blank'><i class='fa fa-file'></i></a></td>
                                                    <td>{{$attachment->user->name}}</td>
                                                    <td><a href='#' data-target="#share{{$attachment->id}}" data-toggle="modal" title='Share'><i class="fa fa-edit"></i></a> @foreach($attachment->share as $share){{$share->user->name}} ,@endforeach</td>
                                                </tr>
                                                @include('share')
                                                @endforeach
                                                
                                            </tbody>
                                            
                                        </table>
                                       
                                    </div>
                                </div>
                                </dl>
                            </div>
                        </div>
                        <div class='row '>
                            <div class='col-md-6'>
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        Procedures
                                    </div>
                                    <div class="panel-body">
                                        @foreach($audit_plan->procedures as $key => $procedure)
                                            {{$key+1}}. {{$procedure->name}} <br>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        Objectives
                                    </div>
                                    <div class="panel-body">
                                        @foreach($audit_plan->objectives as $key => $objective)
                                        {{$key+1}}. {{$objective->name}} <br>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <a href="{{url('new-observation/'.$audit_plan->id)}}" class='btn-sm btn-success' ><i class='fa fa-plus' title='New Observation'></i> New Observation</a>
                            </div>
                        </div>
                        <div class="row m-t-sm">
                            <div class="col-lg-12">
                            <div class="panel blank-panel">
                            <div class="panel-heading">
                                <div class="panel-options">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#tab-1" data-toggle="tab">Observations </a></li>
                                        <li class=""><a href="#tab-2" data-toggle="tab">Action Plans</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="panel-body">

                            <div class="tab-content">
                            <div class="tab-pane active" id="tab-1">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>Code</th>
                                            <th>Criteria / Standard</th>
                                            <th>Person In Charge<br><small>Status</small></th>
                                            <th>IAD<br>Approval</th>
                                            <th>Type</th>
                                            <th>Explanation</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($audit_plan->observations as $observation)
                                        <tr>
                                            <td>
                                                <div class="btn-group">
                                                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="fa fa-ellipsis-v"></i> </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a title='View' href="#view{{$observation->id}}" data-toggle="modal" >View</a></li>
                                                        @if($observation->status == "For Approval")
                                                        <li><a title='Edit' href="#edit{{$observation->id}}" data-toggle="modal" >Edit</a></li>
                                                        @endif
                                                        <li>
                                                            <a title='Move to Findings' onclick='move_to("{{$observation->findings ? "yes" : "no"}}",{{$observation->id}})' data-toggle="modal" >Move to {{$observation->findings ? "Observations" : "Findings"}}</a></li>
                                                      </ul>
                                                </div>

                                            </td>
                                            <td>{{$observation->code}}
                                                
                                            </td>
                                            <td>{{$observation->criteria}}</td>
                                            <td>{{$observation->user->name}} 
                                               
                                            </td>
                                            <td>
                                                @if($observation->status == "For Approval")
                                                    <span class='label label-warning'>{{$observation->status}}</span>
                                                @elseif($observation->status == "Declined")
                                                <span class='label label-danger'>DECLINED</span>
                                                @else
                                                    <span class='label label-info'>APPROVED</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($observation->findings == null)<span class='label label-info'>Observation</span>@else<span class='label label-danger'>Findings</span>@endif
                                         
                                            </td>
                                            <td>
                                                @if(($observation->status == "On-going") || ($observation->status == "Closed"))
                                                    @if($observation->explanation == null)
                                                        <span class='label label-warning'>No Explanation Submitted</span>
                                                    @else
                                                        <span class='label label-primary'>Explanation Submitted</span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                
                                                <span class='label label-warning'>{{$observation->status}}</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="tab-2">

                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            
                                            <tr>
                                                <th>ACR CODE</th>
                                                <th>Observation</th>
                                                <th>Action Plan</th>
                                                <th>Other Part(ies) Involved</th>
                                                <th>Status</th>
                                                <th>Target Date</th>
                                            </tr>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                </table>

                            </div>
                            <div class="tab-pane" id="tab-3">

                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Reference #</th>
                                            <th>Type of Document</th>
                                            <th>Date Requested</th>
                                            <th>Date Needed</th>
                                            <th>Requestor</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                   
                                </table>

                            </div>
                            </div>

                            </div>

                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach($audit_plan->observations as $observation)
    @include('view_observ')
@endforeach
@include('upload_attachment')
@include('carbon_copy')
@include('business_unit_head')
@endsection
@section('js')

<script src="{{ asset('login_css/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{ asset('login_css/js/plugins/chosen/chosen.jquery.js') }}"></script>
<script src="{{ asset('login_css/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script>
        function move_to(info,id)
    {
        if(info == "yes")
        {
            comment = "Observation";
        }
        else
        {
            comment = "Findings";
        }
        var id = id;
            swal({
                title: "Are you sure?",
                text: "This ACR will be moved to "+comment,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, move it!",
                closeOnConfirm: false
            }, function (){
                $.ajax({
                    dataType: 'json',
                    type:'POST',
                    url:  '{{url("move-observation")}}',
                    data:{id:id,
                    info : info},
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                }).done(function(data){
                    console.log(data);
                    swal("Moved!", "Your ACR now moved.", "success");
                    location.reload();
                }).fail(function(data)
                {
                    
                    swal("Moved!", "Your ACR now moved.", "success");
                location.reload();
                });
            });
    
    }
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
