<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;


use App\Models\Order;

class CalculateController extends Controller
{
    //
    public function __construct() {
        // parent::__construct();

        $this->data['currentAdminMenu'] = 'calculate';
        $this->data['currentAdminSubMenu'] = 'calculate';
    }

    public function index()
    {
        $items = Order::select(DB::raw("orders.id as id_order,
                                    orders.user_id, 
                                    orders.shop_id, 
									orders.status, 
									orders.payment_status, 
									orders.income_rank, 
									orders.deleted_at, 
									order_items.product_id,
                                    users.city_id,
                                    regions.number,
                                    product_ingredients.ingredient_id,
                                    product_sells.prod_sell_number,
									shop_capitals.capital_id
									"))
						->leftJoin('order_items', 'order_items.order_id', '=', 'orders.id' )
						->leftJoin('users', 'users.id', '=', 'orders.shop_id' )
						->leftJoin('regions', 'regions.city_id', '=', 'users.city_id' )
						->leftJoin('product_ingredients', 'product_ingredients.product_id', '=', 'order_items.product_id')
                        ->leftJoin('product_sells', 'product_sells.product_id', '=', 'order_items.product_id')
						->leftJoin('shop_capitals', 'shop_capitals.shop_id', '=', 'orders.shop_id')
						->where('orders.status', 'created')
						->where('orders.payment_status', 'unpaid')
						->where('orders.deleted_at', null)
                        ->orderBy('id_order', 'ASC')
						->get();

        $this->data['items'] = $items;

        return view('admin.calculates.index', $this->data);
    }

    public function kmeans(){ 
        $currentAdminMenu = 'calculate';
        $currentAdminSubMenu = 'clustering';
        //init var data array       
        $data = [];
        $name = [];

        $dataOrders = Order::select(DB::raw("orders.id as id_order,
                                        orders.user_id, 
                                        orders.shop_id, 
                                        orders.status, 
                                        orders.payment_status, 
                                        orders.income_rank, 
                                        orders.deleted_at, 
                                        order_items.product_id,
                                        users.city_id,
                                        regions.number,
                                        product_ingredients.ingredient_id,
                                        product_sells.prod_sell_number,
                                        shop_capitals.capital_id
                                        "))
                                ->leftJoin('order_items', 'order_items.order_id', '=', 'orders.id' )
                                ->leftJoin('users', 'users.id', '=', 'orders.shop_id' )
                                ->leftJoin('regions', 'regions.city_id', '=', 'users.city_id' )
                                ->leftJoin('product_ingredients', 'product_ingredients.product_id', '=', 'order_items.product_id')
                                ->leftJoin('product_sells', 'product_sells.product_id', '=', 'order_items.product_id')
                                ->leftJoin('shop_capitals', 'shop_capitals.shop_id', '=', 'orders.shop_id')
                                ->where('orders.status', 'created')
                                ->where('orders.payment_status', 'unpaid')
                                ->where('orders.deleted_at', null)
                                ->orderBy('id_order', 'ASC')
                                ->get();
        // dd($dataOrders);
        //# looping change from collection array
        foreach($dataOrders as $row){
            $data[] = $row;
            $name[] = $row['number'];
        }
        //dd($name);
        //dd($earlydata);
        $data = [];
        //# looping change array to row(indexing)
        foreach($dataOrders as $row){
            $data[] = [
                $row['ingredient_id'],
                $row['number'],
                $row['prod_sell_number'],
                $row['income_rank'],
                $row['capital_id'],
            ];            
        }
        // dd($data);

        //# set K based on method,I set 3
        $cluster = 5;

        //# var centroid call method earlyCentroid
        $centroid = $this->earlyCentroid($data, $cluster);
        // dd($centroid[0]);                        
        $hasil_iterasi = [];
        $hasil_cluster = [];
        $itr = 0;        

        //-----------------K-MEANS-------------------
        while (true) {
            $iterasi = array();
            foreach ($data as $key => $valuedata) {
                //dd($valuedata);
                $iterasi[$key]['data'] = $valuedata;
                //dd($valuedata);
                //# value centroid => earlycentroid
                foreach ($centroid[$itr] as $key_centroid => $valuecentroid) {
                    //dd($valuecentroid);
                    //# array 2d jarak
                    $iterasi[$key]['jarak_ke_centroid'][] = $this->distance($valuedata,$valuecentroid);
                    //dd($iterasi);
                }
                //# array 2d jarak terdekat
                $iterasi[$key]['jarak_terdekat'] = $this->nearDistance($iterasi[$key]['jarak_ke_centroid'],$centroid);
                //dd($iterasi);
            }
            //# push two array into 1 array
            array_push($hasil_iterasi, $iterasi);        
            //dd($hasil_iterasi, $iterasi , $hasil_cluster); 
            $centroid[++$itr] = $this->newCentroid($iterasi, $hasil_cluster);
            //dd($centroid);
            $lanjutkan = $this->centroidChange($centroid, $itr);
            $boolval = boolval($lanjutkan) ? 'ya' : 'tidak';
            //# checking if centroid not change it will break        
            if(!$lanjutkan)
            break;
        }
        $result_centroid = last($centroid);
        //dd($result_centroid);
        $result_iterasi = last($hasil_iterasi);
        //dd($result_iterasi);        
        Order::deleteHelper();
        //dd($result_iterasi);
        foreach ($result_iterasi as $key => $value) {
            # code...
            //dd($value);
            $dcentroid1 = $value["jarak_ke_centroid"][0];
            $dcentroid2 = $value["jarak_ke_centroid"][1];
            $dcentroid3 = $value["jarak_ke_centroid"][2];
            $dcentroid4 = $value["jarak_ke_centroid"][3];
            $dcentroid5 = $value["jarak_ke_centroid"][4];
            $mindistance = $value["jarak_terdekat"]["value"];
            $clusterall = $value["jarak_terdekat"]["cluster"];        
            Order::saveHelper($dcentroid1, $dcentroid2, $dcentroid3, $dcentroid4, $dcentroid5, $mindistance,$clusterall);
        }
        //dd(end($hasil_iterasi));

        //------------------------DAVIES BOULDIN INDEX------------------
        //# var rs call method from model(collection) then change to array
        // $rs = Order::groupClusterHelper()->toArray();        
        //dd($rs);
        //# var ssw call method sumsquareWithin with param $rs
        // $ssw = $this->sumsquareWithin($rs);
        //# var ssb call method sumsquareWithin with param $result_centroid
        // $ssb = $this->sumsquareBetween($result_centroid);
        //# var ratio call method sumsquareWithin with param $rs
        // $ratio = $this->ratioDBI($ssw,$ssb);

        //------------------------PURITY--------------------------
        //# var Purity call method from model(collection) then change to array
        // $puritysr = Order::groupingSameValueCluster()->groupBy('cluster')->toArray();
        //dd($puritysr);
        // $purity = $this->purity($puritysr,$data);
        //dd($purity);
        // $test = array_count_values($purity);
        
        //dd($test);
        
        return view('admin.calculates.kmeans',compact('cluster','centroid','data','valuedata','valuecentroid','hasil_iterasi','name', 'currentAdminMenu', 'currentAdminSubMenu'));
    }

    public function earlyCentroid($data, $cluster){
        // dd($data);
        $randCentroid = [];
        for ($i=0; $i < $cluster; $i++) { 
            # code...
            $temp = [3, 10, 16, 23, 32];
            while(in_array($randCentroid, [$temp])){
                $temp = rand(0,(count($data)-1));
            }                        
            $centroid[0][] = [
                $data[$temp[$i]][0],
                $data[$temp[$i]][1],
                $data[$temp[$i]][2],
                $data[$temp[$i]][3],
                $data[$temp[$i]][4],
            ];                           
        }
        return $centroid;
    }

    public function distance($data, $centroid){ 
        // dd($centroid;
        $resultDistance = sqrt(pow(($data[0]-$centroid[0]),2)+pow(($data[1]-$centroid[1]),2)+pow(($data[2]-$centroid[2]),2)+pow(($data[3]-$centroid[3]),2)+pow(($data[4]-$centroid[4]),2));
        // dd($resultDistance);             
        return $resultDistance;        
    }

    public function nearDistance($jarak_ke_centroid,$centroid){
        foreach ($jarak_ke_centroid as $key => $value) {
            //# check mininum distance
            if(!isset($minimum)){
                $minimum=$value;
               
                $cluster=($key+1);
                continue;
            }
            else if($value<$minimum){
                $minimum=$value;
                $cluster=($key+1);
            }
        }
        return array(
            'cluster'=>$cluster,
            'value'=>$minimum,
        );
    }    

    public function newCentroid($iterasi,$hasil_cluster){
        $hasil_cluster = [];
        //# looping for regrouping based on cluster
        foreach ($iterasi as $key => $value) {
            //dd($value);
            $hasil_cluster[($value['jarak_terdekat']['cluster']-1)][0][]= $value['data'][0];
            $hasil_cluster[($value['jarak_terdekat']['cluster']-1)][1][]= $value['data'][1];
            $hasil_cluster[($value['jarak_terdekat']['cluster']-1)][2][]= $value['data'][2];        
            $hasil_cluster[($value['jarak_terdekat']['cluster']-1)][3][]= $value['data'][3];        
            $hasil_cluster[($value['jarak_terdekat']['cluster']-1)][4][]= $value['data'][4];        
        }
        //dd($hasil_cluster);    
        $new_centroid = [];
        //# looping for find new centroid in a way find average from each data
        foreach ($hasil_cluster as $key => $value) {
            # code...
            $new_centroid[$key] = [
                array_sum($value[0])/count($value[0]),
                array_sum($value[1])/count($value[1]),
                array_sum($value[2])/count($value[2]),
                array_sum($value[3])/count($value[3]),
                array_sum($value[4])/count($value[4]),
            ];
        }
        //dd($new_centroid);
        //sort based key array
        ksort($new_centroid);
        return $new_centroid;
    }

    public function centroidChange($centroid,$itr){
        $centroid_lama = $this->flatten_array($centroid[($itr-1)]); //flattern array
        //dd($centroid_lama);
        $centroid_baru = $this->flatten_array($centroid[$itr]); //flatten array
        //dd($centroid[$itr]);
        //# comparing old centroid dan new centroid if change return true, if not change/value jumlah equal = 0 return false
        $jumlah_sama = 0;
        for($i=0; $i<count($centroid_lama); $i++){
            if($centroid_lama[$i] === $centroid_baru[$i]){
                $jumlah_sama++;
            }
        }
        //dd($jumlah_sama);
        return $jumlah_sama === count($centroid_lama) ? false : true; 
    }

    function flatten_array($arg) {
        //dd($arg);
        //# find variable array then send value and then merge array
        return is_array($arg) ? array_reduce($arg, function ($c, $a) { 
            return array_merge($c, Arr::flatten($a)); },[]) : [$arg];
    }
    
    //TODO1 : Fungsi Sum Square Within (SSW)
    public function sumsquareWithin($rs){
        //dd(count($rs));        
        $result = 0;
        //looping based count param
        for ($iterate = 0; $iterate < count($rs) ; $iterate++) { 
            $result += $rs[$iterate]->average;
        }
        //dd($result);
        return $result;
    }
    //TODO2 : Fungsi Sum Square Between (SSB) 
    public function sumsquareBetween($result_centroid){
        //dd($result_centroid);        
        $resultc1c2 = sqrt(pow(($result_centroid[0][0]-$result_centroid[1][0]),2)+pow(($result_centroid[0][1]-$result_centroid[1][1]),2)+pow(($result_centroid[0][2]-$result_centroid[1][2]),2));
        $resultc1c3 = sqrt(pow(($result_centroid[0][0]-$result_centroid[2][0]),2)+pow(($result_centroid[0][1]-$result_centroid[2][1]),2)+pow(($result_centroid[0][2]-$result_centroid[2][2]),2));
        $resultc2c3 = sqrt(pow(($result_centroid[1][0]-$result_centroid[2][0]),2)+pow(($result_centroid[1][1]-$result_centroid[2][1]),2)+pow(($result_centroid[1][2]-$result_centroid[2][2]),2));
        
        $resultall = $resultc1c2+$resultc1c3+$resultc2c3;
        return $resultall;        
    } 
    //TODO3 : Fungsi Ratio(Output DBI)
    public function ratioDBI($ssw,$ssb){
        return $ssw/$ssb;
    }

    //TODO Fungsi Purity
    public function purity($puritysr,$data){
        # code...
        // dd($puritysr);
        //dd($data);
        $alldata = [];
        //# looping based on param
        for($i = 1 ; $i <= count($puritysr) ; $i++){
            $alldata[$i] = count($puritysr[$i]);
        }
        $puritytotal = array_sum($alldata)/count($data);
        //dd($alldata);
        return $puritytotal;
    }
}
