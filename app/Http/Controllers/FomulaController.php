<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use DB;

class FomulaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function setting(){
        $data['data'] = \App\Models\Setting_time::where('setting_status','T')->get();
        return view('setting',$data);
    }

    public function custom_time(Request $request){
        $custom_time = $request->input('custom_time');

        dd($custom_time);
    }
    public function setting_time(Request $request){
        $setting_time = $request->input('setting_time');
        dd($setting_time);
    }
    public function custom_auto(Request $request){
        $custom_auto = $request->input('custom_auto');
        dd($custom_auto);
    }

    public function settime(){
        return json_encode(date('Y-m-d H:i:s'));
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
        $setting_time = $request->input('setting_time');
        $custom_auto = $request->input('custom_auto');

        if($setting_time != null) {
            $input_all['setting_time'] = $request->input('setting_time');
            $input_all['setting_status'] = $request->input('active','T');
            $input_all['created_at'] = date('Y-m-d H:i:s');
            $input_all['updated_at'] = date('Y-m-d H:i:s');
            $data_insert = $input_all;
            \App\Models\Setting_time::where('setting_status','T')->update(['setting_status'=>'F']);
            \App\Models\Setting_time::insert($data_insert);
            return redirect('setting')->with('status', 'Insert Success');
        } elseif($custom_auto != null){
            $input_all2['setting_time'] = $request->input('custom_auto');
            $input_all2['setting_status'] = $request->input('active','T');
            $input_all2['created_at'] = date('Y-m-d H:i:s');
            $input_all2['updated_at'] = date('Y-m-d H:i:s');
            $data_insert2 = $input_all2;
            \App\Models\Setting_time::where('setting_status','T')->update(['setting_status'=>'F']);
            \App\Models\Setting_time::insert($data_insert2);
            return redirect('setting')->with('status', 'Insert Success');
        } else {
            return redirect('setting')->with('status', 'Insert Error');
        }
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

    public function check_data(){
        $foma = \DB::connection('foma')
        ->table('PROD')
        ->select('FCSNAME','FTLASTUPD','FCSKID')
        ->where('FCCORP','pฌy((()')
        ->whereBetween('FTLASTUPD',['2018-01-01 00:00:00.000',date('Y-m-d H:i:s').":999"])
        ->get();


        $magento = \DB::connection('magento')
        ->table('catalog_product_entity')
        ->select('sku','updated_at')
        ->get();

        $sku_magento = \DB::connection('magento')
            ->table('catalog_product_entity')
            ->select('sku')
            ->whereBetween('updated_at',['2018-01-01 00:00:00.000',date('Y-m-d H:i:s').":999"])
            ->get();

        foreach($sku_magento as $key => $skumagento){
            $getkey[] = $skumagento->sku;
        }

        $sku['insert'] = \DB::connection('foma')
            ->table('PROD')
            ->select('FCSNAME')
            ->whereNotIn('FCSNAME',$getkey)
            ->where('PROD.FCCORP','pฌy((()')
            ->whereBetween('FTLASTUPD',['2018-01-01 00:00:00.000',date('Y-m-d H:i:s').":999"])
            ->get();

        foreach($foma as  $key_foma => $value_foma){
            $date = substr($value_foma->FTLASTUPD, 0, -4);
            $faname = trim($value_foma->FCSNAME);

            $result = \DB::connection('magento')
                ->table('catalog_product_entity')
                ->select('entity_id','sku','updated_at')
                ->where('sku',$faname)
                ->where('updated_at','!=',$date)
                ->first();
            if($result !== "" && $result !==null){
                $new_result = [
                    'id_magento' => $result->entity_id,
                    'id_foma' => $value_foma->FCSKID,
                    'sku' => $result->sku,
                    'updated_at' => $result->updated_at
                ];
                $update[] = $new_result;
            }
        }
            $sku['update'] = $update;

            // return $sku;
            foreach($sku['update'] as $key => $value){
                $value_update[] = $this->update_api( $value['id_foma'] , $value['id_magento'] );
            }

            foreach($sku['insert'] as $key_insert => $value_insert2){
                $value_insert[] = $this->haco_api(trim($value_insert2->FCSNAME));
            }

        return $sku['insert'];

    }


    public function getValueFoma($foma=null,$name=null){
        if($foma != null){
            $value = \App\Models\Prod::leftjoin('PRODXA','PRODXA.FCPROD','=','PROD.FCSKID')
            ->leftjoin('PDBRAND','PRODXA.FCPDBRAND','=','PDBRAND.FCSKID')
            ->leftjoin('PDMODEL','PRODXA.FCPDMODEL','=','PDMODEL.FCSKID')
            ->leftjoin('PDCOLOR','PRODXA.FCPDCOLOR','=','PDCOLOR.FCSKID')
            ->leftjoin('PRODXA_HACO','PROD.FCSKID','=' ,'PRODXA_HACO.FORMA_ID_SEC')
            ->where('PROD.FCSKID',$foma)
            ->where('PROD.FCCORP','pฌy((()')
            ->whereBetween('PROD.FTLASTUPD',['2018-01-01 00:00:00.000', date('Y-m-d H:i:s').":999"])
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
            ->first();
        } else {
            $value = \App\Models\Prod::leftjoin('PRODXA','PRODXA.FCPROD','=','PROD.FCSKID')
            ->leftjoin('PDBRAND','PRODXA.FCPDBRAND','=','PDBRAND.FCSKID')
            ->leftjoin('PDMODEL','PRODXA.FCPDMODEL','=','PDMODEL.FCSKID')
            ->leftjoin('PDCOLOR','PRODXA.FCPDCOLOR','=','PDCOLOR.FCSKID')
            ->leftjoin('PRODXA_HACO','PROD.FCSKID','=' ,'PRODXA_HACO.FORMA_ID_SEC')
            ->where('PROD.FCSNAME',$name) //35500000
            ->where('PROD.FCCORP','pฌy((()')
            ->whereBetween('PROD.FTLASTUPD',['2018-01-01 00:00:00.000', date('Y-m-d H:i:s').":999"])
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
            ->first();
        }

        $data['data'] = $value;

        if(!empty($value->PRIECT_Lll)){
            $pirce = $value->PRIECT_Lll;
        } else {
            $pirce = '';
        }

            if(COUNT($pirce)!=0){
                $data['price'] = $pirce[(COUNT($pirce)-1)]->FNAMT;
            }else{
                $data['price'] = null;
            }

            if(COUNT($pirce)!=0){
                $data['pcontrac'] = $pirce[(COUNT($pirce)-1)];
                $data['pcontrac'] = COUNT($data['pcontrac']->PCONTRAC);

                if($data['pcontrac']!=0){
                    $data['pcontrac'] = $data['pcontrac']->PCONTRAC;
                    $data['start'] = $data['pcontrac']->FDBEGDATE;
                    $data['end'] = $data['pcontrac']->FDENDDATE;

                }else{
                    $data['pcontrac'] = null;
                    $data['start'] = null;
                    $data['end'] = null;
                }
            }else{
                $data['pcontrac'] = null;
            }

        return $data;
    }

    public function check_table($table,$col1=null,$value1=null,$col2=null,$value2=null){
        $table = \DB::connection('magento')->table($table)->where($col1,$value1)->where($col2,$value2)->count();
        return $table;
    }

    public function insert_table($table,$col1=null,$value1=null,$col2=null,$data){
        $data = array(
            $col1 => $value1,
            $col2 => $value2,
        );
        $table = \DB::connection('magento')->table($table)->insertGetId($data);
        return $table;
    }

    public function update_api($foma=null,$magento=null){
        $prodxda = $this->getValueFoma($foma);

        \DB::beginTransaction();
            try {
                $PROD_FCSNAME = trim($prodxda['data']->PROD_FCSNAME); // ชื่อสินค้า & รหัสสินค้า & /* meta_title */                           +
                $PROD_FCNAME = trim($prodxda['data']->PROD_FCNAME); // รายละเอียดสินค้าโดยย่อ // meta_description                                 +
                $PROD_FCSNAME2 = trim($prodxda['data']->PROD_FCSNAME2); // ชื่อสินค้า Eng
                $PROD_FCNAME2 = trim($prodxda['data']->PROD_FCNAME2); // รายละเอียดสินค้าโดยย่อ Eng
                $PROD_FCSTATUS = trim($prodxda['data']->PROD_FCSTATUS); // สถานะ (เปิดการใช้งาน) & การมองเห็น(รายการสินค้า,ค้นหา)                         +
                $PRODXA_HACO_SPEC_DESCRIPTION_TH = trim($prodxda['data']->PRODXA_HACO_SPEC_DESCRIPTION_TH); // รายละเอียดสินค้า                       +
                $PRODXA_HACO_SPEC_DESCRIPTION_EN = trim($prodxda['data']->PRODXA_HACO_SPEC_DESCRIPTION_EN); // รายละเอียดสินค้า Eng
                $PRODXA_HACO_WEIGHT_SKU = trim($prodxda['data']->PRODXA_HACO_WEIGHT_SKU); // น้ำหนัก                                                          +
                $PRODXA_HACO_IMAGE_HIGH = trim($prodxda['data']->PRODXA_HACO_IMAGE_HIGH); // image
                $PRODXA_HACO_IMAGE_LOW = trim($prodxda['data']->PRODXA_HACO_IMAGE_LOW); // image & small_image & thumbnail
                $PRODXA_HACO_IMAGE_DRAW = trim($prodxda['data']->PRODXA_HACO_IMAGE_DRAW);
                $PRODXA_HACO_IMAGE_3D = trim($prodxda['data']->PRODXA_HACO_IMAGE_3D);
                $PRODXA_HACO_IMAGE_1 = trim($prodxda['data']->PRODXA_HACO_IMAGE_1);
                $PRODXA_HACO_IMAGE_2 = trim($prodxda['data']->PRODXA_HACO_IMAGE_2);
                $PRODXA_HACO_IMAGE_3 = trim($prodxda['data']->PRODXA_HACO_IMAGE_3);
                $PDCOLOR_FCNAME = trim($prodxda['data']->PDCOLOR_FCNAME); // สี
                $PDBRAND_FCNAME = trim($prodxda['data']->PDBRAND_FCNAME); /* meta_title */                                                                           /* + */
                $PDMODEL_FCNAME = trim($prodxda['data']->PDMODEL_FCNAME); // meta_keyword                                                                         +
                $PRICE_FNAMT = trim($prodxda['price']); // ราคา & ราคาส่วนลด
                $PCONTRAC_FDBEGDATE = trim($prodxda['start']); // ราคาส่วนลดเริ่ม (null)
                $PCONTRAC_FDENDDATE = trim($prodxda['end']); // สิ้นสุดราคาส่วนลด(null)
                $PROD_FTDATETIME = trim($prodxda['data']->PROD_FTDATETIME);
                $PROD_FTLASTUPD = trim($prodxda['data']->PROD_FTLASTUPD);

                if($PROD_FCSTATUS == "" || $PROD_FCSTATUS == null){
                    $PROD_FCSTATUS = "4";
                    $PROD_FCSTATUS2 = "1";
                }

                // print_r($value->PROD_FCSNAME);
                // dd($prodxda['data']->PROD_FCSNAME);
                // echo $PROD_FCSNAME;
                // return $prodxda['data'];


                // dd($select_color_color);
                // exit();

                // $select_gallery = \DB::connection('magento')->table('catalog_product_entity_varchar as varchar')
                // ->select('value_to_entity.value_id','varchar.entity_id','value.value_id as gallery_value','gallery.value as gallery_image')
                // ->leftjoin('catalog_product_entity_media_gallery_value_to_entity as value_to_entity','value_to_entity.entity_id','=','varchar.entity_id')
                // ->leftjoin('catalog_product_entity_media_gallery_value as value','value.value_id','=','value_to_entity.value_id')
                // ->leftjoin('catalog_product_entity_media_gallery as gallery','gallery.value_id','=','value.value_id')
                // ->where('varchar.entity_id',$magento)
                // ->where('value.entity_id',$magento)
                // ->where('varchar.attribute_id','87')
                // ->first();

                // dd($select_gallery);

                // if($this->check_table('catalog_product_entity_media_gallery_value_to_entity','value_id',$select_gallery->value_id,'entity_id',$select_gallery->entity_id) > 0){
                //     echo "update";
                // } else {
                //     echo "insert";
                // }

                // exit();




                // dd($select_gallery);

                // echo $select_gallery->value_id."<br/>";
                // echo $select_gallery->entity_id."<br/>";
                // echo $select_gallery->gallery_value."<br/>";
                // echo $select_gallery->gallery_image."<br/>";

                // if($select_gallery) {
                //     $value_to_entity = \DB::connection('magento')->table('catalog_product_entity_media_gallery_value_to_entity as value_to_entity')
                //     ->where('entity_id',$select_gallery->entity_id)
                //     ->first();

                //     dd($select_gallery);
                //     if($value_to_entity){
                //         //มี value_to_entity
                //         $gallery_value = \DB::connection('magento')->table('catalog_product_entity_media_gallery_value as gallery_value')
                //         ->where('gallery_value.value_id',$value_to_entity->value_id)
                //         ->where('gallery_value.entity_id',$value_to_entity->entity_id)
                //         ->first();



                //         $gallery_val = array(
                //             'value_id' => $value_to_entity->value_id,
                //             'store_id' => '0',
                //             'entity_id' => $value_to_entity->entity_id,
                //             'label' => '',
                //             'position' => '',
                //             'disabled' => '0'
                //         );
                //         if($gallery_value){
                //             //มี gallery_value
                //             // $update_gallery_val = \DB::connection('magento')->table('catalog_product_entity_media_gallery_value')->where('value_id',$value_to_entity->value_id)->where('entity_id',$value_to_entity->entity_id)->update($gallery_val);
                //             $value = \DB::connection('magento')->table('catalog_product_entity_media_gallery as value')
                //             ->where('value.value_id',$gallery_value->value_id)
                //             ->first();
                //             $value_image = array(
                //                 'attribute_id' => '90',
                //                 'value' => $PRODXA_HACO_IMAGE_LOW,
                //                 'media_type' => 'image',
                //                 'disabled' => '0'
                //             );
                //             if($value) {
                //                 //มี value
                //                 // $update_val_image = \DB::connection('magento')->table('catalog_product_entity_media_gallery')->where('value_id',$gallery_value->value_id)->update($value_image);
                //             } else {
                //                 //ไม่มี value
                //                 // $insert_val_image = \DB::connection('magento')->table('catalog_product_entity_media_gallery')->insert($value_image);
                //             }
                //         } else {
                //             //ไม่มี gallery_value
                //             // $insert_gallery_val = \DB::connection('magento')->table('catalog_product_entity_media_gallery_value')->insert($gallery_val);
                //         }

                //     } else {
                //         //ไม่มี value_to_entity
                //     }

                // } else {
                //     //ไม่มี
                //     echo "2";
                // }



                // exit();

                // dd($select_gallery);


                ///////////////////// Product /////////////////////////
                $catalog_product_entity = array(
                    'attribute_set_id' => 4,
                    'type_id' => 'simple',
                    'sku' => $PROD_FCSNAME,
                    'has_options' => '0',
                    'required_options' => '0',
                    'created_at' => $PROD_FTDATETIME,
                    'updated_at' => $PROD_FTLASTUPD
                );

                // $select_product = \DB::connection('magento')->table('catalog_product_entity')->where('product_id',$PROD_FCSNAME)->first();
                // $product = \DB::connection('magento')->table('catalog_product_entity')->where('sku',$PROD_FCSNAME)->update($catalog_product_entity);

                $cataloginventory_stock_item = array(
                    'product_id' => $magento,
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

                $select_stock_item = \DB::connection('magento')->table('cataloginventory_stock_item')->where('product_id',$magento)->first();

                if($select_stock_item != null){
                    \DB::connection('magento')->table('cataloginventory_stock_item')->where('product_id',$magento)->update($cataloginventory_stock_item);
                } else {
                    \DB::connection('magento')->table('cataloginventory_stock_item')->insert($cataloginventory_stock_item);
                }

                $cataloginventory_stock_status = array(
                    'product_id' => $magento,
                    'website_id' => '0',
                    'stock_id' => '1',
                    'qty' => '0.0000',
                    'stock_status' => '1',
                );

                $select_stock_status = \DB::connection('magento')->table('cataloginventory_stock_status')->where('product_id',$magento)->first();

                if($select_stock_status != null){
                    \DB::connection('magento')->table('cataloginventory_stock_status')->where('product_id',$magento)->update($cataloginventory_stock_status);
                } else {
                    \DB::connection('magento')->table('cataloginventory_stock_status')->insert($cataloginventory_stock_status);
                }

                $catalog_product_entity_decimal_price = array(
                    'attribute_id' => '77',
                    'store_id' => '0',
                    'entity_id' => $magento,
                    'value' => $PRICE_FNAMT,
                );

                $catalog_product_entity_decimal_weight = array(
                    'attribute_id' => '82',
                    'store_id' => '0',
                    'entity_id' => $magento,
                    'value' => $PRODXA_HACO_WEIGHT_SKU
                );

                $catalog_product_entity_decimal_special_price = array(
                    'attribute_id' => '78',
                    'store_id' => '0',
                    'entity_id' => $magento,
                    'value' => $PRICE_FNAMT,
                );

                $select_decimal_price = \DB::connection('magento')->table('catalog_product_entity_decimal')->where('entity_id',$magento)->where('attribute_id','77')->first();
                $select_decimal_weight = \DB::connection('magento')->table('catalog_product_entity_decimal')->where('entity_id',$magento)->where('attribute_id','82')->first();
                $select_decimal_special_price = \DB::connection('magento')->table('catalog_product_entity_decimal')->where('entity_id',$magento)->where('attribute_id','78')->first();

                if($select_decimal_price != null) {
                    \DB::connection('magento')->table('catalog_product_entity_decimal')->where('entity_id',$magento)->where('attribute_id','77')->update($catalog_product_entity_decimal_price);
                } else {
                    \DB::connection('magento')->table('catalog_product_entity_decimal')->insert($catalog_product_entity_decimal_price);
                }
                if($select_decimal_weight != null){
                    \DB::connection('magento')->table('catalog_product_entity_decimal')->where('entity_id',$magento)->where('attribute_id','82')->update($catalog_product_entity_decimal_weight);
                } else {
                    \DB::connection('magento')->table('catalog_product_entity_decimal')->insert($catalog_product_entity_decimal_weight);
                }
                if($select_decimal_special_price != null){
                    \DB::connection('magento')->table('catalog_product_entity_decimal')->where('entity_id',$magento)->where('attribute_id','78')->update($catalog_product_entity_decimal_special_price);
                } else {
                    \DB::connection('magento')->table('catalog_product_entity_decimal')->insert($catalog_product_entity_decimal_special_price);
                }

                $select_color_color = \DB::connection('magento')->table('eav_attribute_option_value as value_color')
                ->where('store_id','0')
                ->where('value_color.value',$PDCOLOR_FCNAME) //PDCOLOR_FCNAME
                ->first();

                $select_entity_option = \DB::connection('magento')->table('eav_attribute_option')->max('sort_order');

                $select_entity_option_sum = $select_entity_option+1;

                if(!empty($select_color_color)){
                    $value_color = $select_color_color->value;
                    $color_value = $select_color_color->option_id;
                } else {
                    $value_color = '';
                    $color_value = '';
                }

                $select_color = \DB::connection('magento')->table('eav_attribute_option_value')->where('store_id','0')->where('value',$PDCOLOR_FCNAME)->first();

                $color_entity_option = array(
                    'attribute_id' => '93',
                    'sort_order' => $select_entity_option_sum,
                );

                $color_entity_option_value_insert = '';
                $color_entity_option_value_update = '';

                if($select_color == null || $select_color == ''){
                    $color_entity_option_value_insert = \DB::connection('magento')->table('eav_attribute_option')->insertGetId($color_entity_option);
                } else {
                    $color_entity_option_value_update = $select_color->option_id;
                }

                $color_value_text = array(
                    'option_id' => $color_entity_option_value_insert,
                    'store_id' => '1',
                    'value' => $PDCOLOR_FCNAME,
                );
                $color_value_text2 = array(
                    'option_id' => $color_entity_option_value_insert,
                    'store_id' => '0',
                    'value' => $PDCOLOR_FCNAME,
                );

                $update_color_value_text = array(
                    'store_id' => '1',
                    'value' => $PDCOLOR_FCNAME,
                );
                $update_color_value_text2 = array(
                    'store_id' => '0',
                    'value' => $PDCOLOR_FCNAME,
                );

                if($color_entity_option_value_insert != null || $color_entity_option_value_insert != ''){
                    \DB::connection('magento')->table('eav_attribute_option_value')->insert($color_value_text);
                    \DB::connection('magento')->table('eav_attribute_option_value')->insert($color_value_text2);
                } else {
                    \DB::connection('magento')->table('eav_attribute_option_value')->where('store_id','1')->where('option_id',$color_entity_option_value_update)->update($update_color_value_text);
                    \DB::connection('magento')->table('eav_attribute_option_value')->where('store_id','0')->where('option_id',$color_entity_option_value_update)->update($update_color_value_text2);
                }

                if($select_color == null || $select_color == ''){
                    $color = $color_entity_option_value_update;
                } else {
                    $color = $color_value;
                }

                $catalog_product_entity_int_status = array(
                    'attribute_id' => '97',
                    'store_id' => '0',
                    'entity_id' => $magento,
                    'value' => $PROD_FCSTATUS2
                );
                $catalog_product_entity_int_visibility = array(
                    'attribute_id' => '99',
                    'store_id' => '0',
                    'entity_id' => $magento,
                    'value' => $PROD_FCSTATUS
                );
                $catalog_product_entity_int_quantity_and_stock_status = array(
                    'attribute_id' => '115',
                    'store_id' => '0',
                    'entity_id' => $magento,
                    'value' => '1'
                );
                $catalog_product_entity_int_tax_class_id = array(
                    'attribute_id' => '134',
                    'store_id' => '0',
                    'entity_id' => $magento,
                    'value' => '2'
                );
                $catalog_product_entity_int_color = array(
                    'attribute_id' => '93',
                    'store_id' => '0',
                    'entity_id' => $magento,
                    'value' => $color
                );

                $select_entity_int_status = \DB::connection('magento')->table('catalog_product_entity_int')->where('entity_id',$magento)->where('attribute_id','97')->first();
                $select_entity_int_visibility = \DB::connection('magento')->table('catalog_product_entity_int')->where('entity_id',$magento)->where('attribute_id','99')->first();
                $select_entity_int_quantity_and_stock_status = \DB::connection('magento')->table('catalog_product_entity_int')->where('entity_id',$magento)->where('attribute_id','115')->first();
                $select_entity_int_tax_class_id = \DB::connection('magento')->table('catalog_product_entity_int')->where('entity_id',$magento)->where('attribute_id','134')->first();

                if($select_entity_int_status != null){
                    \DB::connection('magento')->table('catalog_product_entity_int')->where('entity_id',$magento)->where('attribute_id','97')->update($catalog_product_entity_int_status);
                } else {
                    \DB::connection('magento')->table('catalog_product_entity_int')->insert($catalog_product_entity_int_status);
                }
                if($select_entity_int_visibility != null){
                    \DB::connection('magento')->table('catalog_product_entity_int')->where('entity_id',$magento)->where('attribute_id','99')->update($catalog_product_entity_int_visibility);
                } else {
                    \DB::connection('magento')->table('catalog_product_entity_int')->insert($catalog_product_entity_int_visibility);
                }
                if($select_entity_int_quantity_and_stock_status != null){
                    \DB::connection('magento')->table('catalog_product_entity_int')->where('entity_id',$magento)->where('attribute_id','115')->update($catalog_product_entity_int_quantity_and_stock_status);
                } else {
                    \DB::connection('magento')->table('catalog_product_entity_int')->insert($catalog_product_entity_int_quantity_and_stock_status);
                }
                if($select_entity_int_tax_class_id != null){
                    \DB::connection('magento')->table('catalog_product_entity_int')->where('entity_id',$magento)->where('attribute_id','134')->update($catalog_product_entity_int_tax_class_id);
                } else {
                    \DB::connection('magento')->table('catalog_product_entity_int')->insert($catalog_product_entity_int_tax_class_id);
                }
                if($color_entity_option_value_update != null){
                    \DB::connection('magento')->table('catalog_product_entity_int')->where('entity_id',$magento)->where('attribute_id','93')->update($catalog_product_entity_int_color);
                } else {
                    \DB::connection('magento')->table('catalog_product_entity_int')->insert($catalog_product_entity_int_color);                }

                $catalog_product_entity_text_meta_keyword = array(
                    'attribute_id' => '85',
                    'store_id' => '0',
                    'entity_id' => $magento,
                    'value' => $PDMODEL_FCNAME
                );
                $catalog_product_entity_text_shot_desciption = array(
                    'attribute_id' => '76',
                    'store_id' => '0',
                    'entity_id' => $magento,
                    'value' => $PROD_FCNAME
                );
                $catalog_product_entity_text_desciption = array(
                    'attribute_id' => '75',
                    'store_id' => '0',
                    'entity_id' => $magento,
                    'value' => $PRODXA_HACO_SPEC_DESCRIPTION_TH
                );

                $select_text_meta_keyword = \DB::connection('magento')->table('catalog_product_entity_text')->where('entity_id',$magento)->where('attribute_id','85')->first();
                $select_text_shot_desciption = \DB::connection('magento')->table('catalog_product_entity_text')->where('entity_id',$magento)->where('attribute_id','85')->first();
                $select_text_desciption = \DB::connection('magento')->table('catalog_product_entity_text')->where('entity_id',$magento)->where('attribute_id','85')->first();

                if($select_text_meta_keyword != null){
                    \DB::connection('magento')->table('catalog_product_entity_text')->where('entity_id',$magento)->where('attribute_id','85')->update($catalog_product_entity_text_meta_keyword);
                } else {
                    \DB::connection('magento')->table('catalog_product_entity_text')->insert($catalog_product_entity_text_meta_keyword);
                }
                if($select_text_shot_desciption != null){
                    \DB::connection('magento')->table('catalog_product_entity_text')->where('entity_id',$magento)->where('attribute_id','76')->update($catalog_product_entity_text_shot_desciption);
                } else {
                    \DB::connection('magento')->table('catalog_product_entity_text')->insert($catalog_product_entity_text_shot_desciption);
                }
                if($select_text_desciption != null){
                    \DB::connection('magento')->table('catalog_product_entity_text')->where('entity_id',$magento)->where('attribute_id','75')->update($catalog_product_entity_text_desciption);
                } else {
                    \DB::connection('magento')->table('catalog_product_entity_text')->insert($catalog_product_entity_text_desciption);
                }

                $catalog_product_entity_varchar_name = array(
                    'attribute_id' => '73',
                    'store_id' => '0',
                    'entity_id' => $magento,
                    'value' => $PROD_FCSNAME,
                );
                $catalog_product_entity_varchar_meta_title = array(
                    'attribute_id' => '84',
                    'store_id' => '0',
                    'entity_id' => $magento,
                    'value' => $PDBRAND_FCNAME,
                );
                $catalog_product_entity_varchar_meta_description = array(
                    'attribute_id' => '86',
                    'store_id' => '0',
                    'entity_id' => $magento,
                    'value' => $PROD_FCNAME,
                );
                $catalog_product_entity_varchar_image = array(
                    'attribute_id' => '87',
                    'store_id' => '0',
                    'entity_id' => $magento,
                    'value' => $PRODXA_HACO_IMAGE_LOW,
                );
                $catalog_product_entity_varchar_small_image = array(
                    'attribute_id' => '88',
                    'store_id' => '0',
                    'entity_id' => $magento,
                    'value' => $PRODXA_HACO_IMAGE_LOW,
                );
                $catalog_product_entity_varchar_thumbnail = array(
                    'attribute_id' => '89',
                    'store_id' => '0',
                    'entity_id' => $magento,
                    'value' => $PRODXA_HACO_IMAGE_LOW,
                );
                $catalog_product_entity_varchar_options_container = array(
                    'attribute_id' => '106',
                    'store_id' => '0',
                    'entity_id' => $magento,
                    'value' => 'container2',
                );
                $catalog_product_entity_varchar_url_key = array(
                    'attribute_id' => '119',
                    'store_id' => '0',
                    'entity_id' => $magento,
                    'value' => $PROD_FCSNAME,
                );

                $select_varchar_name = \DB::connection('magento')->table('catalog_product_entity_varchar')->where('entity_id',$magento)->where('attribute_id','73')->first();
                $select_varchar_meta_title = \DB::connection('magento')->table('catalog_product_entity_varchar')->where('entity_id',$magento)->where('attribute_id','84')->first();
                $select_varchar_meta_description = \DB::connection('magento')->table('catalog_product_entity_varchar')->where('entity_id',$magento)->where('attribute_id','86')->first();
                $select_varchar_image = \DB::connection('magento')->table('catalog_product_entity_varchar')->where('entity_id',$magento)->where('attribute_id','87')->first();
                $select_varchar_small_image = \DB::connection('magento')->table('catalog_product_entity_varchar')->where('entity_id',$magento)->where('attribute_id','88')->first();
                $select_varchar_thumbnail = \DB::connection('magento')->table('catalog_product_entity_varchar')->where('entity_id',$magento)->where('attribute_id','89')->first();
                $select_varchar_noptions_container = \DB::connection('magento')->table('catalog_product_entity_varchar')->where('entity_id',$magento)->where('attribute_id','106')->first();
                $select_varchar_url_key = \DB::connection('magento')->table('catalog_product_entity_varchar')->where('entity_id',$magento)->where('attribute_id','119')->first();

                if($select_varchar_name != null){
                    \DB::connection('magento')->table('catalog_product_entity_varchar')->where('entity_id',$magento)->where('attribute_id','73')->update($catalog_product_entity_varchar_name);
                } else {
                    \DB::connection('magento')->table('catalog_product_entity_varchar')->insert($catalog_product_entity_varchar_name);
                }
                if($select_varchar_meta_title != null){
                    \DB::connection('magento')->table('catalog_product_entity_varchar')->where('entity_id',$magento)->where('attribute_id','84')->update($catalog_product_entity_varchar_meta_title);
                } else {
                    \DB::connection('magento')->table('catalog_product_entity_varchar')->insert($catalog_product_entity_varchar_meta_title);
                }
                if($select_varchar_meta_description != null){
                    \DB::connection('magento')->table('catalog_product_entity_varchar')->where('entity_id',$magento)->where('attribute_id','86')->update($catalog_product_entity_varchar_meta_description);
                } else {
                    \DB::connection('magento')->table('catalog_product_entity_varchar')->insert($catalog_product_entity_varchar_meta_description);
                }
                if($select_varchar_image != null){
                    \DB::connection('magento')->table('catalog_product_entity_varchar')->where('entity_id',$magento)->where('attribute_id','87')->update($catalog_product_entity_varchar_image);
                } else {
                    \DB::connection('magento')->table('catalog_product_entity_varchar')->insert($catalog_product_entity_varchar_image);
                }
                if($select_varchar_small_image != null){
                    \DB::connection('magento')->table('catalog_product_entity_varchar')->where('entity_id',$magento)->where('attribute_id','88')->update($catalog_product_entity_varchar_small_image);
                } else {
                    \DB::connection('magento')->table('catalog_product_entity_varchar')->insert($catalog_product_entity_varchar_small_image);
                }
                if($select_varchar_thumbnail != null){
                    \DB::connection('magento')->table('catalog_product_entity_varchar')->where('entity_id',$magento)->where('attribute_id','89')->update($catalog_product_entity_varchar_thumbnail);
                } else {
                    \DB::connection('magento')->table('catalog_product_entity_varchar')->insert($catalog_product_entity_varchar_thumbnail);
                }
                if($select_varchar_noptions_container != null){
                    \DB::connection('magento')->table('catalog_product_entity_varchar')->where('entity_id',$magento)->where('attribute_id','106')->update($catalog_product_entity_varchar_options_container);
                } else {
                    \DB::connection('magento')->table('catalog_product_entity_varchar')->insert($catalog_product_entity_varchar_options_container);
                }
                if($select_varchar_url_key != null){
                    \DB::connection('magento')->table('catalog_product_entity_varchar')->where('entity_id',$magento)->where('attribute_id','119')->update($catalog_product_entity_varchar_url_key);
                } else {
                    \DB::connection('magento')->table('catalog_product_entity_varchar')->insert($catalog_product_entity_varchar_url_key);
                }

                ////////////////////////////// catalog_product_entity_media_gallery_value_to_entity ////////////////////////////////////////

                $catalog_product_index_eav_product1 = array(
                    'entity_id' => $magento,
                    'attribute_id' => '99',
                    'store_id' => '1',
                    'value' => $PROD_FCSTATUS,
                    'source_id' => $magento
                );
                $catalog_product_index_eav_product2 = array(
                    'entity_id' => $magento,
                    'attribute_id' => '99',
                    'store_id' => '2',
                    'value' => $PROD_FCSTATUS,
                    'source_id' => $magento
                );

                $select_eav_product1 = \DB::connection('magento')->table('catalog_product_index_eav')->where('entity_id',$magento)->where('store_id','1')->first();
                $select_eav_product2 = \DB::connection('magento')->table('catalog_product_index_eav')->where('entity_id',$magento)->where('store_id','2')->first();

                if($select_eav_product1 != null){
                    \DB::connection('magento')->table('catalog_product_index_eav')->where('entity_id',$magento)->where('store_id','1')->update($catalog_product_index_eav_product1);
                } else {
                    \DB::connection('magento')->table('catalog_product_index_eav')->insert($catalog_product_index_eav_product1);
                }
                if($select_eav_product2 != null){
                    \DB::connection('magento')->table('catalog_product_index_eav')->where('entity_id',$magento)->where('store_id','2')->update($catalog_product_index_eav_product2);
                } else {
                    \DB::connection('magento')->table('catalog_product_index_eav')->insert($catalog_product_index_eav_product2);
                }

                $catalog_product_index_price_web0 = array(
                    'entity_id' => $magento,
                    'customer_group_id' => '0',
                    'website_id' => '1',
                    'tax_class_id' => '2',
                    'price' => $PRICE_FNAMT,
                    'final_price' => $PRICE_FNAMT,
                    'min_price' => $PRICE_FNAMT,
                    'max_price' => $PRICE_FNAMT,
                    'tier_price' => $PRICE_FNAMT
                );
                $catalog_product_index_price_web1 = array(
                    'entity_id' => $magento,
                    'customer_group_id' => '1',
                    'website_id' => '1',
                    'tax_class_id' => '2',
                    'price' => $PRICE_FNAMT,
                    'final_price' => $PRICE_FNAMT,
                    'min_price' => $PRICE_FNAMT,
                    'max_price' => $PRICE_FNAMT,
                    'tier_price' => $PRICE_FNAMT
                );
                $catalog_product_index_price_web2 = array(
                    'entity_id' => $magento,
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
                    'entity_id' => $magento,
                    'customer_group_id' => '3',
                    'website_id' => '1',
                    'tax_class_id' => '2',
                    'price' => $PRICE_FNAMT,
                    'final_price' => $PRICE_FNAMT,
                    'min_price' => $PRICE_FNAMT,
                    'max_price' => $PRICE_FNAMT,
                    'tier_price' => $PRICE_FNAMT
                );

                $select_index_price_web0 = \DB::connection('magento')->table('catalog_product_index_price')->where('entity_id',$magento)->where('customer_group_id','0')->first();
                $select_index_price_web1 = \DB::connection('magento')->table('catalog_product_index_price')->where('entity_id',$magento)->where('customer_group_id','1')->first();
                $select_index_price_web2 = \DB::connection('magento')->table('catalog_product_index_price')->where('entity_id',$magento)->where('customer_group_id','2')->first();
                $select_index_price_web3 = \DB::connection('magento')->table('catalog_product_index_price')->where('entity_id',$magento)->where('customer_group_id','3')->first();

                if($select_index_price_web0){
                    \DB::connection('magento')->table('catalog_product_index_price')->where('entity_id',$magento)->where('customer_group_id','0')->update($catalog_product_index_price_web0);
                } else {
                    \DB::connection('magento')->table('catalog_product_index_price')->insert($catalog_product_index_price_web0);
                }
                if($select_index_price_web1){
                    \DB::connection('magento')->table('catalog_product_index_price')->where('entity_id',$magento)->where('customer_group_id','1')->update($catalog_product_index_price_web1);
                } else {
                    \DB::connection('magento')->table('catalog_product_index_price')->insert($catalog_product_index_price_web1);
                }
                if($select_index_price_web2){
                    \DB::connection('magento')->table('catalog_product_index_price')->where('entity_id',$magento)->where('customer_group_id','2')->update($catalog_product_index_price_web2);
                } else {
                    \DB::connection('magento')->table('catalog_product_index_price')->insert($catalog_product_index_price_web2);
                }
                if($select_index_price_web3){
                    \DB::connection('magento')->table('catalog_product_index_price')->where('entity_id',$magento)->where('customer_group_id','3')->update($catalog_product_index_price_web3);
                } else {
                    \DB::connection('magento')->table('catalog_product_index_price')->insert($catalog_product_index_price_web3);
                }


                $catalog_product_website = array(
                    'product_id' => $magento,
                    'website_id' => '1'
                );
                // $catalog_product_website2 = array(
                //     'product_id' => $magento,
                //     'website_id' => '2'
                // );

                $select_website = \DB::connection('magento')->table('catalog_product_website')->where('product_id',$magento)->where('website_id','1')->first();
                // $select_website2 = \DB::connection('magento')->table('catalog_product_website')->where('product_id',$magento)->where('website_id','2')->first();

                if($select_website != null){
                    \DB::connection('magento')->table('catalog_product_website')->where('product_id',$magento)->where('website_id','1')->update($catalog_product_website);
                } else {
                    \DB::connection('magento')->table('catalog_product_website')->insert($catalog_product_website);
                }
                // if($select_website2 != null){
                //     \DB::connection('magento')->table('catalog_product_website')->where('product_id',$magento)->where('website_id','2')->update($catalog_product_website2);
                // } else {
                //     \DB::connection('magento')->table('catalog_product_website')->insert($catalog_product_website2);
                // }

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

                $select_search_query = \DB::connection('magento')->table('search_query')->where('query_text',$PROD_FCSNAME)->first();

                if($select_search_query != null){

                } else {
                    \DB::connection('magento')->table('search_query')->insert($search_query);
                }

                $url_rewrite1 = array(
                    'entity_type' => 'product',
                    'entity_id' => $magento,
                    'request_path' => $PROD_FCSNAME,
                    'target_path' => 'catalog/product/view/id/'.$magento,
                    'redirect_type' => '',
                    'store_id' => '1',
                    'description' => '',
                    'is_autogenerated' => '1',
                    'metadata' => '',
                );
                // $url_rewrite2 = array(
                //     'entity_type' => 'product',
                //     'entity_id' => $magento,
                //     'request_path' => $PROD_FCSNAME,
                //     'target_path' => 'catalog/product/view/id/'.$magento,
                //     'redirect_type' => '',
                //     'store_id' => '2',
                //     'description' => '',
                //     'is_autogenerated' => '1',
                //     'metadata' => '',
                // );

                $select_url_rewrite1 = \DB::connection('magento')->table('url_rewrite')->where('entity_id',$magento)->where('store_id','1')->first();
                // $select_url_rewrite2 = \DB::connection('magento')->table('url_rewrite')->where('entity_id',$magento)->where('store_id','2')->first();

                if($select_url_rewrite1 != null){
                    \DB::connection('magento')->table('url_rewrite')->where('entity_id',$magento)->where('store_id','1')->update($url_rewrite1);
                } else {
                    \DB::connection('magento')->table('url_rewrite')->insert($url_rewrite1);
                }
                // if($select_url_rewrite2){
                //     \DB::connection('magento')->table('url_rewrite')->where('entity_id',$magento)->where('store_id','2')->update($url_rewrite2);
                // } else {
                //     \DB::connection('magento')->table('url_rewrite')->insert($url_rewrite2);
                // }

                $catalogsearch_fulltext_scope1_1 = array(
                    'entity_id' => $magento,
                    'attribute_id' => '73',
                    'data_index' => $PROD_FCSNAME,
                );
                $catalogsearch_fulltext_scope1_2 = array(
                    'entity_id' => $magento,
                    'attribute_id' => '74',
                    'data_index' => $PROD_FCSNAME,
                );
                $catalogsearch_fulltext_scope1_3 = array(
                    'entity_id' => $magento,
                    'attribute_id' => '75',
                    'data_index' => $PRODXA_HACO_SPEC_DESCRIPTION_TH,
                );
                $catalogsearch_fulltext_scope1_4 = array(
                    'entity_id' => $magento,
                    'attribute_id' => '76',
                    'data_index' => $PROD_FCNAME,
                );

                $select_fulltext_scope1_1 = \DB::connection('magento')->table('catalogsearch_fulltext_scope1')->where('entity_id',$magento)->where('attribute_id','73')->first();
                $select_fulltext_scope1_2 = \DB::connection('magento')->table('catalogsearch_fulltext_scope1')->where('entity_id',$magento)->where('attribute_id','74')->first();
                $select_fulltext_scope1_3 = \DB::connection('magento')->table('catalogsearch_fulltext_scope1')->where('entity_id',$magento)->where('attribute_id','75')->first();
                $select_fulltext_scope1_4 = \DB::connection('magento')->table('catalogsearch_fulltext_scope1')->where('entity_id',$magento)->where('attribute_id','76')->first();

                if($select_fulltext_scope1_1 != null){
                    \DB::connection('magento')->table('catalogsearch_fulltext_scope1')->where('entity_id',$magento)->where('attribute_id','73')->update($catalogsearch_fulltext_scope1_1);
                } else {
                    \DB::connection('magento')->table('catalogsearch_fulltext_scope1')->insert($catalogsearch_fulltext_scope1_1);
                }
                if($select_fulltext_scope1_2 != null){
                    \DB::connection('magento')->table('catalogsearch_fulltext_scope1')->where('entity_id',$magento)->where('attribute_id','74')->update($catalogsearch_fulltext_scope1_2);
                } else {
                    \DB::connection('magento')->table('catalogsearch_fulltext_scope1')->insert($catalogsearch_fulltext_scope1_2);
                }
                if($select_fulltext_scope1_3 != null){
                    \DB::connection('magento')->table('catalogsearch_fulltext_scope1')->where('entity_id',$magento)->where('attribute_id','75')->update($catalogsearch_fulltext_scope1_3);
                } else {
                    \DB::connection('magento')->table('catalogsearch_fulltext_scope1')->insert($catalogsearch_fulltext_scope1_3);
                }
                if($select_fulltext_scope1_4 != null){
                    \DB::connection('magento')->table('catalogsearch_fulltext_scope1')->where('entity_id',$magento)->where('attribute_id','76')->update($catalogsearch_fulltext_scope1_4);
                } else {
                    \DB::connection('magento')->table('catalogsearch_fulltext_scope1')->insert($catalogsearch_fulltext_scope1_4);
                }
                // $catalogsearch_fulltext_scope2_1 = array(
                //     'entity_id' => $magento,
                //     'attribute_id' => '73',
                //     'data_index' => $PROD_FCSNAME,
                // );
                // $catalogsearch_fulltext_scope2_2 = array(
                //     'entity_id' => $magento,
                //     'attribute_id' => '74',
                //     'data_index' => $PROD_FCSNAME,
                // );
                // $catalogsearch_fulltext_scope2_3 = array(
                //     'entity_id' => $magento,
                //     'attribute_id' => '75',
                //     'data_index' => $PRODXA_HACO_SPEC_DESCRIPTION_TH,
                // );
                // $catalogsearch_fulltext_scope2_4 = array(
                //     'entity_id' => $magento,
                //     'attribute_id' => '76',
                //     'data_index' => $PROD_FCNAME,
                // );

                // $select_fulltext_scope2_1 = \DB::connection('magento')->table('catalogsearch_fulltext_scope2')->where('entity_id',$magento)->where('attribute_id','73')->first();
                // $select_fulltext_scope2_2 = \DB::connection('magento')->table('catalogsearch_fulltext_scope2')->where('entity_id',$magento)->where('attribute_id','74')->first();
                // $select_fulltext_scope2_3 = \DB::connection('magento')->table('catalogsearch_fulltext_scope2')->where('entity_id',$magento)->where('attribute_id','75')->first();
                // $select_fulltext_scope2_4 = \DB::connection('magento')->table('catalogsearch_fulltext_scope2')->where('entity_id',$magento)->where('attribute_id','76')->first();

                // if($select_fulltext_scope2_1 != null){
                //     \DB::connection('magento')->table('catalogsearch_fulltext_scope2')->where('entity_id',$magento)->where('attribute_id','73')->update($catalogsearch_fulltext_scope2_1);
                // } else {
                //     \DB::connection('magento')->table('catalogsearch_fulltext_scope2')->insert($catalogsearch_fulltext_scope2_1);
                // }
                // if($select_fulltext_scope2_2 != null){
                //     \DB::connection('magento')->table('catalogsearch_fulltext_scope2')->where('entity_id',$magento)->where('attribute_id','74')->update($catalogsearch_fulltext_scope2_2);
                // } else {
                //     \DB::connection('magento')->table('catalogsearch_fulltext_scope2')->insert($catalogsearch_fulltext_scope2_2);
                // }
                // if($select_fulltext_scope2_3 != null){
                //     \DB::connection('magento')->table('catalogsearch_fulltext_scope2')->where('entity_id',$magento)->where('attribute_id','75')->update($catalogsearch_fulltext_scope2_3);
                // } else {
                //     \DB::connection('magento')->table('catalogsearch_fulltext_scope2')->insert($catalogsearch_fulltext_scope2_3);
                // }
                // if($select_fulltext_scope2_4 != null){
                //     \DB::connection('magento')->table('catalogsearch_fulltext_scope2')->where('entity_id',$magento)->where('attribute_id','76')->update($catalogsearch_fulltext_scope2_4);
                // } else {
                //     \DB::connection('magento')->table('catalogsearch_fulltext_scope2')->insert($catalogsearch_fulltext_scope2_4);
                // }

                $catalog_category_product_index1 = array(
                    'category_id' => '2',
                    'product_id' => $magento,
                    'position' => '0',
                    'is_parent' => '0',
                    'store_id' => '1',
                    'visibility' => $PROD_FCSTATUS
                );
                $catalog_category_product_index2 = array(
                    'category_id' => '2',
                    'product_id' => $magento,
                    'position' => '0',
                    'is_parent' => '0',
                    'store_id' => '2',
                    'visibility' => $PROD_FCSTATUS
                );

                $select_product_index1 = \DB::connection('magento')->table('catalog_category_product_index')->where('product_id',$magento)->where('store_id','1')->first();
                $select_product_index2 = \DB::connection('magento')->table('catalog_category_product_index')->where('product_id',$magento)->where('store_id','2')->first();

                if($select_product_index1 != null){
                    \DB::connection('magento')->table('catalog_category_product_index')->where('product_id',$magento)->where('store_id','1')->update($catalog_category_product_index1);
                } else {
                    \DB::connection('magento')->table('catalog_category_product_index')->insert($catalog_category_product_index1);
                }
                if($select_product_index2 != null){
                    \DB::connection('magento')->table('catalog_category_product_index')->where('product_id',$magento)->where('store_id','2')->update($catalog_category_product_index2);
                } else {
                    \DB::connection('magento')->table('catalog_category_product_index')->insert($catalog_category_product_index2);
                }

                /////////////////////////////// catalog_product_entity_datetime //////////////////////////////

                $date_start = array(
                    'attribute_id' => '79',
                    'store_id' => '0',
                    'entity_id' => $magento,
                    'value' => $PCONTRAC_FDBEGDATE,
                );
                $date_end = array(
                    'attribute_id' => '80',
                    'store_id' => '0',
                    'entity_id' => $magento,
                    'value' => $PCONTRAC_FDENDDATE,
                );

                $select_date_price_start = \DB::connection('magento')->table('catalog_product_entity_datetime')->where('attribute_id','79')->where('entity_id',$magento)->first();
                $select_date_price_end = \DB::connection('magento')->table('catalog_product_entity_datetime')->where('attribute_id','80')->where('entity_id',$magento)->first();

                if($select_date_price_start != null) {
                    \DB::connection('magento')->table('catalog_product_entity_datetime')->where('attribute_id','79')->where('entity_id',$magento)->update($date_start);
                } else {
                    \DB::connection('magento')->table('catalog_product_entity_datetime')->insert($date_start);
                }

                if($select_date_price_end != null){
                    \DB::connection('magento')->table('catalog_product_entity_datetime')->where('attribute_id','80')->where('entity_id',$magento)->update($date_end);
                } else {
                    \DB::connection('magento')->table('catalog_product_entity_datetime')->insert($date_end);
                }

                \DB::commit();
                $return['status'] = 1;
                $return['content'] = 'สำเร็จ';
                } catch (Exception $e) {
                    \DB::rollBack();
                    $return['status'] = 0;
                    $return['content'] = 'ไม่สำรเ็จ'.$e->getMessage();
                }
            return json_encode($return);
    }

    public function haco_api($foma=null){
        $prodxda = $this->getValueFoma('',$foma);

        // dd($prodxda);
        // exit();

        \DB::beginTransaction();
        try {
            // foreach($prodxda['data'] as $key => $value){
            if($prodxda['start'] == '' || $prodxda['start'] == ''){
                $PCONTRAC_FDBEGDATE = '';
                $PCONTRAC_FDENDDATE = '';
            } else {
                $PCONTRAC_FDBEGDATE = trim($prodxda['start']);
                $PCONTRAC_FDENDDATE = trim($prodxda['end']);
            }

                $PROD_FCSNAME = trim($prodxda['data']->PROD_FCSNAME); // ชื่อสินค้า & รหัสสินค้า & /* meta_title */                           +
                $PROD_FCNAME = trim($prodxda['data']->PROD_FCNAME); // รายละเอียดสินค้าโดยย่อ // meta_description                                 +
                $PROD_FCSNAME2 = trim($prodxda['data']->PROD_FCSNAME2); // ชื่อสินค้า Eng
                $PROD_FCNAME2 = trim($prodxda['data']->PROD_FCNAME2); // รายละเอียดสินค้าโดยย่อ Eng
                $PROD_FCSTATUS = trim($prodxda['data']->PROD_FCSTATUS); // สถานะ (เปิดการใช้งาน) & การมองเห็น(รายการสินค้า,ค้นหา)                         +
                $PRODXA_HACO_SPEC_DESCRIPTION_TH = trim($prodxda['data']->PRODXA_HACO_SPEC_DESCRIPTION_TH); // รายละเอียดสินค้า                       +
                $PRODXA_HACO_SPEC_DESCRIPTION_EN = trim($prodxda['data']->PRODXA_HACO_SPEC_DESCRIPTION_EN); // รายละเอียดสินค้า Eng
                $PRODXA_HACO_WEIGHT_SKU = trim($prodxda['data']->PRODXA_HACO_WEIGHT_SKU); // น้ำหนัก                                                          +
                $PRODXA_HACO_IMAGE_HIGH = trim($prodxda['data']->PRODXA_HACO_IMAGE_HIGH); // image
                $PRODXA_HACO_IMAGE_LOW = trim($prodxda['data']->PRODXA_HACO_IMAGE_LOW); // image & small_image & thumbnail
                $PRODXA_HACO_IMAGE_DRAW = trim($prodxda['data']->PRODXA_HACO_IMAGE_DRAW);
                $PRODXA_HACO_IMAGE_3D = trim($prodxda['data']->PRODXA_HACO_IMAGE_3D);
                $PRODXA_HACO_IMAGE_1 = trim($prodxda['data']->PRODXA_HACO_IMAGE_1);
                $PRODXA_HACO_IMAGE_2 = trim($prodxda['data']->PRODXA_HACO_IMAGE_2);
                $PRODXA_HACO_IMAGE_3 = trim($prodxda['data']->PRODXA_HACO_IMAGE_3);
                $PDCOLOR_FCNAME = trim($prodxda['data']->PDCOLOR_FCNAME); // สี
                $PDBRAND_FCNAME = trim($prodxda['data']->PDBRAND_FCNAME); /* meta_title */                                                                           /* + */
                $PDMODEL_FCNAME = trim($prodxda['data']->PDMODEL_FCNAME); // meta_keyword                                                                         +
                $PRICE_FNAMT = trim($prodxda['price']); // ราคา & ราคาส่วนลด
                // $PCONTRAC_FDBEGDATE = trim($prodxda['start']); // ราคาส่วนลดเริ่ม (null)
                // $PCONTRAC_FDENDDATE = trim($prodxda['end']); // สิ้นสุดราคาส่วนลด(null)
                $PROD_FTDATETIME = trim($prodxda['data']->PROD_FTDATETIME);
                $PROD_FTLASTUPD = trim($prodxda['data']->PROD_FTLASTUPD);

                if($PROD_FCSTATUS == "" || $PROD_FCSTATUS == null){
                    $PROD_FCSTATUS = "4";
                    $PROD_FCSTATUS2 = "1";
                } else {
                    $PROD_FCSTATUS = trim($prodxda['data']->PROD_FCSTATUS);
                    $PROD_FCSTATUS2 = trim($prodxda['data']->PROD_FCSTATUS);
                }

                // exit();

                ///////////////////// Product /////////////////////////
                $catalog_product_entity = array(
                    'attribute_set_id' => 4,
                    'type_id' => 'simple',
                    'sku' => $PROD_FCSNAME,
                    'has_options' => '0',
                    'required_options' => '0',
                    'created_at' => $PROD_FTDATETIME,
                    'updated_at' => $PROD_FTLASTUPD
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
                    'value' => $PRODXA_HACO_IMAGE_LOW,
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

                // exit();

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
                    'source_id' => $product
                );
                // $catalog_product_index_eav_product2 = array(
                //     'entity_id' => $product,
                //     'attribute_id' => '99',
                //     'store_id' => '2',
                //     'value' => $PROD_FCSTATUS,
                //     'source_id' => $max_catalog_product_index_eav+$key
                // );

                \DB::connection('magento')->table('catalog_product_index_eav')->insert($catalog_product_index_eav_product1);
                // \DB::connection('magento')->table('catalog_product_index_eav')->insert($catalog_product_index_eav_product2);

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
                    'value' => $PROD_FCSTATUS2
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
                    'customer_group_id' => '1',
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
                    'customer_group_id' => '2',
                    'website_id' => '1',
                    'tax_class_id' => '2',
                    'price' => $PRICE_FNAMT,
                    'final_price' => $PRICE_FNAMT,
                    'min_price' => $PRICE_FNAMT,
                    'max_price' => $PRICE_FNAMT,
                    'tier_price' => $PRICE_FNAMT
                );
                $catalog_product_index_price_web4 = array(
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
                \DB::connection('magento')->table('catalog_product_index_price')->insert($catalog_product_index_price_web2);
                \DB::connection('magento')->table('catalog_product_index_price')->insert($catalog_product_index_price_web3);
                \DB::connection('magento')->table('catalog_product_index_price')->insert($catalog_product_index_price_web4);

                ///////////////////////////////// catalog_product_website ////////////////////////////////////

                $catalog_product_website = array(
                    'product_id' => $product,
                    'website_id' => '1'
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

                $select_search_query = \DB::connection('magento')->table('search_query')->where('query_text',$PROD_FCSNAME)->first();

                if($select_search_query != null){

                } else {
                    \DB::connection('magento')->table('search_query')->insert($search_query);
                }
                // \DB::connection('magento')->table('search_query')->insert($search_query);

                $cataloginventory_stock_status = array(
                    'product_id' => $product,
                    'website_id' => '0',
                    'stock_id' => '1',
                    'qty' => '0.0000',
                    'stock_status' => '1',
                );

                \DB::connection('magento')->table('cataloginventory_stock_status')->insert($cataloginventory_stock_status);

                $catalogsearch_fulltext_scope1_1 = array(
                    'entity_id' => $product,
                    'attribute_id' => '73',
                    'data_index' => $PROD_FCSNAME,
                );
                $catalogsearch_fulltext_scope1_2 = array(
                    'entity_id' => $product,
                    'attribute_id' => '74',
                    'data_index' => $PROD_FCSNAME,
                );
                $catalogsearch_fulltext_scope1_3 = array(
                    'entity_id' => $product,
                    'attribute_id' => '75',
                    'data_index' => $PRODXA_HACO_SPEC_DESCRIPTION_TH,
                );
                $catalogsearch_fulltext_scope1_4 = array(
                    'entity_id' => $product,
                    'attribute_id' => '76',
                    'data_index' => $PROD_FCNAME,
                );

                \DB::connection('magento')->table('catalogsearch_fulltext_scope1')->insert($catalogsearch_fulltext_scope1_1);
                \DB::connection('magento')->table('catalogsearch_fulltext_scope1')->insert($catalogsearch_fulltext_scope1_2);
                \DB::connection('magento')->table('catalogsearch_fulltext_scope1')->insert($catalogsearch_fulltext_scope1_3);
                \DB::connection('magento')->table('catalogsearch_fulltext_scope1')->insert($catalogsearch_fulltext_scope1_4);

                $url_rewrite1 = array(
                    'entity_type' => 'product',
                    'entity_id' => $product,
                    'request_path' => $PROD_FCSNAME,
                    'target_path' => 'catalog/product/view/id/'.$product,
                    'redirect_type' => '',
                    'store_id' => '1',
                    'description' => '',
                    'is_autogenerated' => '1',
                    'metadata' => '',
                );

                $select_url_rewrite1 = \DB::connection('magento')->table('url_rewrite')->where('request_path',$PROD_FCSNAME)->where('entity_id',$product)->where('store_id','1')->first();
                // $select_url_rewrite2 = \DB::connection('magento')->table('url_rewrite')->where('entity_id',$magento)->where('store_id','2')->first();

                // dd($select_url_rewrite1);

                if($select_url_rewrite1 == null){
                    \DB::connection('magento')->table('url_rewrite')->insert($url_rewrite1);
                } else {
                    \DB::connection('magento')->table('url_rewrite')->where('entity_id',$product)->where('store_id','1')->update($url_rewrite1);
                    // \DB::connection('magento')->table('url_rewrite')->insert($url_rewrite1);
                }

                    // \DB::connection('magento')->table('url_rewrite')->insert($url_rewrite1);

                $datetime_start = array(
                    'attribute_id' => '79',
                    'store_id' => '0',
                    'entity_id' => $product,
                    'value' => $PCONTRAC_FDBEGDATE,
                );

                $datetime_end = array(
                    'attribute_id' => '80',
                    'store_id' => '0',
                    'entity_id' => $product,
                    'value' => $PCONTRAC_FDENDDATE,
                );

                if($prodxda['start'] != null && $prodxda['end'] != null){
                    \DB::connection('magento')->table('catalog_product_entity_datetime')->insert($datetime_start);
                    \DB::connection('magento')->table('catalog_product_entity_datetime')->insert($datetime_end);
                }

                $gallery = array(
                    'attribute_id' => '90',
                    'value' => $PRODXA_HACO_IMAGE_LOW,
                    'media_type' => 'image',
                    'disabled' => '0',
                );
                $gallery2 = array(
                    'attribute_id' => '90',
                    'value' => $PRODXA_HACO_IMAGE_1,
                    'media_type' => 'image',
                    'disabled' => '0',
                );
                $gallery3 = array(
                    'attribute_id' => '90',
                    'value' => $PRODXA_HACO_IMAGE_2,
                    'media_type' => 'image',
                    'disabled' => '0',
                );
                $gallery4 = array(
                    'attribute_id' => '90',
                    'value' => $PRODXA_HACO_IMAGE_3,
                    'media_type' => 'image',
                    'disabled' => '0',
                );

                if($PRODXA_HACO_IMAGE_LOW != null){
                    $gallert_id = \DB::connection('magento')->table('catalog_product_entity_media_gallery')->insertGetId($gallery);
                } else {
                    $gallert_id = '';
                }
                if($PRODXA_HACO_IMAGE_1 != null){
                    $gallert_id2 = \DB::connection('magento')->table('catalog_product_entity_media_gallery')->insertGetId($gallery2);
                } else {
                    $gallert_id2 = '';
                }
                if($PRODXA_HACO_IMAGE_2 != null){
                    $gallert_id3 = \DB::connection('magento')->table('catalog_product_entity_media_gallery')->insertGetId($gallery3);
                } else {
                    $gallert_id3 = '';
                }
                if($PRODXA_HACO_IMAGE_3 != null){
                    $gallert_id4 = \DB::connection('magento')->table('catalog_product_entity_media_gallery')->insertGetId($gallery4);
                } else {
                    $gallert_id4 = '';
                }

                // dd($PRODXA_HACO_IMAGE_LOW);

                $gallery_value = array(
                    'value_id' => $gallert_id,
                    'store_id' => '0',
                    'entity_id' => $product,
                    'label' => '',
                    'position' => '',
                    'disabled' => '0',
                );
                $gallery_value2 = array(
                    'value_id' => $gallert_id2,
                    'store_id' => '0',
                    'entity_id' => $product,
                    'label' => '',
                    'position' => '',
                    'disabled' => '0',
                );
                $gallery_value3 = array(
                    'value_id' => $gallert_id3,
                    'store_id' => '0',
                    'entity_id' => $product,
                    'label' => '',
                    'position' => '',
                    'disabled' => '0',
                );
                $gallery_value4 = array(
                    'value_id' => $gallert_id4,
                    'store_id' => '0',
                    'entity_id' => $product,
                    'label' => '',
                    'position' => '',
                    'disabled' => '0',
                );

                if($gallert_id != null){
                    \DB::connection('magento')->table('catalog_product_entity_media_gallery_value')->insert($gallery_value);
                }
                if($gallert_id2 != null){
                    \DB::connection('magento')->table('catalog_product_entity_media_gallery_value')->insert($gallery_value2);
                }
                if($gallert_id3 != null){
                    \DB::connection('magento')->table('catalog_product_entity_media_gallery_value')->insert($gallery_value3);
                }
                if($gallert_id4 != null){
                    \DB::connection('magento')->table('catalog_product_entity_media_gallery_value')->insert($gallery_value4);
                }

                $gallery_value_to_entity = array(
                    'value_id' => $gallert_id,
                    'entity_id' => $product,
                );

                $gallery_value_to_entity2 = array(
                    'value_id' => $gallert_id2,
                    'entity_id' => $product,
                );

                $gallery_value_to_entity3 = array(
                    'value_id' => $gallert_id3,
                    'entity_id' => $product,
                );

                $gallery_value_to_entity4 = array(
                    'value_id' => $gallert_id,
                    'entity_id' => $product,
                );

                if($gallert_id != null || $gallert_id != ''){
                    \DB::connection('magento')->table('catalog_product_entity_media_gallery_value_to_entity')->insert($gallery_value_to_entity);
                }
                if($gallert_id2 != null || $gallert_id2 != ''){
                    \DB::connection('magento')->table('catalog_product_entity_media_gallery_value_to_entity')->insert($gallery_value_to_entity2);
                }
                if($gallert_id3 != null || $gallert_id3 != ''){
                    \DB::connection('magento')->table('catalog_product_entity_media_gallery_value_to_entity')->insert($gallery_value_to_entity3);
                }
                if($gallert_id4 != null || $gallert_id4 != ''){
                    \DB::connection('magento')->table('catalog_product_entity_media_gallery_value_to_entity')->insert($gallery_value_to_entity4);
                }

                $select_color_color = \DB::connection('magento')->table('eav_attribute_option_value as value_color')
                ->where('store_id','0')
                ->where('value_color.value',$PDCOLOR_FCNAME) //PDCOLOR_FCNAME
                ->first();

                $select_entity_option = \DB::connection('magento')->table('eav_attribute_option')->max('sort_order');

                $select_entity_option_sum = $select_entity_option+1;

                if(!empty($select_color_color)){
                    $value_color = $select_color_color->value;
                    $color_value = $select_color_color->option_id;
                } else {
                    $value_color = '';
                    $color_value = '';
                }

                $select_color = \DB::connection('magento')->table('eav_attribute_option_value')->where('store_id','0')->where('value',$PDCOLOR_FCNAME)->first();

                $color_entity_option = array(
                    'attribute_id' => '93',
                    'sort_order' => $select_entity_option_sum,
                );

                $color_entity_option_value_insert = '';
                $color_entity_option_value_update = '';

                if($select_color == null || $select_color == ''){
                    $color_entity_option_value_insert = \DB::connection('magento')->table('eav_attribute_option')->insertGetId($color_entity_option);
                } else {
                    $color_entity_option_value_update = $select_color->option_id;
                }

                $color_value_text = array(
                    'option_id' => $color_entity_option_value_insert,
                    'store_id' => '1',
                    'value' => $PDCOLOR_FCNAME,
                );
                $color_value_text2 = array(
                    'option_id' => $color_entity_option_value_insert,
                    'store_id' => '0',
                    'value' => $PDCOLOR_FCNAME,
                );

                $update_color_value_text = array(
                    'store_id' => '1',
                    'value' => $PDCOLOR_FCNAME,
                );
                $update_color_value_text2 = array(
                    'store_id' => '0',
                    'value' => $PDCOLOR_FCNAME,
                );

                // dd($color_value);

                if($color_entity_option_value_insert != null || $color_entity_option_value_insert != ''){
                    \DB::connection('magento')->table('eav_attribute_option_value')->insert($color_value_text);
                    \DB::connection('magento')->table('eav_attribute_option_value')->insert($color_value_text2);
                } else {
                    \DB::connection('magento')->table('eav_attribute_option_value')->where('store_id','1')->where('option_id',$color_entity_option_value_update)->update($update_color_value_text);
                    \DB::connection('magento')->table('eav_attribute_option_value')->where('store_id','0')->where('option_id',$color_entity_option_value_update)->update($update_color_value_text2);
                }

                if($select_color == null || $select_color == ''){
                    $color = $color_entity_option_value_update;
                } else {
                    $color = $color_value;
                }

                $catalog_product_entity_int_color = array(
                    'attribute_id' => '93',
                    'store_id' => '0',
                    'entity_id' => $product,
                    'value' => $color
                );

                if($color_entity_option_value_update != null){
                    \DB::connection('magento')->table('catalog_product_entity_int')->where('entity_id',$product)->where('attribute_id','93')->update($catalog_product_entity_int_color);
                } else {
                    \DB::connection('magento')->table('catalog_product_entity_int')->insert($catalog_product_entity_int_color);
                }


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

            // }
        }catch (Exception $e) {
            report($e);
            return false;
        }
    }
}
