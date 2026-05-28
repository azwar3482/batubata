<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e5e7eb; border-radius: 8px; }
        .header { text-align: center; margin-bottom: 20px; }
        .footer { font-size: 12px; color: #666; margin-top: 30px; text-align: center; }
        .btn { background: #2563eb; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>KOMPASKARIR</h2>
        </div>
        <p>Halo Admin,</p>
        <p>Terlampir adalah laporan analitik platform KOMPASKARIR untuk periode:</p>
        <p><strong>{{ $startDate }}</strong> hingga <strong>{{ $endDate }}</strong></p>
        <p>Laporan ini mencakup statistik pertumbuhan pengguna, data asesmen, dan tren keahlian saat ini.</p>
        <p>Silakan buka file PDF yang terlampir untuk rincian selengkapnya.</p>
        <p>Terima kasih,<br>Sistem KOMPASKARIR</p>
    </div>
    <div class="footer">
        Email ini dikirim otomatis oleh sistem dashboard admin.
    </div>
</body>
</html>
