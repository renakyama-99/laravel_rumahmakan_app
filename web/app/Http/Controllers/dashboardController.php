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
class dashboardController extends Controller
{
    public function home(){
        return view('home');
    }

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
                $kode_temp = Session::get('kodeTemp');
                $cek       = DB::table('tabel_item')->where('kode_temp', $kode_temp)->count();
                $arrData = array("jumlah_data" => $cek,
                                  "arrData" => array());
                if($cek >= 1){
                    $query     = "SELECT * FROM tabel_item WHERE kode_temp='$kode_temp'";
                    $getData   = DB::select(DB::raw($query));
                    foreach($getData As $index => $value){
                        
                    }
                    
                }
                break;
        }
    }
}

