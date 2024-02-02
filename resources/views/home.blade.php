@extends('layouts.header')
@section('css')

<link href="{{ asset('login_css/css/plugins/c3/c3.min.css') }}" rel="stylesheet">
<link href="{{ asset('login_css/css/plugins/morris/morris-0.4.3.min.css') }}" rel="stylesheet">
@endsection
@section('content')
@if(auth()->user()->role != "Auditee")
<div class="row">
  <div class="col-lg-3">
      <div class="ibox float-e-margins">
          <div class="ibox-title">
              <span class="label label-success pull-right">as of Today</span>
              <h5>Total Engagements</h5>
          </div>
          <div class="ibox-content">
              <h1 class="no-margins">{{count($audits)}}</h1>
              {{-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> --}}
              <small>&nbsp;</small>
          </div>
      </div>
  </div>
  <div class="col-lg-3">
      <div class="ibox float-e-margins">
          <div class="ibox-title">
              <span class="label label-success pull-right">as of Today</span>
              <h5>Open Findings</h5>
          </div>
          <div class="ibox-content">
              <h1 class="no-margins">{{count($reports->where('findings','!=',null)->where('status','On-going'))}}</h1>
              {{-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> --}}
              <small>&nbsp;</small>
          </div>
      </div>
  </div>
  <div class="col-lg-3">
      <div class="ibox float-e-margins">
          <div class="ibox-title">
              <span class="label label-success pull-right">as of Today</span>
              <h5>Delayed Action Plans</h5>
          </div>
          <div class="ibox-content">
              <h1 class="no-margins">{{count($action_plans->where('status','!=','Closed')->where('target_date','<',date('Y-m-d')))}}</h1>
              {{-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> --}}
              <small>&nbsp;</small>
          </div>
      </div>
  </div>
  <div class="col-lg-3">
      <div class="ibox float-e-margins">
          <div class="ibox-title">
              <span class="label label-success pull-right">as of this Month ({{date('M. Y')}})</span>
              <h5>Action Plans not Due</h5>
          </div>
          <div class="ibox-content">
              <h1 class="no-margins">{{count($action_plans->where('status','!=','Closed')->where('target_date','>=',date('Y-m-d')))}}</h1>
              {{-- <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div> --}}
              <small>&nbsp;</small>
          </div>
      </div>
  </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Findings Report</h5>
            </div>
            <div class="ibox-content">
                <div>
                    <div id="slineChart" ></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<div class="row">
  {{-- <div class="col-md-5 grid-margin stretch-card">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
          <h5>Action Plans Report </h5>
      </div>
      <div class="ibox-content">
          <div id="morris-bar-chart"></div>
      </div>
    </div>
  </div> --}}
    <div class="col-lg-5">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Closed as of @if((int)date('d') > 5) ({{date('F t, Y')}}) @else {{date('F t, Y',strtotime("-1 month"))}} @endif</h5>
            </div>
            <div class="ibox-content">
                <table class="table table-striped table-bordered table-hover tables">
                    <thead>
                        <tr>
                            <th>Department</th>
                            <th>Closed</th>
                            <th>Delayed</th>
                            <th>Not yet Due</th>
                            <th>Total</th>
                            <th>%</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($departments as $department)
                        @if($department->group == null)
                        <tr>
                            <td>{{$department->code}}</td>
                            <td><a @if(auth()->user()->role != "Auditee") data-toggle="modal"  href="#view{{$department->id}}" @endif>{{count(($department->action_plans)->where('action_plan','!=',"N/A")->where('status','Closed'))}}</a></td>
                            <td><a @if(auth()->user()->role != "Auditee") data-toggle="modal"  href="#view_delayed{{$department->id}}" @endif>{{count(($department->action_plans)->where('action_plan','!=',"N/A")->where('status','Verified')->where('target_date','<',date('Y-m-d')))}}</td>
                            <td><a @if(auth()->user()->role != "Auditee") data-toggle="modal"  href="#view_open{{$department->id}}" @endif>{{count(($department->action_plans)->where('action_plan','!=',"N/A")->where('status','Verified')->where('target_date','>=',date('Y-m-d')))}}</a></td>
                            <td>{{count(($department->action_plans)->where('action_plan','!=',"N/A")->where('status','!=','For Approval'))}}</td>
                            <td>@php
                                $closed = count(($department->action_plans)->where('action_plan','!=',"N/A")->where('status','Closed'));
                                $delayed = count(($department->action_plans)->where('action_plan','!=',"N/A")->where('status','Verified')->where('target_date','<',date('Y-m-d')));
                                $total = $closed + $delayed;
                                if($closed+$delayed == 0)
                                {
                                    $percent = 1;
                                }
                                else
                                {
                                    $percent = $closed/($closed+$delayed);
                                }
                                
                            @endphp
                            @if(count($department->action_plans) == 0)
                            100.00 %
                            @else
                                {{number_format($percent*100,2)}} %
                            @endif</td>
                        </tr>
                        @endif
                       
                        @endforeach
                   
                        @foreach($groups as $key => $group)
                        @php
                        $dep_grou = ($group->dep)->pluck('department_id')->toArray();
                        $close_count = 0;
                        $delayed_count = 0;
                        $open = 0;
                        $total = 0;
                        @endphp
                        <tr>
                           <td>{{$group->name}}</td>
                           <td> 
                                @foreach($departments->whereIn('id',$dep_grou) as $group_department)
                                @php
                                    $close_count = $close_count + count(($group_department->action_plans)->where('action_plan','!=',"N/A")->where('status','Closed'));
                                @endphp
                                @endforeach
                                <a @if(auth()->user()->role != "Auditee") data-toggle="modal"  href="#view_group{{$key}}" @endif>{{$close_count}}</a>
                            </td>
                           <td>
                                @foreach($departments->whereIn('id',$dep_grou) as $group_department)
                                @php
                                    $delayed_count = $delayed_count + count(($group_department->action_plans)->where('action_plan','!=',"N/A")->where('status','Verified')->where('target_date','<',date('Y-m-d')));
                                @endphp
                                @endforeach
                                <a @if(auth()->user()->role != "Auditee") data-toggle="modal"  href="#view_delayed_group{{$key}}" @endif>{{$delayed_count}}</a>
                           </td>
                           <td>
                            @foreach($departments->whereIn('id',$dep_grou) as $group_department)
                            @php
                                $open = $open + count(($group_department->action_plans)->where('action_plan','!=',"N/A")->where('status','Verified')->where('target_date','>=',date('Y-m-d')));
                            @endphp
                            @endforeach
                            <a @if(auth()->user()->role != "Auditee") data-toggle="modal"  href="#view_open_group{{$key}}" @endif>{{$open}}</a>
                           </td>
                           <td>
                            @foreach($departments->whereIn('id',$dep_grou) as $group_department)
                            @php
                                $total = $total +  count(($group_department->action_plans)->where('action_plan','!=',"N/A")->where('status','!=','For Approval'));
                            @endphp
                            @endforeach
                            {{$total}}  
                           
                           </td>
                           <td>
                            @php
                                if($close_count+$delayed_count == 0)
                                {
                                    $percent = 1;
                                }
                                else
                                {
                                    $percent = $close_count/($close_count+$delayed_count);
                                }
                            @endphp
                            @if(count($group_department->action_plans) == 0)
                            100.00 %
                            @else
                                {{number_format($percent*100,2)}} %
                            @endif
                           </td>
                        </tr>
                       @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @if(auth()->user()->role != "Auditee")
    @foreach($departments as $department)
    
    @include('view_closed')
    @include('view_dalayed')
    @include('view_open')
    @endforeach
    @foreach($groups as $key => $group)
    @php
        $dep_grou = ($group->dep)->pluck('department_id')->toArray();
    @endphp
    @include('view_closed_group')
    @include('view_delayed_group')
    @include('view_open_group')
    @endforeach
    @endif
    @if(auth()->user()->role != "Auditee")
    <div class="col-lg-5">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Activity</h5>
            </div>
            <div class="ibox-content">
                <table class="table table-striped table-bordered table-hover tables-data">
                    <thead>
                    <tr>
                        <th>User</th>
                        <th>Action</th>
                        <th>Remarks</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($remarks as $remark)
                        <tr>
                            <td>{{$remark->user->name}}</td>
                            <td>{{$remark->action}}</td>
                            <td>{{$remark->remarks}}</td>
                            <td>{{date('M d, Y h:i A',strtotime($remark->created_at))}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('js')
<script src="{{ asset('login_css/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{ asset('login_css/js/plugins/chosen/chosen.jquery.js') }}"></script>
<script src="{{ asset('login_css/js/plugins/chartJs/Chart.min.js') }}"></script>
<script>
    var audit_plans = {!! json_encode(($departmentResults)) !!};
</script>  

{{-- <script src="{{ asset('login_css/js/plugins/morris/raphael-2.1.0.min.js') }}"></script> --}}
{{-- <script src="{{ asset('login_css/js/plugins/morris/morris.js') }}"></script> --}}

<script src="{{ asset('login_css/js/plugins/d3/d3.min.js') }}"></script>
<script src="{{ asset('login_css/js/plugins/c3/c3.min.js') }}"></script>
<script >
      $(document).ready(function () {
      c3.generate({
                bindto: '#slineChart',
                data: {
                    
                x : 'x',
                columns: audit_plans,
       
        type: 'bar',
        types: {
            "Avg. Risk": 'spline',
        },
        // groups: [
        //     ['data1','data2']
        // ]
    },
    axis: {
        x: {
            show: true,
            type: 'categorized', // this is needed to load string x value
        },

        },
            });
        });


    $(document).ready(function(){
      $('.tables').DataTable({
            order: [[5, 'asc']],
            pageLength: -1 ,
            ordering: true,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                {extend: 'csv'},
            ]

        });

    });
    $(document).ready(function(){
      $('.tables-data').DataTable({
           
            pageLength: 25,
            ordering: false,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                {extend: 'csv'},
            ]

        });

    });
</script>
@endsection