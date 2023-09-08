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
                    <h5>ACR</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{count($reports)}}</h1>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Observations</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"></h1>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Findings</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"></h1>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Findings No Action Plan</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins"></h1>
                </div>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>ACR
                        {{-- <button class="btn btn-success "  data-target="#uploadDocument" data-toggle="modal" type="button"><i class="fa fa-plus"></i>&nbsp;New Engagement</button></h5> --}}
                        
                    </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover tables" >
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Code</th>
                                    <th>Engagement Title</th>
                                    <th>Criteria / Standard</th>
                                    <th>Date Discovered</th>
                                    <th>Date Prepared</th>
                                    <th>Risk Implication(s)</th>
                                    <th colspan='2'>Consequence</th>
                                    <th colspan='2'>Likelihood</th>
                                    <th colspan='2'>Overall Risk</th>
                                    <th>Type</th>
                                    <th>Encoded By</th>
                                    <th>Auditee</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reports as $observation)
                                    <tr>
                                        <td> <div class="btn-group">
                                            <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="fa fa-ellipsis-v"></i> </button>
                                            <ul class="dropdown-menu">
                                                <li><a title='View' href="#view{{$observation->id}}" data-toggle="modal" >View</a></li>
                                               </ul>
                                        </div></td>
                                        <td>{{$observation->code}}</td>
                                        <td>{{$observation->audit_plan->engagement_title}}</td>
                                        <td>{{$observation->criteria}}</td>
                                        <td>{{$observation->date_audit}}</td>
                                        <td>{{date('Y-m-d',strtotime($observation->created_at))}}</td>
                                        <td>{{$observation->risk_implication}}</td>
                                        <td>{{$observation->consequence}}</td>
                                        <td>{{$observation->consequence_number}}</td>
                                        <td>{{$observation->likelihood}}</td>
                                        <td>{{$observation->likelihood_number}}</td>
                                        <td>{{$observation->overall_risk}}</td>
                                        <td>{{$observation->overall_number}}</td>
                                        <td>@if($observation->findings == null)<span class='label label-info'>Observation</span>@else<span class='label label-danger'>Findings</span>@endif</td>
                                        <td>{{$observation->created_by_user->name}}</td>
                                        <td>{{$observation->user->name}}</td>
                                        <td>{{$observation->status}}</td>
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
@foreach($reports as $observation)
    @include('view_observation_full')
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
