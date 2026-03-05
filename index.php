<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IQ Test - Measure Your Intelligence</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            width: 100%;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.8rem;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Dashboard */
        .dashboard {
            padding: 40px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-box {
            background: #f8f9ff;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            border: 1px solid #e0e7ff;
            transition: transform 0.3s ease;
        }

        .stat-box:hover {
            transform: translateY(-5px);
        }

        .stat-box i {
            font-size: 2.5rem;
            color: #667eea;
            margin-bottom: 15px;
        }

        .stat-box h3 {
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 5px;
        }

        .stat-box p {
            color: #666;
            font-size: 0.9rem;
        }

        /* Test Info */
        .test-info {
            background: #f8f9ff;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            border-left: 5px solid #667eea;
        }

        .test-info h2 {
            color: #667eea;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }

        .test-info ul {
            list-style: none;
            padding-left: 0;
        }

        .test-info li {
            padding: 10px 0;
            border-bottom: 1px solid #e0e7ff;
            display: flex;
            align-items: center;
            color: #555;
        }

        .test-info li:before {
            content: "✓";
            color: #667eea;
            font-weight: bold;
            margin-right: 10px;
        }

        /* Start Button */
        .start-container {
            text-align: center;
            padding: 20px 0;
        }

        .start-btn {
            display: inline-flex;
            align-items: center;
            gap: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 18px 50px;
            font-size: 1.3rem;
            font-weight: 600;
            text-decoration: none;
            border-radius: 50px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        .start-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.6);
        }

        .start-btn i {
            font-size: 1.5rem;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 30px;
            background: #f8f9ff;
            color: #666;
            border-top: 1px solid #e0e7ff;
        }

        .footer p {
            margin-bottom: 10px;
            line-height: 1.5;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header {
                padding: 30px 20px;
            }
            
            .header h1 {
                font-size: 2.2rem;
            }
            
            .dashboard {
                padding: 30px 20px;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .start-btn {
                padding: 16px 40px;
                font-size: 1.2rem;
                width: 100%;
                justify-content: center;
            }
        }

        /* Loading animation */
        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-brain"></i> IQ Test</h1>
            <p>Measure your cognitive abilities with our professional intelligence assessment. Get instant results and personalized feedback.</p>
        </div>

        <div class="dashboard">
            <div class="stats-grid">
                <div class="stat-box">
                    <i class="fas fa-clock pulse"></i>
                    <h3>15-20 Minutes</h3>
                    <p>Quick assessment</p>
                </div>
                <div class="stat-box">
                    <i class="fas fa-question-circle"></i>
                    <h3>10 Questions</h3>
                    <p>Comprehensive test</p>
                </div>
                <div class="stat-box">
                    <i class="fas fa-chart-line"></i>
                    <h3>Instant Results</h3>
                    <p>Get score immediately</p>
                </div>
                <div class="stat-box">
                    <i class="fas fa-user-graduate"></i>
                    <h3>Detailed Feedback</h3>
                    <p>Personalized analysis</p>
                </div>
            </div>

            <div class="test-info">
                <h2>Test Information</h2>
                <ul>
                    <li>10 carefully selected IQ questions</li>
                    <li>Covers logical, numerical, and pattern reasoning</li>
                    <li>No registration required</li>
                    <li>Your results are private and secure</li>
                    <li>Get your IQ score instantly</li>
                </ul>
            </div>

            <div class="start-container">
                <a href="quiz.php" class="start-btn">
                    <i class="fas fa-play-circle"></i> Start IQ Test Now
                </a>
            </div>
        </div>

        <div class="footer">
            <p><strong>Important:</strong> This test provides an estimate of cognitive abilities.</p>
            <p>For professional assessment, consult a certified psychologist.</p>
            <p style="margin-top: 20px; font-size: 0.9rem; color: #888;">© <?php echo date('Y'); ?> IQ Test Platform</p>
        </div>
    </div>

    <script>
        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            const statBoxes = document.querySelectorAll('.stat-box');
            statBoxes.forEach((box, index) => {
                box.style.animationDelay = `${index * 0.1}s`;
                box.style.animation = 'fadeIn 0.5s ease-out forwards';
                box.style.opacity = '0';
            });
            
            // Animate start button on hover
            const startBtn = document.querySelector('.start-btn');
            startBtn.addEventListener('mouseenter', function() {
                this.querySelector('i').style.transform = 'scale(1.2)';
                this.querySelector('i').style.transition = 'transform 0.3s ease';
            });
            
            startBtn.addEventListener('mouseleave', function() {
                this.querySelector('i').style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>
