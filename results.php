<?php
session_start();

// Check if user has taken the test
if (!isset($_SESSION['answers']) || empty($_SESSION['answers'])) {
    header('Location: index.php');
    exit();
}

// Questions array (same as quiz.php)
$questions = [
    [
        'id' => 1,
        'question' => 'What comes next in the pattern: 2, 4, 8, 16, ?',
        'options' => ['24', '32', '64', '128'],
        'correct' => 1,
        'category' => 'Logical'
    ],
    [
        'id' => 2,
        'question' => 'If all roses are flowers and some flowers fade quickly, which statement must be true?',
        'options' => [
            'All roses fade quickly',
            'Some roses fade quickly', 
            'No roses fade quickly',
            'Some flowers that fade quickly are roses'
        ],
        'correct' => 3,
        'category' => 'Logical'
    ],
    [
        'id' => 3,
        'question' => 'What is 25% of 200 plus 1/3 of 120?',
        'options' => ['50', '70', '90', '110'],
        'correct' => 2,
        'category' => 'Numerical'
    ],
    [
        'id' => 4,
        'question' => 'What comes next: △, □, ○, △, □, ?',
        'options' => ['△', '□', '○', '◊'],
        'correct' => 2,
        'category' => 'Pattern'
    ],
    [
        'id' => 5,
        'question' => 'If 3 people can paint 3 fences in 3 hours, how many fences can 6 people paint in 6 hours?',
        'options' => ['6', '9', '12', '18'],
        'correct' => 2,
        'category' => 'Numerical'
    ],
    [
        'id' => 6,
        'question' => 'Which number does not belong: 2, 3, 6, 7, 8, 14, 15, 30',
        'options' => ['3', '8', '15', '30'],
        'correct' => 1,
        'category' => 'Pattern'
    ],
    [
        'id' => 7,
        'question' => 'A clock shows 3:15. What is the angle between the hour and minute hands?',
        'options' => ['0°', '7.5°', '15°', '30°'],
        'correct' => 1,
        'category' => 'Numerical'
    ],
    [
        'id' => 8,
        'question' => 'If you rearrange the letters "CIFAIPC", you would get the name of a:',
        'options' => ['City', 'Animal', 'Ocean', 'Country'],
        'correct' => 2,
        'category' => 'Verbal'
    ],
    [
        'id' => 9,
        'question' => 'Complete the pattern: A1, B2, C3, D4, ?',
        'options' => ['E4', 'E5', 'F5', 'D5'],
        'correct' => 1,
        'category' => 'Pattern'
    ],
    [
        'id' => 10,
        'question' => 'If today is Monday, what day is 72 hours from now?',
        'options' => ['Monday', 'Tuesday', 'Thursday', 'Friday'],
        'correct' => 2,
        'category' => 'Logical'
    ]
];

// Calculate score
$score = 0;
$total_questions = count($questions);
$category_scores = [
    'Logical' => ['correct' => 0, 'total' => 0],
    'Numerical' => ['correct' => 0, 'total' => 0],
    'Pattern' => ['correct' => 0, 'total' => 0],
    'Verbal' => ['correct' => 0, 'total' => 0]
];

foreach ($questions as $index => $question) {
    $category = $question['category'];
    $category_scores[$category]['total']++;
    
    if (isset($_SESSION['answers'][$index]) && $_SESSION['answers'][$index] == $question['correct']) {
        $score++;
        $category_scores[$category]['correct']++;
    }
}

// Calculate IQ score
$percentage = ($score / $total_questions) * 100;
$iq_score = 100 + (($percentage - 50) / 10) * 15;
$iq_score = round($iq_score);
$iq_score = max(70, min($iq_score, 130)); // Between 70-130

// Determine IQ category
if ($iq_score >= 130) {
    $iq_category = "Very Superior";
    $feedback = "Exceptional cognitive abilities! You have excellent logical reasoning and problem-solving skills.";
} elseif ($iq_score >= 120) {
    $iq_category = "Superior";
    $feedback = "Outstanding performance! You have strong analytical abilities and good pattern recognition.";
} elseif ($iq_score >= 110) {
    $iq_category = "High Average";
    $feedback = "Above average cognitive abilities. You demonstrate good logical thinking.";
} elseif ($iq_score >= 90) {
    $iq_category = "Average";
    $feedback = "Average cognitive abilities. With practice, you can improve your scores.";
} else {
    $iq_category = "Below Average";
    $feedback = "You may benefit from practicing reasoning exercises and puzzles.";
}

// Add time factor
$time_spent = time() - $_SESSION['start_time'];
if ($time_spent < 600) {
    $feedback .= " You completed the test quickly, showing good processing speed.";
} elseif ($time_spent > 1200) {
    $feedback .= " Consider practicing to improve your processing speed.";
}

// Clear session for new test
$session_data = $_SESSION;
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IQ Test Results</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .results-container {
            max-width: 800px;
            width: 100%;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Header */
        .results-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }

        .results-header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .results-header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* Score Display */
        .score-display {
            text-align: center;
            padding: 40px;
            background: #f8f9ff;
        }

        .iq-score {
            font-size: 5rem;
            font-weight: 800;
            color: #667eea;
            margin-bottom: 10px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .iq-category {
            font-size: 1.8rem;
            color: #764ba2;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .score-details {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 20px;
        }

        /* Results Info */
        .results-info {
            padding: 40px;
        }

        .result-section {
            margin-bottom: 30px;
        }

        .result-section h3 {
            color: #667eea;
            margin-bottom: 20px;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .result-section h3 i {
            font-size: 1.5rem;
        }

        .result-section p {
            line-height: 1.6;
            color: #555;
            margin-bottom: 15px;
        }

        /* Category Breakdown */
        .category-breakdown {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .category-box {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.08);
            border: 1px solid #e0e7ff;
            text-align: center;
        }

        .category-name {
            color: #667eea;
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 1.1rem;
        }

        .category-score {
            font-size: 1.8rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .category-percentage {
            color: #666;
            font-size: 0.9rem;
        }

        /* Progress bar */
        .progress-container {
            height: 8px;
            background: #e0e7ff;
            border-radius: 4px;
            margin-top: 10px;
            overflow: hidden;
        }

        .category-progress {
            height: 100%;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 4px;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 20px;
            padding: 30px 40px;
            background: #f8f9ff;
            border-top: 1px solid #e0e7ff;
        }

        .action-btn {
            flex: 1;
            padding: 18px 30px;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-retake {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .btn-retake:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-home {
            background: white;
            color: #667eea;
            border: 2px solid #e0e7ff;
        }

        .btn-home:hover {
            background: #667eea;
            color: white;
            transform: translateY(-3px);
        }

        /* Footer */
        .results-footer {
            text-align: center;
            padding: 30px;
            color: #666;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .results-header {
                padding: 30px 20px;
            }
            
            .score-display {
                padding: 30px 20px;
            }
            
            .iq-score {
                font-size: 4rem;
            }
            
            .results-info {
                padding: 30px 20px;
            }
            
            .category-breakdown {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .action-buttons {
                flex-direction: column;
                padding: 30px 20px;
            }
            
            .action-btn {
                width: 100%;
            }
        }

        /* Confetti for high scores */
        .confetti {
            position: fixed;
            width: 10px;
            height: 10px;
            background: #667eea;
            border-radius: 50%;
            z-index: 1000;
            pointer-events: none;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="results-container">
        <div class="results-header">
            <h1><i class="fas fa-medal"></i> Your IQ Test Results</h1>
            <p>Test completed on <?php echo date('F j, Y'); ?></p>
        </div>

        <div class="score-display">
            <div class="iq-score"><?php echo $iq_score; ?></div>
            <div class="iq-category"><?php echo $iq_category; ?> Intelligence</div>
            <div class="score-details">
                You answered <strong><?php echo $score; ?> out of <?php echo $total_questions; ?></strong> questions correctly
                (<?php echo round($percentage, 1); ?>%)
            </div>
            <div style="color: #888; font-size: 1rem;">
                Time taken: <?php echo floor($time_spent / 60); ?> minutes <?php echo $time_spent % 60; ?> seconds
            </div>
        </div>

        <div class="results-info">
            <div class="result-section">
                <h3><i class="fas fa-comment-medical"></i> Assessment</h3>
                <p><?php echo $feedback; ?></p>
            </div>

            <div class="result-section">
                <h3><i class="fas fa-chart-bar"></i> Category Performance</h3>
                <div class="category-breakdown">
                    <?php foreach ($category_scores as $category => $data): 
                        if ($data['total'] > 0):
                            $cat_percentage = round(($data['correct'] / $data['total']) * 100, 1);
                    ?>
                    <div class="category-box">
                        <div class="category-name"><?php echo $category; ?></div>
                        <div class="category-score"><?php echo $data['correct']; ?>/<?php echo $data['total']; ?></div>
                        <div class="category-percentage"><?php echo $cat_percentage; ?>% correct</div>
                        <div class="progress-container">
                            <div class="category-progress" style="width: <?php echo $cat_percentage; ?>%"></div>
                        </div>
                    </div>
                    <?php endif; endforeach; ?>
                </div>
            </div>

            <div class="result-section">
                <h3><i class="fas fa-lightbulb"></i> Recommendations</h3>
                <ul style="padding-left: 20px; color: #555; line-height: 1.8;">
                    <li>Practice logical reasoning puzzles regularly</li>
                    <li>Try brain training apps to improve cognitive skills</li>
                    <li>Solve mathematical problems to enhance numerical ability</li>
                    <li>Take this test again in 1-2 months to track improvement</li>
                    <li>Challenge yourself with different types of puzzles</li>
                </ul>
            </div>
        </div>

        <div class="action-buttons">
            <button class="action-btn btn-retake" onclick="retakeTest()">
                <i class="fas fa-redo"></i> Retake Test
            </button>
            <button class="action-btn btn-home" onclick="goHome()">
                <i class="fas fa-home"></i> Back to Home
            </button>
        </div>

        <div class="results-footer">
            <p><strong>Note:</strong> This test provides an estimate of cognitive abilities.</p>
            <p>Results are for educational purposes only.</p>
        </div>
    </div>

    <script>
        function retakeTest() {
            if (confirm('Start a new IQ test?')) {
                window.location.href = 'index.php';
            }
        }

        function goHome() {
            window.location.href = 'index.php';
        }

        // Create confetti for high scores
        <?php if ($iq_score >= 120): ?>
        document.addEventListener('DOMContentLoaded', function() {
            createConfetti();
        });

        function createConfetti() {
            const colors = ['#667eea', '#764ba2', '#10b981', '#f59e0b'];
            
            for (let i = 0; i < 100; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti';
                confetti.style.left = Math.random() * 100 + 'vw';
                confetti.style.top = '-10px';
                confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.width = Math.random() * 10 + 5 + 'px';
                confetti.style.height = confetti.style.width;
                document.body.appendChild(confetti);
                
                // Animate
                const animation = confetti.animate([
                    { transform: 'translateY(0) rotate(0deg)', opacity: 1 },
                    { transform: `translateY(${window.innerHeight + 20}px) rotate(${Math.random() * 360}deg)`, opacity: 0 }
                ], {
                    duration: Math.random() * 3000 + 2000,
                    easing: 'cubic-bezier(0.215, 0.610, 0.355, 1)'
                });
                
                animation.onfinish = () => confetti.remove();
            }
        }
        <?php endif; ?>
    </script>
</body>
</html>
