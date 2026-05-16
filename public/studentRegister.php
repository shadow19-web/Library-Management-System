<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration - LibroTech</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../src/css/studentRegister.css">
</head>

<body>
    <div class="background-overlay"></div>
    <div class="register-container">

        <div class="logo">
            <i class="fas fa-user-graduate"></i>
        </div>

        <h1>Student Registration</h1>
        <p>LibroTech Library Management System</p>

        <form action="../auth/process_student_register.php" method="POST" id="registerForm">
            <div class="form-row">
                <div class="form-group">
                    <label for="firstname">First Name</label>
                    <input type="text" id="firstname" name="firstname" placeholder="Jhon" required>
                    <span class="field-error-message">This field is required</span>
                </div>

                <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input type="text" id="lastname" name="lastname" placeholder="Doe" required>
                    <span class="field-error-message">This field is required</span>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="civilStatus">Civil Status</label>
                    <select id="civilStatus" name="civilStatus" required>
                        <option value="">Select civil status</option>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Divorced">Divorced</option>
                        <option value="Widowed">Widowed</option>
                    </select>
                    <span class="field-error-message">Please select a status</span>
                </div>

                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" required>
                        <option value="">Select gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                    <span class="field-error-message">Please select a gender</span>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="phonenumber">Phone Number</label>
                    <input type="tel" id="phonenumber" name="phonenumber" placeholder="e.g. 09123456789" required>
                    <span class="field-error-message" id="phoneError">Invalid phone number (must be 09... or +639...)</span>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="example@gmail.com" required>
                    <span class="field-error-message">Invalid email format</span>
                </div>
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="e.g. student_123" required>
                <span class="field-error-message">Username is too short</span>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Create your password" required>
                    <span class="field-error-message">Password must be at least 8 characters and include a special character (!@#$%^&*)</span>
                </div>

                <div class="form-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Re-type your password" required>
                    <span class="field-error-message" id="confirmError">Passwords do not match</span>
                </div>
            </div>

            <?php
            if (isset($_SESSION['error'])) {
                echo '<p class="error-message">' . htmlspecialchars($_SESSION['error']) . '</p>';
                unset($_SESSION['error']);
            }

            if (isset($_SESSION['success'])) {
                echo '<p class="success-message">' . htmlspecialchars($_SESSION['success']) . '</p>';
                unset($_SESSION['success']);
            }
            ?>

            <div class="agreement-group">
                <label class="agreement-checkbox">
                    <input type="checkbox" id="agreement" name="agreement">
                    <span>I agree to the <a href="#" class="terms-link">Terms and Conditions</a> of LibroTech</span>
                </label>
                <div class="terms-summary">
                    By checking this box, you agree to follow the library policies, maintain the condition of borrowed books, and adhere to the specified return dates.
                </div>
            </div>

            <button type="submit" class="register-btn" id="registerBtn" disabled>
                <i class="fas fa-user-plus"></i> Register
            </button>
        </form>

        <div class="login-link">
            <p>Already have an account? <a href="studentLogin.php">Sign in</a></p>
        </div>

        <div class="back-home">
            <a href="loginAs.php">
                <i class="fas fa-arrow-left"></i>
                Back to Login Options
            </a>
        </div>
    </div>

    <!-- Terms and Conditions Modal -->
    <div id="termsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Terms and Conditions</h2>
                <span class="close-modal">&times;</span>
            </div>
            <div class="terms-body">
                <h4>1. Data Collection</h4>
                <p>We collect personal information including your name, email, phone number, and academic details to manage your library account. This data is used for:</p>
                <ul>
                    <li>Maintaining borrowing records.</li>
                    <li>Sending automated notifications for due dates and overdues.</li>
                    <li>Ensuring account security and system integrity.</li>
                    <li>All sensitive data is encrypted using industry-standard AES-256 encryption.</li>
                </ul>

                <h4>2. Conditions of Use</h4>
                <p>By registering at LibroTech, you agree to the following:</p>
                <ul>
                    <li>You will provide accurate and up-to-date information during registration.</li>
                    <li>You are responsible for the physical condition of all books borrowed under your account.</li>
                    <li>Books must be returned on or before the specified due date.</li>
                    <li>Losing or damaging books may result in fines or suspension of borrowing privileges.</li>
                </ul>

                <h4>3. System Operations</h4>
                <p>LibroTech reserves the right to suspend accounts that violate library policies or engage in suspicious activity.</p>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById('termsModal');
        const termsLink = document.querySelector('.terms-link');
        const closeBtn = document.querySelector('.close-modal');
        const agreement = document.getElementById('agreement');
        const registerBtn = document.getElementById('registerBtn');
        const form = document.getElementById('registerForm');

        // Toggle Register Button
        agreement.addEventListener('change', function() {
            registerBtn.disabled = !this.checked;
        });

        // Simple Visual Validation (Red Boxes)
        function setError(element, hasError) {
            const group = element.closest('.form-group');
            if (hasError) {
                element.classList.add('error-field');
                group.classList.add('has-error');
            } else {
                element.classList.remove('error-field');
                group.classList.remove('has-error');
            }
        }

        // Comprehensive Field Check
        function validateField(input) {
            let hasError = false;

            // 1. Required Check
            if (input.required && input.value.trim() === '') {
                hasError = true;
            }

            // 2. Email Check
            if (input.type === 'email' && input.value !== '') {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                hasError = !emailRegex.test(input.value);
            }

            // 3. Name Length Check
            if ((input.id === 'firstname' || input.id === 'lastname') && input.value !== '') {
                hasError = input.value.trim().length < 4;
            }

            // 4. Username Check
            if (input.id === 'username' && input.value !== '') {
                hasError = input.value.length < 5;
            }

            // 4. Password Check (8 chars + special char)
            if (input.id === 'password' && input.value !== '') {
                const specialCharRegex = /[!@#$%^&*]/;
                hasError = input.value.length < 8 || !specialCharRegex.test(input.value);
            }

            // 5. Password Matching
            if (input.id === 'confirmPassword') {
                const pass = document.getElementById('password').value;
                hasError = input.value !== pass;
            }

            // 6. Phone Number Check
            if (input.id === 'phonenumber' && input.value !== '') {
                hasError = !(input.value.startsWith('09') || input.value.startsWith('+639'));
            }

            setError(input, hasError);
        }

        // Run validation on all interactions
        form.addEventListener('input', (e) => validateField(e.target));
        form.addEventListener('blur', (e) => validateField(e.target), true);
        form.addEventListener('change', (e) => validateField(e.target));

        // Prevent submission if errors exist
        form.addEventListener('submit', function(e) {
            const inputs = form.querySelectorAll('input[required], select[required]');
            let firstError = null;

            inputs.forEach(input => {
                validateField(input);
                if (input.classList.contains('error-field')) {
                    if (!firstError) firstError = input;
                }
            });

            if (firstError) {
                e.preventDefault();
                firstError.focus();
            }
        });

        // Modal Open/Close
        termsLink.addEventListener('click', function(e) {
            e.preventDefault();
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });

        closeBtn.addEventListener('click', function() {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        });

        window.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }
        });
    </script>
</body>

</html>