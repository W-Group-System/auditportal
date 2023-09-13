@extends('layouts.header')
@section('css')
<link href="{{ asset('login_css/css/plugins/fullcalendar/fullcalendar.css') }}" rel="stylesheet">
<link href="{{ asset('login_css/css/plugins/fullcalendar/fullcalendar.print.css') }}" rel='stylesheet' media='print'>
<link href="{{ asset('login_css/css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">

@endsection
@section('content')
<div class="row">
  <div class="col-lg-3">
      <div class="ibox float-e-margins">
          <div class="ibox-title">
              <span class="label label-success pull-right">this {{date('M Y')}}</span>
              <h5>Schedule</h5>
          </div>
          <div class="ibox-content">
              <h1 class="no-margins">{{count($schedule_month)}}</h1>
              {{-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> --}}
              <small>&nbsp;</small>
          </div>
      </div>
  </div>
  <div class="col-lg-3">
      <div class="ibox float-e-margins">
          <div class="ibox-title">
              <span class="label label-success pull-right">this {{date('M Y')}}</span>
              <h5>Done</h5>
          </div>
          <div class="ibox-content">
              <h1 class="no-margins">{{count($schedule_month->where('status','Done'))}}</h1>
              {{-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> --}}
              <small>&nbsp;</small>
          </div>
      </div>
  </div>
  <div class="col-lg-3">
      <div class="ibox float-e-margins">
          <div class="ibox-title">
              <span class="label label-success pull-right">this {{date('M Y')}}</span>
              <h5>Pending</h5>
          </div>
          <div class="ibox-content">
              <h1 class="no-margins">{{count($schedule_month->where('status',null))}}</h1>
              {{-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> --}}
              <small>&nbsp;</small>
          </div>
      </div>
  </div>
  <div class="col-lg-3">
      <div class="ibox float-e-margins">
          <div class="ibox-title">
              <span class="label label-success pull-right">({{date('M. d, Y')}})</span>
              <h5>Schedule Today</h5>
          </div>
          <div class="ibox-content">
              <h1 class="no-margins">{{count($schedule_month->where('audit_from','<=',date('Y-m-d'))->where('audit_to','>=',date('Y-m-d')))}}</h1>
              {{-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> --}}
              <small>&nbsp;</small>
          </div>
      </div>
  </div>
</div>
<div class='row'>
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <form method='GET' onsubmit='show();' enctype="multipart/form-data">
                    <div class='row'>
                        <div class="col-lg-3">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-right text-white">Select Month</label>
                                <div class="col-sm-8">
                                    <input class='form-control-sm form-control' name='month' value='{{$month}}'  type='month' required>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <button type="submit" class="btn btn-primary col-sm-3 col-lg-3 col-md-3">Search</button>
                        </div>
                    </div>
                </form> 
            </div>
        </div>
    </div>
</div>
<div class='row'>
    <div class="col-lg-8">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                        <h5>Audit Plans 
                            @if(count($uploads) > 0) 
                            <button class="btn btn-success "  data-target="#newScheduleSpecial" data-toggle="modal" type="button"><i class="fa fa-plus"></i>&nbsp;</button>
                            @else
                            <button class="btn btn-success "  data-target="#newSchedule" data-toggle="modal" type="button"><i class="fa fa-plus"></i>&nbsp;</button>
                            <a href='{{url('monthly-report?month='.$month)}}' target='_blank' > <button class="btn btn-danger "  data-toggle="modal" type="button"><i class="fa fa-print"></i>&nbsp;</button></a></h5>
                          
                            @endif
                             {{-- <button class="btn btn-success "  data-target="#uploadDocument" data-toggle="modal" type="button"><i class="fa fa-plus"></i>&nbsp;New Engagement</button></h5> --}}
             
            </div>
            <div class="ibox-content">

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover tables" >
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Audit Task/Procedures</th>
                                <th>Period Cover</th>
                                <th>Company</th>
                                <th>Assigned Auditor</th>
                                <th>Deadline</th>
                            </tr>
                        </thead>
                    <tbody>
                        @foreach($schedule_month as $schedule)
                            <tr>
                                <td>
                                    @if(count($uploads) > 0)
                                    <a href="{{url('view-calendar/'.$schedule->id)}}" class='btn btn-sm btn-info'><i class="fa fa-eye"></i></a>
                                    @else
                                    <button class="btn btn-sm btn-info"  title='Edit' data-target="#editSchedule{{$schedule->id}}" data-toggle="modal"><i class="fa fa-edit"></i></button>
                                    @endif
                                </td>
                                <td>{{$schedule->engagement_title}}</td>
                                <td>{{$schedule->scope}}</td>
                                <td>@foreach($schedule->companies as $company) {{$company->company->code}} /@endforeach</td>
                                <td>@foreach($schedule->auditor_data as $auditor) {{$auditor->user->name}} <br>@endforeach</td>
                                <td>{{date('M. d, Y',strtotime($schedule->audit_to))}}</td>
                            </tr>
                        @include('edit_schedule')
                        @endforeach
                        
                    </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Uploaded Signed <button class="btn btn-success "  data-target="#upload" data-toggle="modal" type="button"><i class="fa fa-plus"></i>&nbsp;Upload</button></h5>
            </div>
            <div class="ibox-content">
                <table class="table table-striped table-bordered table-hover tables">
                    <thead>
                      <tr>
                          <th>Month</th>
                          <th>File</th>
                          <th>Uploaded By</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($uploads as $upload)
                        <tr>
                            <td>{{date('F Y',strtotime($upload->month))}}</td>
                            <td><a href="{{url($upload->file)}}" target='_blank'><i class='fa fa-file'></i></a></td>
                            <td>{{$upload->user->name}}</td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                    
                </table>
            </div>
        </div>
      </div>

</div>
@include('upload_monthly')
{{-- <div class="row">
  <div class="col-md-9 grid-margin stretch-card">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
          <h5>Audit Schedule <button class="btn btn-success "  data-target="#newSchedule" data-toggle="modal" type="button"><i class="fa fa-plus"></i>&nbsp;New Schedule</button></h5>
        </h5>
      </div>
        <div class="ibox-content">
            <div id="calendar"></div>
        </div>
    </div>
  </div>
  <div class="col-lg-3">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Schedule Today</h5>
        </div>
        <div class="ibox-content">
            <table class="table table-striped table-bordered table-hover tables">
                <thead>
                  <tr>
                      <th>Code</th>
                      <th>Department</th>
                      <th>Auditor</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($engagements->where('audit_from','<=',date('Y-m-d'))->where('audit_to','>=',date('Y-m-d')) as $engagement)
                    <tr>
                        <td>{{$engagement->code}}</td>
                        <td>{{$engagement->department->department_name->code}}</td>
                        <td>{{$engagement->engagement_title}}</td>
                    </tr>
                    @endforeach
                </tbody>
                
            </table>
        </div>
    </div>
  </div>
</div> --}}
@include('new_audit')
@include('new_audit_special')
@endsection

@section('js')
<script src="{{ asset('login_css/js/plugins/fullcalendar/moment.min.js')}}"></script>
<script src="{{ asset('login_css/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{ asset('login_css/js/plugins/chosen/chosen.jquery.js') }}"></script>
<script src="{{ asset('login_css/js/plugins/chartJs/Chart.min.js') }}"></script>

<script src="{{ asset('login_css/js/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
<script >

    $(document).ready(function(){

        var audit_plans = {!!json_encode($schedule_month->toArray()) !!};
        $('.cat').chosen({width: "100%"});
      $('.tables').DataTable({
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            bInfo : false,
            buttons: [
                
            ]

        });
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var events = [];
        for(var i = 0;i < audit_plans.length ;i++)
        {
            var info = {};
                info.title = audit_plans[i].engagement_title;
                info.start = new Date(audit_plans[i].audit_from);
                info.end = new Date(audit_plans[i].audit_to);
                if(audit_plans[i].status == null)
                {
                    info.color = '#378006';
                }
                else
                {
                    info.color = '#f44336';
                }
                events.push(info);

        }
        // console.log();
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month'
            },
            editable: false,
            displayEventTime: false,
            droppable: false, // this allows things to be dropped onto the calendar
            drop: function() {
                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    $(this).remove();
                }
            },
            events: events
        });


    });
</script>
@endsection