@extends('layouts.header')
@section('css')
@endsection
@section('content')
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                  <h3 class="font-weight-bold">Welcome {{auth()->user()->name}}</h3>
                </div>
              </div>
            </div>
          </div>
        <div class="row">
            <div class="col-md-3 mb-4 stretch-card transparent">
                <div class="card card-tale">
                    <div class="card-body">
                    <p class="mb-4">Open Engagements</p>
                    <p class="fs-30 mb-2">2</p>
                    <p>10.00% (30 days)</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4 stretch-card transparent">
                <div class="card card-dark-blue">
                    <div class="card-body">
                    <p class="mb-4">Open Findings</p>
                    <p class="fs-30 mb-2">10</p>
                    <p>22.00% (30 days)</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4  stretch-card transparent">
                <div class="card card-light-blue">
                    <div class="card-body">
                    <p class="mb-4">Action Plans not Due</p>
                    <p class="fs-30 mb-2">5</p>
                    <p>2.00% (30 days)</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4 stretch-card transparent">
                <div class="card card-light-danger">
                    <div class="card-body">
                        <p class="mb-4">Action Plans Due</p>
                        <p class="fs-30 mb-2">3</p>
                        <p>0.22% (30 days)</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                   <div class="d-flex justify-content-between">
                    <p class="card-title">Findings Report</p>
                   </div> <div id="sales-legend" class="chartjs-legend mt-4 mb-2"></div>
                    <canvas id="sales-chart"></canvas>
                  </div>
                </div>
            </div>
            <div class="col-md-5 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <p class="card-title mb-0">Latest Update</p>
                    <div class="table-responsive">
                      <table class="table table-striped table-borderless">
                        <thead>
                          <tr>
                            <th>Department</th>
                            <th>Engagements</th>
                            <th>Findings</th>
                            <th>Action Plans</th>
                          </tr>  
                        </thead>
                        <tbody>
                          <tr>
                            <td>HRD</td>
                            <td>3</td>
                            <td>5</td>
                            <td >0</td>
                          </tr>
                          <tr>
                            <td>IT</td>
                            <td>1</td>
                            <td>1</td>
                            <td >1</td>
                          </tr>
                          <tr>
                            <td>SALES</td>
                            <td>1</td>
                            <td>7</td>
                            <td >0</td>
                          </tr>
                          <tr>
                            <td>LEGAL</td>
                            <td>1</td>
                            <td>7</td>
                            <td>0</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
        </div>
      </div>
    </div>
@endsection

@section('js')
<script>
    var audit_plans = [];
</script>  
<script src="{{ asset('js/jquery.cookie.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/dashboard.js') }}"></script>
<script src="{{ asset('js/todolist.js') }}"></script>
<script src="{{ asset('js/Chart.roundedBarCharts.js') }}"></script>

<script src="{{ asset('vendors/chart.js/Chart.min.js') }}"></script>
<script src="{{asset('vendors/moment/moment.min.js')}}"></script>
<script src="{{asset('js/calendar.js')}}"></script>
@endsection