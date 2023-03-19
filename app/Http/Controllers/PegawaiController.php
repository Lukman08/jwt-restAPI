<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(),[
            'nama' => 'required',
            'divisi' => 'required',
            'jabatan' => 'required',
        ],
        [ 
        'nama' => 'nama harus ada',
        'divisi' => 'divisi harus ada',
        'jabatan' => 'jabatan'
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ],401);
        } else{
            $pegawai = Pegawai::create([
                'nama'=>$request->nama,
                'divisi'=>$request->divisi,
                'jabatan'=>$request->jabatan,
            ]);
        }
    
        if ($pegawai) {
            return response()->json(['message' => 'Tambah pegawai berhasil']);
        } else{
            return response()->json(['message' => 'Tambah pegawai gagal']);
        }
    }
    
    public function index()
    {
        $pegawai = Pegawai::all();
        return response()->json($pegawai);
    }
    
    public function update(Request $request, $id)
    {
        // membuat validasi semua field wajib diisi
        $validator = Validator::make($request->all(), [
            'nama'     => 'required',
            'divisi'       => 'required',
            'jabatan'   => 'required'
        ],
        [
            'nama' => 'nama harus ada',
            'divisi' => 'divisi harus ada',
            'jabatan' => 'jabatan'
        ]);

        //jika validasi gagal maka kirim pesan error
        if($validator->fails()){
            //mengembalikan pesan error dengan menggunakan json
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Bidang Yang Kosong',
                'data'    => $validator->errors()
            ],401);
        }else{
            //melakukan update data berdasarkan $id
            $pegawai = Pegawai::find($id);
            $pegawai->nama = $request->nama;
            $pegawai->divisi = $request->divisi;
            $pegawai->jabatan = $request->jabatan;

            //jika berhasil maka simpan data dengan methode $pegawai->save()
            if($pegawai->save()){
                return response()->json( 'Edit pegawai berhasil');
            }else{
                return response()->json('Edit pegawai gagal');
            }
        }
    }
    
    public function show($id)
    {
        $pegawai = Pegawai::where('id', $id)->first();
        // return response()->json($pegawai);
        if($pegawai){
            return response([
                $pegawai
            ]);
        }else{
            return response([
                'tidak ada data'
            ]);
        }
    }
    
    public function destroy($id)
    {
        //mencari data sesuai $id
    $pegawai = Pegawai::findOrFail($id);

    // jika data berhasil didelete maka tampilkan pesan json 
    if($pegawai->delete()){
        return response([
            'Berhasil Menghapus Data'
        ]);
    }else{
        return response([
            'Tidak Berhasil Menghapus Data'
        ]);
    }
    }
}
