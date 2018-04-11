@extends('layout')

<!-- app name / title -->
@section('title', 'Datatable')
@section('contentheader')
    <h1>
        SETTING
        <small>Database</small>
    </h1>
@endsection
<!-- css -->
@section('cssbottom')
<style>
    .invalid-feedback{
        color: red;
        border-color: red;
    }
</style>
@endsection

<!-- content -->
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header with-border">
            <h3 class="box-title">FOMA(SQLSERVER)</h3>
            </div>
            <!-- host 163.44.197.239
            Database MySQL 
            Database Name : haco_magento
            Username : haco_magento
            Password : r!Qlq482 -->
            <!-- /.box-header -->
            <form class="form-horizontal" id="foma">
                <div class="box-body">
                    <div class="form-group">
                        <label for="host" class="col-sm-2 control-label">Host</label>
                        <div class="col-sm-10">
                            <input name="host" class="form-control" id="host" placeholder="host" type="text" {{isset($foma->host)?"value=$foma->host":''}}>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="port" class="col-sm-2 control-label">Port</label>
                        <div class="col-sm-10">
                            <input name="port" class="form-control" id="port" placeholder="port" type="text" {{isset($foma->port)?"value=$foma->port":''}}>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="host" class="col-sm-2 control-label">Database Name</label>
                        <div class="col-sm-10">
                            <input name="database_name" class="form-control" id="database_name" placeholder="database_name" type="text" {{isset($foma->database_name)?"value=$foma->database_name":''}}>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="host" class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-10">
                            <input name="username" class="form-control" id="username" placeholder="username" type="text" {{isset($foma->username)?"value=$foma->username":''}}>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="host" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10">
                            <input name="password" class="form-control" id="host" placeholder="password" type="text" {{isset($foma->password)?"value=$foma->password":''}}>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2"></label>
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary btn-block btn-save">save</button> 
                        </div>
                    </div>
                </div>
            </form>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->

    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header with-border">
            <h3 class="box-title">Magento(MYSQL)</h3>
            </div>
            <!-- /.box-header -->
            <form class="form-horizontal" id="magento">
                <div class="box-body">
                    <div class="form-group">
                        <label for="host" class="col-sm-2 control-label">Host</label>
                        <div class="col-sm-10">
                            <input name="host" class="form-control" id="host" placeholder="host" type="text" {{isset($magento->host)?"value=$magento->host":''}}>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="port" class="col-sm-2 control-label">Port</label>
                        <div class="col-sm-10">
                            <input name="port" class="form-control" id="port" placeholder="port" type="text" {{isset($magento->port)?"value=$magento->port":''}}>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="host" class="col-sm-2 control-label">Database Name</label>
                        <div class="col-sm-10">
                            <input name="database_name" class="form-control" id="database_name" placeholder="database_name" type="text" {{isset($magento->database_name)?"value=$magento->database_name":''}}>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="host" class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-10">
                            <input name="username" class="form-control" id="username" placeholder="username" type="text" {{isset($magento->username)?"value=$magento->username":''}}>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="host" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10">
                            <input name="password" class="form-control" id="host" placeholder="password" type="text" {{isset($magento->password)?"value=$magento->password":''}}>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2"></label>
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary btn-block btn-save">save</button> 
                        </div>
                    </div>
                </div>
            </form>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
@endsection

<!-- javascript -->
@section('jsbottom')
<!-- <script src="{{asset('plugins/jquery-validation/js/validate.js')}}"></script> -->
<script src="{{asset('plugins/jquery-validation/dist/jquery.validate.js')}}"></script>
<script src="{{asset('plugins/jquery-validation/dist/localization/messages_th.js')}}"></script>
<script>
    $('#foma').validate({
    debug: true,
    lang: 'th',
	errorElement: 'div',
	errorClass: 'invalid-feedback',
	focusInvalid: false,
	rules: {
		'host': {
			required: true,
        },
        'port': {
			required: true,
        },
        'database_name': {
			required: true,
        },
        'username': {
			required: true,
        },
        'password': {
			required: true,
        },
	},
	// messages: {

	// 	text: {
	// 		required: "กรุณาระบุ",
	// 	},
	// },
	// highlight: function (e) {
	// 	validate_highlight(e);
	// },
	// success: function (e) {
	// 	validate_success(e);
	// },
	// errorPlacement: function (error, element) {
	// 	validate_errorplacement(error, element);
	// },
	submitHandler: function (form){
		var btn = $(form).find('[type="submit"]');
		// var data_ar = $(form).serialize();
		btn.button("loading");
		$.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
			method : "POST",
			url : url_gb+"/settingfoma",
			dataType : 'json',
            data : $(form).serialize(),
            success: function(rec){
                //console.log(rec.status);
                btn.button("reset");
                if(rec.status==1){
                    //TableList.api().ajax.reload();
                    //resetFormCustom(form);
                    swal(rec.title,rec.content,"success");
                    // $('#ModalAdd').modal('hide');
                }else{
                    swal(rec.title,rec.content,"error");
                }
            }
		});
	},
	invalidHandler: function (form) {
	}
});
</script>
<script>
    $('#magento').validate({
    debug: true,
    lang: 'th',
	errorElement: 'div',
	errorClass: 'invalid-feedback',
	focusInvalid: false,
	rules: {
		'host': {
			required: true,
        },
        'port': {
			required: true,
        },
        'database_name': {
			required: true,
        },
        'username': {
			required: true,
        },
        'password': {
			required: true,
        },
	},
	// messages: {

	// 	text: {
	// 		required: "กรุณาระบุ",
	// 	},
	// },
	// highlight: function (e) {
	// 	validate_highlight(e);
	// },
	// success: function (e) {
	// 	validate_success(e);
	// },
	// errorPlacement: function (error, element) {
	// 	validate_errorplacement(error, element);
	// },
	submitHandler: function (form){
		var btn = $(form).find('[type="submit"]');
		// var data_ar = $(form).serialize();
		btn.button("loading");
		$.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
			method : "POST",
			url : url_gb+"/settingmagento",
			dataType : 'json',
            data : $(form).serialize(),
            success: function(rec){
                //console.log(rec.status);
                btn.button("reset");
                if(rec.status==1){
                    //TableList.api().ajax.reload();
                    //resetFormCustom(form);
                    swal(rec.title,rec.content,"success");
                    // $('#ModalAdd').modal('hide');
                }else{
                    swal(rec.title,rec.content,"error");
                }
            }
		});
	},
	invalidHandler: function (form) {
	}
});
</script>
@endsection