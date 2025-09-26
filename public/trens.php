<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>trens</title>
</head>
<body>
</body>
</html>


<?php 
//só apgar aqui
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); 
    exit;
}

