<?php

namespace App\Http\Controllers;

use App\Models\AlokasiPupuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AlokasiController extends Controller
{
    public function store(Request $request, $id)
    {
        // Validasi input form
        $request->validate([
            'nama_penanggung_jawab' => 'required|string|max:255',
            'musim_tanam' => 'required|integer',
            'jenis_pupuk' => 'required|string|max:255',
            'jumlah_pupuk' => 'required|integer',
            'harga_pupuk' => 'required|integer',
            'foto_bukti' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto_ttd' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Hitung total nilai subsidi
        $total_nilai_subsidi = $request->jumlah_pupuk * $request->harga_pupuk;

        // Simpan foto bukti distribusi dengan nama UUID
        if ($request->hasFile('foto_bukti')) {
            $fotoBukti = $request->file('foto_bukti');
            $fotoBuktiName = Str::uuid() . '.' . $fotoBukti->getClientOriginalExtension();
            // Storage::putFileAs('uploads', $fotoBukti, $fotoBuktiName);
            $fotoBukti->storeAs('uploads', $fotoBuktiName, 'public');
        }

        // Simpan foto tanda tangan dengan nama UUID
        if ($request->hasFile('foto_ttd')) {
            $fotoTTD = $request->file('foto_ttd');
            $fotoTTDName = Str::uuid() . '.' . $fotoTTD->getClientOriginalExtension();
            // Storage::putFileAs('uploads', $fotoTTD, $fotoTTDName);
            $fotoTTD->storeAs('uploads', $fotoTTDName, 'public');
        }

        $data = new AlokasiPupuk();
        $data->nama_penanggung_jawab = $request->nama_penanggung_jawab;
        $data->musim_tanam = $request->musim_tanam;
        $data->jenis_pupuk = $request->jenis_pupuk;
        $data->jumlah_pupuk = $request->jumlah_pupuk;
        $data->harga_pupuk = $request->harga_pupuk;
        $data->total_nilai_subsidi = $total_nilai_subsidi;
        $data->foto_bukti_distribusi = $fotoBuktiName;
        $data->foto_tanda_tangan = $fotoTTDName;
        $data->lahan_id = $id;
        $data->save();

        return redirect()->back()->with('success', 'Alokasi pupuk berhasil ditambahkan');
    }
}
