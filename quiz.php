<?php
session_start();

// IQ Questions Array (10 questions)
$questions = [
    [
        'id' => 1,
        'question' => 'What comes next in the pattern: 2, 4, 8, 16, ?',
        'options' => ['24', '32', '64', '128'],
        'correct' => 1, // Index 1 = "32"
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

// Initialize session for new test
if (!isset($_SESSION['current_question'])) {
    $_SESSION['current_question'] = 0;
    $_SESSION['answers'] = [];
    $_SESSION['start_time'] = time();
    $_SESSION['questions'] = $questions;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Save answer
    if (isset($_POST['answer'])) {
        $_SESSION['answers'][$_SESSION['current_question']] = (int)$_POST['answer'];
    }
    
    // Handle navigation
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'next' && $_SESSION['current_question'] < count($questions) - 1) {
            $_SESSION['current_question']++;
        } elseif ($_POST['action'] === 'prev' && $_SESSION['current_question'] > 0) {
            $_SESSION['current_question']--;
        } elseif ($_POST['action'] === 'submit') {
            header('Location: results.php');
            exit();
        }
    }
    
    // Redirect to avoid form resubmission
    header('Location: quiz.php');
    exit();
}

$current_q = $_SESSION['current_question'];
$question = $questions[$current_q];
$total_questions = count($questions);
$progress = (($current_q + 1) / $total_questions) * 100;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IQ Test - Question <?php echo $current_q + 1; ?></title>
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

        .quiz-container {
            max-width: 800px;
            width: 100%;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }

        /* Progress Bar */
        .progress-bar {
            background: #e0e7ff;
            height: 8px;
            border-radius: 0;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 0;
            width: <?php echo $progress; ?>%;
            transition: width 0.3s ease;
        }

        /* Header */
        .quiz-header {
            padding: 25px 40px;
            background: #f8f9ff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e0e7ff;
        }

        .quiz-title {
            font-size: 1.5rem;
            color: #667eea;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .question-counter {
            background: #667eea;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
        }

        /* Question Area */
        .question-area {
            padding: 40px;
        }

        .question-number {
            color: #667eea;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .question-number:before {
            content: "Q";
            background: #667eea;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
        }

        .question-text {
            font-size: 1.4rem;
            color: #333;
            line-height: 1.5;
            margin-bottom: 30px;
            font-weight: 500;
        }

        /* Options */
        .options-container {
            display: grid;
            gap: 15px;
            margin-bottom: 40px;
        }

        .option {
            padding: 18px 20px;
            border: 2px solid #e0e7ff;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 15px;
            background: white;
        }

        .option:hover {
            border-color: #667eea;
            background: #f8f9ff;
            transform: translateX(5px);
        }

        .option.selected {
            border-color: #667eea;
            background: #f8f9ff;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.2);
        }

        .option-label {
            width: 40px;
            height: 40px;
            background: #e0e7ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #667eea;
            flex-shrink: 0;
        }

        .option.selected .option-label {
            background: #667eea;
            color: white;
        }

        .option-text {
            font-size: 1.1rem;
            color: #333;
        }

        /* Navigation */
        .navigation {
            display: flex;
            justify-content: space-between;
            gap: 15px;
        }

        .nav-btn {
            padding: 15px 30px;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-prev {
            background: #f8f9ff;
            color: #667eea;
            border: 2px solid #e0e7ff;
        }

        .btn-prev:hover:not(:disabled) {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .btn-next {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            margin-left: auto;
        }

        .btn-next:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-submit {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(16, 185, 129, 0.4);
        }

        .nav-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none !important;
        }

        /* Timer */
        .timer {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 1rem;
            background: #f8f9ff;
            border-top: 1px solid #e0e7ff;
        }

        .time-value {
            font-weight: 600;
            color: #667eea;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .quiz-header {
                padding: 20px;
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .question-area {
                padding: 30px 20px;
            }
            
            .question-text {
                font-size: 1.2rem;
            }
            
            .option {
                padding: 15px;
            }
            
            .navigation {
                flex-direction: column;
            }
            
            .nav-btn {
                width: 100%;
                justify-content: center;
            }
        }

        /* Animation */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .question-area {
            animation: slideIn 0.3s ease-out;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <form method="POST" id="quizForm">
        <div class="quiz-container">
            <div class="progress-bar">
                <div class="progress-fill"></div>
            </div>
            
            <div class="quiz-header">
                <div class="quiz-title">
                    <i class="fas fa-brain"></i>
                    <span>IQ Test</span>
                </div>
                <div class="question-counter">
                    Question <?php echo $current_q + 1; ?> of <?php echo $total_questions; ?>
                </div>
            </div>
            
            <div class="question-area">
                <div class="question-number">Question <?php echo $current_q + 1; ?></div>
                <div class="question-text"><?php echo htmlspecialchars($question['question']); ?></div>
                
                <div class="options-container">
                    <?php
                    $selected = $_SESSION['answers'][$current_q] ?? null;
                    $letters = ['A', 'B', 'C', 'D'];
                    
                    for ($i = 0; $i < 4; $i++):
                    ?>
                    <div class="option <?php echo $selected === $i ? 'selected' : ''; ?>" 
                         onclick="selectOption(<?php echo $i; ?>)">
                        <div class="option-label"><?php echo $letters[$i]; ?></div>
                        <div class="option-text"><?php echo htmlspecialchars($question['options'][$i]); ?></div>
                    </div>
                    <?php endfor; ?>
                </div>
                
                <input type="hidden" name="answer" id="selectedAnswer" value="<?php echo $selected; ?>">
                
                <div class="navigation">
                    <?php if ($current_q > 0): ?>
                    <button type="submit" name="action" value="prev" class="nav-btn btn-prev">
                        <i class="fas fa-arrow-left"></i> Previous
                    </button>
                    <?php else: ?>
                    <button type="button" class="nav-btn btn-prev" disabled>
                        <i class="fas fa-arrow-left"></i> Previous
                    </button>
                    <?php endif; ?>
                    
                    <?php if ($current_q < $total_questions - 1): ?>
                    <button type="submit" name="action" value="next" class="nav-btn btn-next" id="nextBtn" disabled>
                        Next <i class="fas fa-arrow-right"></i>
                    </button>
                    <?php else: ?>
                    <button type="submit" name="action" value="submit" class="nav-btn btn-submit" id="submitBtn" disabled>
                        Submit Test <i class="fas fa-check-circle"></i>
                    </button>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="timer">
                <i class="far fa-clock"></i> Time: <span class="time-value" id="timer">00:00</span>
            </div>
        </div>
    </form>

    <script>
        // Initialize
        window.onload = function() {
            // Enable next button if answer already selected
            const selectedAnswer = document.getElementById('selectedAnswer').value;
            if (selectedAnswer !== '') {
                document.getElementById('nextBtn')?.removeAttribute('disabled');
                document.getElementById('submitBtn')?.removeAttribute('disabled');
            }
            
            // Start timer
            startTimer();
        };

        // Select option function
        function selectOption(index) {
            // Update visual selection
            document.querySelectorAll('.option').forEach(opt => {
                opt.classList.remove('selected');
            });
            
            const selectedOption = document.querySelector(`.option:nth-child(${index + 1})`);
            if (selectedOption) {
                selectedOption.classList.add('selected');
            }
            
            // Update hidden input
            document.getElementById('selectedAnswer').value = index;
            
            // Enable buttons
            document.getElementById('nextBtn')?.removeAttribute('disabled');
            document.getElementById('submitBtn')?.removeAttribute('disabled');
        }

        // Timer function
        function startTimer() {
            let seconds = <?php echo time() - $_SESSION['start_time']; ?>;
            
            function updateTimer() {
                seconds++;
                const mins = Math.floor(seconds / 60);
                const secs = seconds % 60;
                document.getElementById('timer').textContent = 
                    `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
            }
            
            updateTimer();
            setInterval(updateTimer, 1000);
        }

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            // Number keys 1-4 for options
            if (e.key >= '1' && e.key <= '4') {
                selectOption(parseInt(e.key) - 1);
            }
            // Enter key to submit next
            if (e.key === 'Enter' && document.getElementById('nextBtn') && !document.getElementById('nextBtn').disabled) {
                document.querySelector('form').submit();
            }
        });

        // Prevent accidental refresh
        window.addEventListener('beforeunload', function(e) {
            if (document.getElementById('selectedAnswer').value !== '') {
                e.preventDefault();
                e.returnValue = 'You have unsaved answers. Are you sure you want to leave?';
            }
        });
    </script>
</body>
</html>
