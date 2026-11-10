<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Insiden Diterima</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f5f7fb; margin: 0; padding: 32px 16px; color: #1a2940;">
    <div style="max-width: 640px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; border: 1px solid #dfe7f5;">
        <div style="padding: 24px 28px; background: linear-gradient(135deg, #0b4f79, #0d1b2a); color: white;">
            <strong style="font-size: 18px;">CSIRT Kota Depok</strong>
            <div style="margin-top: 8px; font-size: 13px; letter-spacing: 0.06em; opacity: 0.8;">Notifikasi Penerimaan Laporan</div>
        </div>

        <div style="padding: 28px;">
            <h2 style="margin: 0 0 18px; font-size: 24px; color: #0d1b2a;">Laporan Anda telah diterima</h2>

            <p style="margin: 0 0 14px; line-height: 1.6; color: #334155;">
                Terima kasih atas laporan insiden yang telah dikirimkan. Tim CSIRT Kota Depok akan meninjau laporan Anda dan melakukan proses triase sesuai prioritas keamanan.
            </p>

            <div style="background: #eef7ff; border: 1px solid #cfe4ff; border-radius: 10px; padding: 16px; margin: 20px 0;">
                <div style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.08em; color: #3b82f6; font-weight: bold;">Nomor Tiket</div>
                <div style="font-size: 28px; font-weight: bold; color: #0d1b2a; margin-top: 6px;">{{ $report->ticket_number }}</div>
            </div>

            <p style="margin: 0; line-height: 1.6; color: #334155;">
                Judul laporan: <strong>{{ $report->judul }}</strong><br>
                Kategori: <strong>{{ $report->kategori }}</strong><br>
                Status saat ini: <strong>{{ ucfirst($report->status) }}</strong>
            </p>

            <p style="margin-top: 20px; color: #475569; line-height: 1.6;">
                Anda dapat memantau perkembangan laporan melalui halaman <strong>Status Laporan Saya</strong> di website CSIRT Kota Depok dengan memasukkan nomor tiket di atas.
            </p>
        </div>
    </div>
</body>
</html>
