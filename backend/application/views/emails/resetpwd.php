<html>
<head>
    <style>
        body {
            background: #fff;
            color: #000;
            font-size: 16px;
        }
        h3 {
            font-size: 20px;
            text-align: center;
        }
        h2{
            font-size: 25px;
            text-align: center;
        }
        p {
            text-align: center;
        }
        .container {
            width: 70%;
            margin: 80px auto;
            padding: 20px;
            border: 1px;
            font-size: 16px;
            background: #efefef;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Reset Password</h3>

        <h2><?php echo $code; ?></h2>

        <p> Your password reset code is <?php echo $code; ?>. Please input the code in the app </p>
    </div>
</body>
</html>