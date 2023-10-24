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
                    <h5>For Verification </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover tables" >
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Code</th>
                                    <th>Engagement Title</th>
                                    <th>Criteria</th>
                                    <th>Auditor</th>
                                    <th>Prepared By</th>
                                    <th>Reviewed By</th>
                                </tr>
                            </thead>
                        <tbody>
                            @foreach($observations as $observation)
                            <tr>
                                <td><a href="#view{{$observation->id}}" data-toggle="modal"  class='btn btn-sm btn-info'><i class="fa fa-eye"></i></a></td>
                                <td>{{$observation->code}}</td>
                                <td>{{$observation->audit_plan->engagement_title}}</td>
                                <td>{{$observation->criteria}}</td>
                                <td>{{$observation->created_by_user->name}}</td>
                                <td>{{$observation->explanation->user->name}}</td>
                                <td>{{$observation->explanation->reviewed->name}}</td>
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
@foreach($observations as $observation)
    @include('for_verification_view')
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
