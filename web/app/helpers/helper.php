<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class helpers{
   public static function buat_kode($tabel,$inisial,$jumlah_str,$urutan_field,$wherefield){
     
 
    // 🔥 Ambil nama kolom sesuai urutan asli database
    $columns = DB::table('INFORMATION_SCHEMA.COLUMNS')
                ->select('COLUMN_NAME')
                ->where('TABLE_SCHEMA', DB::getDatabaseName())
                ->where('TABLE_NAME', $tabel)
                ->orderBy('ORDINAL_POSITION')
                ->pluck('COLUMN_NAME')
                ->toArray();

    if (!isset($columns[$urutan_field])) {
        throw new \Exception("Urutan field tidak ditemukan pada tabel {$tabel}");
    }

    $field = $columns[$urutan_field];

    // Hitung panjang inisial
    $jml_string_in = strlen($inisial);

    // Ambil kode terbesar berdasarkan field yang benar
    if ($wherefield != "") {
        $row = DB::table($tabel)
            ->where($wherefield, Session::get('kodeTemp'))
            ->max($field);
    } else {
        $row = DB::table($tabel)->max($field);
    }

    $kode = $row;

    if (empty($kode)) {
        $angka = 0;
        $panjang_string = $jumlah_str;
    } else {
        // Pisahkan angka dari inisial
        $angka = substr($kode, $jml_string_in);
        $panjang_string = strlen($kode);
    }

    $angka++;
    $angka = (string) $angka;

    // Tambahkan leading zero
    $tmp = "";
    for ($i = 0; $i < ($panjang_string - $jml_string_in - strlen($angka)); $i++) {
        $tmp .= "0";
    }

    return $inisial . $tmp . $angka;

}
 
}