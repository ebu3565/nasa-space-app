<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Urban Planner - Climate Resilience & SDG 11</title>
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
            background-color: #f8f9fa;
        }
        
        .hero {
            min-height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%D&auto=format&fit=crop&w=1813&q=80') no-repeat center center/cover;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 2rem;
            color: #fff;
        }
        
        .hero-content {
            max-width: 900px;
            margin-top: 2rem;
        }
        
        h1 {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        
        .hero p {
            font-size: 1.4rem;
            margin-bottom: 2.5rem;
            max-width: 800px;
        }
        
        .btn {
            display: inline-block;
            background: #4CAF50;
            color: white;
            padding: 1.2rem 2.5rem;
            font-size: 1.2rem;
            font-weight: 600;
            text-decoration: none;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            border: 2px solid #3e8e41;
            cursor: pointer;
        }
        
        .btn:hover {
            background: #3e8e41;
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3);
        }
        
        .btn:active {
            transform: translateY(0);
        }
        
        .info-section {
            padding: 5rem 2rem;
            background: #f8f9fa;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .section-title {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            color: #2c3e50;
        }
        
        /* About Section */
        .about {
            padding: 5rem 2rem;
            background: white;
        }
        
        .about-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
        }
        
        .about-img {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .about-img img {
            width: 100%;
            height: auto;
            display: block;
        }
        
        /* Learn Section */
        .learn {
            padding: 5rem 2rem;
            background: #e8f5e9;
        }
        
        .resources {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        .resource-card {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .resource-card h3 {
            color: #2c3e50;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }
        
        .resource-card ul {
            list-style: none;
            margin-top: 1rem;
        }
        
        .resource-card li {
            margin-bottom: 0.5rem;
            padding-left: 1.5rem;
            position: relative;
        }
        
        .resource-card li:before {
            content: "•";
            color: #4CAF50;
            font-weight: bold;
            position: absolute;
            left: 0;
        }
        
        /* SDG 11 Section */
        .sdg-section {
            padding: 5rem 2rem;
            background: white;
        }
        
        .sdg-header {
            text-align: center;
            padding: 40px 20px;
            background: linear-gradient(135deg, #2ecc71 0%, #3498db 100%);
            color: white;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .sdg-header h1 {
            font-size: 2.8rem;
            margin-bottom: 15px;
            text-shadow: none;
        }
        
        .sdg-header p {
            font-size: 1.2rem;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .sdg-icon {
            font-size: 3.5rem;
            margin-bottom: 20px;
            color: #fff;
            background-color: #e74c3c;
            width: 100px;
            height: 100px;
            line-height: 100px;
            border-radius: 50%;
            display: inline-block;
        }
        
        .sections-container {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            margin-bottom: 40px;
        }
        
        .section {
            flex: 1;
            min-width: 300px;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .section:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        }
        
        .section-header {
            padding: 25px 20px;
            color: white;
            text-align: center;
        }
        
        .section-content {
            padding: 25px;
        }
        
        .section-content h3 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-size: 1.5rem;
        }
        
        .section-content p {
            margin-bottom: 20px;
            color: #555;
        }
        
        .section-content ul {
            list-style-type: none;
            padding-left: 5px;
        }
        
        .section-content li {
            margin-bottom: 12px;
            padding-left: 25px;
            position: relative;
        }
        
        .section-content li:before {
            content: "•";
            color: #2ecc71;
            font-weight: bold;
            position: absolute;
            left: 0;
            font-size: 1.4rem;
        }
        
        .stats {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 20px;
        }
        
        .stat-box {
            flex: 1;
            min-width: 120px;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            border-left: 4px solid #3498db;
        }
        
        .stat-number {
            font-size: 1.8rem;
            font-weight: bold;
            color: #2c3e50;
        }
        
        .stat-label {
            font-size: 0.9rem;
            color: #7f8c8d;
        }
        
        #goals .section-header {
            background: #3498db;
        }
        
        #importance .section-header {
            background: #2ecc71;
        }
        
        #action .section-header {
            background: #e74c3c;
        }
        
        .action-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .action-card {
            flex: 1;
            min-width: 200px;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            transition: transform 0.2s ease;
        }
        
        .action-card:hover {
            transform: scale(1.03);
        }
        
        .action-card i {
            font-size: 2.5rem;
            color: #e74c3c;
            margin-bottom: 15px;
        }
        
        .action-card h4 {
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        /* Gamification Section - Redesigned */
        .gamification {
            padding: 5rem 2rem;
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(61, 51, 51, 0.8)), url('../image/new folder/back.jpg') no-repeat center center/cover;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .game-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
            z-index: 2;
        }
        
        .game-content {
            max-width: 800px;
            margin-bottom: 3rem;
        }
        
        .game-content h2 {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        
        .game-content p {
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
            line-height: 1.8;
        }
        
        .game-preview-container {
            position: relative;
            width: 75%;
            max-width: 800px;
            margin: 0 auto;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4);
            transition: transform 0.5s ease;
        }
        
        .game-preview-container:hover {
            transform: scale(1.02);
        }
        
        .game-preview {
            width: 100%;
            height: 400px;
            background: url('../image/new folder/Untitled design.jpg') no-repeat center center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }
        
        .game-preview::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            transition: background 0.3s ease;
        }
        
        .game-preview-container:hover .game-preview::before {
            background: rgba(0, 0, 0, 0.2);
        }
        
        .play-btn {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            border: none;
            padding: 1.2rem 2.5rem;
            font-size: 1.3rem;
            font-weight: 600;
            border-radius: 50px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 2;
        }
        
        .play-btn:hover {
            background: linear-gradient(135deg, #c0392b, #a53125);
            transform: scale(1.1);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
        }
        
        .play-btn i {
            font-size: 1.5rem;
        }
        
        
        @media (max-width: 768px) {
            h1 {
                font-size: 2.5rem;
            }
            
            .hero p {
                font-size: 1.1rem;
            }
            
            .btn {
                padding: 1rem 2rem;
                font-size: 1.1rem;
            }
            
            .about-content {
                grid-template-columns: 1fr;
            }
            
            .section-title {
                font-size: 2.2rem;
            }
            
            .sections-container {
                flex-direction: column;
            }
            
            .sdg-header h1 {
                font-size: 2.2rem;
            }
            
            .sdg-icon {
                width: 80px;
                height: 80px;
                line-height: 80px;
                font-size: 2.8rem;
            }
            
            .game-content h2 {
                font-size: 2.2rem;
            }
            
            .game-content p {
                font-size: 1.1rem;
            }
            
            .game-preview-container {
                width: 90%;
            }
            
            .game-preview {
                height: 300px;
            }
        }
    </style>
</head>
<body>
    <!-- Include Navigation Bar -->
    <?php include 'essentials/navbar.php'; ?>
    
    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-content">
            <h1>Urban Planning for Climate Resilience</h1>
            <p>Climate change brings new complexities to maintaining the wellbeing of society and the environment in cities. Natural resources, ecosystems, and existing infrastructure must be monitored to ensure human quality of life remains high.</p>
            <button class="btn">Urban Planner</button>
        </div>
    </section>

    <!-- SDG 11 Section -->
    <section class="sdg-section" id="sdg">
        <div class="container">
            <div class="sdg-header">
                <div class="sdg-icon">11</div>
                <h1>Sustainable Development Goal 11</h1>
                <p>Make cities and human settlements inclusive, safe, resilient, and sustainable</p>
            </div>
            
            <div class="sections-container">
                <section id="goals" class="section">
                    <div class="section-header">
                        <h2><i class="fas fa-bullseye"></i> Goals & Targets</h2>
                    </div>
                    <div class="section-content">
                        <h3>Primary Objectives</h3>
                        <p>SDG 11 aims to create sustainable cities and communities that provide opportunities for all, with access to basic services, energy, housing, transportation and more.</p>
                        
                        <ul>
                            <li>Ensure access for all to adequate, safe and affordable housing</li>
                            <li>Provide access to safe, affordable, accessible and sustainable transport systems</li>
                            <li>Enhance inclusive and sustainable urbanization</li>
                            <li>Protect and safeguard the world's cultural and natural heritage</li>
                            <li>Reduce the adverse per capita environmental impact of cities</li>
                            <li>Support least developed countries in building sustainable buildings</li>
                        </ul>
                        
                        <div class="stats">
                            <div class="stat-box">
                                <div class="stat-number">3.5B</div>
                                <div class="stat-label">People in cities by 2050</div>
                            </div>
                            <div class="stat-box">
                                <div class="stat-number">30%</div>
                                <div class="stat-label">Urban population in slums</div>
                            </div>
                        </div>
                    </div>
                </section>
                
                <section id="importance" class="section">
                    <div class="section-header">
                        <h2><i class="fas fa-question-circle"></i> Why It Matters</h2>
                    </div>
                    <div class="section-content">
                        <h3>The Importance of Sustainable Cities</h3>
                        <p>Cities are hubs for ideas, commerce, culture, science, productivity, social development and much more. At their best, cities have enabled people to advance socially and economically.</p>
                        
                        <p>However, many challenges exist to maintaining cities in a way that continues to create jobs and prosperity without straining land and resources.</p>
                        
                        <h3>Key Challenges</h3>
                        <ul>
                            <li>Congestion and lack of funds for basic services</li>
                            <li>Shortage of adequate housing and declining infrastructure</li>
                            <li>Increasing air pollution and environmental deterioration</li>
                            <li>Unplanned urban sprawl and increased crime rates</li>
                            <li>Vulnerability to disasters and climate change impacts</li>
                        </ul>
                    </div>
                </section>
                
                <section id="action" class="section">
                    <div class="section-header">
                        <h2><i class="fas fa-hands-helping"></i> Taking Action</h2>
                    </div>
                    <div class="section-content">
                        <h3>How You Can Contribute</h3>
                        <p>Creating sustainable cities requires collective action from governments, businesses, communities, and individuals.</p>
                        
                        <div class="action-cards">
                            <div class="action-card">
                                <i class="fas fa-bicycle"></i>
                                <h4>Use Sustainable Transport</h4>
                                <p>Walk, cycle, or use public transportation whenever possible</p>
                            </div>
                            <div class="action-card">
                                <i class="fas fa-recycle"></i>
                                <h4>Reduce Waste</h4>
                                <p>Recycle, compost, and minimize single-use plastics</p>
                            </div>
                            <div class="action-card">
                                <i class="fas fa-tree"></i>
                                <h4>Support Green Spaces</h4>
                                <p>Advocate for and help maintain parks and green areas</p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>

    <!-- Gamification Section - Redesigned -->
    <section class="gamification" id="game">
        <div class="container">
            <div class="game-container">
                <div class="game-content">
                    <h2>Build Your Sustainable City</h2>
                    <p>Test your urban planning skills in our interactive game! Make decisions about transportation, green spaces, housing, and energy to create a climate-resilient city.</p>
                    <p>Learn about sustainable development while having fun. Each choice you make affects your city's environmental impact, economic growth, and citizen happiness.</p>
                </div>
                
                <div class="game-preview-container">
                    <div class="game-preview">
                        <button class="play-btn" onclick="window.location.href='../game2.html'">
                            <i class="fas fa-play"></i> Play Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <div class="container">
            <h2 class="section-title">About Urban Planning</h2>
            
            <div class="about-content">
                <div class="about-text">
                    <p>Urban planning is a technical and political process concerned with the development and design of land use and the built environment, including air, water, and the infrastructure passing into and out of urban areas, such as transportation, communications, and distribution networks.</p>
                    <p>With the growing threat of climate change, urban planners now face the additional challenge of creating sustainable, resilient cities that can withstand environmental changes while maintaining high quality of life for residents.</p>
                    <p>Modern urban planning requires interdisciplinary collaboration between government officials, environmental scientists, engineers, architects, and community stakeholders to create effective solutions.</p>
                </div>
                
                <div class="about-img">
                    <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80" alt="Urban Planning">
                </div>
            </div>
        </div>
    </section>
    
    <!-- Learn Section -->
    <section class="learn" id="learn">
        <div class="container">
            <h2 class="section-title">Learn More</h2>
            
            <div class="resources">
                <div class="resource-card">
                    <h3>Educational Resources</h3>
                    <p>Expand your knowledge about sustainable urban planning and climate resilience with these resources:</p>
                    <ul>
                        <li>Introduction to Urban Climate Adaptation</li>
                        <li>Sustainable Infrastructure Design</li>
                        <li>Green Space Planning Strategies</li>
                        <li>Community Engagement Methods</li>
                        <li>Climate Data Analysis for Planners</li>
                    </ul>
                </div>
                
                <div class="resource-card">
                    <h3>Tools & Technologies</h3>
                    <p>Modern urban planners use various tools to create sustainable cities:</p>
                    <ul>
                        <li>Geographic Information Systems (GIS)</li>
                        <li>Climate Modeling Software</li>
                        <li>Urban Simulation Platforms</li>
                        <li>Remote Sensing Technologies</li>
                        <li>Community Feedback Systems</li>
                    </ul>
                </div>
                
                <div class="resource-card">
                    <h3>Case Studies</h3>
                    <p>Learn from cities that have successfully implemented climate-resilient planning:</p>
                    <ul>
                        <li>Copenhagen's Flood Prevention</li>
                        <li>Singapore's Vertical Greening</li>
                        <li>Portland's Urban Growth Boundary</li>
                        <li>Curitiba's Bus Rapid Transit System</li>
                        <li>Amsterdam's Circular Economy</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
<?php include 'essentials/footer.php'; ?>

    <script>
        // Simple animation for the button
        const btn = document.querySelector('.btn');
        
        btn.addEventListener('mouseover', () => {
            btn.textContent = 'Explore Solutions';
        });
        
        btn.addEventListener('mouseout', () => {
            btn.textContent = 'Urban Planner';
        });
        
        btn.addEventListener('click', () => {
            // Redirect to map.php when clicked
            window.location.href = 'map.php';
        });
    </script>
</body>
</html>