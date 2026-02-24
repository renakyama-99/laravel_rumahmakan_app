<?php
namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Post;
use Illuminate\Http\Request;
use DB;
use Helper;
use Illuminate\Support\Facades\File;

class my_controller extends Controller
{

    public function register(Request $request){
       $nama_tem    = $request->input('name_location');
       $alamat      = $request->input('alamat');
       $email       = $request->input('email');
       $user_id     = $request->input('user_id');
       $pass        = MD5($request->input('pass'));
       $no_telpon   = $request->input('no_telpon');
       $pos_code    = $request->input('pos_code');
       $code        = $request->input('code');
       $level       = "admin";
       $cek_email   = DB::table('tblprimary')->where('email' , $email)->count();
       $cek_user    = DB::table('tbl_users')->where('user_id' , $user_id)->count();
       if($cek_email > 0){
            echo "email yang anda masukkan sudah terdaftar";
       }elseif($cek_user > 0){
            echo "user id yang anda masukkan sudah ada, silahkan gunakan id lain";
       }else{  
        DB::table('tblprimary')->insert([
            'kode_temp'=>$code,
            'nama_temp' => $nama_tem,
            'alamat' => $alamat,
            'email' => $email,
            'no_telpon' => $no_telpon,
            'kode_pos' => $pos_code
            
         ]);

         DB::table('tbl_users')->insert([
            'kode_temp' => $code,
            'email' => $email,
            'user_id' => $user_id,
            'password' => $pass,
            'level' => $level,
            'verifyat' => NULL,
            'token' => '',
         ]);
         $path = public_path().'/folderUser/'.$code;
         File::makeDirectory($path , 0777 , true);

            echo "ANDA SUDAH BERHASIL MENDAFTAR SILAHKAN LOGIN";
            echo "<br>";
            echo "<a href='/login'>back</a>"; 
       }

   
    
    }

}
