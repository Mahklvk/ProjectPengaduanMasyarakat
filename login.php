<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">k
        <!-- fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,500;0,700;1,300&display=swap" rel="stylesheet" />


    <!-- My Style -->
    <link rel="stylesheet" href="style.css" />

</head>
<body>
    <div class = "container">
    <div class="right-section">
            <img src="storages/loginUser.png" alt="image">
        </div>
        <div class="left-section">
            <h1>Selamat Datang</h1>
            <h2>Login</h2>
            <p>Selamat datang, tolong login ke akun anda</p>

            <form>
                <label for="username">Username</label>
                <input type="text" id="username" placeholder="example123">

                <label for="password">Password</label>
                <input type="password" id="password" placeholder="">
                <span class="toggle-password"></span>

                <div class="options">
                    <label>
                        <input type="checkbox"> Ingat Saya
                    </label>
                    <a href="#">Lupa Password?</a>
                </div>

                <button type="submit" class="login-button">Login</button>
            </form>

            <p>Pengguna Baru? <a href="#">Daftar</a></p>
        </div>
    </div>
</body>
</html>