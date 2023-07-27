@extends('layouts.header')
@section('css')
@endsection
@section('content')
<div class="main-panel">
    <div class="content-wrapper">

        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Companies</h4>
                    <p class="card-description">
                        <button type="button" class="btn btn-outline-success btn-icon-text" data-toggle="modal" data-target="#newCompany">
                            <i class="ti-plus btn-icon-prepend"></i>
                            New Company
                        </button>
                    </p>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered tablewithSearch">
                            <thead>
                                <tr>
                                    <th>Company Icon</th>
                                    <th>Company Name</th>
                                    <th>Company Code</th>
                                    <th>Date Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($companies as $company)
                                {{-- {{dd($company->logo)}} --}}
                                    <tr>
                                        <td class="py-1"><img src="{{ url($company->icon) }}" class="img-sm me-3 " alt="image">
                                        </td>
                                        <td>{{ $company->name }}</td>
                                        <td>{{ $company->code }}</td>
                                        <td>{{ date('M d Y ', strtotime($company->created_at)) }}</td>
                                        <td id="tdActionId{{ $company->id }}" data-id="{{ $company->id }}">
                                            @if($company->status == "")
                                            <button type="button" id="edit{{ $company->id }}" class="btn btn-info btn-rounded btn-icon"
                                                data-target="#edit_allowance{{ $company->id }}" data-toggle="modal" title='Edit'>
                                                <i class="ti-pencil-alt"></i>
                                            </button>
                                            <button title='Disable' id="{{ $company->id }}" onclick="disable(this.id)"
                                                class="btn btn-rounded btn-danger btn-icon">
                                                <i class="fa fa-ban"></i>
                                            </button>
                                            @else
                                            <button title='Activate' id="{{ $company->id }}" onclick="activate(this.id)"
                                                class="btn btn-rounded btn-primary btn-icon">
                                                <i class="fa fa-check"></i>
                                            </button>
                                            @endif
                                        </td>
                                        
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
@endsection