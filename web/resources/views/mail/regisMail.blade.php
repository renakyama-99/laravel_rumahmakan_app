<!DOCTYPE HTML>
<html>
    <head>
        <title></title>
        <style>
                .btn {
                background-color: #695FE2; /* Green */
                border: none;
                color: white;
                padding: 15px 32px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                }

                .wrapper {
                    position: relative;
                	padding: 70px 0;
			        text-align: center;  
                    max-width:660px;
                }
                .wrapper p {
                	color: #4B49AC !important;
                }
                .wrapper table {
                	position : relative;
                	
                }
        </style>
    </head>
    <body>
    <center> 
        <div class="wrapper">
            <table>
                <tr>
                    <p>Halo {{ Session()->get('userId') }} Untuk verifikasi data silahkan klik tombol dibawah ini</p>
                </tr>
                <tr>
                    <a href="{{ url('/email/verify/'.Session()->get('token')) }}" class="btn">VERIFY DATA</a>
                </tr>
                <tr>
                    <p>Agar dapat menggunakan sistem yg kami buat anda harus memverifykasi Email anda</p>
                </tr>
            </table>
        </div>
    </center> 
    </body>
</html>