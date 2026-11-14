<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Kata Sandi - Gajah Depa Akuatik</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f1f5f9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #1e293b; line-height: 1.6;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f1f5f9; padding: 30px 15px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" style="max-width: 580px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0;" cellspacing="0" cellpadding="0" border="0">
                    <!-- HEADER -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #008cc9 0%, #005a87 100%); padding: 32px 28px; text-align: center; color: #ffffff;">
                            <h1 style="margin: 0; font-size: 22px; font-weight: 800; letter-spacing: 0.5px; text-transform: uppercase;">
                                GAJAH DEPA AKUATIK
                            </h1>
                            <p style="margin: 6px 0 0; font-size: 13px; opacity: 0.9; font-weight: 400;">
                                Sistem Informasi Manajemen Les Renang
                            </p>
                        </td>
                    </tr>

                    <!-- CONTENT -->
                    <tr>
                        <td style="padding: 32px 28px;">
                            <div style="text-align: center; margin-bottom: 24px;">
                                <div style="display: inline-block; width: 56px; height: 56px; line-height: 56px; border-radius: 50%; background-color: #e0f2fe; color: #0284c7; font-size: 26px;">
                                    🔐
                                </div>
                                <h2 style="margin: 14px 0 6px; font-size: 20px; font-weight: 700; color: #0f172a;">
                                    Permintaan Reset Kata Sandi
                                </h2>
                                <p style="margin: 0; font-size: 14px; color: #64748b;">
                                    Halo, <strong>{{ $user->nama ?? 'Pengguna' }}</strong>!
                                </p>
                            </div>

                            <p style="font-size: 14px; color: #475569; margin: 0 0 16px;">
                                Kami menerima permintaan untuk mengatur ulang kata sandi akun Anda yang terdaftar dengan email: 
                                <strong style="color: #0284c7;">{{ $user->email }}</strong>.
                            </p>
                            <p style="font-size: 14px; color: #475569; margin: 0 0 24px;">
                                Jika Anda memang melakukan permintaan ini, silakan klik tombol di bawah untuk membuat kata sandi baru:
                            </p>

                            <!-- CTA BUTTON -->
                            <div style="text-align: center; margin: 30px 0;">
                                <a href="{{ $url }}" target="_blank" style="display: inline-block; background-color: #008cc9; color: #ffffff; text-decoration: none; padding: 13px 32px; border-radius: 9999px; font-size: 14px; font-weight: 700; letter-spacing: 0.3px; box-shadow: 0 4px 10px rgba(0, 140, 201, 0.35);">
                                    Atur Ulang Kata Sandi
                                </a>
                            </div>

                            <div style="background-color: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 10px; padding: 14px; margin-bottom: 24px;">
                                <p style="margin: 0; font-size: 12px; color: #64748b;">
                                    ⏱️ Tautan reset ini hanya berlaku selama <strong>60 menit</strong>. Jika Anda tidak merasa meminta reset kata sandi, abaikan email ini dan akun Anda tetap aman.
                                </p>
                            </div>

                            <div style="border-top: 1px solid #f1f5f9; padding-top: 18px; margin-top: 24px;">
                                <p style="margin: 0 0 6px; font-size: 11px; color: #94a3b8;">
                                    Jika tombol di atas tidak dapat diklik, salin dan tempel URL berikut ke peramban (browser) Anda:
                                </p>
                                <p style="margin: 0; font-size: 11px; word-break: break-all; color: #0284c7;">
                                    <a href="{{ $url }}" style="color: #0284c7; text-decoration: underline;">{{ $url }}</a>
                                </p>
                            </div>
                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 20px 28px; text-align: center;">
                            <p style="margin: 0 0 4px; font-size: 12px; font-weight: 600; color: #64748b;">
                                Gajah Depa Akuatik
                            </p>
                            <p style="margin: 0; font-size: 11px; color: #94a3b8;">
                                Email ini dikirim secara otomatis oleh sistem, mohon untuk tidak membalas langsung ke alamat ini.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

