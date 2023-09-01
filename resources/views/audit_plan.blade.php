@extends('layouts.header')
@section('css')
<link href="{{ asset('login_css/css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">

<script src="https://cdn.tiny.cloud/1/yemsbvzrf507kpiivlpanbssgxsf1tatzwwtu81qli4yre3p/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>tinymce.init({
    selector:'textarea',
    content_style: "p { margin: 0; }",    
    });</script>
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
                                    
                                </dl>
                            </div>
                        </div>
                        <div class='row '>
                            <div class='col-md-6 '>
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
                                            <th> Code</th>
                                            <th>Criteria / Standard</th>
                                            <th>Observation</th>
                                            <th>Recommendation</th>
                                            <th>Person In Charge</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($audit_plan->observations as $observation)
                                        <tr>
                                            <td>{{$observation->code}}</td>
                                            <td>{{$observation->criteria}}</td>
                                            <td>{!!$observation->observation!!}</td>
                                            <td>{!!$observation->recommendation!!}</td>
                                            <td>{{$observation->user->name}}</td>
                                            <td>{{$observation->status}}</td>
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
@include('carbon_copy')
@include('business_unit_head')
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
