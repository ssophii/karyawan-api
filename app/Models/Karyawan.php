<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $fillable = ['kode', 'nama','jabatan','divisi_id'];

    public function divisi(){
        return $this->belongsTo(Divisi::class);
    }
    /** @use HasFactory<\Database\Factories\KaryawanFactory> */
    use HasFactory;
}
