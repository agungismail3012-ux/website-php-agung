<?php
session_start();
include 'koneksi.php';

// Jika admin sudah login sebelumnya, langsung lempar ke dashboard
if(isset($_SESSION['login'])) {
    header("Location: dashboard.php");
    exit;
}

if(isset($_POST['masuk'])) {
    $username = $_POST['username'];
    // Mengubah input password menjadi MD5 agar cocok dengan data di database
    $password = md5($_POST['password']); 

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' AND password = '$password'");
    
    if(mysqli_num_rows($result) === 1) {
        // Set session tanda sukses login
        $_SESSION['login'] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = true;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Panel Admin</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: #0B0F19; color: #E2E8F0; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .login-box { background: #1E293B; padding: 30px; border-radius: 12px; width: 350px; box-shadow: 0 20px 40px rgba(0,0,0,0.3); }
        h2 { text-align: center; margin-bottom: 20px; color: #FFF; font-size: 1.2rem; }
        input { width: 100%; background: #0B0F19; border: 1px solid rgba(255,255,255,0.1); padding: 11px; margin-bottom: 15px; border-radius: 6px; color: #FFF; }
        button { width: 100%; background: #38BDF8; color: #0B0F19; padding: 11px; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; }
        .error-msg { color: #EF4444; font-size: 0.85rem; text-align: center; margin-bottom: 15px; }
    </style>
</head>
<body>

<div class="login-box">
    <h2>🔒 Panel Akses Admin</h2>
    <?php if(isset($error)) { echo "<div class='error-msg'>Username atau Password salah!</div>"; } ?>
    <form action="" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="masuk">Log In</button>
    </form>
</div>

</body>
</html>