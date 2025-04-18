<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premier League - Sign In</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-image: url("assets/images/club/stadium/kings.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.8) 0%, rgba(10, 34, 64, 0.9) 100%);
            z-index: 0;
        }

        .container {
            position: relative;
            z-index: 1;
            margin: 0 15px;
            width: 100%;
            max-width: 450px;
            animation: bounceIn 0.8s ease;
        }

        @keyframes bounceIn {
            0% { transform: scale(0.8); opacity: 0; }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); opacity: 1; }
        }

        .form-box {
            width: 100%;
            padding: 40px 30px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: none;
            transition: all 0.3s ease;
        }

        .form-box.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            font-size: 28px;
            text-align: center;
            margin-bottom: 30px;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            padding-bottom: 10px;
            font-weight: 700;
        }

        h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: #e0001a;
        }

        .form-box::before {
            content: '';
            position: absolute;
            top: -5px;
            left: -5px;
            right: -5px;
            bottom: -5px;
            border-radius: 20px;
            background: linear-gradient(45deg, #e0001a, #0a2240, #e0001a);
            background-size: 200% 200%;
            z-index: -1;
            animation: gradientBG 8s ease infinite;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Input group styling */
        .input-group {
            position: relative;
            margin-bottom: 25px;
        }

        .input-group i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
            z-index: 2;
        }

        .form-control {
            width: 100%;
            padding: 14px 14px 14px 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            outline: none;
            font-size: 16px;
            color: #fff;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .form-control:focus {
            border-color: #e0001a;
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 10px rgba(224, 0, 26, 0.3);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        /* Button styling */
        .form-button {
            width: 100%;
            padding: 14px;
            background: #e0001a;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            color: #fff;
            font-weight: 600;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
        }

        .form-button:hover {
            background: #c00018;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(224, 0, 26, 0.3);
        }

        .or-divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
            color: rgba(255, 255, 255, 0.7);
        }

        .or-divider::before,
        .or-divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .or-divider span {
            padding: 0 10px;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .social-icon:hover {
            background: #e0001a;
            transform: translateY(-3px);
        }

        .form-footer {
            text-align: center;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
        }

        .form-footer a {
            color: #e0001a;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .form-footer a:hover {
            color: #ff3333;
            text-decoration: underline;
        }

        .logo-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo-header img {
            height: 60px;
            margin-bottom: 10px;
        }

        /* Responsive adjustments */
        @media (max-width: 480px) {
            .form-box {
                padding: 30px 20px;
            }
            
            h2 {
                font-size: 24px;
            }
            
            .form-control {
                padding: 12px 12px 12px 40px;
            }
            
            .form-button {
                padding: 12px;
            }
            
            .logo-header img {
                height: 50px;
            }
        }

        /* Message styling */
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
            display: none;
        }

        .message.success {
            background-color: rgba(0, 200, 0, 0.2);
            border: 1px solid rgba(0, 200, 0, 0.5);
            color: #0f0;
        }

        .message.error {
            background-color: rgba(200, 0, 0, 0.2);
            border: 1px solid rgba(200, 0, 0, 0.5);
            color: #f00;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-box active" id="login-form"> 
            <div class="logo-header">
                <img src="assets/images/club/BPL.png" alt="Premier League Logo">
            </div>
            <form id="loginForm" method="POST" action="register.php">
                <h2>Login</h2>
                <?php if(isset($_GET['error']) && $_GET['error'] == 'login'): ?>
                <div class="message error">Incorrect email or password</div>
                <?php endif; ?>
                
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                
                <p class="form-footer">
                    <a href="#">Recover Password</a>
                </p>
                
                <button type="submit" class="form-button" name="signIn">Sign In</button>
                
                <div class="or-divider">
                    <span>OR</span>
                </div>
                
                <div class="social-icons">
                    <div class="social-icon">
                        <i class="fab fa-google"></i>
                    </div>
                    <div class="social-icon">
                        <i class="fab fa-facebook-f"></i>
                    </div>
                </div>
                
                <p class="form-footer">
                    Don't have an account? <a href="#" onclick="showForm('register-form')">Sign Up</a>
                </p>
            </form>
        </div>

        <div class="form-box" id="register-form">
            <div class="logo-header">
                <img src="assets/images/club/BPL.png" alt="Premier League Logo">
            </div>
            <form id="registerForm" method="POST" action="register.php">
                <h2>Register</h2>
                <?php if(isset($_GET['error']) && $_GET['error'] == 'email_exists'): ?>
                <div class="message error">Email address already exists!</div>
                <?php endif; ?>
                
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="fName" class="form-control" placeholder="First Name" required>
                </div>
                
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="lName" class="form-control" placeholder="Last Name" required>
                </div>
                
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                
                <button type="submit" class="form-button" name="signUp">Sign Up</button>
                
                <div class="or-divider">
                    <span>OR</span>
                </div>
                
                <div class="social-icons">
                    <div class="social-icon">
                        <i class="fab fa-google"></i>
                    </div>
                    <div class="social-icon">
                        <i class="fab fa-facebook-f"></i>
                    </div>
                </div>
                
                <p class="form-footer">
                    Already have an account? <a href="#" onclick="showForm('login-form')">Sign In</a>
                </p>
            </form>
        </div>
    </div>

    <script>
        function showForm(formId) {
            document.querySelectorAll('.form-box').forEach(form => {
                form.classList.remove('active');
            });
            document.getElementById(formId).classList.add('active');
            return false;
        }
    </script>
</body>
</html>