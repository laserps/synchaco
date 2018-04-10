<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Dashboard Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="{{ asset('css/ie10-viewport-bug-workaround.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="{{ asset('js/ie-emulation-modes-warning.js') }}"></script>

	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top" style="background-color: #337ab7;">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#" style="color: white;">Haco</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <!-- <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="#">Profile</a></li>
            <li><a href="#">Help</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form> -->
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar" style="background-color: #e6e5e5; top: 50px;">
          <ul class="nav nav-sidebar">
            <li class="active"><a href="{{ url('formula') }}">DashBorad</a></li>
            <li><a href="{{ url('setting') }}">Setting</a></li>
            <!-- <li><a href="#">Analytics</a></li> -->
            <!-- <li><a href="#">Export</a></li> -->
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
      	<h4 class="page-header">
          	<div class="col-md-7">
	          	<h4>Dashboard</h4>
          	</div>
			<div class="col-md-5 pull-right">
				<div class="col-md-10">
					<input type="text" class="form-control" id="date_search" name="daterange" value="">
				</div>
				<div class="col-md-2">
					<button type="button" class="btn btn-info"><i class="fa fa-search"></i> ค้นหา</button>
				</div>
			</div>
			&nbsp
         </h4>
         <div class="clearfix"></div>

			<div class="row">
				<div class="panel panel-primary">
					<div class="panel-heading"><h4>ประวัติการ Sync ข้อมูล</h4></div>
					<div class="panel-body">
						<div class="col-md-12">
							<table class="table table-striped">
								<thead>
									<tr>
										<th style="text-align: center;">วันที่</th>
										<th style="text-align: center;">เวลา</th>
										<th style="text-align: center;">ตาราง 1</th>
										<th style="text-align: center;">ตาราง 2</th>
										<th style="text-align: center;">วันที่ Upload</th>
										<th style="text-align: center;">จำนวน record</th>
										<th style="text-align: center;">รายละเอียด</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td style="text-align: center;">28/03/2561</td>
										<td style="text-align: center;">00.00</td>
										<td style="text-align: center;">catalog_product_entity</td>
										<td style="text-align: center;">23</td>
										<td style="text-align: center;">28/03/2561</td>
										<td style="text-align: center;">2</td>
										<td style="text-align: center;">แก้ไข SKU</td>
									</tr>
									<tr>
										<td style="text-align: center;">25/03/2561</td>
										<td style="text-align: center;">03.00</td>
										<td style="text-align: center;">catalog_product_varchar</td>
										<td style="text-align: center;">35</td>
										<td style="text-align: center;">25/03/2561</td>
										<td style="text-align: center;">4</td>
										<td style="text-align: center;">แก้ไขชื่อสินค้า</td>
									</tr>
									<tr>
										<td style="text-align: center;">20/03/2561</td>
										<td style="text-align: center;">08.00</td>
										<td style="text-align: center;">catalog_proudct_text</td>
										<td style="text-align: center;">60</td>
										<td style="text-align: center;">20/03/2561</td>
										<td style="text-align: center;">5</td>
										<td style="text-align: center;">แก้ไข keyword</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

        </div>
      </div>
    </div>

    <!-- <div class="col-md-6">
		<div class="form-group">
		    <label class="control-label">กำหนดประเภทการ Sync ข้อมูล</label>
			<select name="custom_time" class="form-control">
				<option></option>
			</select>
		</div>
		<div class="form-group">
		    <label for="exampleInputEmail1">กำหนดเวล่ Sync </label>
		    <select name="custom_time" class="form-control">
				<option></option>
			</select>
		</div>
		<div class="form-group">
		    <label for="exampleInputEmail1">กำนหนดระยะเวล่ Sync อัติโนมัติ</label>
		    <select name="custom_time" class="form-control">
				<option></option>
			</select>
		</div>
		<div class="form-group">
			<label for="exampleInputEmail1">Sync โดยผู้ดูแลระบบ</label>
			<button style="width: 100%;" class="btn btn-primary" type="button">Sync ข้อมูลทันที</button>
		</div>
	</div> -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script> -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="{{ asset('js/holder.min.js') }}"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="{{ asset('js/ie10-viewport-bug-workaround.js') }}"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>

<script type="text/javascript">
$(function() {
    $('#date_search').daterangepicker();
});
</script>

  </body>
</html>