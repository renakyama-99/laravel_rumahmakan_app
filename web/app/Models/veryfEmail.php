<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Model;

class veryfEmail extends Model
{
    use HasFactory;
    public $table = "tbl_users";

    protected $fillable = ['user_id' , 'token'];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

}