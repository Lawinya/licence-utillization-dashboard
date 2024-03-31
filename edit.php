<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $collegeId = $conn->real_escape_string($_POST['collegeId']);
    $collegeName = $conn->real_escape_string($_POST['collegeName']);
    $collegeLocation = $conn->real_escape_string($_POST['collegeLocation']);
    $courseNames = $_POST['courseName'];
    $courseDescriptions = $_POST['courseDescription'];

    
    $updateCollegeSql = "UPDATE colleges SET college_name = '$collegeName', college_location = '$collegeLocation' WHERE college_id = $collegeId";
    echo $updateCollegeSql; 
    $conn->query($updateCollegeSql);

    
    foreach ($courseNames as $index => $courseName) {
        $courseId = $conn->real_escape_string($_POST['courseId'][$index]); 
        $updateCourseSql = "UPDATE courses SET course_name = '$courseName', course_description = '$courseDescriptions[$index]' WHERE course_id = $courseId";
        echo $updateCourseSql; 
        $conn->query($updateCourseSql);
    }

    foreach ($_POST['newCourseName'] as $index => $newCourseName) {
        $newCourseDescription = $conn->real_escape_string($_POST['newCourseDescription'][$index]);

        $insertNewCourseSql = "INSERT INTO courses (college_id, course_name, course_description) VALUES ($collegeId, '$newCourseName', '$newCourseDescription')";
        echo $insertNewCourseSql; 
        $conn->query($insertNewCourseSql);
    }

    
    header("Location: display.php");
    exit();
} else {
   
    $collegeId = isset($_GET['id']) ? $conn->real_escape_string($_GET['id']) : '';

    $sql = "SELECT colleges.college_id, colleges.college_name, colleges.college_location,
                   courses.course_id, courses.course_name, courses.course_description
            FROM colleges
            LEFT JOIN courses ON colleges.college_id = courses.college_id
            WHERE colleges.college_id = $collegeId";

    $result = $conn->query($sql);  
    $collegeDetails = $result->fetch_assoc();
    $result->data_seek(0);

   
    $courses = array();
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit College</title>
    <link rel="stylesheet" href="./edit.css">
</head>
<body>

    <?php include 'navbar.php'; ?>
    <header>
        <h1>Edit College</h1>
    </header>

    <form method="post" id="editCollegeForm">
        <input type="hidden" name="collegeId" value="<?php echo $collegeDetails['college_id']; ?>">

        <label for="collegeName">College Name:</label>
        <input type="text" id="collegeName" name="collegeName" value="<?php echo $collegeDetails['college_name']; ?>" required>

        <label for="collegeLocation">College Location:</label>
        <input type="text" id="collegeLocation" name="collegeLocation" value="<?php echo $collegeDetails['college_location']; ?>" required>

        <?php foreach ($courses as $index => $course): ?>
            <div>
                <input type="hidden" name="courseId[]" value="<?php echo $course['course_id']; ?>">

                <label for="courseName<?php echo $index; ?>">Course Name:</label>
                <input type="text" id="courseName<?php echo $index; ?>" name="courseName[]" value="<?php echo $course['course_name']; ?>" required>

                <label for="courseDescription<?php echo $index; ?>">Course Description:</label>
                <textarea id="courseDescription<?php echo $index; ?>" name="courseDescription[]" required><?php echo $course['course_description']; ?></textarea>

                <a href="delete_course.php?id=<?php echo $course['course_id']; ?>&college_id=<?php echo $collegeDetails['college_id']; ?>&course_name=<?php echo urlencode($course['course_name']); ?>" onclick="return confirm('Are you sure you want to delete the course <?php echo $course['course_name']; ?>?')" class="delete-button">Delete</a>
            </div>
        <?php endforeach; ?>

        <div id="newCoursesContainer"></div>

        <button type="button" onclick="addNewCourses()">Add New Courses</button>
        <button type="submit">Save Changes</button>
    </form>

    <script>
        function addNewCourses() {
            var numberOfCourses = prompt("Enter the number of new courses to add:", "1");
            
            if (numberOfCourses !== null) {
                numberOfCourses = parseInt(numberOfCourses);

                if (!isNaN(numberOfCourses) && numberOfCourses > 0) {
                    var container = document.getElementById("newCoursesContainer");

                    for (var i = 0; i < numberOfCourses; i++) {
                        var newDiv = document.createElement("div");
                        newDiv.innerHTML = `
                            <label for="newCourseName${i}">New Course Name:</label>
                            <input type="text" id="newCourseName${i}" name="newCourseName[]" required>

                            <label for="newCourseDescription${i}">New Course Description:</label>
                            <textarea id="newCourseDescription${i}" name="newCourseDescription[]" required></textarea>
                        `;
                        container.appendChild(newDiv);
                    }
                } else {
                    alert("Please enter a valid number greater than 0.");
                }
            }
        }
    </script>

</body>
</html>
