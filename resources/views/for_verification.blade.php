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
    function add_immediate_action(id)
    {
        var lastItemID = $('.content'+id).children().last().attr('id');
    if(lastItemID){
        finalLastId = parseInt(last_id[1]) + 1;
    }else{
        finalLastId = 1;
    }
        var data = "<tr class='new_action_plan' id="+finalLastId+" >";
            data += "<td>";
            data += "<textarea class='form-control' name='new_immediate_action[]'  rows='6' cols='100' required placeholder='Correction or Immediate Action'></textarea> </td> ";
            data += "</td>";
            data += "<td>";
            data += "<div class='form-group'>";
            data += "<label class='col-sm-6 control-label text-left'>Other Party(ies) Involved :</label>";
            data += "<div class='col-sm-6'>";
            data += "<input type='text' placeholder='Other Party(ies) Involved (optional)' disabled class='form-control form-control-sm '  >";
            data += "</div>";
            data += "</div>";
            data += "<div class='form-group text-left'>";
            data += "<label class='col-sm-6 control-label text-left'>Proof:</label>";
            data += "<div class='col-sm-6'> <span class='text-danger'>No Proof</span>";
            data += " </div>";
            data += "</div>";
            data += "<div class='form-group text-left'>";
            data += "<label class='col-sm-6 control-label text-left'>Target Completion :</label>";
            data += " <div class='col-sm-6'>";
            data += "<input name='new_target_date[]' class='form-control form-control-sm' type='date' required >";
            data += " </div>";
            data += "</div>";
            data += "</td>";
            data += " </tr>";  
            
            $('#content'+id).append(data);
                                       
    }
    function remove_immediate_action(id)
    {
        if($('tr.new_action_plan').length > 0)
        {
            lastItemID =  $('#content'+id+' tr:last').attr('id');
        $('#'+lastItemID).remove();
        }
                                       
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
