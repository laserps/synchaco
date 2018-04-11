<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

class FunctionController extends Controller
{
    function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    function edit(){
        $file = 'database2.php';
        $data = Storage::disk('config')->get($file);
    
        $str_foma = "";
            $str_foma .= "\n        'foma' => [\n";
                $str_foma .="           'driver' => 'sqlsrv',\n";
                $str_foma .="           'host' => '202.183.186.84',\n";
                $str_foma .="           'port' => '8089',\n";
                $str_foma .="           'database' => 'formula',\n";
                $str_foma .="           'username' => 'sa',\n";
                $str_foma .="           'password' => 'sa',\n";
                $str_foma .="           'charset' => 'utf8',\n";
                $str_foma .="           'prefix' => '',\n";
                $str_foma .="           'TrustServerCertificate' => 'yes',\n";
            $str_foma .= "        ],\n        ";
    
        $str_magento = "";
            $str_magento .= "\n         'magento' => [\n";
                $str_magento .= "           'driver' => 'mysql',\n";
                $str_magento .= "           'host' => '127.0.0.1',\n";
                $str_magento .= "           'port' => '3306',\n";
                $str_magento .= "           'database' => 'magento',\n";
                $str_magento .= "           'username' => 'root',\n";
                $str_magento .= "           'password' => '',\n";
                $str_magento .= "           'charset' => 'utf8',\n";
        $str_magento .= "         ],\n        ";

        //return $data;
        $all['data'] = $data;

        $all['foma'] = $this->get_string_between($data,'//startfoma','//endfoma');
        $all['data'] = str_replace($all['foma'],$str_foma,$all['data']);
        
        $all['magento'] = $this->get_string_between($data,'//startmagento','//endmagento');
        $all['data'] = str_replace($all['magento'],$str_magento,$all['data']);

        //$all['data'] = $data;
        if(Storage::disk('config')->put($file,$all['data'])){
            $all['status'] = 'success';
        }else{
            $all['status'] = 'fail';
        }
        // dd($all['data']);
        return $all;
    }

}
