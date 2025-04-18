<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premier League - Sign In</title>
    
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

        /* Animated football pitch overlay */
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

    

        @keyframes moveLines {
            0% { background-position: 0 0; }
            100% { background-position: 1000px 1000px; }
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

        /* Unified form control styling */
        .form-control {
            width: 100%;
            padding: 14px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            outline: none;
            font-size: 16px;
            color: #fff;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        input.form-control:focus, 
        select.form-control:focus {
            border-color: #e0001a;
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 10px rgba(224, 0, 26, 0.3);
        }

        input.form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        select.form-control {
            appearance: none;
           
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 15px;
        }

        /* Fix for dropdown options visibility */
        select.form-control option {
            background: #0a2240;
            color: white;
            padding: 10px;
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
            text-align: center;
            display: block;
            box-sizing: border-box;
        }

        .form-button::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%, -50%);
            transform-origin: 50% 50%;
        }

        .form-button:focus:not(:active)::after {
            animation: ripple 0.6s ease-out;
        }

        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 0.5;
            }
            100% {
                transform: scale(20, 20);
                opacity: 0;
            }
        }

        .form-button:hover {
            background: #c00018;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(224, 0, 26, 0.3);
        }

        p {
            font-size: 14px;
            text-align: center;
            margin-bottom: 10px;
            color: rgba(255, 255, 255, 0.8);
        }

        p a {
            color: #e0001a;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        p a:hover {
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
            
            .form-control,
            .form-button {
                padding: 12px;
            }
            
            .logo-header img {
                height: 50px;
            }
        }
    </style>
</head>
<body>
    <!-- Your existing login page content -->
    <div class="container">
        <div class="form-box active" id="login-form"> 
            <div class="logo-header">
                <img src="assets/images/club/BPL.png" alt="Premier League Logo">
            </div>
            <form id="loginForm" method="POST">
                <h2>Login</h2>
                <div id="loginMessage" class="message" style="display: none;"></div>
                <input type="email" name="email" class="form-control" placeholder="Email" required>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <button type="submit" class="form-button" name="login">Login</button>
                <p>Don't have an account? <a href="#" onclick="showForm('register-form')">Register</a></p>
            </form>
        </div>

        <div class="form-box" id="register-form">
            <div class="logo-header">
                <img src="assets/images/club/BPL.png" alt="Premier League Logo">
            </div>
            <form id="registerForm" method="POST">
                <h2>Register</h2>
                <div id="registerMessage" class="message" style="display: none;"></div>
                <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                <input type="email" name="email" class="form-control" placeholder="Email" required>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <select name="role" class="form-control" required>
                    <option value="">--Select Role--</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
                <button type="submit" class="form-button" name="register">Join The League</button>
                <p>Already have an account? <a href="#" onclick="showForm('login-form')">Login</a></p>
            </form>
        </div>
    </div>

    <script>
        // Your existing JavaScript with AJAX calls
        function showForm(formId) {
            document.querySelectorAll('.form-box').forEach(form => {
                form.classList.remove('active');
            });
            document.getElementById(formId).classList.add('active');
            document.getElementById('loginMessage').style.display = 'none';
            document.getElementById('registerMessage').style.display = 'none';
            return false;
        }

        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            fetch('process_login.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const messageElement = document.getElementById('loginMessage');
                messageElement.style.display = 'block';
                
                if (data.success) {
                    messageElement.className = 'message success';
                    messageElement.textContent = data.message;
                    setTimeout(() => {
                        window.location.href = data.redirect || 'dashboard.php';
                    }, 1500);
                } else {
                    messageElement.className = 'message error';
                    messageElement.textContent = data.message;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                const messageElement = document.getElementById('loginMessage');
                messageElement.style.display = 'block';
                messageElement.className = 'message error';
                messageElement.textContent = 'An error occurred. Please try again.';
            });
        });

        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            fetch('process_register.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const messageElement = document.getElementById('registerMessage');
                messageElement.style.display = 'block';
                
                if (data.success) {
                    messageElement.className = 'message success';
                    messageElement.textContent = data.message;
                    this.reset();
                    setTimeout(() => showForm('login-form'), 2000);
                } else {
                    messageElement.className = 'message error';
                    messageElement.textContent = data.message;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                const messageElement = document.getElementById('registerMessage');
                messageElement.style.display = 'block';
                messageElement.className = 'message error';
                messageElement.textContent = 'An error occurred. Please try again.';
            });
        });
    </script>
</body>
</html>