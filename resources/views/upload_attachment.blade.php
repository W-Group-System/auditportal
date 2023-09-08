
<div class="modal" id="upload" tabindex="-1" role="dialog"  >
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class='col-md-10'>
                    <h5 class="modal-title" >Upload Attachment</h5>
                </div>
                <div class='col-md-2'>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            
        
        <form method='post' action='{{url('upload-attachment/'.$audit_plan->id)}}' onsubmit='show();'  enctype="multipart/form-data" >
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class='row'>
                        <div class='col-md-12'>
                            File :
                            <input type="file" class="form-control-sm form-control "   name="file" required/>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-12'>
                            Type :
                            <select class='form-control form-control-sm cat' name='type' required>
                                <option value=''></option>
                                <option value='Authority to Audit'>Authority to Audit</option>
                                <option value='Initial Report'>Initial Report</option>
                                <option value='Closing/Final Report'>Closing/Final Report</option>
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