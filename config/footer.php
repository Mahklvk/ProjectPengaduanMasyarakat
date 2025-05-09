<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyReport Footer</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <style>
        .footer {
            background-color: #2c70b9;
            color: white;
            padding: 12px 0;
            width: 100%;
        }
        
        .footer-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }
        
        .footer-logo {
            display: flex;
            align-items: center;
        }
        
        .footer-logo img.logo-icon {
            height: 24px;
            margin-right: 8px;
        }
        
        .footer-logo img.logo-text {
            height: 20px;
        }
        
        .footer-nav {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        
        .footer-nav a {
            color: white;
            text-decoration: none;
            font-size: 14px;
            padding: 0 10px;
        }
        
        .footer-nav a:hover {
            text-decoration: underline;
        }
        
        .footer-button {
            background-color: transparent;
            color: white;
            border: 1px solid white;
            border-radius: 20px;
            padding: 5px 15px;
            font-size: 14px;
        }
        
        .footer-copyright {
            font-size: 12px;
            text-align: center;
            margin-top: 10px;
        }
        
        /* Icons styling */
        .footer-icons {
            display: flex;
            justify-content: center;
            gap: 45px;
            margin-bottom: 10px;
        }
        
        .footer-icons a {
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .footer-icons i {
            font-size: 1.2rem;
        }
        
        .divider {
            height: 1px;
            background-color: rgba(255, 255, 255, 0.3);
            margin: 10px 0;
            width: 100%;
        }
    </style>
</head>
<body>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-3">
                <div class="footer-logo">
                    <img src="storages/logo.png" alt="Logo" class="logo-icon">
                    <img src="storages/MyReport.png" alt="MyReport" class="logo-text">
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="footer-icons">
                    <a href="#"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-twitter"></i></a>
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-github"></i></a>
                </div>
                <div class="divider"></div>
                <div class="footer-nav mt-2">
                    <a href="#">Home</a>
                    <a href="#">About</a>
                    <a href="#">Contact</a>
                    <a href="#">Login</a>
                </div>
            </div>
            
            <div class="col-md-3 text-end">
                <button class="footer-button">Get Started</button>
            </div>
        </div>
        
        <div class="footer-copyright mt-2">
            © 20777 Kelompok 4.All rights reserved.
        </div>
    </div>
</footer>
</body>
</html>