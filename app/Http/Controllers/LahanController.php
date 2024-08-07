<?php

namespace App\Http\Controllers;

use App\Models\Lahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LahanController extends Controller
{
    public function index()
    {
        $lahans = Lahan::where('user_id', Auth::id())->get();

        return view('users.data-lahan', ['lahans' => $lahans]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lahan' => 'required|string|max:255',
            'luas_lahan' => 'required|numeric',
            'isi_lahan' => 'required|string|max:255',
            'pemilik_lahan' => 'required|string|max:255',
            'alamat_lahan' => 'required|string|max:255',
            'denah_lahan' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'hasil_panen' => 'required|numeric',
            'awal_tanam' => 'required|date',
            'akhir_tanam' => 'required|date|after_or_equal:awal_tanam',
        ]);

        $lahan = new Lahan();

        $lahan->nama_lahan = $request->nama_lahan;
        $lahan->luas_lahan = $request->luas_lahan;
        $lahan->isi_lahan = $request->isi_lahan;
        $lahan->pemilik_lahan = $request->pemilik_lahan;
        $lahan->alamat_lahan = $request->alamat_lahan;
        $lahan->denah_lahan = $request->denah_lahan;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('uploads', $filename, 'public');
            $lahan->gambar = $filename;
        }
        $lahan->hasil_panen = $request->hasil_panen;
        $lahan->awal_tanam = $request->awal_tanam;
        $lahan->akhir_tanam = $request->akhir_tanam;
        $lahan->user_id = Auth::id();

        $lahan->save();

        return redirect('/user/data-lahan')->with('success', 'Data Lahan Berhasil Disimpan');
    }

    public function edit_lahan($id)
    {
        $lahan = Lahan::find($id);

        return view('users.update-data', ['lahan' => $lahan]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lahan' => 'required|string|max:255',
            'luas_lahan' => 'required|numeric',
            'isi_lahan' => 'required|string|max:255',
            'pemilik_lahan' => 'required|string|max:255',
            'alamat_lahan' => 'required|string|max:255',
            'denah_lahan' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'hasil_panen' => 'required|numeric',
            'awal_tanam' => 'required|date',
            'akhir_tanam' => 'required|date|after_or_equal:awal_tanam',
        ]);

        $lahan = Lahan::findOrFail($id);

        $lahan->nama_lahan = $request->nama_lahan;
        $lahan->luas_lahan = $request->luas_lahan;
        $lahan->isi_lahan = $request->isi_lahan;
        $lahan->pemilik_lahan = $request->pemilik_lahan;
        $lahan->alamat_lahan = $request->alamat_lahan;
        $lahan->denah_lahan = $request->denah_lahan;

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($lahan->gambar) {
                Storage::disk('public')->delete('uploads/' . $lahan->gambar);
            }

            // Simpan gambar baru
            $file = $request->file('gambar');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('uploads', $filename, 'public');
            $lahan->gambar = $filename;
        }

        $lahan->hasil_panen = $request->hasil_panen;
        $lahan->awal_tanam = $request->awal_tanam;
        $lahan->akhir_tanam = $request->akhir_tanam;
        $lahan->user_id = Auth::id();

        $lahan->save();

        return redirect('/user/data-lahan')->with('success', 'Data Lahan Berhasil Diperbarui');
    }
}
