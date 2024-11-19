@extends('layouts.header')
@section('css')
<link href="{{ asset('login_css/css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">
@endsection
@section('content')

<div class="wrapper wrapper-content">
    <div class='row'>
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Whistle Blowers Report
                       
                    </div>
                    <div class="ibox-content">
    
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover tables">
                                <thead>
                                    <tr>
                                        <th>Issue</th>
                                        <th>Name of Respondent</th>
                                        <th>Department of Respondent</th>
                                        <th>Risk</th>
                                        <th>Date of Incident</th>
                                        <th>Name of Whistleblower</th>
                                        <th>Proof</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lists as $list)

                                    <tr>
                                        <td>{{$list->issue}}</td>
                                        <td>{{$list->name_of_respondent}}</td>
                                        <td>{{$list->department_of_respondent}}</td>
                                        <td>{{$list->risk}}</td>
                                        <td>{{$list->date_of_incident}}</td>
                                        <td>{{$list->name_of_whistleblower}}</td>
                                        <td>
                                            @foreach($list->attachments as $key => $attachment)
                                           {{$key+1}}. <a href='{{url($attachment->file_name)}}' target='_blank'>Attachment</a><br>
                                            @endforeach
                                        </td>
                                    </tr>
                                
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
    
    
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection
@section('js')
<script src="{{ asset('login_css/js/plugins/dataTables/datatables.min.js')}}"></script>
<script src="{{ asset('login_css/js/plugins/chosen/chosen.jquery.js') }}"></script>
<script>
    $(document).ready(function(){
        

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
