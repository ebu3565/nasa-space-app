<?php
// Get the current page name for active state
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Urban Planner - Climate Resilience</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            color: #333;
            line-height: 1.6;
            overflow-x: hidden;
            padding-top: 70px; /* Offset for fixed navbar */
        }
        
        /* Navigation Bar */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: rgba(26, 37, 47, 0.95);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1001;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        
        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: #fff;
            display: flex;
            align-items: center;
            text-decoration: none;
        }
        
        .logo i {
            margin-right: 10px;
            color: #4CAF50;
        }
        
        .nav-links {
            display: flex;
            list-style: none;
        }
        
        .nav-links li {
            margin-left: 1.5rem;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: all 0.3s ease;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .nav-links a:hover, .nav-links a.active {
            background: #4CAF50;
            color: white;
        }
        
        .menu-toggle {
            display: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding-top: 60px;
            }
            
            .navbar {
                padding: 0.8rem 1.5rem;
            }
            
            .menu-toggle {
                display: block;
            }
            
            .nav-links {
                position: fixed;
                top: 60px;
                left: -100%;
                width: 100%;
                height: calc(100vh - 60px);
                background: #1a252f;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                transition: all 0.4s ease;
            }
            
            .nav-links.active {
                left: 0;
            }
            
            .nav-links li {
                margin: 1.5rem 0;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <a href="./homepage.php" class="logo">
            <i class="fas fa-seedling"></i>
            <span>Sustainable Planet</span>
        </a>
        
        <div class="menu-toggle" id="menu-toggle">
            <i class="fas fa-bars"></i>
        </div>
        
        <ul class="nav-links" id="nav-links">
            <li><a href="./homepage.php" class="<?php echo ($current_page == './homepage.php') ? 'active' : ''; ?>">Home</a></li>
            <li><a href="./map.php" class="<?php echo ($current_page == 'about.php') ? 'active' : ''; ?>">Urban Planner</a></li>
            <li><a href="../game2.html" class="<?php echo ($current_page == 'challenges.php') ? 'active' : ''; ?>">Play Game</a></li>
            <li><a href="floodforecast.php" class="<?php echo ($current_page == 'solutions.php') ? 'active' : ''; ?>">Flood Forecast</a></li>
            <li><a href="./login.php" class="active">Login</a></li>
        </ul>
    </nav>

    <script>
        // Mobile menu toggle
        const menuToggle = document.getElementById('menu-toggle');
        const navLinks = document.getElementById('nav-links');
        
        menuToggle.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });
        
        // Close mobile menu when clicking on a link
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                navLinks.classList.remove('active');
            });
        });
        
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 70,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>