<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MataKuliah;
use App\Http\Resources\MatakuliahResource;
use Illuminate\Support\Facades\Validator;

class MatakuliahController extends Controller
{
    //TODO ( Praktikan Nomor Urut 5 )
    // Tambahkan fungsi index yang akan menampilkan List Data Matakuliah
    // dan fungsi show yang akan menampilkan Detail Data Mahasiswa yang dipilih

    //TODO ( Praktikan Nomor Urut 6 )
    // Tambahkan fungsi store yang akan menyimpan data MataKuliah baruurn new MatakuliahResource(true, 'Data Matakuliah Berhasil Ditambahkan!', $matakuliah)
    public function  store(Request $request)
    {
        $validator = Validator::make($request ->all(),[
            'nama' => ['required', 'string', 'max:255'],
            'kode' => ['required', 'string','max:255','unique:mata_kuliahs'],
            'sks'  => ['required', 'interger'],
        ]);

        if ($validator->fais()) {
            return response() ->json($validator->error(), 422);
        }

        $matakuliah = Matakuliah::create([
            'nama' => $request -> nama,
            'kode' => $request -> kode,
            'sks'  => $request -> sks,
        ]);
        
        return new MatakuliahResource(true, 'Data Matakuliah Berhasil Ditambahkan!', $matakuliah);
    }
    //TODO ( Praktikan Nomor Urut 7 )
    // Tambahkan fungsi update yang mengubah data MataKuliah yang dipilih

    //TODO ( Praktikan Nomor Urut 8 )
    // Tambahkan fungsi destroy yang akan menghapus data MataKuliah yang dipilih
}

