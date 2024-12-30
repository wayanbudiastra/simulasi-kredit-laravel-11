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
        $jenisAngsuran = $request->jenis_angsuran;
    $totalBunga=0;
    $totalbayar=0;
        // Konversi data
        $bungaBulanan = ($bungaPerTahun / 100) / 12; // r
        $jangkaWaktuBulan = $jangkaWaktu * 12; // n
    
        $hasil = [];
        $sisaPinjaman = $jumlahPinjaman;
    
        if ($jenisAngsuran === 'tetap') {
            // Hitung angsuran tetap (Anuitas)
            $angsuranTetap = $jumlahPinjaman * ($bungaBulanan * pow(1 + $bungaBulanan, $jangkaWaktuBulan)) / (pow(1 + $bungaBulanan, $jangkaWaktuBulan) - 1);
    
            for ($i = 1; $i <= $jangkaWaktuBulan; $i++) {
                $bunga = $sisaPinjaman * $bungaBulanan; // Bunga bulan ini
                $angsuranPokok = $angsuranTetap - $bunga; // Angsuran pokok bulan ini
                $sisaPinjaman -= $angsuranPokok; // Kurangi sisa pinjaman
                $totalBunga = $totalBunga + $bunga;

                $hasil[] = [
                    'bulan' => $i,
                    'angsuran_pokok' => $angsuranPokok,
                    'bunga' => $bunga,
                    'total_angsuran' => $angsuranTetap,
                    'sisa_pinjaman' => max($sisaPinjaman, 0),
                ];
            }
        } else {
            // Hitung angsuran menurun
            $angsuranPokok = $jumlahPinjaman / $jangkaWaktuBulan;
    
            for ($i = 1; $i <= $jangkaWaktuBulan; $i++) {
                $bunga = $sisaPinjaman * $bungaBulanan; // Bunga bulan ini
                $totalAngsuran = $angsuranPokok + $bunga;
                $sisaPinjaman -= $angsuranPokok;
                $totalBunga = $totalBunga+$bunga;
    
                $hasil[] = [
                    'bulan' => $i,
                    'angsuran_pokok' => $angsuranPokok,
                    'bunga' => $bunga,
                    'total_angsuran' => $totalAngsuran,
                    'sisa_pinjaman' => max($sisaPinjaman, 0),
                ];
            }
        }
    
    
        return view('simulasi-kredit', ['hasil' => $hasil, 'total_bunga'=> $totalBunga]);
    }
}
