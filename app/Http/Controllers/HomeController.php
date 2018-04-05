<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.3/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        return view('adminlte::home');
    }

    public function haco_api(){
        // ini_set('display_errors', 1);
        // ini_set('display_startup_errors', 1);
        // error_reporting(E_ALL);
        // $users = DB::connection('foma')->select('select FCSNAME from PROD');
        // dd($users);
        // die;
        // return "test";
        try {
            // $fcsname = \DB::connection('foma')->table('PROD')->select('*')->whereBetween('FTLASTUPD',['2018-03-01 13:16:20.000','2018-03-28 13:16:20.000'])->limit(1000)->orderBy('FTLASTUPD','ASC')->get();
            // $spec_dexcriotion_th = DB::connection('foma')->table('PRODXA_HACO')->select('SPEC_DESCRIPTION_TH')->limit(100)->get();
            // $fcsname = DB::connection('foma')->table('PROD')->select('FCSNAME2')->limit(10)->get();
            // $spec_description_eng = DB::connection('foma')->table('PRODXA_HACO')->select('SPEC_DESCRIPTION_EN')->limit(100)->get();
            // $weight_sku = DB::connection('foma')->table('PRODXA_HACO')->select('WEIGHT_SKU')->limit(100)->get();
            // $fcname_pdcolor = DB::connection('foma')->table('PDCOLOR')->select('FCSNAME')->limit(100)->get();
            // $fcstatus = DB::connection('foma')->table('PROD')->select('FCSTATUS')->limit(100)->get();
            // $fnamt = DB::connection('foma')->table('PRICE')->select('*')->limit(10)->get();


            // $fdBbegdate = DB::connection('foma')->table('PCONTRAC')->select('FCSKID')->limit(10)->get();
            // $fdenddate = DB::connection('foma')->table('PCONTRAC')->select('*')->limit(10)->get();

            // var_dump($fcsname);
            // dd($fcsname);

            // exit();
            // $fcname_pdbrand = DB::connection('foma')->table('PDBRAND')->select('FCNAME')->limit(100)->get();
            // $fcname_pdmodel = DB::connection('foma')->table('PDMODEL')->select('FCNAME')->limit(100)->get();
            // $image_high = DB::connection('foma')->table('PRODXA_HACO')->select('IMAGE_HIGH')->limit(100)->get();
            // $image_low = DB::connection('foma')->table('PRODXA_HACO')->select('IMAGE_LOW')->limit(100)->get();
            // $image_draw = DB::connection('foma')->table('PRODXA_HACO')->select('IMAGE_DRAW')->limit(100)->get();
            // $image_3d = DB::connection('foma')->table('PRODXA_HACO')->select('IMAGE_3D')->limit(100)->get();
            // $image_1 = DB::connection('foma')->table('PRODXA_HACO')->select('IMAGE_1')->limit(100)->get();
            // $image_2 = DB::connection('foma')->table('PRODXA_HACO')->select('IMAGE_2')->limit(100)->get();
            // $image_3 = DB::connection('foma')->table('PRODXA_HACO')->select('IMAGE_3')->limit(100)->get();
            //$prod = DB::connection('foma')->table('PROD')->select('FCSNAME','FCSNAME2','FCSTATUS','FCSKID')->limit(100)->get();
            // $prod = DB::connection('foma')->table('PROD')->join('PRODXA','PROD.FCSKID = PRODXA.FCPROD')->select('PROD.*','PRODXA.*')->limit(100)->get();

            //$prod = DB::connection('foma')->table('PROD')->select('FCSNAME','FCSNAME2','FCSTATUS','FCSKID')->limit(10)->get();

            // $prod = DB::connection('foma')->table('PROD')->select('FCSNAME','FCSNAME2','FCSTATUS','FCSKID')->limit(10)->get();
            // $prodxda = DB::connection('foma')->table('PRICE')
            // ->join('PROD','PROD.FCSKID','=','PRICE.FCSKID')
            // ->select(['PROD.FCSKID','PROD.FCSNAME','PROD.FCSNAME2','PROD.FCSTATUS','PRICE.FNAMT'])
            // ->limit(10)->get();
            // $magento = DB::table('url_rewrite')->select('*')->limit(1)->get();
            // $magento = DB::connection('magento')->table('url_rewrite')->select('url_rewrite_id')->limit(1)->get();

            // dd($magento);
            // exit();
            // $test = \App\Models\Prod::select('PROD.FCSNAME as PROD_FCSNAME','PROD.FCNAME as PROD_FCNAME','PROD.FCSNAME2 as PROD_FCSNAME2','PROD.FCNAME2 as PROD_FCNAME2','PROD.FCSTATUS as PROD_FCSTATUS')->with('PRODXA')->limit(10)->get();

            //->with('PDBRAND')->with('PDMODEL')->with('PDCOLOR')->with('PRODXA_HACO')

            // return $test;
            // exit();
            
            // exit();


            $prodxda = \DB::connection('foma')->table('PROD')
            ->leftjoin('PRODXA','PROD.FCSKID','=','PRODXA.FCPROD')
            ->leftjoin('PDBRAND','PRODXA.FCPDBRAND','=','PDBRAND.FCSKID')
            ->leftjoin('PDMODEL','PRODXA.FCPDMODEL','=','PDMODEL.FCSKID')
            ->leftjoin('PDCOLOR','PRODXA.FCPDCOLOR','=','PDCOLOR.FCSKID')
            ->leftjoin('PRODXA_HACO','PROD.FCSKID','=' ,'PRODXA_HACO.FORMA_ID_SEC')
            ->rightjoin('PRICE','PROD.FCSKID','=','PRICE.FCPROD')
            ->rightjoin('PCONTRAC','PRICE.FCCORP','=','PCONTRAC.FCCORP')
            ->select([
                    'PROD.FCSKID as PROD_FCSKID','PRODXA.FCPROD as PRODXA_FCPROD','PDBRAND.FCSKID as PDBRAND_FCSKID','PDMODEL.FCSKID as PDMODEL_FCSKID','PDCOLOR.FCSKID as PDCOLOR_FCSKID','PRODXA_HACO.FORMA_ID_SEC',
                    'PROD.FCSNAME as PROD_FCSNAME','PROD.FCNAME as PROD_FCNAME','PROD.FCSNAME2 as PROD_FCSNAME2','PROD.FCNAME2 as PROD_FCNAME2','PROD.FCSTATUS as PROD_FCSTATUS',
                    'PRODXA_HACO.SPEC_DESCRIPTION_TH as PRODXA_HACO_SPEC_DESCRIPTION_TH','PRODXA_HACO.SPEC_DESCRIPTION_EN as PRODXA_HACO_SPEC_DESCRIPTION_EN','PRODXA_HACO.WEIGHT_SKU as PRODXA_HACO_WEIGHT_SKU','PRODXA_HACO.IMAGE_HIGH as PRODXA_HACO_IMAGE_HIGH','PRODXA_HACO.IMAGE_LOW as PRODXA_HACO_IMAGE_LOW','PRODXA_HACO.IMAGE_DRAW as PRODXA_HACO_IMAGE_DRAW','PRODXA_HACO.IMAGE_3D as PRODXA_HACO_IMAGE_3D','PRODXA_HACO.IMAGE_1 as PRODXA_HACO_IMAGE_1','PRODXA_HACO.IMAGE_2 as PRODXA_HACO_IMAGE_2','PRODXA_HACO.IMAGE_3 as PRODXA_HACO_IMAGE_3',
                    'PDCOLOR.FCNAME as PDCOLOR_FCNAME',
                    'PDBRAND.FCNAME as PDBRAND_FCNAME',
                    'PDMODEL.FCNAME as PDMODEL_FCNAME',
                    'PRICE.FNAMT as PRICE_FNAMT',
                    'PCONTRAC.FDBEGDATE as PCONTRAC_FDBEGDATE','PCONTRAC.FDENDDATE as PCONTRAC_FDENDDATE',
                    'PROD.FTLASTUPD as PROD_FTLASTUPD','PROD.FTDATETIME as PROD_FTDATETIME'
                    ])
            // ->limit(1)->orderBy('PCONTRAC_FDENDDATE','DESC')->get();
            ->limit(1)->get();

            // $max_catalog_product_index_eav = \DB::connection('magento')->table('catalog_product_index_eav')->max('source_id');

            dd($prodxda);
            // echo date('Y-m-d H:i:s');
            // dd($prodxda);
            exit();

            foreach($prodxda as $key => $value){
                $PROD_FCSNAME = trim($value->PROD_FCSNAME); // ชื่อสินค้า & รหัสสินค้า & /* meta_title */                           +
                $PROD_FCNAME = trim($value->PROD_FCNAME); // รายละเอียดสินค้าโดยย่อ // meta_description                                 +
                $PROD_FCSNAME2 = trim($value->PROD_FCSNAME2); // ชื่อสินค้า Eng
                $PROD_FCNAME2 = trim($value->PROD_FCNAME2); // รายละเอียดสินค้าโดยย่อ Eng
                $PROD_FCSTATUS = trim($value->PROD_FCSTATUS); // สถานะ (เปิดการใช้งาน) & การมองเห็น(รายการสินค้า,ค้นหา)                         +
                $PRODXA_HACO_SPEC_DESCRIPTION_TH = trim($value->PRODXA_HACO_SPEC_DESCRIPTION_TH); // รายละเอียดสินค้า                       +
                $PRODXA_HACO_SPEC_DESCRIPTION_EN = trim($value->PRODXA_HACO_SPEC_DESCRIPTION_EN); // รายละเอียดสินค้า Eng
                $PRODXA_HACO_WEIGHT_SKU = trim($value->PRODXA_HACO_WEIGHT_SKU); // น้ำหนัก                                                          +
                $PRODXA_HACO_IMAGE_HIGH = trim($value->PRODXA_HACO_IMAGE_HIGH); // image
                $PRODXA_HACO_IMAGE_LOW = trim($value->PRODXA_HACO_IMAGE_LOW); // small_image & thumbnail
                $PRODXA_HACO_IMAGE_DRAW = trim($value->PRODXA_HACO_IMAGE_DRAW);
                $PRODXA_HACO_IMAGE_3D = trim($value->PRODXA_HACO_IMAGE_3D);
                $PRODXA_HACO_IMAGE_1 = trim($value->PRODXA_HACO_IMAGE_1);
                $PRODXA_HACO_IMAGE_2 = trim($value->PRODXA_HACO_IMAGE_2);
                $PRODXA_HACO_IMAGE_3 = trim($value->PRODXA_HACO_IMAGE_3);
                $PDCOLOR_FCNAME = trim($value->PDCOLOR_FCNAME); // สี
                $PDBRAND_FCNAME = trim($value->PDBRAND_FCNAME); /* meta_title */                                                                           /* + */
                $PDMODEL_FCNAME = trim($value->PDMODEL_FCNAME); // meta_keyword                                                                         +
                $PRICE_FNAMT = trim($value->PRICE_FNAMT); // ราคา & ราคาส่วนลด
                $PCONTRAC_FDBEGDATE = trim($value->PCONTRAC_FDBEGDATE); // ราคาส่วนลดเริ่ม (null)
                $PCONTRAC_FDENDDATE = trim($value->PCONTRAC_FDENDDATE); // สิ้นสุดราคาส่วนลด(null)

                exit();

                ///////////////////// Product /////////////////////////
                $catalog_product_entity = array(
                    'attribute_set_id' => 4,
                    'type_id' => 'simple',
                    'sku' => $PROD_FCSNAME,
                    'has_options' => '0',
                    'required_options' => '0',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                );
                $product = \DB::connection('magento')->table('catalog_product_entity')->insertGetId($catalog_product_entity);

                ////////////////////// catalog_product_entity_varchar ///////////////////////////////////////////

                $catalog_product_entity_varchar_name = array(
                    'attribute_id' => '73',
                    'store_id' => '0',
                    'entity_id' => $product,
                    'value' => $PROD_FCSNAME,
                );
                $catalog_product_entity_varchar_meta_title = array(
                    'attribute_id' => '84',
                    'store_id' => '0',
                    'entity_id' => $product,
                    'value' => $PDBRAND_FCNAME,
                );
                $catalog_product_entity_varchar_meta_description = array(
                    'attribute_id' => '86',
                    'store_id' => '0',
                    'entity_id' => $product,
                    'value' => $PROD_FCNAME,
                );
                $catalog_product_entity_varchar_image = array(
                    'attribute_id' => '87',
                    'store_id' => '0',
                    'entity_id' => $product,
                    'value' => $PRODXA_HACO_IMAGE_HIGH,
                );
                $catalog_product_entity_varchar_small_image = array(
                    'attribute_id' => '88',
                    'store_id' => '0',
                    'entity_id' => $product,
                    'value' => $PRODXA_HACO_IMAGE_LOW,
                );
                $catalog_product_entity_varchar_thumbnail = array(
                    'attribute_id' => '89',
                    'store_id' => '0',
                    'entity_id' => $product,
                    'value' => $PRODXA_HACO_IMAGE_LOW,
                );
                $catalog_product_entity_varchar_options_container = array(
                    'attribute_id' => '106',
                    'store_id' => '0',
                    'entity_id' => $product,
                    'value' => 'container2',
                );
                $catalog_product_entity_varchar_url_key = array(
                    'attribute_id' => '119',
                    'store_id' => '0',
                    'entity_id' => $product,
                    'value' => $PROD_FCSNAME,
                );

                \DB::connection('magento')->table('catalog_product_entity_varchar')->insert($catalog_product_entity_varchar_name);
                \DB::connection('magento')->table('catalog_product_entity_varchar')->insert($catalog_product_entity_varchar_meta_title);
                \DB::connection('magento')->table('catalog_product_entity_varchar')->insert($catalog_product_entity_varchar_meta_description);
                \DB::connection('magento')->table('catalog_product_entity_varchar')->insert($catalog_product_entity_varchar_image);
                \DB::connection('magento')->table('catalog_product_entity_varchar')->insert($catalog_product_entity_varchar_small_image);
                \DB::connection('magento')->table('catalog_product_entity_varchar')->insert($catalog_product_entity_varchar_thumbnail);
                \DB::connection('magento')->table('catalog_product_entity_varchar')->insert($catalog_product_entity_varchar_options_container);
                \DB::connection('magento')->table('catalog_product_entity_varchar')->insert($catalog_product_entity_varchar_url_key);

                ///////////////////// catalog_product_entity_text ////////////////////////////////////

                $catalog_product_entity_text_meta_keyword = array(
                    'attribute_id' => '85',
                    'store_id' => '0',
                    'entity_id' => $product,
                    'value' => $PDMODEL_FCNAME
                );
                $catalog_product_entity_text_shot_desciption = array(
                    'attribute_id' => '76',
                    'store_id' => '0',
                    'entity_id' => $product,
                    'value' => $PROD_FCNAME
                );
                $catalog_product_entity_text_desciption = array(
                    'attribute_id' => '75',
                    'store_id' => '0',
                    'entity_id' => $product,
                    'value' => $PRODXA_HACO_SPEC_DESCRIPTION_TH
                );
                \DB::connection('magento')->table('catalog_product_entity_text')->insert($catalog_product_entity_text_meta_keyword);
                \DB::connection('magento')->table('catalog_product_entity_text')->insert($catalog_product_entity_text_shot_desciption);
                \DB::connection('magento')->table('catalog_product_entity_text')->insert($catalog_product_entity_text_desciption);

                ///////////////////////////// catalog_product_index_eav ///////////////////////////////////


                $catalog_product_index_eav_product1 = array(
                    'entity_id' => $product,
                    'attribute_id' => '99',
                    'store_id' => '1',
                    'value' => $PROD_FCSTATUS,
                    'source_id' => $max_catalog_product_index_eav+$key
                );
                $catalog_product_index_eav_product2 = array(
                    'entity_id' => $product,
                    'attribute_id' => '99',
                    'store_id' => '2',
                    'value' => $PROD_FCSTATUS,
                    'source_id' => $max_catalog_product_index_eav+$key
                );

                \DB::connection('magento')->table('catalog_product_index_eav')->insert($catalog_product_index_eav_product1);
                \DB::connection('magento')->table('catalog_product_index_eav')->insert($catalog_product_index_eav_product2);

                //////////////////////////////////  //////////////////////////////////

                $catalog_product_entity_decimal_price = array(
                    'attribute_id' => '77',
                    'store_id' => '0',
                    'entity_id' => $product,
                    'value' => $PRICE_FNAMT
                );
                $catalog_product_entity_decimal_weight = array(
                    'attribute_id' => '82',
                    'store_id' => '0',
                    'entity_id' => $product,
                    'value' => $PRODXA_HACO_WEIGHT_SKU
                );
                $catalog_product_entity_decimal_special_price = array(
                    'attribute_id' => '78',
                    'store_id' => '0',
                    'entity_id' => $product,
                    'value' => $PRICE_FNAMT
                );

                \DB::connection('magento')->table('catalog_product_entity_decimal')->insert($catalog_product_entity_decimal_price);
                \DB::connection('magento')->table('catalog_product_entity_decimal')->insert($catalog_product_entity_decimal_weight);
                \DB::connection('magento')->table('catalog_product_entity_decimal')->insert($catalog_product_entity_decimal_special_price);

                //////////////////////////// catalog_product_entity_int /////////////////////////////////

                // $catalog_product_entity_int_color= array(
                //     'attribute_id' => '93',
                //     'store_id' => '0',
                //     'entity_id' => $product,
                //     'value' => '2'
                // );
                $catalog_product_entity_int_status = array(
                    'attribute_id' => '97',
                    'store_id' => '0',
                    'entity_id' => $product,
                    'value' => $PROD_FCSTATUS
                );
                $catalog_product_entity_int_visibility = array(
                    'attribute_id' => '99',
                    'store_id' => '0',
                    'entity_id' => $product,
                    'value' => $PROD_FCSTATUS
                );
                $catalog_product_entity_int_quantity_and_stock_status = array(
                    'attribute_id' => '115',
                    'store_id' => '0',
                    'entity_id' => $product,
                    'value' => '1'
                );
                $catalog_product_entity_int_tax_class_id = array(
                    'attribute_id' => '134',
                    'store_id' => '0',
                    'entity_id' => $product,
                    'value' => '2'
                );

                \DB::connection('magento')->table('catalog_product_entity_int')->insert($catalog_product_entity_int_status);
                \DB::connection('magento')->table('catalog_product_entity_int')->insert($catalog_product_entity_int_visibility);
                \DB::connection('magento')->table('catalog_product_entity_int')->insert($catalog_product_entity_int_quantity_and_stock_status);
                \DB::connection('magento')->table('catalog_product_entity_int')->insert($catalog_product_entity_int_tax_class_id);
                // \DB::connection('magento')->table('catalog_product_entity_int')->insert($catalog_product_entity_int_color);

                ///////////////////////// catalog_product_index_price ///////////////////////////////

                $catalog_product_index_price_web0 = array(
                    'entity_id' => $product,
                    'customer_group_id' => '0',
                    'website_id' => '1',
                    'tax_class_id' => '2',
                    'price' => $PRICE_FNAMT,
                    'final_price' => $PRICE_FNAMT,
                    'min_price' => $PRICE_FNAMT,
                    'max_price' => $PRICE_FNAMT,
                    'tier_price' => $PRICE_FNAMT
                );
                $catalog_product_index_price_web2 = array(
                    'entity_id' => $product,
                    'customer_group_id' => '2',
                    'website_id' => '1',
                    'tax_class_id' => '2',
                    'price' => $PRICE_FNAMT,
                    'final_price' => $PRICE_FNAMT,
                    'min_price' => $PRICE_FNAMT,
                    'max_price' => $PRICE_FNAMT,
                    'tier_price' => $PRICE_FNAMT
                );
                $catalog_product_index_price_web3 = array(
                    'entity_id' => $product,
                    'customer_group_id' => '3',
                    'website_id' => '1',
                    'tax_class_id' => '2',
                    'price' => $PRICE_FNAMT,
                    'final_price' => $PRICE_FNAMT,
                    'min_price' => $PRICE_FNAMT,
                    'max_price' => $PRICE_FNAMT,
                    'tier_price' => $PRICE_FNAMT
                );
                $catalog_product_index_price_web3 = array(
                    'entity_id' => $product,
                    'customer_group_id' => '3',
                    'website_id' => '1',
                    'tax_class_id' => '2',
                    'price' => $PRICE_FNAMT,
                    'final_price' => $PRICE_FNAMT,
                    'min_price' => $PRICE_FNAMT,
                    'max_price' => $PRICE_FNAMT,
                    'tier_price' => $PRICE_FNAMT
                );

                \DB::connection('magento')->table('catalog_product_index_price')->insert($catalog_product_index_price_web0);
                \DB::connection('magento')->table('catalog_product_index_price')->insert($catalog_product_index_price_web1);
                \DB::connection('magento')->table('catalog_product_index_price')->insert($catalog_product_index_price_web2);
                \DB::connection('magento')->table('catalog_product_index_price')->insert($catalog_product_index_price_web3);

                ///////////////////////////////// catalog_product_website ////////////////////////////////////

                $catalog_product_website = array(
                    'product_id' => $product,
                    'website_id' => '1'
                );
                $catalog_product_website = array(
                    'product_id' => $product,
                    'website_id' => '2'
                );

                \DB::connection('magento')->table('catalog_product_website')->insert($catalog_product_website);

                //////////////////////////// catalog_category_product_index //////////////////////////////

                $catalog_category_product_index = array(
                    'category_id' => '2',
                    'product_id' => $product,
                    'position' => '0',
                    'is_parent' => '0',
                    'store_id' => '1',
                    'visibility' => $PROD_FCSTATUS
                );

                \DB::connection('magento')->table('catalog_category_product_index')->insert($catalog_category_product_index);

                /////////////////////////////// cataloginventory_stock_item /////////////////////////////////////

                $cataloginventory_stock_item = array(
                    'product_id' => $product,
                    'stock_id' => '1',
                    'qty' => '',
                    'min_qty' => '0.0000',
                    'use_config_min_qty' => '1',
                    'is_qty_decimal' => '0',
                    'backorders' => '0',
                    'use_config_backorders' => '1',
                    'min_sale_qty' => '1.0000',
                    'use_config_min_sale_qty' => '1',
                    'max_sale_qty' => '0.0000',
                    'use_config_max_sale_qty' => '1',
                    'is_in_stock' => '0',
                    'low_stock_date' => '',
                    'notify_stock_qty' => '',
                    'use_config_notify_stock_qty' => '1',
                    'manage_stock' => '0',
                    'use_config_manage_stock' => '1',
                    'stock_status_changed_auto' => '0',
                    'use_config_qty_increments' => '1',
                    'qty_increments' => '0.0000',
                    'use_config_enable_qty_inc' => '1',
                    'enable_qty_increments' => '0',
                    'is_decimal_divided' => '0',
                    'website_id' => '0'
                );

                \DB::connection('magento')->table('cataloginventory_stock_item')->insert($cataloginventory_stock_item);

                ////////////////////////////// search_query //////////////////////////////////////

                $search_query = array(
                    'query_text' => $PROD_FCSNAME,
                    'num_results' => '1',
                    'popularity' => '1',
                    'redirect' => '',
                    'store_id' => '1',
                    'display_in_terms' => '1',
                    'is_active' => '1',
                    'is_processed' => '0',
                    'updated_at' => date('Y-m-d H:i:s'),
                );

                \DB::connection('magento')->table('search_query')->insert($search_query);


                //catalog_product_entity
                //catalog_product_entity_varchar
                //catalog_product_entity_text
                //catalog_product_index_eav
                //catalog_product_entity_decimal
                //catalog_product_entity_int
                //catalog_product_index_price
                //catalog_product_website
                //catalog_category_product_index
                //cataloginventory_stock_item
                //search_query

            }
        }catch (Exception $e) {
            report($e);
            return false;
        }
    }
}