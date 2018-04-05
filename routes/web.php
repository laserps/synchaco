<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/check', function (){
	//return "aabbcc";
	// return \DB::connection('foma')
 //    ->table('PROD')
 //    ->with('PRICE')
 //    ->limit(100)
 //    ->get();
	//return \DB::connection('foma')->SELECT("select TOP 10 set FCSNAME(REPLACE('FCSNAME',' ','')) from PROD");

    $test =  \App\Models\Prod::select('PROD.FCSNAME as PROD_FCSNAME','PROD.FCSKID')
    //select('PROD.FCSNAME as PROD_FCSNAME','PROD.FCNAME as PROD_FCNAME','PROD.FCSNAME2 as PROD_FCSNAME2','PROD.FCNAME2 as PROD_FCNAME2','PROD.FCSTATUS as PROD_FCSTATUS')
    ->whereBetween('PROD.FTLASTUPD',['2018-03-01 16:39:30.000','2018-03-31 16:39:30.000'])
	// ->leftjoin('PRODXA','PRODXA.FCPROD','=','PROD.FCSKID')
	// ->leftjoin('PDBRAND','PRODXA.FCPDBRAND','=','PDBRAND.FCSKID')
    // ->leftjoin('PDMODEL','PRODXA.FCPDMODEL','=','PDMODEL.FCSKID')
    // ->leftjoin('PDCOLOR','PRODXA.FCPDCOLOR','=','PDCOLOR.FCSKID')
    // ->leftjoin('PRODXA_HACO','PROD.FCSKID','=' ,'PRODXA_HACO.FORMA_ID_SEC')
    ->with('ALLPRICE')
    ->get();

    return $test[0]->allprice[31]->FNAMT;
});


Route::get('formula','FomulaController@index');
Route::get('setting','FomulaController@setting');
Route::get('haco_api','FomulaController@haco_api');
Route::post('custom_time','FomulaController@custom_time');
Route::post('setting_time','FomulaController@setting_time');
Route::post('custom_auto','FomulaController@custom_auto');
Route::get('check_data','FomulaController@check_data');
Route::get('update_api','FomulaController@update_api');
Route::post('insert','FomulaController@store');
Route::get('settime','FomulaController@settime');

Route::get('getValueFoma',function(){
	//return 'asdfdsf';
    $value = \App\Models\Prod::leftjoin('PRODXA','PROD.FCSKID','=','PRODXA.FCPROD')
    ->leftjoin('PDBRAND','PRODXA.FCPDBRAND','=','PDBRAND.FCSKID')
    ->leftjoin('PDMODEL','PRODXA.FCPDMODEL','=','PDMODEL.FCSKID')
    ->leftjoin('PDCOLOR','PRODXA.FCPDCOLOR','=','PDCOLOR.FCSKID')
    ->leftjoin('PRODXA_HACO','PROD.FCSKID','=' ,'PRODXA_HACO.FORMA_ID_SEC')

    // ->rightjoin('PRICE','PROD.FCSKID','=','PRICE.FCPROD')
    // ->rightjoin('PCONTRAC','PRICE.FCCORP','=','PCONTRAC.FCCORP')
    ->select(
            'PROD.FCSKID as PROD_FCSKID','PRODXA.FCPROD as PRODXA_FCPROD','PDBRAND.FCSKID as PDBRAND_FCSKID','PDMODEL.FCSKID as PDMODEL_FCSKID','PDCOLOR.FCSKID as PDCOLOR_FCSKID','PRODXA_HACO.FORMA_ID_SEC',
            'PROD.FCSNAME as PROD_FCSNAME','PROD.FCNAME as PROD_FCNAME','PROD.FCSNAME2 as PROD_FCSNAME2','PROD.FCNAME2 as PROD_FCNAME2','PROD.FCSTATUS as PROD_FCSTATUS',
            'PRODXA_HACO.SPEC_DESCRIPTION_TH as PRODXA_HACO_SPEC_DESCRIPTION_TH','PRODXA_HACO.SPEC_DESCRIPTION_EN as PRODXA_HACO_SPEC_DESCRIPTION_EN','PRODXA_HACO.WEIGHT_SKU as PRODXA_HACO_WEIGHT_SKU','PRODXA_HACO.IMAGE_HIGH as PRODXA_HACO_IMAGE_HIGH','PRODXA_HACO.IMAGE_LOW as PRODXA_HACO_IMAGE_LOW','PRODXA_HACO.IMAGE_DRAW as PRODXA_HACO_IMAGE_DRAW','PRODXA_HACO.IMAGE_3D as PRODXA_HACO_IMAGE_3D','PRODXA_HACO.IMAGE_1 as PRODXA_HACO_IMAGE_1','PRODXA_HACO.IMAGE_2 as PRODXA_HACO_IMAGE_2','PRODXA_HACO.IMAGE_3 as PRODXA_HACO_IMAGE_3',
            'PDCOLOR.FCNAME as PDCOLOR_FCNAME',
            'PDBRAND.FCNAME as PDBRAND_FCNAME',
            'PDMODEL.FCNAME as PDMODEL_FCNAME',
            // 'PRICE.FNAMT as PRICE_FNAMT',
            // 'PCONTRAC.FDBEGDATE as PCONTRAC_FDBEGDATE','PCONTRAC.FDENDDATE as PCONTRAC_FDENDDATE',
            'PROD.FTDATETIME as PROD_FTDATETIME','PROD.FTLASTUPD as PROD_FTLASTUPD'
            )

    // ->where('PROD.FCSKID', $foma)
    ->where('PROD.FTLASTUPD', '>=' , '2018-03-01 00:00:00')
    ->where('PROD.FTLASTUPD' ,'<=',  '2018-03-31 23:59:59')
    ->with('ALLPRICE')
    ->get();
return $value;
});

Route::group(['middleware' => 'auth'], function(){
    //    Route::get('/link1', function ()    {
//        // Uses Auth Middleware
//    });

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes
});
