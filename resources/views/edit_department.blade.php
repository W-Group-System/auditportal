
<div class="modal" id="editDepartment{{$department->id}}" tabindex="-1" role="dialog"  >
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class='col-md-10'>
                    <h5 class="modal-title" id="exampleModalLabel">Edit Department</h5>
                </div>
                <div class='col-md-2'>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <form method='post' action='edit-department/{{$department->id}}' onsubmit='show();' class="form-horizontal"  enctype="multipart/form-data" >
                <div class="modal-body">
                    <div class='row'>
                        {{ csrf_field() }}
                        <div class='col-md-12'>
                            Department Code :
                            <input type="text" class="form-control-sm form-control "  value="{{$department->code}}"  name="code" readonly required/>
                        </div>
                        <div class='col-md-12'>
                            Department Name :
                            <input type="text" class="form-control-sm form-control "  value="{{$department->name}}"  name="name" required/>
                        </div>
                        <div class='col-md-12'>
                            Department Head :
                            <select name='user_id' class='form-control-sm form-control cat' >
                                <option value=""></option>
                                @foreach($employees as $employee)
                                    <option value='{{$employee->id}}' @if($department->dep_head->user_id == $employee->id) selected @endif>{{$employee->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type='submit'  class="btn btn-primary" >Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
