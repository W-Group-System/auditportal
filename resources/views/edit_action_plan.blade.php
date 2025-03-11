<div class="modal fade" id="edit_action_plan{{$action_plan->id}}" tabindex="-1" aria-labelledby="addIncome" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Action Plan <label class='label label-danger'></span></h5>
                    </div>
                    <form method='post' action='{{url('edit-action-plan/'.$action_plan->id)}}' onsubmit='show();' class="form-horizontal"  enctype="multipart/form-data" >
                    <div class="modal-body">             
                        @csrf
                        <div class='row'>
                            <div class='col-md-12'>
                                Action Plan :
                                <textarea name='action_plan' rows="6" cols="100" class='form-control form-control-sm' required>{{$action_plan->action_plan}}</textarea>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-12'>
                                Employee :
                                <select name='user' rows="6" cols="100" class='form-control form-control-sm cat' required>
                                    @foreach($users->where('role','Auditee') as $user)
                                        <!-- <option value='{{$user->id}}' @if($user->id == $action_plan->user_id) selected @endif>{{$user->name}}</option> -->
                                        <option value='{{$user->id}}' @if($user->id == $action_plan->user_id) selected @endif>{{$user->name}} - {{$user->department->code}}</option>
                                    @endforeach
                                </select>
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