<?php

require_once('student.php');

$servername="localhost";
$username="root";
$password="root";
$database="school_db";

$con = new mysqli($servername, $username, $password, $database);
    
/**
 * Updates a student record in the database that has the id $id
 *
 * @param mysqli $con
 * @param int $id
 * @return bool
*/
function updateStudentInDB($con, $id){
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
    $picture_data = "";
    if(isset($_FILES["image-input"]) && $_FILES["image-input"]["error"] == 0){
        if(isset($_FILES["image-input"]["tmp_name"])){
            $picture_name = $_FILES["image-input"]["tmp_name"];
            $picture_data = ($picture_name != "" ? file_get_contents($picture_name) : "");
        }
    }
    $command = "update students set full_name=?, dob=?, gender=?, course=?, year_level=?,contact_number=?, email=?, profile_picture=? where id=?";
    $prep = $con->prepare($command);
    $prep->bind_param("ssssisssi", 
        $fullname,
        $dob,
        $gender,
        $course,
        $yearlevel,
        $contact,
        $email,
        $picture_data,
        $id);
    return $prep->execute();
}

/**
 * Checks whether the received POST request is from dashboard.php (edit_entry_button
 * is set) or submitted from this update.php file (submit-button is set).
 *
 * If submit-button is set, updateStudentInDb() is called.
 *
 * If edit_entry_button is set, this function fetches the data of the record 
 * chosen to edit in dashboard.php, generates an instance of Student and returns
 * it
 *
 * @param mysqli $con
 * @param Student $student
*/
function initPage($con){
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        if(isset($_POST["submit-button"])){
            if(updateStudentInDB($con, $_POST["submit-button"]))
                header("Location: dashboard.php");
            else
                header("Location: dashboard.php");
            return null;
        }
        $id = $_POST["edit_entry_button"];
        $command = "select * from students where id=$id";
        $rs = $con->query($command);
        if($row = $rs->fetch_assoc()){
            return initStudent($row, $id);
        }
    }
}

/**
 * Takes in an sql result row and generates a Student instance with it.
 *
 * @param mysqli_result $row
 * @param int $id
 * @return Student
 */
function initStudent($row, $id){
    return new StudentBuilder()
        ->setId($id)
        ->setFullname($row["full_name"])
        ->setDOB($row["dob"])
        ->setGender($row["gender"])
        ->setCourse($row["course"])
        ->setYearLevel($row["year_level"])
        ->setContact($row["contact_number"])
        ->setEmail($row["email"])
        ->setPictureData(($row["profile_picture"] == null ? "" : $row["profile_picture"]))
        ->build();
}

/**
 * builds a single year level option. if $i matches $yearlevel, the option is
 * set as selected.
 *
 * @param int $i the current iteration in buildYearLevelSelect().
 * @param int|string $yearlevel the student's current year level
 */
function buildYearlevelOption($i, $yearlevel){
    return "<option value=\"$i\"" 
        . ($i == $yearlevel ?  " selected" : "")
        . ">$i</option>";
}

/**
 * generates the year level input field.
 *
 * @param int|string $yearlevel the student's current year level
 */
function buildYearlevelSelect($yearlevel){
    $select = "<div class=\"input-box\">
        <label>Year Level</label>
        <select id=\"yearlevel-field\" name=\"yearlevel-field\" class=\"registration-input\">";
    for ($i=1; $i <= 4; $i++) { 
        $select = $select . buildYearlevelOption($i, $yearlevel);
    }
    $select = "$select
        </select>
    </div>";
    return $select;
}

/**
 * builds a single gender radio button. if $curgender matches $gender, the 
 * option is set as checked.
 *
 * @param string $curgender the gender being generated
 * @param string $gender the student's current gender
 */
function buildGenderOption($curgender, $gender){
    return "<input type=\"radio\" name=\"gender-radio\" name=\"gender-radio\" value=\"$curgender\""
        . ($curgender === $gender ? " checked=\"checked\"" : "")
        . "><label>$curgender</label>";
}

/**
 * generates the gender radio buttons.
 *
 * @param string $gender the student's current gender
 */
function buildGenderSelect($gender){
    $radios = "<div class=\"radio-box\">
                    <div class=\"radio-label-pair\">" .
                        buildGenderOption("Male", $gender) .
                    "</div>
                    <div class=\"radio-label-pair\">" .
                        buildGenderOption("Female", $gender) .
                    "</div>
                    <div class=\"radio-label-pair\">" .
                        buildGenderOption("Other", $gender) .
                    "</div>" .
                "</div>";
    return $radios;
}

/**
 * The Student instance of the student record to be edited.
 *
 * @var Student
 */
$student = initPage($con);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Student</title>
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
        <div class="form-panel">
            <div class="form-input-container">
                <form id="registration-form" class="registration-form" method="post" action="update.php" onsubmit="return validateForm()" enctype="multipart/form-data">
                    <div class="form-top-inputs">
                        <div class="image-panel">
                            <img id="profile-picture-frame"
                            src="<?php echo 'pfp.php?id=' . $student->getId() ?>"
                             onerror="this.onerror=null; this.src='https://static.vecteezy.com/system/resources/previews/004/511/281/original/default-avatar-photo-placeholder-profile-picture-vector.jpg';" 
                            width="128" height="128">
                            <label for="image-input" class="image-input-label">Browse...</label>
                            <input type="file" class="image-input" accept="image/*" name="image-input" id="image-input">
                        </div>
                    </div>
                    <div class="input-box">
                        <div class="form-label-row">
                            <label>Fullname</label><label class="require-label fullname-require-label">*</label>
                        </div>
                        <input type="text" id="fullname-field" name="fullname-field" class="registration-input" value="<?php echo $student->getFullname() ?>">
                    </div>
                    <div class="input-box">
                        <div class="form-label-row">
                            <label>Date of Birth</label><label class="require-label dob-require-label">*</label>
                        </div>
                        <input type="date" id="dob-field" name="dob-field" class="registration-input" value="<?php echo $student->getDOB() ?>">
                    </div>
                    <div class="input-box">
                        <label>Gender</label>
                        <?php echo buildGenderSelect($student->getGender()); ?>
                    </div>
                    <div class="input-box">
                        <div class="form-label-row">
                            <label>Course</label><label class="require-label course-require-label">*</label>
                        </div>
                        <input type="text" id="course-field" name="course-field" class="registration-input" value="<?php echo $student->getCourse() ?>">
                    </div>
                    <?php echo buildYearlevelSelect($student->getYearlevel()); ?>
                    <div class="input-box">
                        <div class="form-label-row">
                            <label>Contact Number</label><label class="require-label contact-require-label">*</label>
                        </div>
                        <input type="text" id="contact-field" name="contact-field" class="registration-input" value="<?php echo $student->getContact() ?>">
                    </div>
                    <div class="input-box">
                        <div class="form-label-row">
                            <label>Email</label><label class="require-label email-require-label">*</label>
                        </div>
                        <input type="email" id="email-field" name="email-field" class="registration-input" value="<?php echo $student->getEmail() ?>">
                    </div>
                    <div class="input-box">
                        <button type="submit" id="submit-button" name="submit-button" class="registration-submit" value='<?php echo $student->getId(); ?>'>Update</button>
                    </div>
                    <div class="input-box">
                        <button type="button" class="reset-form-button" name="reset-button" src="res/reset.svg" onclick="showDialog(event, 'Are you sure you want to reset?')">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script src="form.js"></script>

</html>
