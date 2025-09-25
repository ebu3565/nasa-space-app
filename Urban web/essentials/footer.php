<!-- footer.php -->
<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-content">
            <div class="footer-section">
                <h3>UrbanClimate Initiative</h3>
                <p>Creating sustainable, resilient cities for tomorrow through innovative urban planning and climate adaptation strategies.</p>
                <div class="social-links">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#sdg">SDG 11</a></li>
                    <li><a href="#game">Interactive Game</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#learn">Resources</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h4>Resources</h4>
                <ul>
                    <li><a href="#">Case Studies</a></li>
                    <li><a href="#">Research Papers</a></li>
                    <li><a href="#">Planning Tools</a></li>
                    <li><a href="#">Climate Data</a></li>
                    <li><a href="#">Policy Guidelines</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h4>Contact Us</h4>
                <div class="contact-info">
                    <p><i class="fas fa-envelope"></i> info@urbanclimate.org</p>
                    <p><i class="fas fa-phone"></i> +1 (555) 123-4567</p>
                    <p><i class="fas fa-map-marker-alt"></i> 123 Sustainability St, Green City</p>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <p>&copy; 2023 UrbanClimate Initiative. All rights reserved.</p>
                <div class="footer-links">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                    <a href="#">Sitemap</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    .site-footer {
        background: linear-gradient(135deg, #1a252f 0%, #2c3e50 100%);
        color: #ecf0f1;
        padding: 3rem 0 0;
        margin-top: 2rem;
    }
    
    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
    }
    
    .footer-content {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2.5rem;
        margin-bottom: 2rem;
    }
    
    .footer-section h3 {
        color: #2ecc71;
        font-size: 1.5rem;
        margin-bottom: 1.2rem;
        position: relative;
    }
    
    .footer-section h3::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -8px;
        width: 50px;
        height: 3px;
        background: #3498db;
        border-radius: 2px;
    }
    
    .footer-section h4 {
        color: #3498db;
        font-size: 1.2rem;
        margin-bottom: 1.2rem;
        position: relative;
    }
    
    .footer-section h4::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -8px;
        width: 40px;
        height: 2px;
        background: #2ecc71;
        border-radius: 2px;
    }
    
    .footer-section p {
        line-height: 1.6;
        margin-bottom: 1.5rem;
        color: #bdc3c7;
    }
    
    .footer-section ul {
        list-style: none;
    }
    
    .footer-section ul li {
        margin-bottom: 0.8rem;
    }
    
    .footer-section ul li a {
        color: #bdc3c7;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-block;
    }
    
    .footer-section ul li a:hover {
        color: #2ecc71;
        transform: translateX(5px);
    }
    
    .social-links {
        display: flex;
        gap: 1rem;
    }
    
    .social-links a {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: #34495e;
        border-radius: 50%;
        color: #ecf0f1;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .social-links a:hover {
        background: #2ecc71;
        transform: translateY(-3px);
    }
    
    .contact-info p {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        margin-bottom: 1rem;
    }
    
    .contact-info i {
        color: #3498db;
        width: 20px;
    }
    
    .footer-bottom {
        border-top: 1px solid #34495e;
        padding: 1.5rem 0;
    }
    
    .footer-bottom-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .footer-bottom p {
        color: #95a5a6;
        margin: 0;
    }
    
    .footer-links {
        display: flex;
        gap: 1.5rem;
    }
    
    .footer-links a {
        color: #95a5a6;
        text-decoration: none;
        transition: color 0.3s ease;
        font-size: 0.9rem;
    }
    
    .footer-links a:hover {
        color: #2ecc71;
    }
    
    @media (max-width: 768px) {
        .footer-content {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        
        .footer-bottom-content {
            flex-direction: column;
            text-align: center;
        }
        
        .footer-links {
            justify-content: center;
        }
    }
</style>