<div class="modal fade" id="view{{$observation->id}}" tabindex="-1" aria-labelledby="addIncome" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >ACR <label class='label label-danger'>{{$observation->status}}</span></h5>
                    </div>
                    <form method='post' action='{{url('for-verification-acr/'.$observation->id)}}' onsubmit='show();' class="form-horizontal"  enctype="multipart/form-data" >
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
                                            <td style='width:50%'><textarea class='form-control'  rows="6" cols="100" name='explanation' readonly>{{nl2br(e($observation->explanation->explanation))}}</textarea></td>
                                            <td style='width:50%'><textarea class='form-control'  rows="6" cols="100" name='cause' readonly>{{nl2br(e($observation->explanation->cause))}}</textarea></td>
                                        </tr>
                                        <tr>
                                            <th colspan='2'>Correction or Immediate Action<br><small><i>(Immediate response to temporarily address the cause of observation within
                                                24 hours turn-around time)</i></small></th>
                                        </tr>
                                        @foreach(($observation->action_plans)->where('immediate','!=',null) as $key => $action_plan)
                                        <tr>
                                            <td>
                                                <textarea class='form-control' name='immediate_action[{{$action_plan->id}}]'  rows="6" cols="100" required placeholder="Correction or Immediate Action">{{nl2br(e($action_plan->action_plan))}}</textarea> </td>
                                                <td>
                                                <div class='form-group'>
                                                    <label class='col-sm-6 control-label text-left'>Other Party(ies) Involved :</label>
                                                    <div class="col-sm-6">
                                                        <select name='other_parties_immediate_action[{{$action_plan->id}}][]' data-placeholder="Other Party(ies) Involved (optional)" class='form-control form-control-sm cat' multiple >
                                                            <option value=''></option>
                                                            @foreach($departments as $department)
                                                                <option value='{{$department->id}}' @if(count(($action_plan->teams)->where('department_id',$department->id)) == 1) selected @endif>{{$department->code}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                 <div class='form-group text-left'>
                                                    <label class='col-sm-6 control-label text-left'>Upload Proof <i>(optional)</i>:</label>
                                                    <div class="col-sm-6">
                                                        @if($action_plan->attachment == null)
                                                        <span class='text-danger'>No Proof</span>
                                                        @else
                                                        <a href='{{url($action_plan->attachment)}}' target='_blank'><i class='fa fa-file-pdf-o'> Proof</i></a>
                                                        @endif
                                                        {{-- <input name='supporting_documents_immediate_action[{{$action_plan->id}}]' class='form-control form-control-sm' type='file' > --}}
                                                    </div>
                                                </div>
                                                 <div class='form-group text-left'>
                                                    <label class='col-sm-6 control-label text-left'>Date Completed :</label>
                                                    <div class="col-sm-6">
                                                        <input name='date_completed[{{$action_plan->id}}]' class='form-control form-control-sm' value='{{$action_plan->date_completed}}'  type='date' required >
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <th colspan='2'>Corrective Action Plan<br>
                                                <small><i>(Controls that, if will be in place, may prevent the occurrence of the
                                                    same observation)</i></small></th>
                                        </tr>
                                        @foreach(($observation->action_plans)->where('immediate',null) as $action_plan)
                                        <tr>
                                            
                                            <td>
                                                <textarea class='form-control' name='action_plan[{{$action_plan->id}}]'  rows="6" cols="100" required placeholder='Corrective Action Plan'>{{nl2br(e($action_plan->action_plan))}}</textarea> </td>
                                                <td>
                                                <div class='form-group text-left'>
                                                    <label class='col-sm-6 control-label text-left'>Other Party(ies) Involved :</label>
                                                    <div class="col-sm-6">
                                                        <select name='other_parties_action_plan[{{$action_plan->id}}][]' data-placeholder="Other Party(ies) Involved (optional)" class='form-control form-control-sm cat' multiple >
                                                            <option value=''></option>
                                                            @foreach($departments as $department)
                                                                <option value='{{$department->id}}' @if(count(($action_plan->teams)->where('department_id',$department->id)) == 1) selected @endif>{{$department->code}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class='form-group text-left'>
                                                    <label class='col-sm-6 control-label text-left'>Upload Proof <i>(optional)</i></label>
                                                    <div class="col-sm-6">
                                                        @if($action_plan->attachment == null)
                                                        <span class='text-danger'>No Proof</span>
                                                        @else
                                                        <a href='{{url($action_plan->attachment)}}' target='_blank'><i class='fa fa-file-pdf-o'>Proof</i></a>
                                                        @endif
                                                        {{-- <input name='supporting_documents[{{$action_plan->id}}]' class='form-control form-control-sm' type='file' > --}}
                                                    </div>
                                                </div>
                                                <div class='form-group text-left'>
                                                    <label class='col-sm-6 control-label text-left'>Target Completion :</label>
                                                    <div class="col-sm-6">
                                                        <input name='date_complete[{{$action_plan->id}}]' class='form-control form-control-sm' value='{{$action_plan->target_date}}'  type='date' required >
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                          
                        </div>
                        <div class="row">
                            <div class='col-md-6'>
                                <b>Prepared By : {{$observation->explanation->user->name}}</b>
                            </div>
                            <div class='col-md-6'>
                                <b>Reviewed By : {{$observation->explanation->user->name}}</b>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-md-4'>
                                Action :
                                <select name='action' class='form-control-sm form-control cat' required>
                                    <option value="" ></option>
                                    <option value="Verify" >Verify</option>
                                </select>
                            </div>
                            <div class='col-md-4'>
                                Type :
                                <select name='type' class='form-control-sm form-control cat' required>
                                    <option value="" ></option>
                                    <option value="Findings" >Findings</option>
                                    <option value="Observation" >Observation</option>
                                </select>
                            </div>
                            <div class='col-md-4'>
                                Remarks :
                                <textarea name='remarks' class='form-control-sm form-control' required></textarea>
                            </div>
                        </div>
                    </div> 
                    <div class="modal-footer">
                        <button type='submit'  class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    </form>
            </div>
        </div>
</div>