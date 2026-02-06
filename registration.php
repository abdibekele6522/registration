<?php
// Initialize variables for feedback
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Sanitize and collect input
    $username = trim(htmlspecialchars($_POST['username']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // 2. Professional Validation
    if (empty($username) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters long.";
    } else {
        // 3. Secure Password Hashing
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Success message (In a real app, you'd insert $hashed_password into your DB here)
        $success = "Account created successfully for " . $username . "!";
        
        // Clear fields on success
        $username = $email = "";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Horizontal Registration</title>
    <style>
        :root { 
            --primary: #2563eb; 
            --primary-hover: #1d4ed8;
            --error: #dc2626; 
            --success: #16a34a; 
            --bg: #f8fafc;
            --border: #cbd5e1;
        }

        body { 
            font-family: 'Inter', system-ui, -apple-system, sans-serif; 
            background: var(--bg); 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
            margin: 0; 
            padding: 20px;
        }

        .card { 
            background: white; 
            padding: 2rem; 
            border-radius: 1rem; 
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); 
            width: 100%; 
            max-width: 1000px; 
            border: 1px solid #e2e8f0; 
        }

        h2 { margin-top: 0; margin-bottom: 0.5rem; color: #1e293b; }
        .subtitle { color: #64748b; margin-bottom: 2rem; font-size: 0.95rem; }

        /* The Horizontal Form Layout */
        .registration-form { 
            display: flex; 
            flex-wrap: wrap; 
            gap: 1.5rem; 
            align-items: flex-end; 
        }
        
        .input-group { 
            flex: 1; 
            min-width: 220px; 
        }

        label { 
            display: block; 
            font-size: 0.85rem; 
            font-weight: 600; 
            margin-bottom: 0.5rem; 
            color: #475569;
        }

        input { 
            width: 100%; 
            padding: 0.75rem; 
            border: 1px solid var(--border); 
            border-radius: 0.5rem; 
            box-sizing: border-box; 
            font-size: 1rem;
            transition: all 0.2s;
        }

        input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        button { 
            flex: 0 0 auto; 
            background: var(--primary); 
            color: white; 
            border: none; 
            padding: 0.75rem 2rem; 
            border-radius: 0.5rem; 
            font-weight: 600; 
            cursor: pointer; 
            height: 48px; /* Perfectly aligns with input height */
            transition: background 0.2s;
        }
        
        button:hover { background: var(--primary-hover); }

        /* Feedback Messages */
        .msg { width: 100%; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; font-size: 0.9rem; }
        .error { background: #fee2e2; color: var(--error); border: 1px solid #fecaca; }
        .success { background: #dcfce7; color: var(--success); border: 1px solid #bbf7d0; }

        /* Responsive adjustment: Stack vertically on small mobile screens */
        @media (max-width: 600px) {
            .registration-form { flex-direction: column; align-items: stretch; }
            button { width: 100%; }
        }
    </style>
</head>
<body>

<div class="card">
    <h2>Join the Platform</h2>
    <p class="subtitle">Enter your details to create a professional account.</p>
    
    <?php if($error): ?>
        <div class="msg error"><strong>Error:</strong> <?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if($success): ?>
        <div class="msg success"><strong>Success!</strong> <?php echo $success; ?></div>
    <?php endif; ?>

    <form class="registration-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="input-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?php echo isset($username) ? $username : ''; ?>" placeholder="JohnDoe123" required>
        </div>

        <div class="input-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>" placeholder="john@example.com" required>
        </div>

        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Min. 8 characters" required>
        </div>

        <button type="submit">Create Account</button>
    </form>
</div>

</body>
</html>