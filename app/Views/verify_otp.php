<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .otp-container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .otp-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .btn-custom {
            width: 100%;
            background-color: #007bff;
            border: none;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="otp-container">
    <h2>Verify OTP</h2>
    <form action="<?= base_url('/checkout/check-otp') ?>" method="post">
        <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input type="text" name="phone" class="form-control" value="<?= session('phone') ?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Enter OTP</label>
            <input type="text" name="otp" class="form-control" placeholder="Enter OTP" required>
        </div>
        <button type="submit" class="btn btn-custom">Verify OTP</button>
    </form>
</div>
</body>
</html>
