<?php
// Database connection
$servername = "localhost";
$username = "rsoa_rsoa278_31";
$password = "123456";
$dbname = "rsoa_rsoa278_31";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create questions table
$sql = "CREATE TABLE IF NOT EXISTS questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question_text TEXT NOT NULL,
    option_a VARCHAR(255) NOT NULL,
    option_b VARCHAR(255) NOT NULL,
    option_c VARCHAR(255) NOT NULL,
    option_d VARCHAR(255) NOT NULL,
    correct_option CHAR(1) NOT NULL,
    difficulty INT DEFAULT 1,
    category VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'questions' created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// Create test_results table
$sql = "CREATE TABLE IF NOT EXISTS test_results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(100) NOT NULL,
    score INT NOT NULL,
    total_questions INT NOT NULL,
    iq_score INT NOT NULL,
    feedback TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'test_results' created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// Insert sample questions (20 IQ test questions)
$questions = [
    // Logical reasoning questions
    ["What comes next in the pattern: 2, 4, 8, 16, ?", "24", "32", "64", "128", "B", 1, "Logical"],
    ["If all roses are flowers and some flowers fade quickly, which statement must be true?", "All roses fade quickly", "Some roses fade quickly", "No roses fade quickly", "Some flowers that fade quickly are roses", "D", 2, "Logical"],
    ["Which number does not belong: 2, 3, 6, 7, 8, 14, 15, 30", "3", "8", "15", "30", "B", 2, "Logical"],
    
    // Pattern recognition
    ["What comes next: △, □, ○, △, □, ?", "△", "□", "○", "◊", "C", 1, "Pattern"],
    ["Complete the pattern: A1, B2, C3, D4, ?", "E4", "E5", "F5", "D5", "B", 1, "Pattern"],
    ["Which shape completes the pattern: (square, circle), (triangle, square), (circle, triangle), (?, ?)", "square, circle", "triangle, square", "circle, square", "square, triangle", "A", 3, "Pattern"],
    
    // Numerical ability
    ["If 3 people can paint 3 fences in 3 hours, how many fences can 6 people paint in 6 hours?", "6", "9", "12", "18", "C", 2, "Numerical"],
    ["What is 25% of 200 plus 1/3 of 120?", "50", "70", "90", "110", "C", 1, "Numerical"],
    ["Find the missing number: 5, 11, 19, 29, ?", "39", "41", "43", "45", "B", 2, "Numerical"],
    
    // Problem solving
    ["A clock shows 3:15. What is the angle between the hour and minute hands?", "0°", "7.5°", "15°", "30°", "B", 3, "Problem"],
    ["If you rearrange the letters 'CIFAIPC', you would get the name of a:", "City", "Animal", "Ocean", "Country", "D", 2, "Problem"],
    ["Which is the odd one out?", "Cube", "Sphere", "Pyramid", "Circle", "D", 1, "Problem"],
    
    // More questions to reach 20
    ["What is the next letter: A, E, I, M, ?", "Q", "R", "S", "T", "A", 2, "Pattern"],
    ["If RED is to 27 then BLUE is to ?", "32", "36", "40", "44", "C", 3, "Logical"],
    ["Solve: 7 x 8 - 6 ÷ 2 + 4", "54", "57", "59", "61", "B", 2, "Numerical"],
    ["Which number is the odd one out: 16, 25, 36, 49, 64, 81, 100", "16", "25", "49", "100", "D", 2, "Numerical"],
    ["What comes next: Z, X, V, T, ?", "R", "Q", "P", "O", "A", 1, "Pattern"],
    ["A bat and a ball cost $1.10. The bat costs $1 more than the ball. How much does the ball cost?", "5 cents", "10 cents", "15 cents", "20 cents", "A", 3, "Problem"],
    ["If today is Monday, what day is 72 hours from now?", "Monday", "Tuesday", "Thursday", "Friday", "C", 2, "Logical"],
    ["Complete series: 1, 1, 2, 3, 5, 8, ?", "11", "12", "13", "14", "C", 2, "Pattern"]
];

foreach ($questions as $q) {
    $sql = "INSERT INTO questions (question_text, option_a, option_b, option_c, option_d, correct_option, difficulty, category) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE question_text=VALUES(question_text)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssis", $q[0], $q[1], $q[2], $q[3], $q[4], $q[5], $q[6], $q[7]);
    $stmt->execute();
}

echo "Sample questions inserted successfully!";

$conn->close();
?>
