<?php 

session_start();

include('assets/include/config.php');

$error_message = '';

if (isset($_POST["btn_login"])){
    // Basic sanitization (better to use prepared statements)
    $loginname = trim(htmlspecialchars($_POST["login_name"]));
    $pwd = trim(htmlspecialchars($_POST["pwd_login"]));

    // Fetch user by login only first
    $stmt = $cnx->prepare("SELECT * FROM `users` WHERE login = ?");
    $stmt->execute([$loginname]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Verify hashed password
    if($user && password_verify($pwd, $user['pwd'])){
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['user_name'] = $user['name'];
        header("location:pages/dashboard.php");
        exit();
    } else {
        $error_message = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Log in or create an account for Fast Fit Gym Portal">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Fast Fit Gym Portal</title>
    <link rel="shortcut icon" type="image/png" href="assets/IMAGES/logo-icon.png">
    <link rel="stylesheet" href="./assets/CSS/login.css">
   
</head>

<body>
    <div class="portal-container">
        <div class="portal-header">
            <img src="assets/IMAGES/fast-fit.png" alt="Fast Fit Gym Logo" class="brand-logo">
            <h1 class="portal-title">Fast Fit Gym Portal</h1>
            <p class="portal-subtitle">Your journey to fitness starts here! Log in or create an account.</p>
        </div>

        <div class="toggle-buttons">
            <button class="toggle-button active" id="signin-toggle">Sign In</button>
            <button class="toggle-button" id="signup-toggle">Create Account</button>
        </div>

        <div class="form-section">
            <!-- Sign In Form -->
            <div class="form-container signin-container active">
                <div class="form-header">
                    <h2>Welcome Back!</h2>
                    <p>Access your fitness dashboard</p>
                </div>

                <?php if ($error_message): ?>
                    <div class="alert"><?php echo htmlspecialchars($error_message); ?></div>
                <?php endif; ?>

                <form method="post" id="signin-form" novalidate>
                    <div class="form-group">
                        <i class="fas fa-user"></i>
                        <input type="text" name="login_name" placeholder="Username" class="form-input" required 
                               aria-label="Username" autocomplete="username">
                    </div>

                    <div class="form-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="pwd_login" placeholder="Password" class="form-input" required 
                               aria-label="Password" autocomplete="current-password" id="signin-password">
                        <i class="fas fa-eye password-toggle" id="signin-password-toggle"></i>
                    </div>

                    <div class="form-footer">
                        <a href="forgot_password.php" class="form-link">Forgot Password?</a>
                        <button type="submit" name="btn_login" class="form-button">Sign In</button>
                    </div>
                </form>
            </div>

            <!-- Sign Up Form -->
            <div class="form-container signup-container">
                <div class="form-header">
                    <h2>Join Our Community</h2>
                    <p>Create your account to start your fitness journey</p>
                </div>

                <form method="post" action="assets/include/script.php" id="signup-form" novalidate>
                    <div class="form-group">
                        <i class="fas fa-user"></i>
                        <input type="text" name="name" placeholder="Full Name" class="form-input" required 
                               aria-label="Full Name" autocomplete="name">
                    </div>

                    <div class="form-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" placeholder="Email Address" class="form-input" required 
                               aria-label="Email" autocomplete="email">
                    </div>

                    <div class="form-group">
                        <i class="fas fa-at"></i>
                        <input type="text" name="login" placeholder="Username" class="form-input" required 
                               aria-label="Username" autocomplete="username">
                    </div>

                    <div class="form-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="pwd" placeholder="Password" class="form-input" required 
                               aria-label="Password" autocomplete="new-password" id="signup-password">
                        <i class="fas fa-eye password-toggle" id="signup-password-toggle"></i>
                    </div>

                    <div class="form-footer">
                        <a href="#" class="form-link">Privacy Policy</a>
                        <button type="submit" name="btn_ajouter_user" class="form-button">Create Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const signinToggle = document.getElementById('signin-toggle');
            const signupToggle = document.getElementById('signup-toggle');
            const signinForm = document.querySelector('.signin-container');
            const signupForm = document.querySelector('.signup-container');

            // Toggle between sign in and sign up
            signinToggle.addEventListener('click', () => {
                signinToggle.classList.add('active');
                signupToggle.classList.remove('active');
                signinForm.classList.add('active');
                signupForm.classList.remove('active');
            });

            signupToggle.addEventListener('click', () => {
                signupToggle.classList.add('active');
                signinToggle.classList.remove('active');
                signupForm.classList.add('active');
                signinForm.classList.remove('active');
            });

            // Password visibility toggle
            const togglePassword = (inputId, toggleId) => {
                const input = document.getElementById(inputId);
                const toggle = document.getElementById(toggleId);
                toggle.addEventListener('click', () => {
                    const type = input.type === 'password' ? 'text' : 'password';
                    input.type = type;
                    toggle.classList.toggle('fa-eye');
                    toggle.classList.toggle('fa-eye-slash');
                });
            };

            togglePassword('signin-password', 'signin-password-toggle');
            togglePassword('signup-password', 'signup-password-toggle');

            // Form validation
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', (e) => {
                    const inputs = form.querySelectorAll('.form-input');
                    let valid = true;

                    inputs.forEach(input => {
                        if (!input.value.trim()) {
                            valid = false;
                            input.classList.add('error');
                            input.style.borderColor = 'var(--accent)';
                        } else {
                            input.classList.remove('error');
                            input.style.borderColor = '';
                        }
                    });

                    if (!valid) {
                        e.preventDefault();
                        const alert = document.createElement('div');
                        alert.className = 'alert';
                        alert.textContent = 'Please fill in all fields';
                        form.insertBefore(alert, form.firstChild);
                        setTimeout(() => alert.remove(), 3000);
                    }
                });
            });

            // Auto-hide alerts
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 4000);
            });
        });
    </script>
</body>
</html>