<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Pendaftar Baru - Gajah Depa Akuatik</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f1f5f9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #1e293b; line-height: 1.6;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f1f5f9; padding: 30px 15px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0;" cellspacing="0" cellpadding="0" border="0">
                    <!-- HEADER -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #008cc9 0%, #005a87 100%); padding: 30px 28px; text-align: center; color: #ffffff;">
                            <h1 style="margin: 0; font-size: 20px; font-weight: 800; letter-spacing: 0.5px; text-transform: uppercase;">
                                GAJAH DEPA AKUATIK
                            </h1>
                            <p style="margin: 4px 0 0; font-size: 13px; opacity: 0.9;">
                                Notifikasi Pendaftaran Siswa Baru
                            </p>
                        </td>
                    </tr>

                    <!-- CONTENT -->
                    <tr>
                        <td style="padding: 30px 28px;">
                            <div style="background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px;">
                                <p style="margin: 0; font-size: 13px; color: #92400e; font-weight: 600;">
                                    🔔 Ada calon siswa baru yang mendaftar melalui website dan membutuhkan peninjauan/verifikasi admin.
                                </p>
                            </div>

                            <h3 style="margin: 0 0 16px; font-size: 16px; font-weight: 700; color: #0f172a; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px;">
                                Rincian Calon Siswa
                            </h3>

                            <table role="presentation" width="100%" style="border-collapse: collapse; margin-bottom: 24px; font-size: 13px;">
                                <tr>
                                    <td style="padding: 9px 12px; background-color: #f8fafc; color: #64748b; font-weight: 600; width: 38%; border: 1px solid #e2e8f0;">
                                        Nama Calon Siswa
                                    </td>
                                    <td style="padding: 9px 12px; color: #0f172a; font-weight: 700; border: 1px solid #e2e8f0;">
                                        {{ $data['nama_siswa'] ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 9px 12px; background-color: #f8fafc; color: #64748b; font-weight: 600; border: 1px solid #e2e8f0;">
                                        Nama Orang Tua
                                    </td>
                                    <td style="padding: 9px 12px; color: #1e293b; border: 1px solid #e2e8f0;">
                                        {{ $data['nama_orang_tua'] ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 9px 12px; background-color: #f8fafc; color: #64748b; font-weight: 600; border: 1px solid #e2e8f0;">
                                        No. WhatsApp / HP
                                    </td>
                                    <td style="padding: 9px 12px; color: #1e293b; border: 1px solid #e2e8f0;">
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $data['no_hp'] ?? '') }}" target="_blank" style="color: #008cc9; text-decoration: none; font-weight: 600;">
                                            {{ $data['no_hp'] ?? '-' }} ↗
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 9px 12px; background-color: #f8fafc; color: #64748b; font-weight: 600; border: 1px solid #e2e8f0;">
                                        Email Orang Tua
                                    </td>
                                    <td style="padding: 9px 12px; color: #1e293b; border: 1px solid #e2e8f0;">
                                        {{ $data['email'] ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 9px 12px; background-color: #f8fafc; color: #64748b; font-weight: 600; border: 1px solid #e2e8f0;">
                                        Cabang Les
                                    </td>
                                    <td style="padding: 9px 12px; color: #1e293b; font-weight: 600; border: 1px solid #e2e8f0;">
                                        {{ $data['nama_cabang'] ?? '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 9px 12px; background-color: #f8fafc; color: #64748b; font-weight: 600; border: 1px solid #e2e8f0;">
                                        Pilihan Kelas
                                    </td>
                                    <td style="padding: 9px 12px; color: #1e293b; border: 1px solid #e2e8f0;">
                                        <span style="display: inline-block; background-color: #e0f2fe; color: #0369a1; padding: 2px 10px; border-radius: 9999px; font-weight: 600; font-size: 12px;">
                                            {{ $data['nama_kelas'] ?? '-' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 9px 12px; background-color: #f8fafc; color: #64748b; font-weight: 600; border: 1px solid #e2e8f0;">
                                        Metode Pembayaran
                                    </td>
                                    <td style="padding: 9px 12px; color: #1e293b; border: 1px solid #e2e8f0;">
                                        {{ strtoupper($data['pilihan_pembayaran'] ?? 'Transfer') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 9px 12px; background-color: #f8fafc; color: #64748b; font-weight: 600; border: 1px solid #e2e8f0;">
                                        Waktu Pendaftaran
                                    </td>
                                    <td style="padding: 9px 12px; color: #64748b; border: 1px solid #e2e8f0;">
                                        {{ $data['waktu_daftar'] ?? now()->translatedFormat('d F Y, H:i') }} WIB
                                    </td>
                                </tr>
                                @if(!empty($data['catatan_khusus']))
                                <tr>
                                    <td style="padding: 9px 12px; background-color: #f8fafc; color: #64748b; font-weight: 600; border: 1px solid #e2e8f0;">
                                        Catatan Khusus
                                    </td>
                                    <td style="padding: 9px 12px; color: #1e293b; border: 1px solid #e2e8f0; font-style: italic;">
                                        "{{ $data['catatan_khusus'] }}"
                                    </td>
                                </tr>
                                @endif
                            </table>

                            <!-- CTA BUTTON -->
                            <div style="text-align: center; margin: 28px 0 10px;">
                                <a href="{{ $data['admin_url'] ?? url('/admin/siswa') }}" target="_blank" style="display: inline-block; background-color: #008cc9; color: #ffffff; text-decoration: none; padding: 13px 30px; border-radius: 9999px; font-size: 14px; font-weight: 700; letter-spacing: 0.3px; box-shadow: 0 4px 10px rgba(0, 140, 201, 0.35);">
                                    Buka Panel Pendaftaran Admin ↗
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 20px 28px; text-align: center;">
                            <p style="margin: 0 0 4px; font-size: 12px; font-weight: 600; color: #64748b;">
                                Gajah Depa Swimming Club - Panel Admin
                            </p>
                            <p style="margin: 0; font-size: 11px; color: #94a3b8;">
                                Email notifikasi otomatis sistem untuk Admin Cabang / Admin Pusat.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

