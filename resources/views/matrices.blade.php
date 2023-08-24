@extends('layouts.header')
@section('css')
@endsection
@section('content')
<div class="row">
  <div class="col-lg-4">
      <div class="ibox float-e-margins">
          <div class="ibox-title">
              <h5>Consequences</h5>
          </div>
          <div class="ibox-content">
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Label</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($consequences as $consequence)
                  <tr>
                      <td>{{$consequence->number}}</td>
                      <td>{{$consequence->name}}</td>
                  </tr>
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
              <h5>Likelihood</h5>
          </div>
          <div class="ibox-content">
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Label</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($likelihoods as $likelihood)
                  <tr>
                      <td>{{$likelihood->number}}</td>
                      <td>{{$likelihood->name}}</td>
                  </tr>
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
              <h5>Matrix </h5>
          </div>
          <div class="ibox-content">
           
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Range</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($matrices as $matrice)
                  <tr>
                      <td>{{$matrice->name}}</td>
                      <td>{{$matrice->from}} - {{$matrice->to}}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
      </div>
  </div>
</div>
@endsection

@section('js')
@endsection