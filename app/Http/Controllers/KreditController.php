<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class KreditController extends Controller
{
    public function index()
    {
        return view('simulasi-kredit');
    }

    public function hitung(Request $request)
    {

        $jumlahPinjaman = $request->jumlah_pinjaman;
        $bungaPerTahun = $request->bunga;
        $jangkaWaktu = $request->jangka_waktu;
    
        // Konversi data
        $bungaBulanan = ($bungaPerTahun / 100) / 12; // r
        $jangkaWaktuBulan = $jangkaWaktu * 12; // n
    
        // Hitung angsuran tetap (A)
        $angsuranTetap = $jumlahPinjaman * ($bungaBulanan * pow(1 + $bungaBulanan, $jangkaWaktuBulan)) / (pow(1 + $bungaBulanan, $jangkaWaktuBulan) - 1);
    
        $hasil = [];
        $sisaPinjaman = $jumlahPinjaman;
    
        for ($i = 1; $i <= $jangkaWaktuBulan; $i++) {
            $bunga = $sisaPinjaman * $bungaBulanan; // Bunga bulan ini
            $angsuranPokok = $angsuranTetap - $bunga; // Angsuran pokok bulan ini
            $sisaPinjaman -= $angsuranPokok; // Kurangi sisa pinjaman
    
            $hasil[] = [
                'bulan' => $i,
                'angsuran_pokok' => $angsuranPokok,
                'bunga' => $bunga,
                'total_angsuran' => $angsuranTetap,
                'sisa_pinjaman' => max($sisaPinjaman, 0), // Pastikan tidak negatif
            ];
        }
    
        return view('simulasi-kredit', ['hasil' => $hasil]);
    }
}
