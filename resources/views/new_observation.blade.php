@extends('layouts.header')
@section('css')
<link href="{{ asset('login_css/css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">

<script src="https://cdn.tiny.cloud/1/yemsbvzrf507kpiivlpanbssgxsf1tatzwwtu81qli4yre3p/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>tinymce.init({
    selector:'textarea',
    content_style: "p { margin: 0; }",    
    });</script>
@endsection
@section('content')

<div class="wrapper wrapper-content">
    @include('error')
   

<div class="wrapper wrapper-content ">
    <div class="ibox">
        <div class="ibox-title">
            <h5>New Observation</h5>
        </div>
        <div class="ibox-content">
            <form method='post' action="{{url('observation/'.$audit_plan->id)}}"onsubmit='show();'  enctype="multipart/form-data" >
                    @csrf
                    {{ csrf_field() }}
                    <div class='row'>
                        <div class='col-md-12'>
                           Code:<b> {{$audit_plan->code}} </b><br>
                           Title: <b> {{$audit_plan->engagement_title}} </b>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-6'>
                            Audit Area:
                            <select name='audit_area' class='form-control-sm form-control cat'  required>
                                <option value=""></option>
                                <option value="Completeness">Completeness</option>
                                <option value="Accuracy">Accuracy</option>
                                <option value="Timeliness">Timeliness</option>
                                <option value="Valuation">Valuation</option>
                                <option value="Existence">Existence</option>
                            </select>
                        </div>
                        <div class='col-md-6'>
                            Risk Implication:
                            <input name='risk_implication' type='text' class='form-control-sm form-control'  required>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-12'>
                            <Br>
                            <textarea name='observation' class='observation' id='observation' placeholder="Please encode here your observation" ></textarea>
                        </div>
                    </div>
                    {{-- <div class='row'>
                        <div class='col-md-12'>
                            <Br>
                            <textarea name='recommendation' class='recommendation' id='recommendation' placeholder="Please encode here your recommendation" ></textarea>
                        </div>
                    </div> --}}
                    <div class='row'>
                        <div class='col-md-12'>
                            Auditee:
                            <select name='auditee' class='form-control-sm form-control cat'  required>
                                <option value=""></option>
                                @foreach($audit_plan->department as $dept)
                                <option value="{{$dept->user_id}}">{{$dept->user_name->name}} - {{$dept->user_name->position}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-6'>
                            Consequence:
                            <select name='consequence' class='form-control-sm form-control cat'  required>
                                <option value=""></option>
                                @foreach($consequences as $consequence)
                                <option value="{{$consequence->number}}-{{$consequence->name}}">{{$consequence->number}} - {{$consequence->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class='col-md-6'>
                            Likelihood:
                            <select name='likelihood' class='form-control-sm form-control cat'  required>
                                <option value=""></option>
                                @foreach($likelihoods as $likelihood)
                                <option value="{{$likelihood->number}}-{{$likelihood->name}}">{{$likelihood->number}} - {{$likelihood->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class='row'>
                        {{-- <div class='col-md-4'>
                            Target Date :
                            <input class='form-control' type='date' name='target_date' min='{{date('Y-m-d')}}' value='{{date('Y-m-d',strtotime("+1 month"))}}' required>
                        </div> --}}
                        <div class='col-md-4'>
                            Audit Date :
                            <input class='form-control' type='date' name='audit_date' value='{{date('Y-m-d')}}' required>
                        </div>
                        <div class='col-md-4'>
                            Attachments
                            <input class='form-control' type='file' name='attachments' multiple>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-12 text-right'>
                            <br>    
                            <button type='submit'  class="btn btn-primary" >Submit</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('login_css/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{ asset('login_css/js/plugins/chosen/chosen.jquery.js') }}"></script>
<script>
    $(document).ready(function(){
        

        $('.cat').chosen({width: "100%"});
        $('.tables').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                { extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel', title: 'ExampleFile'},
                {extend: 'pdf', title: 'ExampleFile'},

                {extend: 'print',
                 customize: function (win){
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                }
                }
            ]

        });

    });

</script>
@endsection
