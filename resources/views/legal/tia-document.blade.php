<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer Impact Assessment - KOMPASKARIR</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 11px;
            line-height: 1.6;
            color: #1a1a1a;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #1e40af;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 24px;
            color: #1e40af;
            margin: 0 0 5px 0;
        }

        .header h2 {
            font-size: 16px;
            color: #475569;
            margin: 0 0 10px 0;
            font-weight: normal;
        }

        .header .subtitle {
            font-size: 12px;
            color: #64748b;
        }

        .section {
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #1e40af;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }

        .subsection-title {
            font-size: 12px;
            font-weight: bold;
            color: #334155;
            margin: 15px 0 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 10px;
        }

        th, td {
            border: 1px solid #e2e8f0;
            padding: 8px 10px;
            text-align: left;
        }

        th {
            background-color: #f1f5f9;
            font-weight: 600;
            color: #334155;
        }

        td {
            color: #475569;
        }

        .risk-high {
            color: #dc2626;
            font-weight: bold;
        }

        .risk-medium {
            color: #f59e0b;
            font-weight: bold;
        }

        .risk-low {
            color: #22c55e;
            font-weight: bold;
        }

        .info-box {
            background-color: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 15px;
        }

        .warning-box {
            background-color: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 15px;
        }

        ul {
            margin: 5px 0;
            padding-left: 20px;
        }

        li {
            margin-bottom: 5px;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            font-size: 10px;
            color: #94a3b8;
            text-align: center;
        }

        .signature-block {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            width: 45%;
        }

        .signature-line {
            border-top: 1px solid #000;
            margin-top: 60px;
            padding-top: 5px;
        }

        @media print {
            body {
                padding: 0;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>TRANSFER IMPACT ASSESSMENT (TIA)</h1>
        <h2>Dampak Pemindahan Data Pribadi ke Luar Negeri</h2>
        <div class="subtitle">
            KOMPASKARIR INDONESIA<br>
            Berdasarkan Undang-Undang No. 27 Tahun 2022 tentang Perlindungan Data Pribadi (UU PDP)<br>
            Dokumen ini dibuat pada: {{ now()->translatedFormat('d F Y') }}
        </div>
    </div>

    <div class="section">
        <div class="section-title">1. INFORMASI PENGENDALI DATA PRIBADI</div>
        <table>
            <tr>
                <th width="30%">Nama Entitas</th>
                <td>KOMPASKARIR INDONESIA</td>
            </tr>
            <tr>
                <th>Jenis Usaha</th>
                <td>Platform Karir dan Rekrutmen Digital</td>
            </tr>
            <tr>
                <th>Kontak DPO</th>
                <td>dpo@kompaskarir.id</td>
            </tr>
            <tr>
                <th>Kontak Privasi</th>
                <td>privacy@kompaskarir.id</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">2. IDENTIFIKASI PEMINDAHAN DATA</div>
        
        <div class="subsection-title">2.1 Penerima Data (Data Importer)</div>
        <table>
            <tr>
                <th>No</th>
                <th>Pihak Ketiga</th>
                <th>Layanan</th>
                <th>Lokasi Server</th>
                <th>Tujuan Pemindahan</th>
            </tr>
            <tr>
                <td>1</td>
                <td>Google LLC</td>
                <td>Google OAuth (Login)</td>
                <td>Amerika Serikat</td>
                <td>Autentikasi pengguna</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Google LLC</td>
                <td>Google Gemini AI</td>
                <td>Amerika Serikat</td>
                <td>Chatbot AI dan analisis konten</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Google LLC</td>
                <td>Google Fonts</td>
                <td>Amerika Serikat</td>
                <td>Font untuk tampilan website</td>
            </tr>
        </table>

        <div class="subsection-title">2.2 Data yang Dipindahkan</div>
        <table>
            <tr>
                <th>No</th>
                <th>Jenis Data</th>
                <th>Kategori</th>
                <th>Penerima</th>
                <th>Tujuan Spesifik</th>
            </tr>
            <tr>
                <td>1</td>
                <td>Nama, Email</td>
                <td>Data Pribadi Biasa</td>
                <td>Google OAuth</td>
                <td>Proses login/registrasi</td>
            </tr>
            <tr>
                <td>2</td>
                <td>ID Pengguna Google</td>
                <td>Identifikasi Teknis</td>
                <td>Google OAuth</td>
                <td>Autentikasi</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Pesan chat pengguna</td>
                <td>Data Aktivitas</td>
                <td>Google Gemini</td>
                <td>Respons chatbot AI</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Konteks percakapan</td>
                <td>Data Aktivitas</td>
                <td>Google Gemini</td>
                <td>Konteks chatbot</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">3. ANALISIS RISIKO</div>

        <div class="subsection-title">3.1 Risiko terhadap Subjek Data</div>
        <table>
            <tr>
                <th>Risiko</th>
                <th>Level</th>
                <th>Penjelasan</th>
                <th>Mitigasi</th>
            </tr>
            <tr>
                <td>Akses tidak sah oleh pemerintah asing</td>
                <td class="risk-medium">SEDANG</td>
                <td>Data di server AS dapat diakses oleh pemerintah AS berdasarkan FISA Section 702</td>
                <td>Data yang dikirim minimal, tidak termasuk data sensitif</td>
            </tr>
            <tr>
                <td>Penggunaan data untuk tujuan lain</td>
                <td class="risk-medium">SEDANG</td>
                <td>Google dapat menggunakan data untuk peningkatan layanan</td>
                <td>Hanya kirim data yang diperlukan, gunakan API mode privacy</td>
            </tr>
            <tr>
                <td>Kebocoran data</td>
                <td class="risk-low">RENDAH</td>
                <td>Google memiliki standar keamanan tinggi</td>
                <td>Enkripsi data sebelum dikirim, monitoring penggunaan</td>
            </tr>
            <tr>
                <td>Kehilangan kontrol data</td>
                <td class="risk-medium">SEDANG</td>
                <td>Data di luar yurisdiksi Indonesia</td>
                <td>Kontrak dengan klausul perlindungan, audit berkala</td>
            </tr>
        </table>

        <div class="subsection-title">3.2 Penilaian Keseluruhan</div>
        <div class="info-box">
            <strong>Level Risiko Keseluruhan: SEDANG</strong><br>
            Pemindahan data dilakukan dengan perlindungan yang memadai. Data yang dikirim bersifat minimal dan tidak termasuk kategori data pribadi spesifik sesuai Pasal 4 ayat (2) UU PDP.
        </div>
    </div>

    <div class="section">
        <div class="section-title">4. LANGKAH MITIGASI</div>
        
        <div class="subsection-title">4.1 Mitigasi Teknis</div>
        <ul>
            <li><strong>Data Minimization:</strong> Hanya mengirim data yang benar-benar diperlukan untuk fungsi layanan</li>
            <li><strong>Enkripsi:</strong> Data sensitif dienkripsi sebelum dikirim ke pihak ketiga</li>
            <li><strong>Tokenisasi:</strong> Menggunakan token autentikasi, bukan mengirim data asli</li>
            <li><strong>Monitoring:</strong> Audit log untuk semua pemindahan data ke pihak ketiga</li>
            <li><strong>Rate Limiting:</strong> Membatasi jumlah data yang dapat dikirim dalam periode tertentu</li>
        </ul>

        <div class="subsection-title">4.2 Mitigasi Kontraktual</div>
        <ul>
            <li><strong>Data Processing agreement:</strong> Perjanjian dengan Google yang membatasi penggunaan data</li>
            <li><strong>Standard Contractual Clauses (SCC):</strong> Klausul standar untuk transfer internasional</li>
            <li><strong>Right to Audit:</strong> Hak untuk melakukan audit terhadap pihak ketiga</li>
            <li><strong>Data Retention:</strong> Batasan penyimpanan data oleh pihak ketiga</li>
        </ul>

        <div class="subsection-title">4.3 Mitigasi Organisasi</div>
        <ul>
            <li><strong>DPO:</strong> Penunjukan Data Protection Officer yang bertanggung jawab</li>
            <li><strong>Training:</strong> Pelatihan keamanan data untuk seluruh tim</li>
            <li><strong>Incident Response:</strong> Prosedur penanganan pelanggaran data</li>
            <li><strong>Regular Review:</strong> Review TIA secara berkala minimal 1 tahun sekali</li>
        </ul>
    </div>

    <div class="section">
        <div class="section-title">5. DASAR HUKUM</div>
        <table>
            <tr>
                <th>Peraturan</th>
                <th>Pasal</th>
                <th>Keterangan</th>
            </tr>
            <tr>
                <td>UU No. 27 Tahun 2022</td>
                <td>Pasal 20</td>
                <td>Pemindahan Data Pribadi ke luar wilayah Indonesia</td>
            </tr>
            <tr>
                <td>UU No. 27 Tahun 2022</td>
                <td>Pasal 3</td>
                <td>Prinsip perlindungan data pribadi</td>
            </tr>
            <tr>
                <td>PP No. 71 Tahun 2019</td>
                <td>Pasal 54-57</td>
                <td>Penyelenggaraan Sistem Elektronik</td>
            </tr>
            <tr>
                <td>Permenkominfo No. 20 Tahun 2016</td>
                <td>Pasal 21-23</td>
                <td>Transfer data lintas batas negara</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">6. KESIMPULAN DAN REKOMENDASI</div>
        
        <div class="info-box">
            <strong>Kesimpulan:</strong><br>
            Pemindahan data pribadi ke pihak ketiga (Google) dilakukan dengan tingkat perlindungan yang memadai. Data yang dipindahkan bersifat minimal, tidak termasuk kategori data pribadi spesifik, dan telah dilakukan langkah mitigasi yang sesuai.
        </div>

        <div class="subsection-title">Rekomendasi:</div>
        <ul>
            <li>Lakukan review TIA ini secara berkala minimal 1 tahun sekali</li>
            <li>Pantau perubahan kebijakan privasi Google yang dapat mempengaruhi perlindungan data</li>
            <li>Pertimbangkan alternatif lokal jika tersedia untuk mengurangi risiko transfer internasional</li>
            <li>Dokumentasikan setiap perubahan dalam pemrosesan data oleh pihak ketiga</li>
            <li>Berikan transparansi kepada pengguna tentang pemindahan data ini melalui Kebijakan Privasi</li>
        </ul>
    </div>

    <div class="section">
        <div class="section-title">7. PEMBARUAN DOKUMEN</div>
        <table>
            <tr>
                <th>Versi</th>
                <th>Tanggal</th>
                <th>Perubahan</th>
                <td>Penanggung Jawab</td>
            </tr>
            <tr>
                <td>1.0</td>
                <td>{{ now()->format('d/m/Y') }}</td>
                <td>Dokumen awal</td>
                <td>DPO KOMPASKARIR</td>
            </tr>
        </table>
    </div>

    <div class="signature-block">
        <div class="signature-box">
            <div class="signature-line">
                <strong>Data Protection Officer (DPO)</strong><br>
                KOMPASKARIR INDONESIA<br>
                Tanggal: {{ now()->translatedFormat('d F Y') }}
            </div>
        </div>
        <div class="signature-box" style="text-align: right;">
            <div class="signature-line">
                <strong>Manajemen</strong><br>
                KOMPASKARIR INDONESIA<br>
                Tanggal: {{ now()->translatedFormat('d F Y') }}
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Dokumen ini merupakan bagian dari kepatuhan KOMPASKARIR INDONESIA terhadap Undang-Undang No. 27 Tahun 2022 tentang Perlindungan Data Pribadi (UU PDP).</p>
        <p>© {{ date('Y') }} KOMPASKARIR INDONESIA. Hak Cipta Dilindungi.</p>
    </div>
</body>

</html>
