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

Route::get('/ch_model',function(){
	return \App\Models\Price::Lll();
});

Route::get('/PCONTRAC', function (){
	// return \App\Models\Pcontrac::limit(10)->get();
	return \App\Models\Price::with('PRIECT_LLL')->orderBy('FTLASTUPD','DESC')->limit(100)->get();
});


Route::get('/check', function (){
	//return "aabbcc";
	// return \DB::connection('foma')
 //    ->table('PROD')
 //    ->with('PRICE')
 //    ->limit(100)
 //    ->get();
	//return \DB::connection('foma')->SELECT("select TOP 10 set FCSNAME(REPLACE('FCSNAME',' ','')) from PROD");

 //    $test =  \App\Models\Prod::select('PROD.FCSNAME as PROD_FCSNAME',
 //            'PROD.FCSKID','PRODXA.FCPROD as PRODXA_FCPROD',
 //            'PROD.FCSNAME as PROD_FCSNAME','PROD.FCNAME as PROD_FCNAME','PROD.FCSNAME2 as PROD_FCSNAME2','PROD.FCNAME2 as PROD_FCNAME2','PROD.FCSTATUS as PROD_FCSTATUS',
 //            'PRODXA_HACO.SPEC_DESCRIPTION_TH as PRODXA_HACO_SPEC_DESCRIPTION_TH','PRODXA_HACO.SPEC_DESCRIPTION_EN as PRODXA_HACO_SPEC_DESCRIPTION_EN','PRODXA_HACO.WEIGHT_SKU as PRODXA_HACO_WEIGHT_SKU','PRODXA_HACO.IMAGE_HIGH as PRODXA_HACO_IMAGE_HIGH','PRODXA_HACO.IMAGE_LOW as PRODXA_HACO_IMAGE_LOW','PRODXA_HACO.IMAGE_DRAW as PRODXA_HACO_IMAGE_DRAW','PRODXA_HACO.IMAGE_3D as PRODXA_HACO_IMAGE_3D','PRODXA_HACO.IMAGE_1 as PRODXA_HACO_IMAGE_1','PRODXA_HACO.IMAGE_2 as PRODXA_HACO_IMAGE_2','PRODXA_HACO.IMAGE_3 as PRODXA_HACO_IMAGE_3',
 //            'PDCOLOR.FCNAME as PDCOLOR_FCNAME',
 //            'PDBRAND.FCNAME as PDBRAND_FCNAME',
 //            'PDMODEL.FCNAME as PDMODEL_FCNAME',
 //            // 'PRICE.FNAMT as PRICE_FNAMT',
 //            // 'PCONTRAC.FDBEGDATE as PCONTRAC_FDBEGDATE','PCONTRAC.FDENDDATE as PCONTRAC_FDENDDATE',
 //            'PROD.FTDATETIME as PROD_FTDATETIME','PROD.FTLASTUPD as PROD_FTLASTUPD'
 //            )
	// ->leftjoin('PRODXA','PRODXA.FCPROD','=','PROD.FCSKID')
	// ->leftjoin('PDBRAND','PRODXA.FCPDBRAND','=','PDBRAND.FCSKID')
 //    ->leftjoin('PDMODEL','PRODXA.FCPDMODEL','=','PDMODEL.FCSKID')
 //    ->leftjoin('PDCOLOR','PRODXA.FCPDCOLOR','=','PDCOLOR.FCSKID')
 //    ->leftjoin('PRODXA_HACO','PROD.FCSKID','=' ,'PRODXA_HACO.FORMA_ID_SEC')
 //    ->whereBetween('PROD.FTLASTUPD',['2018-03-01 16:39:30.000','2018-03-31 16:39:30.000'])
 //    ->with('PRIECT_Lll')
 //    ->with('PRIECT_Lll.PRIECT_LLL')
 //    ->get();
 //    return $test;

	$value =  \App\Models\Prod::leftjoin('PRODXA','PRODXA.FCPROD','=','PROD.FCSKID')
        ->leftjoin('PDBRAND','PRODXA.FCPDBRAND','=','PDBRAND.FCSKID')
        ->leftjoin('PDMODEL','PRODXA.FCPDMODEL','=','PDMODEL.FCSKID')
        ->leftjoin('PDCOLOR','PRODXA.FCPDCOLOR','=','PDCOLOR.FCSKID')
        ->leftjoin('PRODXA_HACO','PROD.FCSKID','=' ,'PRODXA_HACO.FORMA_ID_SEC')
        // ->where('PROD.FCSKID',$foma)
        ->whereBetween('PROD.FTLASTUPD',['2018-03-01 16:39:30.000','2018-03-31 16:39:30.000'])
        ->with('PRIECT_Lll')
        ->with('PRIECT_Lll.PCONTRAC')
        ->select(
            'PROD.FCSNAME as PROD_FCSNAME',
            'PROD.FCSKID','PRODXA.FCPROD as PRODXA_FCPROD',
            'PROD.FCSNAME as PROD_FCSNAME','PROD.FCNAME as PROD_FCNAME','PROD.FCSNAME2 as PROD_FCSNAME2','PROD.FCNAME2 as PROD_FCNAME2','PROD.FCSTATUS as PROD_FCSTATUS',
            'PRODXA_HACO.SPEC_DESCRIPTION_TH as PRODXA_HACO_SPEC_DESCRIPTION_TH','PRODXA_HACO.SPEC_DESCRIPTION_EN as PRODXA_HACO_SPEC_DESCRIPTION_EN','PRODXA_HACO.WEIGHT_SKU as PRODXA_HACO_WEIGHT_SKU','PRODXA_HACO.IMAGE_HIGH as PRODXA_HACO_IMAGE_HIGH','PRODXA_HACO.IMAGE_LOW as PRODXA_HACO_IMAGE_LOW','PRODXA_HACO.IMAGE_DRAW as PRODXA_HACO_IMAGE_DRAW','PRODXA_HACO.IMAGE_3D as PRODXA_HACO_IMAGE_3D','PRODXA_HACO.IMAGE_1 as PRODXA_HACO_IMAGE_1','PRODXA_HACO.IMAGE_2 as PRODXA_HACO_IMAGE_2','PRODXA_HACO.IMAGE_3 as PRODXA_HACO_IMAGE_3',
            'PDCOLOR.FCNAME as PDCOLOR_FCNAME',
            'PDBRAND.FCNAME as PDBRAND_FCNAME',
            'PDMODEL.FCNAME as PDMODEL_FCNAME',
            // 'PRICE.FNAMT as PRICE_FNAMT',
            // 'PCONTRAC.FDBEGDATE as PCONTRAC_FDBEGDATE','PCONTRAC.FDENDDATE as PCONTRAC_FDENDDATE',
            'PROD.FTDATETIME as PROD_FTDATETIME','PROD.FTLASTUPD as PROD_FTLASTUPD'
            )
        ->get();


        // return $value[0]->PRIECT_Lll[0]->FNAMT;
        // $values['price'] = $value[0]->PRIECT_Lll[COUNT($value[0]->PRIECT_Lll)-1];
        // $values['pcontrac'] = ($value[0]->PRIECT_Lll[COUNT($value[0]->PRIECT_Lll)-1]);
        $values['data'] = $value[0];
        print_r($value);
        // return $value;
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

Route::get('test','FomulaController@getValueFoma');

Route::get('getValueFoma',function(){
    $value = \App\Models\Prod::leftjoin('PRODXA','PRODXA.FCPROD','=','PROD.FCSKID')
    ->leftjoin('PDBRAND','PRODXA.FCPDBRAND','=','PDBRAND.FCSKID')
    ->leftjoin('PDMODEL','PRODXA.FCPDMODEL','=','PDMODEL.FCSKID')
    ->leftjoin('PDCOLOR','PRODXA.FCPDCOLOR','=','PDCOLOR.FCSKID')
    ->leftjoin('PRODXA_HACO','PROD.FCSKID','=' ,'PRODXA_HACO.FORMA_ID_SEC')
    ->where('PDCOLOR.FCNAME','!=','CHROME')
    // ->where('PROD.FCCORP','pฌy((()')
    ->whereBetween('PROD.FTLASTUPD',['2018-03-01 00:00:00.000', date('Y-m-d H:i:s').":999"])
    ->with('PRIECT_Lll')
    ->with('PRIECT_Lll.PCONTRAC')
    ->select(
        'PROD.FCSNAME as PROD_FCSNAME','PROD.FCCORP',
        'PROD.FCSKID','PRODXA.FCPROD as PRODXA_FCPROD',
        'PROD.FCSNAME as PROD_FCSNAME','PROD.FCNAME as PROD_FCNAME','PROD.FCSNAME2 as PROD_FCSNAME2','PROD.FCNAME2 as PROD_FCNAME2','PROD.FCSTATUS as PROD_FCSTATUS',
        'PRODXA_HACO.SPEC_DESCRIPTION_TH as PRODXA_HACO_SPEC_DESCRIPTION_TH','PRODXA_HACO.SPEC_DESCRIPTION_EN as PRODXA_HACO_SPEC_DESCRIPTION_EN','PRODXA_HACO.WEIGHT_SKU as PRODXA_HACO_WEIGHT_SKU','PRODXA_HACO.IMAGE_HIGH as PRODXA_HACO_IMAGE_HIGH','PRODXA_HACO.IMAGE_LOW as PRODXA_HACO_IMAGE_LOW','PRODXA_HACO.IMAGE_DRAW as PRODXA_HACO_IMAGE_DRAW','PRODXA_HACO.IMAGE_3D as PRODXA_HACO_IMAGE_3D','PRODXA_HACO.IMAGE_1 as PRODXA_HACO_IMAGE_1','PRODXA_HACO.IMAGE_2 as PRODXA_HACO_IMAGE_2','PRODXA_HACO.IMAGE_3 as PRODXA_HACO_IMAGE_3',
        'PDCOLOR.FCNAME as PDCOLOR_FCNAME',
        'PDBRAND.FCNAME as PDBRAND_FCNAME',
        'PDMODEL.FCNAME as PDMODEL_FCNAME',
        // 'PRICE.FNAMT as PRICE_FNAMT',
        // 'PCONTRAC.FDBEGDATE as PCONTRAC_FDBEGDATE','PCONTRAC.FDENDDATE as PCONTRAC_FDENDDATE',
        'PROD.FTDATETIME as PROD_FTDATETIME','PROD.FTLASTUPD as PROD_FTLASTUPD'
        )->limit(100)
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

Route::resource('log','LogController');
Route::get('alllog','LogController@datatable');
Route::get('layout',function(){
    return View::make('layout');
});