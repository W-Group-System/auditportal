<div class="modal fade" id="view_open{{$department->id}}" tabindex="-1" aria-labelledby="addIncome" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" ></h5>
                    </div>
                   <div class="modal-body">  
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover tables" >
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Auditor</th>
                                    <th>Auditee</th>
                                    <th>Agreed Action Plan</th>
                                    <th>Target Date</th>
                                    <th>Date Completed</th>
                                    <th>Type</th>
                                    <th>Supporting Document</th>
                                    <th>Date Closed</th>
                                </tr>
                            </thead>
                        <tbody>
                            @foreach(($department->action_plans)->where('action_plan','!=',"N/A")->where('status','Verified')->where('target_date','>=',date('Y-m-d')) as $action_plan)
                                <tr>
                                    <td><small>{{$action_plan->audit_plan->code}}</small></td>
                                    <td><small>@if($action_plan->observation){{$action_plan->observation->created_by_user->name}} @else @if($action_plan->auditor_data){{$action_plan->auditor_data->name}} @endif @endif</small></td>
                                    <td><small>{{$action_plan->user->name}}</small></td>
                                    <td><small>{!! nl2br(e($action_plan->action_plan)) !!}</small></td>
                                    <td>{{$action_plan->target_date}}</td>
                                    <td>{{$action_plan->date_completed}}</td>
                                    <td>@if($action_plan->immediate == 1) Correction or Immediate Action @else Corrective Action Plan @endif</td>
                                    <td>
                                        @if($action_plan->attachment == null)
                                        <span class='text-danger'>No Proof</span>
                                        @else
                                        <a href='{{url($action_plan->attachment)}}' target='_blank'><i class='fa fa-file-pdf-o'></i></a>
                                        @endif
                                    </td>
                                    <td>
                                        {{date('M. d, Y',strtotime($action_plan->updated_at))}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
           
                      
                    </div> 
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    </form>
            </div>
        </div>
</div>