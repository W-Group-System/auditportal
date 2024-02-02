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
                                    <th></th>
                                    <th>Code</th>
                                    <th>Auditor</th>
                                    <th>Auditee</th>
                                    <th>Agreed Action Plan</th>
                                    <th>Target Date</th>
                                    <th>Date Completed</th>
                                    <th>Type</th>
                                    <th>Supporting Document</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                        <tbody>
                            @foreach(($department->action_plans)->where('action_plan','!=',"N/A")->where('status','Verified')->where('target_date','>=',date('Y-m-d')) as $action_plan)
                                <tr>
                                    <td>
                                        <div class="btn-group">
                                            <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="fa fa-ellipsis-v"></i> </button>
                                            <ul class="dropdown-menu">
                                                @if((auth()->user()->role == "IAD Approver") || (auth()->user()->role == "Administrator"))
                                                    <li><a title='Edit Action Plan' href="#edit_action_plan{{$action_plan->id}}" data-toggle="modal" >Edit</a></li>
                                                @endif
                                                @if(auth()->user()->role == "Auditee")
                                                    <li><a title='Update' href="#view{{$action_plan->id}}" data-toggle="modal" >Upload</a></li>
                                                    <li><a title='View' href="#view_history{{$action_plan->id}}" data-toggle="modal" >View</a></li>
                                                @else
                                                    <li><a title='Update' href="#view{{$action_plan->id}}" data-toggle="modal" >Upload</a></li>
                                                    <li><a title='Change Target Date' href="#change{{$action_plan->id}}" data-toggle="modal" >Change Target Date</a></li>
                                                    <li><a title='Return Action Plan' href="#return{{$action_plan->id}}" data-toggle="modal" >Return Action Plan</a></li>
                                                    @if($action_plan->attachment == null)
                                                    @elseif($action_plan->iad_status == "Returned")
                                                    @else
                                                    <li><a title='Closed Action Plan' href="#closed{{$action_plan->id}}" data-toggle="modal" >Close Action Plan</a></li>
                                                    @endif
                                                    
                                                   
                                                    {{-- <li><a title='View' href="#view_history{{$action_plan->id}}" data-toggle="modal" >View</a></li> --}}
                                                @endif
                                            </ul>
                                        </div>

                                    </td>
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
                                        @if($action_plan->attachment == null)  For Auditee Uploading </span>
                                        @elseif($action_plan->iad_status == "Returned")
                                            Returned Action Plan
                                        @else For IAD Checking 
                                        @endif
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