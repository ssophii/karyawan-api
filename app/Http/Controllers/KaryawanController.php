<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Http\Resources\KaryawanResource;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Karyawan::with('divisi')
            ->when($request->cari, fn ($q, $c)=>$q->where('nama', 'like', "%$c%"))
            ->latest()
            ->paginate(10);

        return KaryawanResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'kode' => 'required|unique:karyawans,kode',
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'divisi_id' => 'nullable|exists:divisis,id',
        ]);

        $karyawan = Karyawan::create($data)->load('divisi');
        return (new KaryawanResource($karyawan))->response()
            ->setStatusCode(201)   ;
    }

    /**
     * Display the specified resource.
     */
    public function show(Karyawan $karyawan)
    {
        return new KaryawanResource($karyawan->load('divisi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Karyawan $karyawan)
    {
        $data= $request->validate([
            'kode' => ['required', 'string', 'max:10',
            Rule::unique('karyawans', 'kode')->ignore($karyawan->id)],
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'divisi_id' => 'nullable|exists:divisis,id',
            ]);
        $karyawan->update($data);
        return new KaryawanResource($karyawan->load('divisi'));

        $karyawan = Karyawan::findOrFail($id);
        $karyawan->update($data);
        return new KaryawanResource($karyawan->load('divisi'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();
        return response()->noContent();
    }
}
