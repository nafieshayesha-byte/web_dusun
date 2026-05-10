<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Nasabah - Bank Sampah Pilang</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }

        body {
            min-height: 100vh;
            display: flex;
            background: #f0f4e8;
        }

        /* ── Left Panel ── */
        .left-panel {
            flex: 1;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            background: linear-gradient(180deg, #d4e8c2 0%, #a8d08d 40%, #6ba854 100%);
            min-height: 100vh;
        }
        .left-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url('assets/nasabah_bg.png') center bottom / cover no-repeat;
            z-index: 1;
        }
        .left-panel::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 30%;
            background: linear-gradient(180deg, rgba(212,232,194,0.8) 0%, transparent 100%);
            z-index: 2;
        }

        .left-logo {
            position: absolute;
            top: 35px;
            left: 35px;
            z-index: 10;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .left-logo-icon {
            width: 48px;
            height: 48px;
            background: #12361A;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }
        .left-logo-icon i {
            color: #7DA67D;
            font-size: 20px;
        }
        .left-logo-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }
        .left-logo-text .top {
            font-size: 11px;
            font-weight: 700;
            color: #12361A;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .left-logo-text .bottom {
            font-size: 26px;
            font-weight: 900;
            color: #12361A;
            letter-spacing: -0.5px;
            font-style: italic;
        }

        /* ── Right Panel ── */
        .right-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            background: #ffffff;
            position: relative;
        }
        .right-panel::before {
            content: '';
            position: absolute;
            top: -80px;
            right: -80px;
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(125,166,125,0.08) 0%, transparent 70%);
            border-radius: 50%;
        }

        .login-card {
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 1;
        }

        .avatar-circle {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #e8f0dc 0%, #d4e2c4 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            box-shadow: 0 6px 20px rgba(18,54,26,0.08);
        }
        .avatar-circle i {
            font-size: 28px;
            color: #12361A;
        }

        .login-card h1 {
            text-align: center;
            font-size: 32px;
            font-weight: 900;
            color: #12361A;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
            font-style: italic;
        }
        .login-card .subtitle {
            text-align: center;
            font-size: 14px;
            color: #62836b;
            font-weight: 500;
            margin-bottom: 40px;
        }

        .form-field {
            position: relative;
            margin-bottom: 20px;
        }
        .form-field i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #7DA67D;
            font-size: 16px;
            z-index: 2;
        }
        .form-field input {
            width: 100%;
            padding: 16px 20px 16px 50px;
            border: 2px solid #e8f0dc;
            border-radius: 14px;
            font-size: 15px;
            font-weight: 500;
            color: #12361A;
            background: #ffffff;
            transition: all 0.3s ease;
            outline: none;
        }
        .form-field input::placeholder {
            color: #a8b8a0;
            font-weight: 500;
        }
        .form-field input:focus {
            border-color: #7DA67D;
            box-shadow: 0 0 0 4px rgba(125,166,125,0.12);
        }

        .btn-row {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            margin-bottom: 20px;
        }
        .btn-back {
            flex: 1;
            padding: 15px 24px;
            border: 2px solid #12361A;
            background: #ffffff;
            color: #12361A;
            font-size: 15px;
            font-weight: 700;
            border-radius: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .btn-back:hover {
            background: #f0f4e8;
            transform: translateY(-2px);
        }
        .btn-login {
            flex: 1.2;
            padding: 15px 24px;
            border: none;
            background: #12361A;
            color: #ffffff;
            font-size: 15px;
            font-weight: 700;
            border-radius: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            background: #1a4d26;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(18,54,26,0.3);
        }

        .help-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 24px;
            background: linear-gradient(135deg, #e8f0dc 0%, #dce5ce 100%);
            border-radius: 14px;
            text-decoration: none;
            color: #12361A;
            font-size: 14px;
            font-weight: 700;
            transition: all 0.3s ease;
        }
        .help-link:hover {
            background: linear-gradient(135deg, #dce5ce 0%, #cdd8bc 100%);
            transform: translateY(-2px);
        }
        .help-link .emoji {
            font-size: 18px;
        }

        /* ── Leaf decorations ── */
        .leaf-deco {
            position: absolute;
            opacity: 0.06;
            font-size: 80px;
            color: #12361A;
            z-index: 0;
        }
        .leaf-1 { top: 30px; right: 30px; transform: rotate(25deg); }
        .leaf-2 { bottom: 40px; left: 20px; transform: rotate(-15deg); font-size: 60px; }

        /* ── Responsive ── */
        @media (max-width: 991px) {
            body { flex-direction: column; }
            .left-panel {
                min-height: 280px;
                flex: none;
            }
            .left-logo { top: 20px; left: 20px; }
            .left-logo-text .bottom { font-size: 20px; }
            .right-panel { padding: 30px 20px; }
        }
        @media (max-width: 600px) {
            .left-panel { min-height: 220px; }
            .login-card h1 { font-size: 26px; }
            .btn-row { flex-direction: column; }
        }
    </style>
</head>
<body>

    <!-- Left Panel - Illustration -->
    <div class="left-panel">
        <div class="left-logo">
            <div class="left-logo-icon">
                <i class="fas fa-recycle"></i>
            </div>
            <div class="left-logo-text">
                <span class="top">Bank Sampah</span>
                <span class="bottom">Pilang</span>
            </div>
        </div>
    </div>

    <!-- Right Panel - Login Form -->
    <div class="right-panel">
        <i class="fas fa-leaf leaf-deco leaf-1"></i>
        <i class="fas fa-leaf leaf-deco leaf-2"></i>

        <div class="login-card">
            <div class="avatar-circle">
                <i class="fas fa-user-friends"></i>
            </div>
            <h1>Login Nasabah</h1>
            <p class="subtitle">Silahkan Masukan data Anda untuk masuk ke akun</p>

            <form id="loginForm" method="POST" action="">
                <div class="form-field">
                    <i class="fas fa-user"></i>
                    <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" required>
                </div>
                <div class="form-field">
                    <i class="fas fa-id-card"></i>
                    <input type="text" name="id_nasabah" placeholder="ID Nasabah" required>
                </div>
                <div class="form-field">
                    <i class="fas fa-phone-alt"></i>
                    <input type="tel" name="no_hp" placeholder="No. Handphone" required>
                </div>

                <div class="btn-row">
                    <a href="bank_sampah.php" class="btn-back">Kembali</a>
                    <button type="submit" class="btn-login">Masuk</button>
                </div>
            </form>

            <a href="kontak.php" class="help-link">
                <span class="emoji">🤖</span>
                Bantuan? Hubungi Admin
            </a>
        </div>
    </div>

</body>
</html>
