<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use View;

class DBController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['foma']=\DB::table('setting_db')->where('connection','foma')->first();
        $data['magento']=\DB::table('setting_db')->where('connection','magento')->first();
        return View::make('settingdb',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    function setting_foma(Request $request){
        $file = 'database.php';
        $data = Storage::disk('config')->get($file);
    
        $str_foma = "";
            $str_foma .= "\n        'foma' => [\n";
                $str_foma .="           'driver' => 'sqlsrv',\n";
                $str_foma .="           'host' => '".$request->host."',\n";
                $str_foma .="           'port' => '".$request->port."',\n";
                $str_foma .="           'database' => '".$request->database_name."',\n";
                $str_foma .="           'username' => '".$request->username."',\n";
                $str_foma .="           'password' => '".$request->password."',\n";
                $str_foma .="           'charset' => 'utf8',\n";
                $str_foma .="           'prefix' => '',\n";
                $str_foma .="           'TrustServerCertificate' => 'yes',\n";
            $str_foma .= "        ],\n        ";

        // $str_foma = "";
        //     $str_foma .= "\n        'foma' => [\n";
        //         $str_foma .="           'driver' => 'sqlsrv',\n";
        //         $str_foma .="           'host' => '202.183.186.84',\n";
        //         $str_foma .="           'port' => '8089',\n";
        //         $str_foma .="           'database' => 'formula',\n";
        //         $str_foma .="           'username' => 'sa',\n";
        //         $str_foma .="           'password' => 'sa',\n";
        //         $str_foma .="           'charset' => 'utf8',\n";
        //         $str_foma .="           'prefix' => '',\n";
        //         $str_foma .="           'TrustServerCertificate' => 'yes',\n";
        //     $str_foma .= "        ],\n        ";   

        $update = $request->all();
        $update['created_at'] = date('Y-m-d H:i:s');
        $update['updated_at'] = date('Y-m-d H:i:s');

        $all['foma'] = App(FunctionController::class)->get_string_between($data,'//startfoma','//endfoma');
        $all['data'] = str_replace($all['foma'],$str_foma,$data);

        if(Storage::disk('config')->put($file,$all['data']) && \DB::table('setting_db')->where('connection','foma')->update($update)){
            $return['content'] = 'อัพเดท';
            $return['status'] = '1';
        }else{
            $return['content'] = 'ไม่สำเร็จ';
            $return['status'] = '0';
        }

        $return['title'] = "บันทึก";
        return $return;
    }

    function setting_magento(Request $request){
        $file = 'database.php';
        $data = Storage::disk('config')->get($file);
    
        $str_foma = "";
            $str_foma .= "\n        'foma' => [\n";
                $str_foma .="           'driver' => 'sqlsrv',\n";
                $str_foma .="           'host' => '".$request->host."',\n";
                $str_foma .="           'port' => '".$request->port."',\n";
                $str_foma .="           'database' => '".$request->database_name."',\n";
                $str_foma .="           'username' => '".$request->username."',\n";
                $str_foma .="           'password' => '".$request->password."',\n";
                $str_foma .="           'charset' => 'utf8',\n";
                $str_foma .="           'prefix' => '',\n";
                $str_foma .="           'TrustServerCertificate' => 'yes',\n";
            $str_foma .= "        ],\n        ";

        // $str_foma = "";
        //     $str_foma .= "\n        'foma' => [\n";
        //         $str_foma .="           'driver' => 'sqlsrv',\n";
        //         $str_foma .="           'host' => '202.183.186.84',\n";
        //         $str_foma .="           'port' => '8089',\n";
        //         $str_foma .="           'database' => 'formula',\n";
        //         $str_foma .="           'username' => 'sa',\n";
        //         $str_foma .="           'password' => 'sa',\n";
        //         $str_foma .="           'charset' => 'utf8',\n";
        //         $str_foma .="           'prefix' => '',\n";
        //         $str_foma .="           'TrustServerCertificate' => 'yes',\n";
        //     $str_foma .= "        ],\n        ";   

        $update = $request->all();
        $update['created_at'] = date('Y-m-d H:i:s');
        $update['updated_at'] = date('Y-m-d H:i:s');

        $all['foma'] = App(FunctionController::class)->get_string_between($data,'//startmagento','//endmagento');
        $all['data'] = str_replace($all['foma'],$str_foma,$data);

        if(Storage::disk('config')->put($file,$all['data']) && \DB::table('setting_db')->where('connection','magento')->update($update)){
            $return['content'] = 'อัพเดท';
            $return['status'] = '1';
        }else{
            $return['content'] = 'ไม่สำเร็จ';
            $return['status'] = '0';
        }

        $return['title'] = "บันทึก";
        return $return;
    }
}