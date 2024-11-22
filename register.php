<?php
   require_once 'config/db.php';

   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       $username = trim($_POST['username']);
       $password = trim($_POST['password']);
       $confirmPassword = trim($_POST['confirm_password']);

       if ($password !== $confirmPassword) {
           $error = "Passwords do not match!";
       } elseif (strlen($password) < 6) {
           $error = "Password must be at least 6 characters!";
       } else {
           // Hash the password
           $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

           // Insert into the database
           $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
           try {
               $stmt->execute([':username' => $username, ':password' => $hashedPassword]);
               $success = "Registration successful! You can now <a href='login.php'>login</a>.";
           } catch (PDOException $e) {
               if ($e->errorInfo[1] == 1062) {
                   $error = "Username already exists!";
               } else {
                   $error = "An error occurred. Please try again.";
               }
           }
       }
   }
   ?>
   <!DOCTYPE html>
   <html lang="en">
   <head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <title>Register</title>
       <link rel="stylesheet" href="assets/css/styles.css">
   </head>
   <body>
   <div class="container mt-5">
       <h1 class="text-center">Register</h1>
       <form method="POST" class="mt-4">
           <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
           <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
           <div class="mb-3">
               <label for="username" class="form-label">Username</label>
               <input type="text" name="username" id="username" class="form-control" required>
           </div>
           <div class="mb-3">
               <label for="password" class="form-label">Password</label>
               <input type="password" name="password" id="password" class="form-control" required>
           </div>
           <div class="mb-3">
               <label for="confirm_password" class="form-label">Confirm Password</label>
               <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
           </div>
           <button type="submit" class="btn btn-primary">Register</button>
           <p class="mt-3">Already have an account? <a href="login.php">Login here</a>.</p>
       </form>
   </div>
   </body>
   </html>