<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h1>Forgot Password</h1>

    <form action="components/send-password-reset.php" method="post">
        <div>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
        </div>
    <button>Send</button>
    </form>
</body>
</html>