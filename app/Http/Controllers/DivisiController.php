<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Divisi;
use App\Http\Resources\DivisiResource;

class DivisiController extends Controller
{
    public function index()
    {
        return DivisiResource::collection(Divisi::withCount('karyawan')->get());
    }
}
