<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="style.css">
  <title>Registration Submitted</title>

  <style>
    .backBtn {
      display: inline-block;
      margin-top: 18px;
      padding: 10px;
      border: none;
      border-radius: 6px;
      background: #333;
      color: white;
      font-weight: bold;
      text-decoration: none;
      text-align: center;
      width: 100%;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Application Submitted</h1>

    <p><strong>Name:</strong> <?php echo $_POST["name"]; ?></p>
    <p><strong>Email:</strong> <?php echo $_POST["email"]; ?></p>
    <p><strong>Course:</strong> <?php echo $_POST["course"]; ?></p>

    <a class="backBtn" href="index.html">Back to Registration Form</a>
  </div>
</body>
</html>
