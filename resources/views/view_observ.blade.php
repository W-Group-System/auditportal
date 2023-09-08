<div class="modal fade" id="view{{$observation->id}}" tabindex="-1" aria-labelledby="addIncome" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >ACR <label class='label label-danger'>{{$observation->status}}</span></h5>
                    </div>
                    <form method='post' action='{{url('action-acr/'.$observation->id)}}' onsubmit='show();' class="form-horizontal"  enctype="multipart/form-data" >
                    <div class="modal-body">             
                        @csrf
                        <div class="row">
                            <div class='col-md-6 '>
                                Date Discovered  :  {{date('M. d, Y',strtotime($observation->date_audit))}}
                            </div>
                            <div class='col-md-6'>
                                Date Prepared  : {{date('M. d, Y',strtotime($observation->created_at))}}
                            </div>
                            <div class='col-md-6'>
                                Department/Position  : {{$observation->user->department->code}} / {{$observation->user->position}}
                            </div>
                            <div class='col-md-6'>
                               
                                ACR Code  : {{$observation->code}}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class='col-md-12'>
                                <b>PART 1. INTERNAL AUDIT OBSERVATION(S)</b>
                            </div>
                            <div class='col-md-12'>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Condition/ Details of Observation:</th>
                                            <th>Criteria/ Standards:</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{!!$observation->observation!!}</td>
                                            <td>{{$observation->criteria}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class='col-md-12'>
                                <b>Risk Implication(s) : <br>{{$observation->risk_implication}}</b>
                            </div>
                            <hr>
                            <div class='col-md-4'>
                                <b>Consequence :</b> <br>{{$observation->consequence}}
                            </div>
                            <div class='col-md-4'>
                                <b>Likelihood :</b><br> {{$observation->likelihood}}
                            </div>
                            <div class='col-md-4'>
                                <b>Overall Risk : </b><br> {{$observation->overall_risk}}
                            </div>
                            <hr>
                          
                        </div>
                        <hr>
                        <div class="row">
                            <div class='col-md-12'>
                                <b>Auditee : {{$observation->user->name}}</b>
                            </div>
                            <div class='col-md-6'>
                                <b>Issued By : {{$observation->created_by_user->name}} - {{date('Y-m-d',strtotime($observation->created_at))}}</b>
                            </div>
                            <div class='col-md-6'>
                                @php
                                    $approver = ($observation->histories)->where('action','IAD Approved')->first();
                                    $approver_declined = ($observation->histories)->where('action','Declined')->first();
                                @endphp
                                @if($observation->status == "Declined")
                                    <b>Declined by : @if($approver_declined)<span class='label label-danger'> {{$approver_declined->user->name}} - {{date('Y-m-d',strtotime($approver_declined->created_at))}} <span>@endif</b>
                                @else
                                    <b>Approved by : @if($approver){{$approver->user->name}} - {{date('Y-m-d',strtotime($approver->created_at))}} @else <span class='label label-danger'>For Approval</span>@endif</b>
                                @endif
                            </div>
                        </div>
                        <hr>
                        @if(Route::current()->getName() == 'for-approval-iad')
                        <div class='row'>
                            <div class='col-md-4'>
                                Action :
                                <select name='action' class='form-control-sm form-control cat' required>
                                    <option value=""></option>
                                    <option value="Approved" >Approve</option>
                                    <option value="Declined" >Decline</option>
                                </select>
                            </div>
                            <div class='col-md-8'>
                                Remarks :
                                <textarea name='remarks' class='form-control-sm form-control' required></textarea>
                            </div>
                        </div>
                        @endif
                        @if($observation->status == "On-going")
                        <div class='row'>
                            <div class='col-md-12'>
                                <div class="panel panel-danger">
                                    <div class="panel-heading">
                                        No Explanation Submitted
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div> 
                    <div class="modal-footer">
                        @if(Route::current()->getName() == 'for-approval-iad')
                        <button type='submit'  class="btn btn-primary">Submit</button>
                        @endif
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    </form>
            </div>
        </div>
</div>