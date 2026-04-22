<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email</title>
    <!--[if mso]>
    <noscript>
    <xml>
    <o:OfficeDocumentSettings>
        <o:PixelsPerInch>96</o:PixelsPerInch>
    </o:OfficeDocumentSettings>
    </xml>
    </noscript>
    <![endif]-->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');
        body { margin: 0; padding: 0; width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; background-color: #f4f7ff; }
        img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; }
        table { border-collapse: collapse !important; }
        
        @media only screen and (max-width: 600px) {
            .container { width: 100% !important; padding: 10px !important; }
            .content { padding: 20px !important; }
            .header { padding: 20px 0 !important; }
        }
    </style>
</head>
<body style="font-family: 'Inter', Helvetica, Arial, sans-serif; background-color: #f4f7ff; margin: 0; padding: 0;">
    <center>
        <table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%" style="background-color: #f4f7ff;">
            <tr>
                <td align="center" valign="top" style="padding: 40px 10px;">
                    <!-- Main Container -->
                    <table border="0" cellpadding="0" cellspacing="0" width="600" class="container" style="background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                        <!-- Header / Logo -->
                        <tr>
                            <td align="center" style="padding: 40px 40px 20px 40px;" class="header">
                                <div style="background-color: #f0eeff; width: 64px; height: 64px; border-radius: 16px; display: table;">
                                    <div style="display: table-cell; vertical-align: middle; text-align: center;">
                                        <span style="font-size: 32px; line-height: 1;">🛡️</span>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Content -->
                        <tr>
                            <td align="center" style="padding: 0 40px 40px 40px;" class="content">
                                <h1 style="color: #1f2937; font-size: 24px; font-weight: 700; line-height: 1.3; margin: 0 0 16px 0;">
                                    Email Verification Required
                                </h1>
                                <p style="color: #4b5563; font-size: 16px; line-height: 1.6; margin: 0 0 24px 0;">
                                    Halo <strong style="color: #695FE2;">{{ Session()->get('userId') }}</strong>,
                                    <br>
                                    Terima kasih telah bergabung dengan sistem kami. Untuk memastikan keamanan data Anda, silakan verifikasi alamat email Anda.
                                </p>
                                
                                <!-- CTA Button -->
                                <table border="0" cellpadding="0" cellspacing="0" style="margin: 32px 0;">
                                    <tr>
                                        <td align="center" bgcolor="#695FE2" style="border-radius: 12px;">
                                            <a href="{{ url('/email/verify/'.Session()->get('token')) }}" target="_blank" style="font-size: 16px; font-family: 'Inter', Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; padding: 16px 32px; display: inline-block; font-weight: 600; letter-spacing: 0.5px;">
                                                VERIFIKASI DATA SEKARANG
                                            </a>
                                        </td>
                                    </tr>
                                </table>

                                <p style="color: #6b7280; font-size: 14px; line-height: 1.5; margin: 24px 0 0 0;">
                                    Agar dapat menggunakan sistem yang kami buat, Anda harus memverifikasi alamat email Anda. Tombol ini akan aktif selama 24 jam.
                                </p>
                            </td>
                        </tr>

                        <!-- Footer Info -->
                        <tr>
                            <td align="center" style="padding: 30px 40px; background-color: #f9fafb; border-top: 1px solid #f3f4f6;">
                                <p style="color: #9ca3af; font-size: 12px; line-height: 1.6; margin: 0;">
                                    Jika Anda tidak merasa mendaftar di sistem kami, harap abaikan email ini.
                                </p>
                                <div style="margin-top: 16px;">
                                    <a href="#" style="color: #9ca3af; text-decoration: none; font-size: 12px; font-weight: 600; margin: 0 8px;">Tentang Kami</a>
                                    <span style="color: #d1d5db;">&bull;</span>
                                    <a href="#" style="color: #9ca3af; text-decoration: none; font-size: 12px; font-weight: 600; margin: 0 8px;">Privasi</a>
                                    <span style="color: #d1d5db;">&bull;</span>
                                    <a href="#" style="color: #9ca3af; text-decoration: none; font-size: 12px; font-weight: 600; margin: 0 8px;">Bantuan</a>
                                </div>
                                <p style="color: #9ca3af; font-size: 12px; margin: 16px 0 0 0;">
                                    &copy; 2026 Dashboard System. All rights reserved.
                                </p>
                            </td>
                        </tr>
                    </table>
                    
                    <!-- Sub-footer -->
                    <table border="0" cellpadding="0" cellspacing="0" width="600" class="container">
                        <tr>
                            <td style="padding: 24px 0;" align="center">
                                <p style="color: #9ca3af; font-size: 12px;">
                                    Sent with ❤️ from our team.
                                </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </center>
</body>
</html>