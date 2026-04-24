<?php
namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Post;
use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
class dashboardController extends Controller
{

    public function dashboard(){
        $kode_temp = Session::get('kodeTemp');
        $getData   = DB::table('tblprimary')->where('kode_temp' , $kode_temp)->get();
        return view('dashboard',[ 'data' => $getData ]);
    }

    public function saveMeja(Request $request){
        $action = $request->input('action');
        switch($action){
            case 'saveData':
                $kodeTempat = $request->input('kodeTemp');
                $kodeMeja   = $request->input('kodeMeja');
                $no_meja    = $request->input('noMeja');
                $insert     = DB::table('tabel_meja')->insert(
                    [ 'kode_temp' => $kodeTempat , 'kode_meja' => $kodeMeja , 'nomor_meja' => $no_meja ]
                );

                if($insert == '1'){
                    echo "berhasil";
                }elseif($insert != '1'){
                    echo 'gagal';
                }
            break;

            case 'load':
                $kodeTemp = $request->input('kode_temp');
                $cek      = DB::table('tabel_meja')->where('kode_temp' , $kodeTemp)->count();
        
                if($cek >= 1 ){
                    $data = DB::table('tabel_meja')->where('kode_temp' , $kodeTemp)->get();
                    $data_array = array(
                        'no' => 1,
                        'dataTable' => array(),
                    );
                    foreach($data As $index => $value){
                        $gabung[] = array($value->kode_temp , $value->kode_meja , $value->nomor_meja);
                    }
                    $data_array['dataTable'] = $gabung;
                    
                }elseif($cek < 1){
                    $data_array = array(
                        'no' => 1,
                        'dataTable' => array(),
                    );
                }
                echo json_encode($data_array);
            break;

            case 'delete' :
                    $id         = $request->input('id');
                    $kodeTemp   = $request->input('kodeTemp');
                    $delete     = DB::table('tabel_meja')->where( 'kode_temp' , $kodeTemp )->where( 'kode_meja' , $id)->delete();
                    if($delete == 1){
                        echo "berhasil";
                    }elseif($delete != '1'){
                        echo 'gagal';
                    }
                break;
        }
    }

    //public function buatFolder(){
   //     $path = public_path().'/folderUser/'.Session::get('kodeTemp');
   //     File::makeDirectory($path , 0777 , true);
   // }

   public function actionMenu(Request $req){
        $action = $req->input('action');
        switch($action){
            case 'save' :
                    $file_upload        = $req->file('file');
                    $kode               = $req->input('kodeItem');
                    $jenis              = $req->input('jenis_item');
                    $nama_item          = $req->input('nama_item');
                    $stock              = $req->input('stok'); 
                    $harga_jual         = $req->input('harga'); 
                    $diskon             = $req->input('disc');
                    $type               = $req->input('tipe');
                    $path_upload        = public_path().'/folderUser/'.Session::get('kodeTemp');
                    $array_extension    = array("JPEG","jpeg","JPG","jpg","png");
                    $cek                = DB::table('tabel_item')->where('kode_temp', Session::get('kodeTemp'))->where('kode_item', $kode)->count();
                    if($cek < 1){
                        if($file_upload != NULL){
                            $file_name          = $file_upload->getClientOriginalName();
                            $file_extension     = $file_upload->getClientOriginalExtension();
                            $new_file_name      = $kode.".".$file_extension;
                            if(!in_array($file_extension, $array_extension)){
                                echo 'extension salah';
                            }elseif(in_array($file_extension, $array_extension)){
                              $array_insert = array(
                                                    'kode_temp' => Session::get('kodeTemp'),
                                                    'kode_item' => $kode,
                                                    'jenis'     => $jenis,
                                                    'nama_item' => $nama_item,
                                                    'nama_file' => $new_file_name,
                                                    'stok'      => $stock,
                                                    'harga'     => $harga_jual,
                                                    'diskon'    => $diskon
                                                    );
                              $insert       = DB::table('tabel_item')->insert($array_insert);
                              $moved        = $file_upload->move($path_upload,$new_file_name);
                              if($insert == "1"){
                                echo "berhasil";
                              }
                            }
                        }
                    }

             break;   

             case 'load' :
                   $batas  = 12;
                   if($req->input('halaman') == ""){
                        $hal        = 1;
                   }else{
                        $hal        = $req->input('halaman');
                   }

                   $offset          =  ($hal - 1) * $batas;
                   $no_mulai        = $offset + 1;
                   
                   if($req->input('cari') != ""){
                    $cari = $req->input('cari');
                        $where = "AND (nama_item LIKE '%$cari%' OR harga LIKE '%$cari%' OR jenis LIKE '%$cari%')";
                   }else{
                        $where = "";
                   }
                   $query           = "SELECT * FROM tabel_item WHERE kode_temp='".Session::get('kodeTemp')."' $where LIMIT $offset,$batas";
                   $query_hitung    = "SELECT * FROM tabel_item WHERE kode_temp='".Session::get('kodeTemp')."' $where ";
                   $jum_data        = count(DB::select($query_hitung));
                   $jum_halaman     = ceil($jum_data/$batas);
                   if($jum_data < 1){
                        $main_data = array(
                            'no'  => 1,
                            'halaman_aktif' => intval($hal),
                            'jumlah_halaman' => intval($jum_halaman),
                            'data' => array(),
                        );
                   }else{
                    $main_data = array(
                        'no'  => $no_mulai,
                        'halaman_aktif' => intval($hal),
                        'jumlah_halaman' => intval($jum_halaman),
                        'data' => array(),
                    );

                    $tampilData = DB::select(DB::raw($query));
                    foreach($tampilData As $index => $value){
                        $gabung[] = array($value->kode_temp , $value->kode_item, $value->nama_item, $value->nama_file, $value->stok, $value->harga, $value->diskon, $value->type);
                    }
                    $main_data['data'] = $gabung;
                   }

                   echo json_encode($main_data);
                break;
 
                case 'update' :
                     $kodeItem = $req->input('kode_item');
                     $jenis    = $req->input('jenis');
                     $namaItem = $req->input('nama_item');
                     $file     = $req->file('file');
                     $stok     = $req->input('stok');
                     $harga    = $req->input('harga');
                     $diskon   = $req->input('diskon');
                     $type     = $req->input('type');
                     $namafile = $req->input('filename');
                     $namaFileSplit = explode(".",$namafile);
                     if($file != NULL){
                        $path_upload         = public_path().'/folderUser/'.Session::get('kodeTemp');
                        $array_extension     = array("JPEG","jpeg","JPG","jpg","png");
                        $extensionFileUpload = $file->getClientOriginalExtension();
                        $nameFileUpload      = $file->getClientOriginalName();
                        if(!in_array($extensionFileUpload,$array_extension)){
                            echo "extensi file salah";
                        }elseif(in_array($extensionFileUpload,$array_extension)){
                            $patch      = public_path().'/folderUser/'.Session::get('kodeTemp');
                            $newFileName = $namaFileSplit[0].".".$extensionFileUpload;
                            File::delete($patch."/".$namafile);

                            //memindahkan file baru kedalam folder
                            $file->move($patch,$newFileName);
                            $update = DB::table('tabel_item')
                                    ->where('kode_temp',Session::get('kodeTemp'))
                                    ->where('kode_item',$kodeItem)
                                    ->update([
                                        'jenis' => $jenis,
                                        'nama_item' => $namaItem,
                                        'nama_file' => $newFileName,
                                        'stok' => $stok,
                                        'harga' => $harga,
                                        'diskon' => $diskon,
                                        'type' => $type
                                    ]);
                            echo "update berhasil";     
                        }
                        
                        
                     }elseif($file == NULL){
                          $update = DB::table('tabel_item')
                                    ->where('kode_temp',Session::get('kodeTemp'))
                                    ->where('kode_item',$kodeItem)
                                    ->update([
                                        'jenis' => $jenis,
                                        'nama_item' => $namaItem,
                                        'stok' => $stok,
                                        'harga' => $harga,
                                        'diskon' => $diskon,
                                        'type' => $type
                                    ]);
                            echo "update berhasil";  
                     }
                    break;
        }
   }

   public function editProduk($id){
        $kode_temp = Session::get('kodeTemp');
        $count     = DB::table('tabel_item')->where('kode_temp', $kode_temp)->where('kode_item', $id)->count();
        if($count < 1){
            echo "Error! no Data";
        }elseif($count > 0){
            $getData = DB::table('tabel_item')->where('kode_temp', $kode_temp)->where('kode_item', $id)->get();
            return view('pages/editItem',['data' => $getData]);
        }
   }

   public function act_pesanan(Request $req){
     $action = $req->input('action');
        switch($action){
            case 'loadData' :
                $kode_temp      = Session::get('kodeTemp');
                $cari           = $req->input('cari');
                $query          = DB::table('tabel_item')->where('kode_temp', $kode_temp);
                if(!empty($cari)){
                    $query->where('nama_item', 'LIKE', '%' . $cari . '%');
                }
                $cek = $query->count();
                $arrData = array("jumlah_data" => $cek,
                                  "arr" => array());
                if($cek >= 1){
                    
                    $getData   = $query->get();
                    foreach($getData As $index => $value){
                        $gabung[] = array(
                             "kodeTem" => $value->kode_temp, 
                             "kodeItem" => $value->kode_item,
                             "jenis" => $value->jenis,
                             "namaItem" => $value->nama_item,
                             "locationFile" => $kode_temp."/".$value->nama_file,
                             "stok" => $value->stok,
                             "harga" => $value->harga,
                             "diskon" => $value->diskon
                            );
                    }
                    
                    $arrData['arr'] = $gabung;
                    echo json_encode($arrData);
                }elseif($cek < 1){
                    $arrData = array("jumlah_data" => $cek,
                                    "arr" => array());
                    echo json_encode($arrData);               
                }
                break;

            case 'getMeja' :
                $kodetemp = $req->input('kode');
                $cek      = DB::table('tabel_meja')->where('kode_temp' , $kodetemp)->count();
            
                if($cek > 0){
                    $arr     = array(
                        "jmlData" => $cek,
                        "arrData" => array()
                        );
                    $getData = DB::table('tabel_meja')->where('kode_temp' , $kodetemp)->get();
                    foreach($getData As $idx => $val){
                        $gabung[] = array(
                            "kodeMeja"    => $val->kode_meja,
                            "nomorMeja" => $val->nomor_meja
                        );
                    }
                     $arr['arrData'] = $gabung;
                     echo json_encode($arr);
                }elseif($cek < 1){
                    $arr     = array(
                        "jmlData" => $cek,
                        "arrData" => array()
                        );
                    echo json_encode($arr);
                }
                break;

            case 'addPesanan' :
                    $kode_tempat = $req->input('kodeTemp');
                    $kode_item   = $req->input('kode_item');
                    $harga       = $req->input('harga');
                    $diskon      = $req->input('disc');
                    $kodeMeja    = $req->input('meja');
                    $nama_item   = $req->input('nama_item');
                    $user        = Session::get('userId');
                    $cek         = DB::table('tmp_pesanan')->where('kode_temp', $kode_tempat)
                                                           ->where('user',$user)
                                                           ->where('kode_meja',$kodeMeja)
                                                           ->where('kode_item', $kode_item)->count();
                    if($cek < 1){
                        $potongan   = ($harga * $diskon) / 100;
                        $hargaJual  = $harga - $potongan;
                        $arrInsert  = array(
                            'kode_temp' => $kode_tempat,
                            'user'      => $user,
                            'kode_meja' => $kodeMeja,
                            'kode_item' => $kode_item,
                            'nama_item' => $nama_item,
                            'harga_jual'=> $hargaJual,
                            'diskon'    => $diskon,
                            'qty'       => 1,
                            'total'     => 1 * $hargaJual
                        );
                        $insert    = DB::table('tmp_pesanan')->insert($arrInsert);
                        $arrData   = array(
                            'msg' => 'insert sukses',
                            'qty' => 1
                        );
                        echo json_encode($arrData);
                    }elseif($cek > 0){
                        $potongan   = ($harga * $diskon) / 100;
                        $hargaJual  = $harga - $potongan;
                        $getQty     = DB::table('tmp_pesanan')->where('kode_temp', $kode_tempat)
                                                              ->where('user',$user)
                                                              ->where('kode_meja',$kodeMeja)
                                                              ->where('kode_item', $kode_item)->value('qty');
                        
                        $qtyUpdate =  $getQty +1;                                
                        $updateTable =  DB::table('tmp_pesanan')->where('kode_temp', $kode_tempat)
                                                              ->where('user',$user)
                                                              ->where('kode_meja',$kodeMeja)
                                                              ->where('kode_item', $kode_item)->update([
                                                                'qty' => $qtyUpdate,
                                                                'total' => $qtyUpdate * $hargaJual
                                                              ]);     
                        $arrData   = array(
                            'msg' => 'update sukses',
                            'qty' => $qtyUpdate
                        ); 
                        echo json_encode($arrData);                                                                  
                    }                                       
                break;

                case 'delPesanan' :
                    $kode_tempat = $req->input('kodeTemp');
                    $kode_item   = $req->input('kode_item');
                    $harga       = $req->input('harga');
                    $diskon      = $req->input('disc');
                    $kodeMeja    = $req->input('meja');
                    $nama_item   = $req->input('nama_item');
                    $user        = Session::get('userId');
                    $cek         = DB::table('tmp_pesanan')->where('kode_temp', $kode_tempat)
                                                           ->where('user',$user)
                                                           ->where('kode_meja',$kodeMeja)
                                                           ->where('kode_item', $kode_item)->count();
                    if($cek > 0){
                        $potongan   = ($harga * $diskon) / 100;
                        $hargaJual  = $harga - $potongan;
                        $getQty     = DB::table('tmp_pesanan')->where('kode_temp', $kode_tempat)
                                                              ->where('user',$user)
                                                              ->where('kode_meja',$kodeMeja)
                                                              ->where('kode_item', $kode_item)->value('qty');
                                
                        if($getQty > 1){
                         $qtyUpdate   =  $getQty - 1;   
                         $updateTable =  DB::table('tmp_pesanan')->where('kode_temp', $kode_tempat)
                                                              ->where('user',$user)
                                                              ->where('kode_meja',$kodeMeja)
                                                              ->where('kode_item', $kode_item)->update([
                                                                'qty' => $qtyUpdate,
                                                                'total' => $qtyUpdate * $hargaJual
                                                              ]);  
                        $arrData   = array(
                            'msg' => 'update sukses',
                            'qty' => $qtyUpdate
                        ); 
                        echo json_encode($arrData);
                        
                        }elseif($getQty == 1){
                         $deleteRow = DB::table('tmp_pesanan')->where('kode_temp', $kode_tempat)
                                                              ->where('user',$user)
                                                              ->where('kode_meja',$kodeMeja)
                                                              ->where('kode_item', $kode_item)->delete();
                        $arrData   = array(
                                    'msg' => 'update sukses',
                                    'qty' => 0
                                ); 
                        echo json_encode($arrData);                                     
                        }
                    }elseif($cek < 1){
                        $arrData   = array(
                            'msg' => 'data kosong',
                            'qty' => 0
                        ); 
                        echo json_encode($arrData);
                    }
                    break;

                    case 'getkeranjang':
                        $kode_tempat = $req->input('kodeTempat');
                        $kodeMeja    = $req->input('meja');
                        $user        = Session::get('userId');
                        $cek         = DB::table('tmp_pesanan')->where('kode_temp', $kode_tempat)
                                                           ->where('user',$user)
                                                           ->where('kode_meja',$kodeMeja)->count();
                        if($cek > 0){
                            $gabung = collect();
                            $get = DB::table('tmp_pesanan')->where('kode_temp', $kode_tempat)
                                                           ->where('user',$user)
                                                           ->where('kode_meja',$kodeMeja)->get();
                            foreach($get As $index => $value){
                                $getNamaFile = DB::table('tabel_item')->where('kode_temp', $kode_tempat)
                                                                      ->where('kode_item', $value->kode_item)
                                                                      ->value('nama_file');
                                $gabung->push([
                                    "kodeTem"   => $value->kode_temp, 
                                    'user'      => $value->user,
                                    'kodeItem'  => $value->kode_item,
                                    'namaItem'  => $value->nama_item,
                                    'qty'       => $value->qty,
                                    'hargaJual' => $value->harga_jual,
                                    'sub'  => $value->total,
                                    "locationFile" => $kode_tempat."/".$getNamaFile
                                ]);
                            }    
                                $gabung = $gabung
                                        ->sortBy('kodeTem')
                                        ->sortBy('namaItem')
                                        ->values()
                                        ->toArray();
                               $arr = [
                                    'jmlData' => $cek,
                                    'load'    => $gabung
                                ];
                                                        
                        }elseif($cek < 1){
                            $arr = [
                                'jmlData' => $cek,
                                 'load'   => []
                                ];
                           
                        }
                         echo json_encode($arr, JSON_UNESCAPED_UNICODE);
                        break;

                        case 'cekPesanan':
                            $kodeMeja    = $req->input('meja');
                            $user        = $req->input('user');
                            $kode_tempat = Session::get('kodeTemp');
                            $cek         = DB::table('tmp_pesanan')->where('kode_temp', $kode_tempat)
                                                           ->where('user',$user)
                                                           ->where('kode_meja',$kodeMeja)->count();
                            if($cek > 0){
                                echo "ada";
                            }elseif($cek < 1){
                                 echo "kosong";
                            }                 
                            break;
        }
    }

    public function actDapur(Request $req){
        $action = $req->input('action');
        switch($action){
            case 'loadData' :
                $kodeTemp = Session::get('kodeTemp');
                $query    = DB::table('tblPenjualan')
                            ->leftJoin('tabel_meja', 'tblPenjualan.kodeMeja', '=', 'tabel_meja.kode_meja')
                            ->where('tblPenjualan.kode_temp', $kodeTemp)->where('tblPenjualan.statPesanan','belum dimasak')
                            ->select('tblPenjualan.*', 'tabel_meja.nomor_meja');
                if($query->count() < 1){
                    $arrData = array(
                        "jmlData" => $query->count(),
                        "load"    => array()
                    );
                }elseif($query->count() > 0){
                    $getData = $query->get();
                    $gb = collect();
                    foreach($getData As $index => $value){
                        $gbTmp = collect();
                        $queryItem = DB::table('tmp_penjualan')->where('no_penjualan' , $value->no_penjualan);
                        $getItem = $queryItem->get();
                        foreach($getItem  As $idxtmp => $valueTmp){
                            
                            $gbTmp->push([
                                'namaItem' => $valueTmp->nama_item,
                                'harga' => $valueTmp->harga_jual,
                                'qty'   => $valueTmp->qty
                            ]);
                        }
                        $gb->push([
                            'kodeTemp' => $value->kode_temp,
                            'no_penjualan' => $value->no_penjualan,
                            'nomorMeja' => $value->nomor_meja,
                            'pelanggan' => $value->namaPelanggan,
                            'subtotal' => $value->subtotal,
                            'waktuPesan' => $value->tglTrans,
                            'statusPesanan' => $value->statPesanan,
                            'note' => $value->keterangan,
                            'loadItem' => $gbTmp
                        ]);
                    }
                    $arrData = array(
                        "jmlData" => $query->count(),
                        "load"    => $gb
                    );
                }

                echo json_encode($arrData);
                break;

                case 'loadDoneData':
                        
                        $tgl    = $req->input('date');
                        $kodeTemp = Session::get('kodeTemp');
                    
                        $batas = 10;
                        if($req->input('hal') == ""){
                            $hal = 1;
                        }else{
                            $hal = $req->input('hal');
                        }
                        $offset = ($hal - 1) * $batas;
                       $query = DB::table('tblPenjualan')
                                    ->leftJoin('tabel_meja', 'tblPenjualan.kodeMeja', '=', 'tabel_meja.kode_meja')
                                    ->where('tblPenjualan.kode_temp', $kodeTemp)      
                                    ->where('tblPenjualan.statPesanan', 'sudah dimasak')  
                                    ->select('tblPenjualan.*', 'tabel_meja.nomor_meja');
                        if($tgl != ""){
                            $split = explode(' to ', $tgl);
                            $countSplit = count($split);
                            if($countSplit == 2){
                                $startDate = trim($split[0]);
                                $endDate = trim($split[1]);
                                $query = $query->whereBetween('tblPenjualan.tglTrans', [
                                    Carbon::parse($startDate)->startOfDay() , Carbon::parse($endDate)->endOfDay()
                                ]);
                            }elseif($countSplit == 1){
                                $date = trim($split[0]);
                                $query = $query->whereBetween('tblPenjualan.tglTrans', [
                                    Carbon::parse($date)->startOfDay() , Carbon::parse($date)->endOfDay()
                                ]);
                            }
                        }

                        $count  = $query->count();
                        $jmlHalaman = ceil($count /$batas);
                        $getData    = $query->offset($offset)->limit($batas)->get();
                        if($count > 0){
                            $gabung = collect();
                            foreach($getData as $idx => $val){
                                $gbTmp = collect();
                                $queryItem = DB::table('tmp_penjualan')->where('no_penjualan' , $val->no_penjualan)->get();
                                foreach($queryItem as $idxTmp => $valTmp){
                                    $gbTmp->push([
                                        'namaItem' => $valTmp->nama_item,
                                        'harga' => $valTmp->harga_jual,
                                        'qty'   => $valTmp->qty
                                    ]);
                                }
                                $gabung->push([
                                        'kodeTemp' => $val->kode_temp,
                                        'no_penjualan' => $val->no_penjualan,
                                         'noMeja' => $val->nomor_meja,
                                        'pelanggan' => $val->namaPelanggan,
                                        'subtotal' => $val->subtotal,
                                        'waktuPesan' => $val->tglTrans,
                                        'statusPesanan' => $val->statPesanan,
                                        'loadItem' => $gbTmp
                                    ]);
                            }
                            $arrData = array(
                                'jmlData' => $count,
                                'jmlHalaman' => $jmlHalaman,
                                'halAktif'  => $hal,
                                'loadData' =>  $gabung
                            );
                        }else{
                            $arrData = array(
                                'jmlData' => $count,
                                'jmlHalaman' => $jmlHalaman,
                                'halAktif'  => $hal,
                                'loadData' =>  array()
                            );
                        }

                        return response()->json($arrData);
                    break;
        }
    }

    public function actionKasir (Request $req){
        $action = $req->input('action');
        switch($action){
            case 'getData':
                 $search    = $req->input('search');
                 $kodeTemp  = Session::get('kodeTemp');
                 $query     = DB::table('tblPenjualan')
                    ->leftJoin('tabel_meja', 'tblPenjualan.kodeMeja', '=', 'tabel_meja.kode_meja')
                    ->select('tblPenjualan.*', 'tabel_meja.nomor_meja')
                    ->where('tblPenjualan.kode_temp', $kodeTemp)->where('tblPenjualan.status', 'belum bayar');
                 if(!empty($search)){
                    $query = $query->where(function($whr) use ($search) {
                        $whr->where('tblPenjualan.namaPelanggan', 'LIKE', "%{$search}%")
                            ->orWhere('tblPenjualan.no_penjualan', 'LIKE', "%{$search}%")
                            ->orWhere('tabel_meja.nomor_meja', 'LIKE', "%{$search}%");
                        });
                 }
                 $count = $query->count();
                 $arr = collect();
                 $get = $query->get();
                 foreach($get as $idx => $value){
                    $gbItem = collect();
                    $queryItem = DB::table('tmp_penjualan')->where('kode_temp',$value->kode_temp)->where('no_penjualan', $value->no_penjualan)->get();
                    foreach($queryItem as $idxItem => $valItem){
                        $gbItem->push([
                            'namaItem' => $valItem->nama_item,
                            'qty' => $valItem->qty
                        ]);
                    }
                    $arr->push([
                        'namaPelanggan' => $value->namaPelanggan,
                        'meja'          => $value->nomor_meja,
                        'nomorPenjualan'=> $value->no_penjualan,
                        'total'         => $value->subtotal,
                        'statPesanan'   => $value->statPesanan,
                        'statBayar'     => $value->status,
                        'tgl_transaksi' => $value->tglTrans,
                        'itemList'      => $gbItem
                    ]);
                 }
                 return response()->json($arr);
                break;
        }
    }

    public function transaksiBayar($noPenjualan){
                return view('pages.cashier');
                
    }
}

