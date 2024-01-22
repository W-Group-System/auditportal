<div class="modal fade" id="upload_attachment{{$action_plan->id}}" tabindex="-1" aria-labelledby="addIncome" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Upload Action Plan <label class='label label-danger'></span></h5>
                    </div>
                    <form method='post' action='{{url('upload-attachment-close/'.$action_plan->id)}}' onsubmit='show();' class="form-horizontal"  enctype="multipart/form-data" >
                    <div class="modal-body">             
                        @csrf
                        <div class='row'>
                            <div class='col-md-12'>File :
                                <input type="file" class="form-control-sm form-control "   name="file" required/>
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