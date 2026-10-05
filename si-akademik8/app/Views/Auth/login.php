<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - SI Akademik</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f8;

            display: flex;
            justify-content: center;
            align-items: center;

            min-height: 100vh;
        }

        .login-container {
            width: 400px;
            background: white;
            padding: 35px;
            border-radius: 15px;

            box-shadow:
                0 5px 20px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-top: 0;
            margin-bottom: 25px;
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;

            border: 1px solid #ccc;
            border-radius: 8px;

            font-size: 15px;
        }

        input:focus {
            outline: none;
            border-color: #333;
        }

        button {
            width: 100%;
            padding: 12px;

            border: none;
            border-radius: 8px;

            background: #333;
            color: white;

            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #555;
        }

        .error {
            background: #f8d7da;
            color: #842029;

            padding: 12px;
            border-radius: 8px;

            margin-bottom: 20px;
        }

        .info {
            margin-top: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>

<body>

<div class="login-container">

    <h1>Login</h1>

    <?php if (isset($_SESSION['error'])): ?>

        <div class="error">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </div>

        <?php unset($_SESSION['error']); ?>

    <?php endif; ?>

    <form
        action="/si-akademik8/public/login"
        method="POST">

        <div class="form-group">

            <label for="username">
                Username
            </label>

            <input
                type="text"
                id="username"
                name="username"
                required>

        </div>

        <div class="form-group">

            <label for="password">
                Password
            </label>

            <input
                type="password"
                id="password"
                name="password"
                required>

        </div>

        <button type="submit">
            Login
        </button>

    </form>

    <div class="info">
        Username: admin<br>
        Password: 12345
    </div>

</div>

</body>
</html>