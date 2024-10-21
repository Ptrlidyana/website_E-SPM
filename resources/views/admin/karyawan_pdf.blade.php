<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order Pupuk Cair Saritana</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            position: relative;
            min-height: 100vh;
        }
        .header {
            text-align: right;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .company-info {
            text-align: left;
            margin-bottom: 30px;
        }
        .content {
            margin: 20px 0;
        }
        .content p {
            line-height: 1.8;
        }
        .footer {
            margin-top: 50px;
        }

        /* Menambahkan styling agar rata */
        .label {
            width: 150px;
            display: inline-block;
            font-weight: bold;
        }

        .info {
            display: inline-block;
            text-align: left;
        }

        .title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .date, .signature {
            position: absolute;
            right: 0;
            text-align: right;
        }

        .date {
            bottom: 120px; 
        }

        .signature {
            bottom: 20px; 
        }
    </style>
</head>
<body>

    <div class="header">
        <p>No. PO: {{ $karyawan->no_po }}</p>
    </div>

    <div class="company-info">
        <p>Kepada Yth.<br>
        PT SASA INTI<br>
        Gending - Probolinggo</p>
    </div>

    <div class="title">
        <p>PURCHASE ORDER PUPUK CAIR SARITANA</p>
    </div>

    <div class="content">
        <p>Dengan hormat,<br>
        Bersama ini kami kirimkan truk kami,</p>

        <p>
            <span class="label">Nama Transportir</span>: <span class="info">{{ $karyawan->nama_transportir }}</span><br>
            <span class="label">Nomor Polisi</span>: <span class="info">{{ $karyawan->nomer_polisi }}</span><br>
            <span class="label">Volume</span>: <span class="info">{{ $karyawan->volume }}</span><br>
            <span class="label">Nama Sopir</span>: <span class="info">{{ $karyawan->nama_user }}</span>
        </p>
    </div>

    <div class="footer">
        <p>Untuk dapatnya diberikan / diisi Pupuk Cair Saritana<br>
        Atas perhatiannya kami ucapkan terima kasih.</p>
    </div>
    
    
    <div class="date">
        <p>{{ date('d M Y') }}</p>
    </div>

    
    <div class="signature">
        <p>Hormat kami,<br><br><br><br>Nama Terang</p>
    </div>

</body>
</html>
