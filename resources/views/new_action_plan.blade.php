<div class="modal fade" id="new" tabindex="-1" aria-labelledby="addIncome" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >Action Plan <label class='label label-danger'></span></h5>
                </div>
                <form method="post" action="{{url('new-action-plan')}}" onsubmit='show();' class="form-horizontal"  enctype="multipart/form-data" >
                <div class="modal-body">             
                    @csrf
                    <div class='row'>
                        <div class='col-md-6'>
                            Audit Plan:
                            <select name='audit_plan' class='form-control-sm form-control cat' required >
                                <option value=""></option>
                                @foreach($audit_plans as $audit_plan)
                                    <option value='{{$audit_plan->id}}'>{{$audit_plan->code}} - {{$audit_plan->engagement_title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class='col-md-6'>
                            ACR :
                            <select name='acr' class='form-control-sm form-control cat'  >
                                <option value=""></option>
                                @foreach($acrs as $acr)
                                    <option value='{{$acr->id}}'>{{$acr->code}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-12'>
                            Findings:
                            <textarea class='form-control' name='findings'  rows="6" cols="100" required placeholder='Findings'></textarea>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-12'>
                            Action Plan:
                            <textarea class='form-control' name='action_plan'  rows="6" cols="100" required placeholder='Agreed Action Plan'></textarea>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-4'>
                            Auditee:
                            <select name='auditee[]' class='form-control-sm form-control cat' multiple required  >
                                <option value=""></option>
                                @foreach($users->where('role','Auditee') as $user)
                                    <option value='{{$user->id}}'>{{$user->name}} - {{$user->department->code}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class='col-md-4'>
                            Auditor :
                            <select name='auditor' class='form-control-sm form-control cat' >
                                <option value=""></option>
                                @foreach($users->where('role','Auditor') as $user)
                                    <option value='{{$user->id}}'>{{$user->name}} - {{$user->department->code}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class='col-md-4'>
                            Type:
                            <select name='type' class='form-control-sm form-control cat'  required>
                                <option value=""></option>
                                <option value="Corrective Action Plan">Corrective Action Plan</option>
                                <option value="Correction or Immediate Action">Correction or Immediate Action</option>
                            </select>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-4'>
                            Target Date:
                            <input name='target_date' class='form-control form-control-sm' type='date' required >
                        </div>
                        <div class='col-md-4'>
                           Status:
                           <select class='form-control' name='status' required>
                                <option value='Verified'>Open</option>
                                <option value='Closed'>Close</option>
                            </select>
                        </div>
                        <div class='col-md-4'>
                           File (optional):
                           <!-- <input type="file" class="form-control-sm form-control" name="file" /> -->
                           <input name='file[]' class='form-control form-control-sm' type='file' multiple accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
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