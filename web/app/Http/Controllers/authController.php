<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\veryfEmail;
use Mail;
use Hash;
use Session;
use DB;
use App\Mail\sendEmail;
use Str;

class authController extends Controller
{
    public function getLogin(){
        return view('welcome');
    }

    public function posLogin(Request $request)
    {
           $userId      = $request->input('userId');
           $password    = MD5($request->input('password'));
           $token       = $request->input('_token');
           $cek_user    = DB::table('tbl_users')->where('user_id' , $userId)->count();
           if($cek_user > 0){
                $cek_password = DB::table('tbl_users')->where('user_id' , $userId)->where('password' , $password)->count();
                if($cek_password > 0){
                        DB::table('tbl_users')->where('user_id', $userId)->update([
                        'token' => $token
                    ]);
                    $get_data = DB::table('tbl_users')->where('user_id' , $userId)->where('password' , $password)->get();
                    $get_data = $get_data->toArray();
                

                    foreach($get_data As $data);
                    $request->session()->put('kodeTemp', $data->kode_temp);
                    $request->session()->put('email', $data->email);
                    $request->session()->put('userId', $data->user_id);
                    $request->session()->put('password', $data->password);
                    $request->session()->put('level', $data->level);
                    $request->session()->put('verify_at', $data->verifyat);
                    $request->session()->put('token', $data->token);
                    return redirect('/dashboard');
                }elseif($cek_password < 1){
                    echo "password yang anda masukkan salah";
                    echo "<br>";
                    echo "<a href='/login'>back</a>";
                }
           }elseif($cek_user == 0){
            echo "user tidak terdaftar";
            echo "<br>";
            echo "<a href='/login'>back</a>";
           }
    }
    
    public function logout(Request $request){
        $request->session()->forget('kodeTemp');
        $request->session()->forget('email');
        $request->session()->forget('userId');
        $request->session()->forget('password');
        $request->session()->forget('level');
        $request->session()->forget('verify_at');
        $request->session()->forget('token');
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/login');
    }


    public function emailverify(){
        $send = new User;
        $send->user = trim(Session()->get('userId'));
        $send->email = trim(Session()->get('email'));
        $send->password = Hash::make(Session()->get('password'));
        $send->token  = trim(Session()->get('token'));
        
        Mail::to($send->email)->send(new sendEmail($send));
        return view('notice/warning_email');
       // echo $send;
    }


    public function verify($token){
            $cek = DB::table('tbl_users')->where('token' , $token)->count();
            if($cek > 0){
                $date = date('Y-m-d H:i:s');
                $update = DB::table('tbl_users')->where('token' , $token)->update([
                    'verifyat' => $date
                ]);
                return view('notice.msg_succes',['token' => $token]);

            }else if($cek < 1){
                echo "Session telah kadaluarsa atau token tidak terdaftar silahkan login kembali kemudian verifykasi ulang email anda";
            }
    }
}