<?php

// Import the Student and StudentBuilder class
require_once('student.php');

$servername="localhost";
$username="root";
$password="root";
$database="school_db";

$con = new mysqli($servername, $username, $password, $database);

/**
 * Takes in an instance of Student from student.php and writes its attributes
 * to the database
 *
 * @param mysqli $con
 * @param Student $student
 * @return bool
 */
function writeStudentToDB($con, $student){
    $command = "insert into students(full_name, dob, gender, course, year_level, contact_number, email, profile_picture)
    values (?, ?, ?, ?, ?, ?, ?, ?)";
    $prep = $con->prepare($command);
    $picture_data = ($student->getPicture() != "" ? file_get_contents($student->getPicture()) : null);
    $prep->bind_param("ssssisss",
        $student->getFullname(),
        $student->getDOB(),
        $student->getGender(),
        $student->getCourse(),
        $student->getYearlevel(),
        $student->getContact(),
        $student->getEmail(),
        $picture_data
    );
    $prep->send_long_data(8, $picture_data);
    return $prep->execute();
}

/**
 * Initiates transactions the insertion of data and decides whether to display
 * an error message or the success message.
 * 
 * @param msyqli $con
 * @return bool
 */
function acceptSubmission($con){
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $picture = "";
        if(isset($_FILES["image-input"]) && $_FILES["image-input"]["error"] == 0){
            if(isset($_FILES["image-input"]["tmp_name"])){
                $picture = $_FILES["image-input"]["tmp_name"];
            }
        }
        $fullname = $_POST["fullname-field"];
        $dob = $_POST["dob-field"];
        $course = $_POST["course-field"];
        $yearlevel = $_POST["yearlevel-field"];
        $contact = $_POST["contact-field"];
        $email = $_POST["email-field"];

        $gender = null;
        if(isset($_POST["gender-radio"])){
            $gender = $_POST["gender-radio"];
        }

        $student = new StudentBuilder()
            ->setFullname($fullname)
            ->setEmail($email)
            ->setDOB($dob)
            ->setCourse($course)
            ->setYearLevel($yearlevel)
            ->setContact($contact)
            ->setGender($gender)
            ->setPicture($picture)
            ->build();

        return writeStudentToDB($con, $student);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <div class="nav-bar">
        <div class="nav-header">
            <p>Student Registration</p>
        </div>

        <div class="nav-links">
            <div class="nav-anchor dashboard-anchor">
                <a href="dashboard.php">Dashboard</a>
            </div>
            <div class="nav-anchor register-anchor">
                <a href="form.html">Register</a>
            </div>
        </div>
    </div>
    <div class="main-content-panel">
<!-- decide whether to show success or failed -->
<?php if (acceptSubmission($con)): ?>
        <div class="result-message-dialog">
            <div class="result-image-panel">
                <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwww.pngall.com%2Fwp-content%2Fuploads%2F12%2FGreen-Check-Transparent.png&f=1&nofb=1&ipt=c5fe0c9eca0a143e76763ceb6aa9aa8656b3a08c5f5d9f03e87f4d4796d0c70d" class="result-image">
            </div>
            <div class="result-message-header-panel">
                <h1 class="result-message-header result-success-header">Success</h1>
            </div>
            <div class="result-message-panel">
                <p class="result-message">Successfully registered the student! Click the button below to return to the registration form:</p>
            </div>
            <div class="result-button-container">
            <button id="result-button" type="button" onclick="window.open('form.html', '_self')" ?> OK</button>
            </div>
        </div>

<?php else: ?>
        <div class="result-message-dialog">
            <div class="result-image-panel">
                <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fstatic.vecteezy.com%2Fsystem%2Fresources%2Fpreviews%2F024%2F039%2F091%2Foriginal%2Fred-x-transparent-free-png.png&f=1&nofb=1&ipt=be1a54624eeea83f08cb73abc9beaf2712353c5694103495331a6935c71df837" class="result-image">
            </div>
            <div class="result-message-header-panel">
                <h1 class="result-message-header result-failed-header">Failed</h1>
            </div>
            <div class="result-message-panel">
                <p class="result-message">Failed to register the student. Click the button below to return to the registration form:</p>
            </div>
            <div class="result-button-container">
                <button id="result-button" type="button" onclick="window.open('form.html', '_self')" >OK</button>
            </div>
        </div>
<?php endif; ?>
    </div>
</body>

</html>
