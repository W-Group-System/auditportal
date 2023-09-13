
<div class="modal" id="newScheduleSpecial" tabindex="-1" role="dialog"  >
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class='col-md-10'>
                    <h5 class="modal-title" id="exampleModalLabel">New Special Audit</h5>
                </div>
                <div class='col-md-2'>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <form method='post' action='new-schedule-special' onsubmit='show();'  enctype="multipart/form-data" >
                <div class="modal-body">
                    {{ csrf_field() }}
                   <div class='row'>
                    <div class='col-md-12'>
                        Engagement Title :
                        <input type="text" class="form-control-sm form-control "  value="{{ old('engagement_title') }}"  name="engagement_title" required/>
                     </div>
                   </div>
                   <div class='row'>
                    <div class='col-md-12'>
                        Activity :
                        <textarea type="text" class="form-control-sm form-control "   name="activity" required>{{ old('activity') }}</textarea>
                     </div>
                   </div>
                   <div class='row'>
                    <div class='col-md-12'>
                        Scope / Period Cover :
                        <textarea class="form-control-sm form-control"  name="scope" required>{{ old('scope') }}</textarea>
                    </div>
                   </div>
                   <hr>
                   <div class='row'>
                        <div class='col-md-6 '>
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    Objectives  </div>
                                <div class="panel-body">
                                    <div class='objectives-data form-group'>
                                        <div class='row mb-2 mt-2' id='objectives_1'>
                                            <div class='col-md-12 '>
                                                <textarea  class="form-control-sm form-control " rows="6" cols="100"   name="objectives" required>{{ old('objective') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-6 '>
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                Procedures   </div>
                                <div class="panel-body">
                                    <div class='procedures-data form-group'>
                                        <div class='row mb-2 mt-2' id='procedures_1'>
                                            <div class='col-md-12 '>
                                                <textarea class="form-control-sm form-control " rows="6" cols="100"   name="procedures" required>{{ old('procedures') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                        </div>
                    </div>
                   <div class='row'>
                        <div class='col-md-12'>
                            <hr>
                        </div>
                   </div>
                   <div class='row'>
                    <div class='col-md-4'>
                        Company :
                        <select name='company[]' class='form-control-sm form-control cat' multiple required>
                            <option value=""></option>
                            @foreach($companies->where('status',null) as $company)
                                <option value='{{$company->id}}' >{{$company->code}} - {{$company->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='col-md-4'>
                        Auditor:
                        <select name='auditor[]' class='form-control-sm form-control cat' multiple required>
                            <option value=""></option>
                            @foreach($users->where('role','Auditor') as $user)
                                <option value='{{$user->id}}'>{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='col-md-4'>
                        Auditee:
                        <select name='auditee[]' class='form-control-sm form-control cat' multiple required>
                            <option value=""></option>
                            @foreach($users->where('role','Auditee') as $user)
                                <option value='{{$user->id}}'>{{$user->name}} - {{$user->department->code}}</option>
                            @endforeach
                        </select>
                    </div>
                   </div>
                   <div class='row'>
                    <div class='col-md-4'>
                        Audit Date Start :
                        <input type="date" class="form-control-sm form-control " min='{{date('Y-m-01',strtotime($month))}}' max='{{date('Y-m-t',strtotime($month))}}'  name="audit_start" required/>
                    </div>
                    <div class='col-md-4'>
                        Audit Date End :
                        <input type="date" class="form-control-sm form-control " min='{{date('Y-m-01',strtotime($month))}}' max='{{date('Y-m-t',strtotime($month))}}'  name="audit_end" required/>
                    </div>
                   </div>
                   <div class='row'>
                    <div class='col-md-12'>
                        <hr>
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