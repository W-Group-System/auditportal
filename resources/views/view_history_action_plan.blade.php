<div class="modal fade" id="view_history{{$action_plan->id}}" tabindex="-1" aria-labelledby="addIncome" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Action Plan <label class='label label-danger'></span></h5>
                    </div>
                    <div class="modal-body">             
                        @csrf
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