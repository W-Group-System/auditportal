@extends('layouts.header')
@section('css')
<link href="{{ asset('login_css/css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">
@endsection
@section('content')

<div class="wrapper wrapper-content">
    @include('error')
    
    <form  method='GET' onsubmit='show();'  enctype="multipart/form-data" >
    @if(auth()->user()->role != "Auditee")
    
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                        <div class="row">
                            {{-- @if(auth()->user()->role != 'Auditee')
                            <div class="col-lg-3">
                                <label>Department</label>
                                <select name='department' class='form-control-sm form-control cat' >
                                    <option value=""></option>
                                    @foreach($departments as $department)
                                    <option value="{{$department->id}}" @if($department->id == $dept) selected @endif>{{$department->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif --}}
                            <div class="col-lg-3">
                                <label>Code</label>
                                <select name='code' class='form-control-sm form-control cat' >
                                    {{-- <option></option> --}}
                                    <option value="">All</option>
                                    @foreach($audit_plans as $code)
                                    <option value="{{$code->id}}" @if($code->id == $done_code) selected @endif>{{$code->engagement_title}} - {{$code->code}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label>Status</label>
                                <select name='status' class='form-control-sm form-control cat'   >
                                    <option value="For IAD Checking" @if($status == "For IAD Checking") selected @endif>For IAD Checking</option>
                                    <option value="Open" @if($status == "Open") selected @endif>For Auditee Uploading</option>
                                    <option value="All" @if($status == "All") selected @endif>All</option>
                                </select>
                                <input name='department' value='{{$dept}}' hidden>
                                <input name='status_report' value='{{$status_report}}' hidden>
                            </div>
                           
                            <div class="col-lg-2">
                                <button class="btn btn-primary mt-4" type="submit" id='submit'><i class="fa fa-check"></i>&nbsp;Search</button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-4">
                                <input type="text" name="search" class="form-control" placeholder="Search by Code, Title, auditor, auditee" value="{{ old('search', $searchTerm) }}">
                            </div>
                            <div class="col-lg-2">
                                <select name='limit' class='form-control-sm form-control cat' placeholder='Limit'  required>
                                    <option value="ALL" @if($default == "ALL") selected @endif>ALL</option>
                                    <option value="10" @if($default == "10") selected @endif>10</option>
                                    <option value="20" @if($default == "20") selected @endif>20</option>
                                    <option value="50" @if($default == "50") selected @endif>50</option>
                                    <option value="100" @if($default == "100") selected @endif>100</option>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Search</button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    
</form>
    <div class='row'>
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Action Plans
                        @if((auth()->user()->role == "Auditor") || (auth()->user()->role == "IAD Approver") || (auth()->user()->role == "Administrator"))
                       <button class="btn btn-success" data-target="#new" data-toggle="modal" type="button"><i class="fa fa-plus"></i>&nbsp;New Action Plan</button></a>
                        </h5>
                        @endif
                        &nbsp;
                        <button class="btn btn-info" onclick="fnExcelReport();" data-toggle="modal" type="button"><i class="	fa fa-cloud-download"></i>&nbsp;Excel</button>
                        </h5>
                    </div>
                    <div class="ibox-content">
    
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover " id='YTD'>
                                <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>#</th>
                                        <th>Code</th>
                                        <th>Title</th>
                                        <th>Auditor</th>
                                        <th>Auditee</th>
                                        <th>Agreed Action Plan</th>
                                        <th>Target Date</th>
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
                                                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                                                    <ul class="dropdown-menu">
                                                        @if((auth()->user()->role == "IAD Approver") || (auth()->user()->role == "Administrator"))
                                                            <li><a title='Edit Action Plan' href="#edit_action_plan{{$action_plan->id}}" data-toggle="modal">Edit</a></li>
                                                        @endif
                                                        @if(auth()->user()->role == "Auditee")
                                                            <li><a title='Update' href="#view{{$action_plan->id}}" data-toggle="modal">Upload</a></li>
                                                            <li><a title='View' href="#view_history{{$action_plan->id}}" data-toggle="modal">View</a></li>
                                                        @else
                                                            <li><a title='Update' href="#view{{$action_plan->id}}" data-toggle="modal">Upload</a></li>
                                                            <li><a title='Change Target Date' href="#change{{$action_plan->id}}" data-toggle="modal">Change Target Date</a></li>
                                                            <li><a title='Return Action Plan' href="#return{{$action_plan->id}}" data-toggle="modal">Return Action Plan</a></li>
                                                            @if($action_plan->attachment == null)
                                                            @elseif($action_plan->iad_status == "Returned")
                                                            @else
                                                            <li><a title='Closed Action Plan' href="#closed{{$action_plan->id}}" data-toggle="modal">Close Action Plan</a></li>
                                                            @endif
                                                            <li><a title='View' href="#view_history{{$action_plan->id}}" data-toggle="modal">View</a></li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </td>
                                            <td>AP-{{$action_plan->id}}</td>
                                            <td><small>{{$action_plan->audit_plan->code}}</small></td>
                                            <td><small>{{$action_plan->audit_plan->engagement_title}}</small></td>
                                            <td><small>@if($action_plan->observation){{$action_plan->observation->created_by_user->name}} @else @if($action_plan->auditor_data){{$action_plan->auditor_data->name}} @endif @endif</small></td>
                                            <td><small>{{$action_plan->user->name}}</small></td>
                                            <td><small>{!! nl2br(e($action_plan->action_plan)) !!}</small></td>
                                            <td @if($action_plan->target_date < date('Y-m-d')) class='bg-danger' @endif>{{$action_plan->target_date}}</td>
                                            <td>@if($action_plan->immediate == 1) Correction or Immediate Action @else Corrective Action Plan @endif</td>
                                            <td>
                                                @if($action_plan->attachment == null)
                                                <span class='text-danger'>No Proof</span>
                                                @else
                                                <a href='{{url($action_plan->attachment)}}' target='_blank'><i class='fa fa-file-pdf-o'></i></a>
                                                @endif
                                            </td>
                                            <td>
                                                @if($action_plan->attachment == null)  For Auditee Uploading
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
    
                        <!-- Pagination links -->
                        <div class="mt-3">
                            {{ $action_plans->appends(request()->only(['search', 'code', 'status','department','limit','status_report']))->links() }} <!-- This will display the pagination links -->
                        </div>
    
                    </div>
                </div>
            </div>
        </div>
@include('new_action_plan')
@foreach($action_plans as $action_plan)
    @include('edit_action_plan')
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
<script>
    function fnExcelReport() {
    var tab_text = "<table border='2px'><tr bgcolor='#87AFC6'>";
    var j = 0;
    var tab = document.getElementById('YTD'); // id of table

    for (j = 0; j < tab.rows.length; j++) {
        tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
        //tab_text=tab_text+"</tr>";
    }

    tab_text = tab_text + "</table>";
    tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
    tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

    var msie = window.navigator.userAgent.indexOf("MSIE ");

    // If Internet Explorer
    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
        txtArea1.document.open("txt/html", "replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus();

        sa = txtArea1.document.execCommand("SaveAs", true, "Download.xls");
    } else {
        // other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
    }

    return sa;
}
</script>
@endsection
