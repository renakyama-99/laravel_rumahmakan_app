<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
use DB;
class authEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Session::get('userId') == ""){
            return redirect('login');
        }else if(Session::get('userId') != ""){
            $cek = Session::get('userId');
            $get_data = DB::table('tbl_users')->where('user_id' , $cek)->get();
            foreach($get_data As $data);
            if($data->verifyat == NULL){
                return redirect('notice');
            }else if($data->verifyat != NULL){
                return $next($request);
            }
           
            
        }
 
  
    }
}
