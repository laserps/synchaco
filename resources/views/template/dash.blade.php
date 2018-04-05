@extends('adminlte::layouts.auth')

@section('htmlheader_title')
    Log in
@endsection

@section('content')
  <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>
            <li><a href="#">Reports</a></li>
            <li><a href="#">Analytics</a></li>
            <li><a href="#">Export</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Dashboard</h1>
      <div class="row">
        <div class="panel panel-primary">
          <div class="panel-heading"><h4>ประวัติการ Sync ข้อมูล</h4></div>
          <div class="panel-body">
            <div class="col-md-6">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th style="text-align: center;">วันที่</th>
                    <th style="text-align: center;">จำนวน record</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td style="text-align: center;">28/03/2561</td>
                    <td style="text-align: center;">23</td>
                  </tr>
                  <tr>
                    <td style="text-align: center;">25/03/2561</td>
                    <td style="text-align: center;">35</td>
                  </tr>
                  <tr>
                    <td style="text-align: center;">20/03/2561</td>
                    <td style="text-align: center;">60</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="col-md-6">
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
            </div>
          </div>
        </div>
      </div>

        </div>
      </div>
    </div>

@endsection
