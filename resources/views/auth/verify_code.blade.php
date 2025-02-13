
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mã xác thực đặt lại mật khẩu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .container {
            max-width: 80%;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #e63946;
            font-size: 24px;
            text-align: center;
        }

        p {
            margin: 15px 0;
            font-size: 16px;
        }

        .order-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }

        .order-info ul {
            list-style: none;
            padding: 0;
        }

        .order-info li {
            margin: 10px 0;
            font-size: 14px;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #555;
        }

        .footer a {
            color: #007bff;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        img.logo {
            max-width: 150px;
            margin: 0 auto 20px;
            display: block;
        }

        .c {
            display: flex;
            justify-content: center
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #f8f9fa;
            color: #333;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e9ecef;
        }

        td {
            color: #555;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class=".c">
            <img src="https://i.imgur.com/vPk7lbg.png" alt="Uploaded Image">
        </div>

        <h1>Xác thực đặt lại mật khẩu</h1>
        <p>Chào <strong>{{ $ho_ten }}</strong>,</p>
        <p>Mã xác thực để đặt lại mật khẩu của bạn là: <strong>{{ $token }}</strong></p>

        <p>Mã này có hiệu lực trong 30 phút.</p>
        <p>Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.</p>
    </div>
    <p>Cảm ơn bạn đã  qua tâm đến các sản phẩm của Articraft!</p>
    <p>Chúc bạn một ngày tốt lành.</p>
</body>

</html>
