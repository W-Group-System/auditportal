@extends('layouts.header')
@section('css')
<link href="{{ asset('login_css/css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">
@endsection
@section('content')

<div class="wrapper wrapper-content">
    @include('error')
   
    <div class="row">
        <div class="col-lg-12">
            <div class="wrapper wrapper-content ">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>{{$engagement->engagement_title}} </h5>@if($engagement->status == null)<span class="label label-primary">Pending</span> @endif
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="m-b-md">
                                    <a href="{{url('autorithy/'.$engagement->id)}}" target="_blank"  class="btn btn-success btn-sm "> Authority to Audit </a>
                                    <a href="{{url('initial-report/'.$engagement->id)}}" target="_blank"  class="btn btn-warning btn-sm "> Initial Report </a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <dl class="dl-horizontal">
                                    <dt>Title:</dt> <dd> <b> {{$engagement->engagement_title}} </b></dd>
                                    <dt>Code:</dt> <dd>  {{$engagement->code}}</dd>
                                    <dt>Auditor:</dt> <dd> {{$engagement->auditor_data->user->name}}</dd>
                                    <dt>Auditee:</dt> <dd> {{$engagement->department->department_name->code}} - {{$engagement->department->user_name->name}}</dd>
                                    <dt>Period Covered:</dt> <dd> {{$engagement->scope}}</dd>
                                    <br>
                                        <div class='row '>
                                            <div class='col-md-6 '>
                                                <div class="panel panel-primary">
                                                    <div class="panel-heading">
                                                        Procedures
                                                    </div>
                                                    <div class="panel-body">
                                                        @foreach($engagement->procedures as $key => $procedure)
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
                                                        @foreach($engagement->objectives as $key => $objective)
                                                        {{$key+1}}. {{$objective->name}} <br>
                                                    @endforeach
                                                    </div>
                                                </div>
                                            
                                                
                                            </div>
                                        </div>
                                </dl>
                            </div>
                           
                        </div>
                        <div class="row m-t-sm">
                            <div class="col-lg-12">
                            <div class="panel blank-panel">
                            <div class="panel-heading">
                                <div class="panel-options">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#tab-1" data-toggle="tab">Observations</a></li>
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
                                            <th>Observation</th>
                                            <th>Recommendation</th>
                                            <th>Department</th>
                                            <th>Revision</th>
                                            <th>Date Obsolete</th>
                                            <th>Obsolete By</th>
                                            <th>Attachments</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="tab-2">

                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            
                                            <th>DICR #</th>
                                            <th>Type of Request</th>
                                            <th>Requested Date</th>
                                            <th>Requestor</th>
                                            <th>Department</th>
                                            <th>Proposed Effective Date</th>
                                            <th>Type of Document</th>
                                            <th>Status</th>
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
