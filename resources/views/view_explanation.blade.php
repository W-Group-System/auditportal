<div class="modal fade" id="view{{$observation->id}}" tabindex="-1" aria-labelledby="addIncome" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >ACR <label class='label label-danger'>{{$observation->status}}</span></h5>
                    </div>
                    <form method='post' action='{{url('explanation/'.$observation->id)}}' onsubmit='show();' class="form-horizontal"  enctype="multipart/form-data" >
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
                        <div class="row">
                            <div class='col-md-12'>
                                <b>PART 2. DEPARTMENT'S RESPONSE(S)</b>
                            </div>
                            <div class='col-md-12'>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th style='width:50%'>Explanation:</th>
                                            <th style='width:50%'>Cause:</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style='width:50%'><textarea class='form-control'  rows="6" cols="100" name='explanation' required></textarea></td>
                                            <td style='width:50%'><textarea class='form-control'  rows="6" cols="100" name='cause' required></textarea></td>
                                        </tr>
                                        <tr>
                                            <th colspan='2'>Correction or Immediate Action<br><small><i>(Immediate response to temporarily address the cause of observation within
                                                24 hours turn-around time)</i></small></th>
                                        </tr>
                                        <tr>
                                            <td>
                                                <textarea class='form-control' name='immediate_action'  rows="6" cols="100" required placeholder="Correction or Immediate Action"></textarea> </td>
                                                <td>
                                                <div class='form-group'>
                                                    <label class='col-sm-6 control-label text-left'>Other Party(ies) Involved :</label>
                                                    <div class="col-sm-6">
                                                        <select name='other_parties_immediate_action[]' disabled data-placeholder="Other Party(ies) Involved (optional)" class='form-control form-control-sm cat' multiple >
                                                            <option value=''></option>
                                                            @foreach($departments as $department)
                                                                <option value='{{$department->id}}'>{{$department->code}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                 <div class='form-group text-left'>
                                                    <label class='col-sm-6 control-label text-left'>Upload Proof <i>(optional)</i>:</label>
                                                    <div class="col-sm-6">
                                                        <input name='supporting_documents_immediate_action' class='form-control form-control-sm' type='file' >
                                                    </div>
                                                </div>
                                                 <div class='form-group text-left'>
                                                    <label class='col-sm-6 control-label text-left'>Date Completed :</label>
                                                    <div class="col-sm-6">
                                                        <input name='date_completed' class='form-control form-control-sm' max='{{date('Y-m-d',strtotime("+7 day", strtotime(date("Y-m-d"))))}}' type='date' required >
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th colspan='2'>Corrective Action Plan<br>
                                                <small><i>(Controls that, if will be in place, may prevent the occurrence of the
                                                    same observation)</i></small></th>
                                        </tr>
                                        <tr>
                                            
                                            <td>
                                                <textarea class='form-control' name='action_plan'  rows="6" cols="100" required placeholder='Corrective Action Plan'></textarea> </td>
                                                <td>
                                                <div class='form-group text-left'>
                                                    <label class='col-sm-6 control-label text-left'>Other Party(ies) Involved :</label>
                                                    <div class="col-sm-6">
                                                        <select name='other_parties_action_plan[]' disabled data-placeholder="Other Party(ies) Involved (optional)" class='form-control form-control-sm cat' multiple >
                                                            <option value=''></option>
                                                            @foreach($departments as $department)
                                                                <option value='{{$department->id}}'>{{$department->code}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class='form-group text-left'>
                                                    <label class='col-sm-6 control-label text-left'>Upload Proof <i>(optional)</i></label>
                                                    <div class="col-sm-6">
                                                        <input name='supporting_documents' class='form-control form-control-sm' type='file' >
                                                    </div>
                                                </div>
                                                <div class='form-group text-left'>
                                                    <label class='col-sm-6 control-label text-left'>Target Completion :</label>
                                                    <div class="col-sm-6">
                                                        <input name='date_complete' class='form-control form-control-sm' max='{{date('Y-m-d',strtotime("+1 month", strtotime(date("Y-m-d"))))}}' type='date' required >
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                          
                        </div>
                    </div> 
                    <div class="modal-footer">
                        @if(Route::current()->getName() == 'for-explanation')
                        <button type='submit'  class="btn btn-primary">Submit</button>
                        @endif
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    </form>
            </div>
        </div>
</div>