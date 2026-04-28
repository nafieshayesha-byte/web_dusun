<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Dusun Pilang</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            /* Fix the background positioning to the left-bottom so the farmer and village are perfectly visible! */
            background: url('../assets/login_bg.png') left bottom / cover no-repeat;
            background-color: #f5f4eb; /* fallback cream */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Inter', sans-serif;
            box-sizing: border-box;
            position: relative;
            overflow: hidden;
        }

        .login-wrapper {
            width: 100%;
            height: 100%;
            display: flex;
            position: relative;
        }

        /* Top left logo */
        .brand-logo {
            position: absolute;
            top: 40px;
            left: 50px;
            display: flex;
            align-items: center;
            gap: 15px;
            z-index: 10;
        }
        .brand-logo-stack {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }
        .brand-logo-img {
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .brand-logo img {
            height: 55px; /* Increased size to match the image visually */
            width: 55px;
            border-radius: 50%;
            object-fit: cover;
        }
        .brand-text-sub {
            font-weight: 800;
            font-size: 13px;
            letter-spacing: -0.3px;
        }
        .text-desa { color: #1a4d25; }
        .text-app { color: #f58400; }
        
        .brand-text-main {
            font-weight: 800;
            color: #12361a;
            font-size: 26px; /* Big title next to it */
            letter-spacing: -0.5px;
        }

        /* The Wave Background Container */
        .wave-container {
            position: absolute;
            right: 0;
            top: 0;
            width: 60%; /* Covers exactly 40%-100% of the screen width */
            height: 100vh;
            z-index: 1;
            filter: drop-shadow(-15px 0 25px rgba(0,0,0,0.15));
        }
        .wave-shape {
            width: 100%;
            height: 100%;
            background: #C3CC9B; /* requested solid color */
            clip-path: url(#wave-curve);
        }

        /* Right side panel */
        .right-panel {
            margin-left: auto;
            width: 50%; /* Right half */
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            z-index: 5;
            height: 100vh;
            padding-right: 5%;
        }

        .welcome-text {
            margin-left: 12%; /* Pushed rightwards slightly for a safer breathing room from the wave */
            margin-bottom: 35px;
        }
        .welcome-text h3 {
            color: #1c3319;
            margin: 0 0 10px;
            font-size: 20px;
            font-weight: 700;
        }
        .welcome-text h1 {
            color: #112d14;
            font-weight: 800;
            font-size: 44px;
            margin: 0 0 15px;
            line-height: 1.1;
            letter-spacing: -1.5px;
        }
        .welcome-text p {
            color: #3b4e36;
            font-size: 14px;
            margin: 0;
            line-height: 1.6;
            font-weight: 500;
            max-width: 500px; /* Ensure description doesn't wrap unnecessarily */
        }

        /* Login Card */
        .login-card {
            background: rgba(255, 255, 255, 0.35); /* #FFFFFF with semi-transparency */
            backdrop-filter: blur(12px); /* Adding frosted glass blur effect */
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5); /* Glossy frosted edge */
            padding: 40px 45px;
            border-radius: 20px;
            width: 100%;
            max-width: 440px;
            margin-left: 35%; /* Pushed significantly to the right to avoid the wave bulge */
            box-sizing: border-box;
            box-shadow: 0 10px 40px rgba(0,0,0,0.05);
        }
        .login-card h2 {
            color: #27452b;
            font-size: 24px;
            margin-top: 0;
            text-align: center;
            margin-bottom: 35px;
            font-weight: 800;
        }
        
        .form-group {
            margin-bottom: 22px;
        }
        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 800;
            color: #1a3219;
            margin-bottom: 8px;
        }
        .form-input {
            width: 100%;
            padding: 15px 20px;
            border: none;
            border-radius: 50px;
            font-size: 13px;
            font-family: inherit;
            outline: none;
            box-sizing: border-box;
            background: #ffffff;
            color: #1E3B20;
            font-weight: 600;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
            transition: all 0.3s;
        }
        .form-input::placeholder {
            color: #9ca3af;
            font-weight: 500;
            font-size: 12px;
        }
        .form-input:focus {
            box-shadow: 0 0 0 3px rgba(30, 59, 32, 0.1);
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
            font-size: 11px;
            padding: 0 5px;
        }
        .form-options label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #4a5d48;
            cursor: pointer;
            font-weight: 500;
        }
        .form-options input[type="checkbox"] {
            accent-color: #254228;
            cursor: pointer;
            width: 14px;
            height: 14px;
            margin: 0;
            border: none;
        }
        .form-options a {
            color: #4a5d48;
            text-decoration: underline;
            text-decoration-color: rgba(74, 93, 72, 0.5);
            text-underline-offset: 3px;
            font-weight: 500;
        }
        .form-options a:hover {
            color: #1E3B20;
        }

        .btn-submit {
            width: 100%;
            background: #4A674A; /* Exact match to button on mockup */
            color: white;
            border: none;
            padding: 16px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(74, 103, 74, 0.3);
            background: #395239;
        }
        
        /* Floating Back Button */
        .btn-back {
            position: fixed; /* 'fixed' ensures it anchors to the browser screen strictly */
            bottom: 12px; /* Mentok ke bawah poll */
            right: 12px; /* Mentok ke kanan poll */
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            color: #12361a;
            padding: 10px 22px;
            border-radius: 50px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 20;
            border: 1px solid rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .btn-back:hover {
            background: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        
        @media (max-width: 900px) {
            .right-panel {
                width: 100%;
                background: rgba(245, 244, 235, 0.95);
                backdrop-filter: blur(10px);
                justify-content: center;
                align-items: flex-start;
                padding: 40px;
                max-width: 100%;
            }
            .welcome-text { margin-left: 0; }
            .login-card { margin-left: 0; margin-top: 20px; }
            
            .btn-back {
                bottom: 15px;
                right: 15px;
                padding: 8px 16px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>

<!-- SVG Defs for Perfect S-Wave -->
<svg width="0" height="0" style="position: absolute;">
  <defs>
    <clipPath id="wave-curve" clipPathUnits="objectBoundingBox">
      <!-- Mathematically perfectly centered symmetrical wave on the 50% screen axis -->
      <path d="M 0.166,0 C -0.15,0.3 0.48,0.7 0.166,1 L 1,1 L 1,0 Z" />
    </clipPath>
  </defs>
</svg>

<div class="login-wrapper">
    <!-- Floating Back Button -->
    <a href="../index.php" class="btn-back">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Kembali
    </a>

    <!-- Brand Logo -->
    <div class="brand-logo">
        <div class="brand-logo-stack">
            <div class="brand-logo-img">
                <img src="../assets/logo_dusun.png" onerror="this.src='https://ui-avatars.com/api/?name=DP&background=86c232&color=fff&rounded=true'" alt="Logo Dusun">
            </div>
            <span class="brand-text-sub"><span class="text-desa">Desa</span><span class="text-app">App</span></span>
        </div>
        <span class="brand-text-main">Dusun Pilang</span>
    </div>

    <!-- The Wave Background Shape -->
    <div class="wave-container">
        <div class="wave-shape"></div>
    </div>

    <!-- Right Side Panel (content only) -->
    <div class="right-panel">
            
        <div class="welcome-text">
            <h3>Hallo Admin,</h3>
            <h1>Welcome to Dusun Pilang</h1>
            <p>Kelola data desa dengan mudah, cepat, dan transparan untuk kesejahteraan bersama.</p>
        </div>
        
        <div class="login-card">
            <h2>Login</h2>
            
            <form action="proses_login.php" method="POST">
                
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-input" placeholder="Enter your username" required>
                </div>
                
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="Enter your password" required>
                </div>
                
                <div class="form-options">
                    <label>
                        <input type="checkbox" onclick="togglePassword()"> Show password
                    </label>
                    <a href="#">Forgot Password?</a>
                </div>
                
                <button type="submit" class="btn-submit">
                    Login to Admin
                </button>
                
            </form>
        </div>
            
    </div>
</div>

<script>
    function togglePassword() {
        var pwd = document.getElementById("password");
        if (pwd.type === "password") {
            pwd.type = "text";
        } else {
            pwd.type = "password";
        }
    }
</script>

</body>
</html>
