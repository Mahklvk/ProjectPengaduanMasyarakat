<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyReport Footer</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Custom styles for the footer */
        .footer {
            background-color: #3E6EA2;
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
        
        .footer-logo img {
            height: 24px;
            margin-right: 8px;
        }
        
        .footer-logo span {
            font-size: 18px;
            font-weight: 600;
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
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
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
            gap: 15px;
        }
        
        .footer-icons a {
            color: white;
            font-size: 16px;
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
                    <i class="fas fa-bullhorn me-2"></i>
                    <span>MyReport</span>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="footer-icons">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fas fa-share-alt"></i></a>
                    <a href="#"><i class="fas fa-thumbs-down"></i></a>
                </div>
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
            © 2077 Kelompok 4. All rights reserved.
        </div>
    </div>
</footer>

<!-- Bootstrap JS (optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>