<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class helpers{
   public static function buat_kode($tabel,$inisial,$jumlah_str,$urutan_field,$wherefield){
     
        //QUERY MEMANGGIL NAMA TABEL FIELD PERTAMA
        $column  = Schema::getColumnListing($tabel);
        $field   = $column[$urutan_field];
         //MENGHITUNG JUMLAH STRING DALAM INISIAL
        $jml_string_in  = strlen($inisial);

        //QUERY UNTUK MENCARI NILAI TERTINGGI DARI TABEL FIELD PERTAMA
        if($wherefield != "" ){
            $row   = DB::table($tabel)->where($wherefield , Session::get('kodeTemp'))->max($field);
        }else{
            $row   = DB::table($tabel)->max($field);
        }
        
        $kode  = $row;
        if($kode == ""){
            $angka = 0;
            $panjang_string = $jumlah_str;
        }else{
            //MEMISAHKAN INISIAL DAN ANGKA 
            $angka = substr($kode,$jml_string_in);
            //MENGHITUNG JUMLAH MAKSIMAL STRING PADA TABEL FIELD PERTAMA
            $panjang_string = strlen($kode);
        }
        $angka++;
        $angka = strval($angka);
        $tmp = "";
        for($i=0;$i < ($panjang_string-$jml_string_in-strlen($angka)); $i++){
            $tmp = $tmp."0";
        }
        return $inisial.$tmp.$angka;
    }
    

}
 
