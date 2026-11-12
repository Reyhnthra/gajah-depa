<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Disetujui - Gajah Depa Akuatik</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f1f5f9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #1e293b; line-height: 1.6;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f1f5f9; padding: 30px 15px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0;" cellspacing="0" cellpadding="0" border="0">
                    <!-- HEADER -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #008cc9 0%, #005a87 100%); padding: 32px 28px; text-align: center; color: #ffffff;">
                            <h1 style="margin: 0; font-size: 22px; font-weight: 800; letter-spacing: 0.5px; text-transform: uppercase;">
                                GAJAH DEPA AKUATIK
                            </h1>
                            <p style="margin: 6px 0 0; font-size: 13px; opacity: 0.9;">
                                Selamat Bergabung di Keluarga Besar Gajah Depa!
                            </p>
                        </td>
                    </tr>

                    <!-- CONTENT -->
                    <tr>
                        <td style="padding: 32px 28px;">
                            <div style="text-align: center; margin-bottom: 24px;">
                                <div style="display: inline-block; width: 60px; height: 60px; line-height: 60px; border-radius: 50%; background-color: #dcfce7; color: #16a34a; font-size: 28px;">
                                    🎉
                                </div>
                                <h2 style="margin: 14px 0 6px; font-size: 20px; font-weight: 700; color: #0f172a;">
                                    Pendaftaran Telah Disetujui!
                                </h2>
                                <p style="margin: 0; font-size: 14px; color: #64748b;">
                                    Halo, <strong>{{ $data['nama_orang_tua'] ?? 'Bapak/Ibu Orang Tua Siswa' }}</strong>!
                                </p>
                            </div>

                            <p style="font-size: 14px; color: #475569; margin: 0 0 20px;">
                                Kabar gembira! Kami dengan senang hati menginformasikan bahwa pendaftaran les renang untuk ananda 
                                <strong style="color: #0f172a;">{{ $data['nama_siswa'] }}</strong> telah diverifikasi dan 
                                <span style="background-color: #dcfce7; color: #15803d; font-weight: 700; padding: 2px 8px; border-radius: 6px;">DISETUJUI (ACC)</span> oleh Admin Gajah Depa Akuatik.
                            </p>

                            <!-- RINCIAN SISWA -->
                            <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 18px; margin-bottom: 24px;">
                                <h4 style="margin: 0 0 12px; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b;">
                                    Informasi Siswa & Kelas
                                </h4>
                                <table role="presentation" width="100%" style="font-size: 13px; line-height: 1.8;">
                                    <tr>
                                        <td style="color: #64748b; width: 40%;">Nama Siswa</td>
                                        <td style="font-weight: 700; color: #0f172a;">: {{ $data['nama_siswa'] }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color: #64748b;">Cabang</td>
                                        <td style="font-weight: 600; color: #1e293b;">: {{ $data['nama_cabang'] ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color: #64748b;">Kelas Les</td>
                                        <td style="font-weight: 700; color: #0284c7;">: {{ $data['nama_kelas'] ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color: #64748b;">Status Siswa</td>
                                        <td>: <span style="color: #16a34a; font-weight: 700;">Aktif</span></td>
                                    </tr>
                                </table>
                            </div>

                            <!-- INSTRUKSI LOGIN / BUAT PASSWORD -->
                            <div style="background-color: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 20px; margin-bottom: 24px;">
                                <h4 style="margin: 0 0 8px; font-size: 14px; font-weight: 700; color: #1e40af;">
                                    📱 Langkah Selanjutnya: Akses Portal Orang Tua
                                </h4>
                                @if(!empty($data['needs_password']))
                                    <p style="margin: 0 0 16px; font-size: 13px; color: #1e3a8a;">
                                        Untuk memantau jadwal latihan, absensi kehadiran, dan perkembangan renang ananda, silakan buat kata sandi akun Anda terlebih dahulu melalui tautan di bawah ini dengan menggunakan email: <strong>{{ $data['email'] }}</strong>.
                                    </p>
                                    <div style="text-align: center; margin: 16px 0 8px;">
                                        <a href="{{ $data['action_url'] ?? url('/register') }}" target="_blank" style="display: inline-block; background-color: #008cc9; color: #ffffff; text-decoration: none; padding: 12px 28px; border-radius: 9999px; font-size: 13px; font-weight: 700; letter-spacing: 0.3px; box-shadow: 0 4px 10px rgba(0, 140, 201, 0.35);">
                                            Buat Kata Sandi Akun ↗
                                        </a>
                                    </div>
                                @else
                                    <p style="margin: 0 0 16px; font-size: 13px; color: #1e3a8a;">
                                        Akun Anda sudah aktif. Silakan masuk ke portal orang tua untuk memantau jadwal latihan dan perkembangan ananda.
                                    </p>
                                    <div style="text-align: center; margin: 16px 0 8px;">
                                        <a href="{{ $data['action_url'] ?? url('/login') }}" target="_blank" style="display: inline-block; background-color: #008cc9; color: #ffffff; text-decoration: none; padding: 12px 28px; border-radius: 9999px; font-size: 13px; font-weight: 700; letter-spacing: 0.3px; box-shadow: 0 4px 10px rgba(0, 140, 201, 0.35);">
                                            Masuk ke Portal Orang Tua ↗
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <p style="font-size: 13px; color: #64748b; margin: 0 0 8px;">
                                Apabila Bapak/Ibu membutuhkan informasi lebih lanjut mengenai jadwal latihan pertama atau perlengkapan yang perlu dibawa, silakan hubungi tim administrasi kami.
                            </p>
                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 20px 28px; text-align: center;">
                            <p style="margin: 0 0 4px; font-size: 12px; font-weight: 600; color: #64748b;">
                                Gajah Depa Swimming Club
                            </p>
                            <p style="margin: 0; font-size: 11px; color: #94a3b8;">
                                Email ini dikirim secara otomatis sebagai tanda bukti penerimaan siswa baru.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

