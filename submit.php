<?php
$fullname = trim($_POST['fullname'] ?? '');
$email    = trim($_POST['email'] ?? '');
$phone    = trim($_POST['phone'] ?? '');

$host = getenv('DB_HOST') ?: '127.0.0.1';
$port = getenv('DB_PORT') ?: '5432';
$db   = getenv('DB_NAME') ?: 'registration_db';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';

$dsn = "pgsql:host=$host;port=$port;dbname=$db";

try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    $pdo->exec("
      CREATE TABLE IF NOT EXISTS registrations (
        id SERIAL PRIMARY KEY,
        fullname VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(50),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
      );
    ");

    $stmt = $pdo->prepare("INSERT INTO registrations (fullname, email, phone) VALUES (:f, :e, :p)");
    $stmt->execute([':f' => $fullname, ':e' => $email, ':p' => $phone]);

} catch (PDOException $e) {
    die("Database error: " . htmlspecialchars($e->getMessage()));
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Submitted</title>
<style>
body{
  font-family:Arial, sans-serif;
  margin:0;
  height:100vh;
  display:flex;
  justify-content:center;
  align-items:center;
  background:white;
}
.card{
  width:380px;
  padding:28px;
  border:1px solid #ccc;
  border-radius:10px;
  text-align:center;
}
h2{margin:0 0 10px 0;}
button{padding:10px 20px;margin-top:18px;cursor:pointer;border-radius:6px;border:1px solid #333;background:#fff;}
</style>
</head>
<body>
  <div class="card">
    <h2>✅ Registered Successfully</h2>
    <p>Your details have been saved.</p>

    <a href="index.html"><button>Back to Registration</button></a>
  </div>
</body>
</html>
