<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulasi Kredit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Simulasi Kredit</h1>
    <form action="{{ route('simulasi-kredit.hitung') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="jumlah_pinjaman" class="form-label">Jumlah Pinjaman (Rp)</label>
            <input type="number" class="form-control" id="jumlah_pinjaman" name="jumlah_pinjaman" required>
        </div>
        <div class="mb-3">
            <label for="bunga" class="form-label">Bunga Per Tahun (%)</label>
            <input type="number" class="form-control" id="bunga" name="bunga" step="0.01" required>
        </div>
        <div class="mb-3">
            <label for="jangka_waktu" class="form-label">Jangka Waktu (Tahun)</label>
            <input type="number" class="form-control" id="jangka_waktu" name="jangka_waktu" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Jenis Angsuran</label>
            <div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="jenis_angsuran" id="angsuran_tetap" value="tetap" checked>
                    <label class="form-check-label" for="angsuran_tetap">
                        Angsuran Tetap (Anuitas)
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="jenis_angsuran" id="angsuran_tidak_tetap" value="tidak_tetap">
                    <label class="form-check-label" for="angsuran_tidak_tetap">
                        Angsuran Tidak Tetap (Menurun)
                    </label>
                </div>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary">Hitung</button>
    </form>

    @if(isset($hasil))
        <h2 class="mt-4">Hasil Simulasi</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th>Angsuran Pokok</th>
                    <th>Bunga</th>
                    <th>Total Angsuran</th>
                    <th>Sisa Pinjaman</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hasil as $data)
                    <tr>
                        <td>{{ $data['bulan'] }}</td>
                        <td>Rp {{ number_format($data['angsuran_pokok'], 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($data['bunga'], 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($data['total_angsuran'], 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($data['sisa_pinjaman'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach

                <tr>
                    <td></td>
                    <td>Total Bunga</td>
                    <td>Rp {{ number_format($total_bunga, 0, ',', '.') }}</td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    @endif
</div>
</body>
</html>
