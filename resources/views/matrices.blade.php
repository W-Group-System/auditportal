@extends('layouts.header')
@section('css')
@endsection
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-lg-4 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Consequences <button type="button" class="btn btn-outline-success btn-icon-text btn-sm">New                          
            </button></h4>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Label</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($consequences as $consequence)
                    <tr>
                        <td>{{$consequence->number}}</td>
                        <td>{{$consequence->name}}</td>
                        <td><button type="button" class="btn btn-outline-secondary btn-icon-text btn-sm">Edit                          
                          </button></td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Likelihood <button type="button" class="btn btn-outline-success btn-icon-text btn-sm">New                          
            </button></h4>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Label</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($likelihoods as $likelihood)
                    <tr>
                        <td>{{$likelihood->number}}</td>
                        <td>{{$likelihood->name}}</td>
                        <td><button type="button" class="btn btn-outline-secondary btn-icon-text btn-sm">Edit                          
                          </button></td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-lg-4 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Matrix <button type="button" class="btn btn-outline-success btn-icon-text btn-sm">New                          
              </button></h4>
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Range</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($matrices as $matrice)
                      <tr>
                          <td>{{$matrice->name}}</td>
                          <td>{{$matrice->from}} to {{$matrice->to}}</td>
                          <td><button type="button" class="btn btn-outline-secondary btn-icon-text btn-sm">Edit                          
                            </button></td>
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
    <!-- content-wrapper ends -->
    <!-- partial:../../partials/_footer.html -->
    <!-- partial -->
  </div>
@endsection

@section('js')
@endsection