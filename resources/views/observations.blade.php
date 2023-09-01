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
        <div class="col-lg-2">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Total Action Plan</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">0</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Delayed Action Plans</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">0</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Not Yet Due</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">0</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Closed Action Plans</h5>
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
                    <h5>Findings
                    </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover tables" >
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Control No.</th>
                                    <th>Date Audit</th>
                                    <th>Company</th>
                                    <th>Auditors</th>
                                    <th>Departments</th>
                                    <th>Audit Engagement</th>
                                    <th>Target Date</th>
                                    <th>Risks</th>
                                    <th>Risk Grade</th>
                                    <th>Status</th>
                                    <th>Audit Plans</th>
                                </tr>
                            </thead>
                        <tbody>
                            @foreach($observations as $observation)
                                <tr>
                                    <td><a href="{{url('view-observation/'.$observation->id)}}"  class='btn btn-sm btn-info'><i class="fa fa-eye"></i></a></td>
                                    <td>{{$observation->code}}</td>
                                    <td>{{$observation->date_audit}}</td>
                                    <td>@foreach($observation->audit_plan->companies as $company) {{$company->company->code}}<br>@endforeach</td>
                                    <td>@foreach($observation->audit_plan->auditor_data as $auditor) {{$auditor->user->name}}<br>@endforeach</td>
                                    @php
                                    $array = [];
                                    @endphp
                                    <td>@foreach(($observation->audit_plan->department)->unique() as $department)
                                        @if(!in_array($department->department_name->code,$array))
                                        {{$department->department_name->code}}
                                        @endif
                                    @php
                                    array_push($array,$department->department_name->code);
                                    @endphp
                                    <br>@endforeach</td>
                                    <td>{{$observation->audit_plan->engagement_title}}</td>
                                    <td>{{date('M. d, Y',strtotime($observation->target_date))}}</td>
                                    <td>{{$observation->overall_risk}}</td>
                                    <td>{{$observation->overall_number}}</td>
                                    <td>{{$observation->status}}</td>
                                    <td>{{count($observation->action_plans)}}</td>
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
