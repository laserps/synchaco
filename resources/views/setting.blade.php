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
    <!-- <link rel="stylesheet" href="https://fontawesome.com/v4.7.0/assets/font-awesome/css/font-awesome.css"> -->

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="{{ asset('css/ie10-viewport-bug-workaround.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="{{ asset('js/ie-emulation-modes-warning.js') }}"></script>


<!-- <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/3/css/bootstrap.css" /> -->
<!-- Include Date Range Picker -->
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body onload="startTime()">

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
            <li><a href="{{ url('formula') }}">DashBorad</a></li>
            <li class="active"><a href="{{ url('setting') }}">Setting</a></li>
            <!-- <li><a href="#">Analytics</a></li> -->
            <!-- <li><a href="#">Export</a></li> -->
          </ul>
        </div>

      <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <h1 class="page-header">Setting</h1>
        <div class="panel panel-primary">
          <div class="panel-heading"><h4>Setting</h4></div>
          <div class="panel-body">
            <div id="txt"></div>
            @foreach($data as $value)
            <h3>สถานะ : {{ $value->setting_time }}</h3><br/>
            <input type="hidden" name="value_time" id="value_time" value="{{ $value->setting_time }}">
            @endforeach

            <div class="col-md-4"></div>
            <div class="col-md-4">
               <div class="form-group">
                    <label class="control-label">กำหนดประเภทการ Sync ข้อมูล</label>
                <select name="custom_time" class="form-control" id="select_type">
                    <option value="" selected>---- กรุณาเลือกเวลา -----</option>
                    <option value="1">เวลา</option>
                    <option value="2">กำหนดระยะเวลา</option>
                    <option value="3">ด้วยมือ</option>
                </select>
              </div>
            </div>

            <div class="col-md-4"></div>

            <div class="clearfix"></div>

        <!-- <div class="col-md-4">
          <div class="tab-content">
            <div class="panel panel-primary">
             <div class="panel-heading"><h4>กำหนดประเภทการ Sync ข้อมูล</h4></div>
            <div class="panel-body">
              <form action="{{ url('custom_time') }}" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <label class="control-label">กำหนดประเภทการ Sync ข้อมูล</label>
              <select name="custom_time" class="form-control">
                <option value="" selected>---- กรุณาเลือกเวลา -----</option>
                <option value="1">เวลา</option>
                <option value="2">กำหนดระยะเวลา</option>
                <option value="3">ด้วยมือ</option>
              </select>
            </div><br/>
            <button type="submit" style="width: 100%;" class="btn btn-primary"><i class="fa fa-floppy-o"></i> บันทึก</button>
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            </form>
          </div>
        </div>
        </div>
      </div> -->

      <div class="col-md-4">
          <div class="tab-content">
            <div class="panel panel-primary">
             <div class="panel-heading"><h4>กำหนดเวลา Sync </h4></div>
            <div class="panel-body" style="min-height: 160px;">
              <form action="{{ url('insert') }}" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                  <label for="exampleInputEmail1">กำหนดเวลา Sync </label>
                  <input type="time" class="form-control" id="setting_time" name="setting_time" placeholder="กำหนดเวลา" value="" disabled>
                  <br/>
              </div>
            <button type="submit" style="width: 100%;" id="btn_setting_time" class="btn btn-primary" disabled><i class="fa fa-floppy-o"></i> บันทึก</button>
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            </form>
          </div>
        </div>
        </div>
      </div>

      <div class="col-md-4">
          <div class="tab-content">
            <div class="panel panel-primary">
             <div class="panel-heading"><h4>กำนหนดระยะเวลา Sync อัตโนมัติ</h4></div>
            <div class="panel-body" style="min-height: 160px;">
              <form action="{{ url('insert') }}" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <label for="exampleInputEmail1">กำนหนดระยะเวลา Sync อัตโนมัติ</label>
                <select name="custom_auto" id="custom_auto" class="form-control" disabled>
                <option value="" selected>---- กรุณาเลือก ----</option>
                <option value="5/1">5 นาที / 1 ครั้ง</option>
                <option value="10/1">10 นาที / 1 ครั้ง</option>
                <option value="30/1">30 นาที / 1 ครั้ง</option>
                <option value="60/1">60 นาที / 1 ครั้ง</option>
              </select>
              <br/>
            </div>
            <button type="submit" style="width: 100%;" class="btn btn-primary" id="btn_custom_auto" disabled><i class="fa fa-floppy-o"></i> บันทึก</button>
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            </form>
          </div>
        </div>
        </div>
      </div>

      <div class="col-md-4">
          <div class="tab-content">
            <div class="panel panel-primary">
             <div class="panel-heading"><h4>Sync โดยผู้ดูแลระบบ</h4></div>
            <div class="panel-body" style="min-height: 160px;">
              <!-- <form action="{{ url('custom_time') }}" method="POST" enctype="multipart/form-data"> -->
              <div class="form-group">
                <label class="control-label">Sync โดยผู้ดูแลระบบ</label>
              </div><div class="clearfix"></div><br/>
            <button type="button" style="width: 100%;" id="btn_submit" onclick="get_api()" class="btn btn-primary btn-lg" disabled><i class="fa fa-floppy-o"></i> บันทึก</button>
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <!-- </form> -->
          </div>
        </div>
        </div>
      </div>


    </div>
  </div>
      </div>
        <!-- <ul class="nav nav-pills nav-justified">
            <li class="active"><a data-toggle="pill" href="#home">Home</a></li>
            <li><a data-toggle="pill" href="#menu1">Menu 1</a></li>
            <li><a data-toggle="pill" href="#menu2">Menu 2</a></li>
            <li><a data-toggle="pill" href="#menu3">Menu 3</a></li>
          </ul>

          <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
              <div class="row"><br/>
                <div class="panel panel-primary">
                  <div class="panel-heading"><h4>ตั้งค่าการ Sync ข้อมูล</h4></div>
                  <div class="panel-body">
                    <div class="col-md-12">
                          <div class="form-group">
                              <label class="control-label">กำหนดประเภทการ Sync ข้อมูล</label>
                            <select name="custom_time" class="form-control">
                              <option value="" selected>---- กรุณาเลือกเวลา -----</option>
                              <option value="">30 นาที</option>
                              <option value="">1 ชั่วโมง</option>
                              <option value="">2  ชั่วโมง</option>
                              <option value="">4  ชั่วโมง</option>
                              <option value="">8  ชั่วโมง</option>
                              <option value="">10  ชั่วโมง</option>
                              <option value="">12  ชั่วโมง</option>
                              <option value="">16  ชั่วโมง</option>
                              <option value="">20  ชั่วโมง</option>
                              <option value="">1  วัน</option>
                            </select>
                          </div>
                          <div class="form-group">
                              <label for="exampleInputEmail1">กำหนดเวล่ Sync </label>
                              <input type="time" class="form-control" name="setting_time" placeholder="กำหนดเวลา" value="">
                          </div>
                          <div class="form-group">
                              <label for="exampleInputEmail1">กำนหนดระยะเวลา Sync อัตโนมัติ</label>
                              <select name="custom_time" class="form-control">
                              <option value="" selected>---- กรุณาเลือก ----</option>
                              <option value="">5 นาที / 1 ครั้ง</option>
                              <option value="">10 นาที / 1 ครั้ง</option>
                              <option value="">30 นาที / 1 ครั้ง</option>
                              <option value="">60 นาที / 1 ครั้ง</option>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">Sync โดยผู้ดูแลระบบ</label>
                            <button style="width: 100%;" class="btn btn-primary" type="button">Sync ข้อมูลทันที</button>
                          </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="menu1" class="tab-pane fade">
              <h3>Menu 1</h3>
              <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>
            <div id="menu2" class="tab-pane fade">
              <h3>Menu 2</h3>
              <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
            </div>
            <div id="menu3" class="tab-pane fade">
              <h3>Menu 3</h3>
              <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
            </div>
          </div>
 -->


        </div>
      </div>
    </div>





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

<script>
function startTime() {
  var data = $("#value_time").val();
  var today = new Date();
  var h = today.getHours();
  var m = today.getMinutes();
  var s = today.getSeconds();
  m = checkTime(m);
  s = checkTime(s);
  var ss = String(s);
  var mm = String(m);
  document.getElementById('txt').innerHTML = h + ":" + m + ":" + s;
  var t = setTimeout(startTime, 1000);

  if(data == "5/1"){
      if(mm.substr(1,2) == 5 || mm.substr(1,2) == 0){
        if(s == 00){
          console.log(data);
          get_api();
        }
      }
  } else if(data == "10/1") {
      if(mm.substr(1,2) == 0){
        if(s == 00){
          console.log(data);
          get_api();
        }
      }
  } else if(data == "30/1"){
    if(m == 30 || m == 00){
        if(s == 00){
          console.log(data);
          get_api();
        }
    }
  } else if(data == "60/1"){
    if(m == 00){
      if(s == 00){
          console.log(data);
          get_api();
      }
    }
  } else if(h+":"+m == data){
    if(s == 00){
        console.log(data);
        get_api();
    }
  }

}
function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}
</script>

<script type="text/javascript">
$(function() {
    $('input[name="daterange"]').daterangepicker();
});

var url = window.location.href;
function get_api(){
$.ajax({
  url : "check_data?v="+Date('Y-m-d H:i:s'),
  method : "GET",
  type : "JSON",
}).done(function(data){
    console.log(data);
    // window.location.reload();
}).error(function(e){
  alert(e);
});
}

// function get_a

$(function(){
  var data = $("#value_time").val();
  var date = new Date();
  var day = date.getDay();
  var month = date.getMonth();
  var year = date.getFullYear();
  var time = date.getMinutes();

  startTime();
  // console.log(time);




});
</script>

<script>
$('body').on('change','#select_type',function(){
  var data = $(this).val();
    if(data == 1){
        $('#setting_time').removeAttr('disabled');
        $('#btn_setting_time').removeAttr('disabled');

        $('#custom_auto').attr('disabled','disabled');
        $('#btn_custom_auto').attr('disabled','disabled');
        $('#btn_submit').attr('disabled','disabled');
    } else if(data == 2) {
        $('#custom_auto').removeAttr('disabled');
        $('#btn_custom_auto').removeAttr('disabled');

        $('#setting_time').attr('disabled','disabled');
        $('#btn_setting_time').attr('disabled','disabled');
        $('#btn_submit').attr('disabled','disabled');
    } else if(data == 3){
        $('#btn_submit').removeAttr('disabled');

        $('#setting_time').attr('disabled','disabled');
        $('#btn_setting_time').attr('disabled','disabled');
        $('#custom_auto').attr('disabled','disabled');
        $('#btn_custom_auto').attr('disabled','disabled');
    } else {
        $('#setting_time').attr('disabled','disabled');
        $('#btn_setting_time').attr('disabled','disabled');
        $('#custom_auto').attr('disabled','disabled');
        $('#btn_custom_auto').attr('disabled','disabled');
        $('#btn_submit').attr('disabled','disabled');
        // alert('Error');
    }
});
</script>
</body>
</html>