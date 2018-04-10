@extends('layout')

<!-- app name / title -->
@section('title', 'Page Title')

<!-- css -->
@section('cssbottom')
<link rel="stylesheet" href="{{asset('plugins/datatables.net-dt/css/jquery.dataTables.css')}}">
@endsection

<!-- content -->
@section('content')
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                <h3 class="box-title">Sync History</h3>
            </div>

            <div class="box-body">
                <table class="table table-bordered table-striped dataTable" id="TableList">
                    <thead>
                        <tr>
                            <th style="text-align: center;">ลำดับ</th>
                            <th style="text-align: center;">syncid</th>
                            <th style="text-align: center;">record</th>
                            <th style="text-align: center;">date</th>
                            <th style="text-align: center;">lastupdate</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection

<!-- javascript -->
@section('jsbottom')
<script src="{{asset('plugins/datatables.net/js/jquery.dataTables.js')}}"></script>
<script>
    url_gb = "{{url('')}}";
    var TableList = $('#TableList').dataTable({
        "ajax": {
            "url": url_gb+"/alllog",
            "data": function ( d ) {
                // d.myKey = "myValue";
                // d.custom = $('#myInput').val();
                // etc
            }
        },
        "columns": [
            {"data" : "DT_Row_Index" , "className": "text-center", "orderable": false , "searchable": false },
            {"data" : "id", "className": "text-center"},
            {"data" : "amount", "className": "text-center"},
            {"data" : "created_at", "className": "text-center"},
            {"data" : "updated_at", "className": "text-center"},
        ]
    });
</script>
@endsection