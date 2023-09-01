
<div class="modal" id="business_unit" tabindex="-1" role="dialog"  >
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class='col-md-10'>
                    <h5 class="modal-title" id="exampleModalLabel">HBU</h5>
                </div>
                <div class='col-md-2'>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <form method='post' action="{{url('hbu/'.$audit_plan->id)}}"onsubmit='show();'  enctype="multipart/form-data" >
                <div class="modal-body">
                    @csrf
                    {{ csrf_field() }}
                    <div class='row'>
                        <div class='col-md-12'>
                            HBU's:
                            <select name='hbu[]' class='form-control-sm form-control cat' multiple required>
                                <option value=""></option>
                                @foreach($business_units as $unit)
                                    <option value='{{$unit->id}}' @if(in_array($unit->id,($audit_plan->hbu)->pluck('business_unit_id')->toArray())) selected @endif>{{$unit->name}} - {{$unit->position}}</option>
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