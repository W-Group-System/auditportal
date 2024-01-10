<div class="modal fade" id="view_history{{$action_plan->id}}" tabindex="-1" aria-labelledby="addIncome" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Action Plan <label class='label label-danger'></span></h5>
                    </div>
                    <div class="modal-body">             
                        @csrf
                        <div class='row'>
                            <div class='col-md-12'>
                                IA Code: <strong><small>{{$action_plan->audit_plan->code}}</small></strong> <br>
                                Title: <strong><small>{{$action_plan->audit_plan->engagement_title}}</small></strong> <br>
                                Auditor: <small>@if($action_plan->observation){{$action_plan->observation->created_by_user->name}} @else @if($action_plan->auditor_data){{$action_plan->auditor_data->name}} @endif @endif</small> <br>
                                Auditee: <small>{{$action_plan->user->name}}</small>
                                
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-md-12'>
                                Findings: <br> @if($action_plan->observation){!!$action_plan->observation->observation!!} @else{!! nl2br(e($action_plan->findings)) !!} @endif<br>
                            </div>
                        </div>
                        <hr>
                        <div class='row'>
                            <div class='col-md-12'>
                                Action Plan: <br> {!! nl2br(e($action_plan->action_plan)) !!}<br>
                            </div>
                        </div>
                        <hr>
                        <div class='row text-center'>
                            <div class='col-md-3 border  border-primary border-top-bottom border-left-right'>
                            Action By
                            </div>
                            <div class='col-md-3 border  border-primary border-top-bottom border-left-right'>
                            Action
                            </div>
                            <div class='col-md-3 border  border-primary border-top-bottom border-left-right'>
                            Remarks
                            </div>
                            <div class='col-md-3 border  border-primary border-top-bottom border-left-right'>
                            Date
                            </div>
                        </div>
                        @foreach(($action_plan->histories) as $history)
                        <div class='row text-center'>
                            <div class='col-md-3 border border-primary border-top-bottom border-left-right'>
                            {{$history->user->name}} &nbsp;
                            </div>
                            <div class='col-md-3 border border-primary border-top-bottom border-left-right'>
                                {{$history->action}} &nbsp;
                            </div>
                            <div class='col-md-3 border border-primary border-top-bottom border-left-right'>
                                {{$history->remarks}}
                            </div>
                            <div class='col-md-3 border border-primary border-top-bottom border-left-right'>
                                {{date('M. d, Y h:i:a',strtotime('+8 hours',strtotime($history->created_at)))}}
                            </div>
                        </div>
                        @endforeach
                    </div> 
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    </form>
            </div>
        </div>
</div>