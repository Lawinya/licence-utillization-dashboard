<?php

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST['collegeName']) && isset($_POST['collegeLocation'])
        && isset($_POST['courseCount']) && isset($_POST['coursesAdded'])
    ) {
        $collegeName = $conn->real_escape_string($_POST['collegeName']);
        $collegeLocation = $conn->real_escape_string($_POST['collegeLocation']);
        $courseCount = (int)$_POST['courseCount'];
        $coursesAdded = $_POST['coursesAdded'];

        if ($coursesAdded === 'true') {
            
            $sqlCollege = "INSERT INTO colleges (college_name, college_location) 
                          VALUES ('$collegeName', '$collegeLocation')";

            if ($conn->query($sqlCollege) === TRUE) {
                $collegeId = $conn->insert_id;

                for ($i = 1; $i <= $courseCount; $i++) {
                    $courseName = $conn->real_escape_string($_POST["courseName$i"]);
                    $courseDescription = $conn->real_escape_string($_POST["courseDescription$i"]);
                    $sqlCourse = "INSERT INTO courses (college_id, course_name, course_description) 
                                  VALUES ('$collegeId', '$courseName', '$courseDescription')";

                    $conn->query($sqlCourse);
                }

                echo '<p class="success-message">Data added successfully</p>';
                header("Location: ".$_SERVER['PHP_SELF']);
                exit();
            } else {
                echo '<p class="error-message">Error adding data: ' . $conn->error . '</p>';
            }
        } else {
            echo '<p class="error-message">Error: Add at least one course before submitting data.</p>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>College Admin Panel</title>
  <link rel="stylesheet" href="./style.css">
</head>
<body>
  <?php include 'navbar.php'; ?>

  <header>
    <h1>College Admin Panel</h1>
  </header>
 
  <main>
    <section id="addData">
      <form id="addDataForm" method="post">
        <label for="collegeName">College Name:</label>
        <input type="text" id="collegeName" name="collegeName" required>
        <label for="collegeLocation">College Location:</label>
        <input type="text" id="collegeLocation" name="collegeLocation" required>
        <label for="courseCount">Number of Courses:</label>
        <input type="number" id="courseCount" name="courseCount" min="1" required oninput="addCourseFields()">
        <div id="courseFields">
        </div>
        <input type="hidden" id="coursesAdded" name="coursesAdded" value="false">
        <button type="submit" onclick="return validateForm()">Add Data</button>
      </form>

      <script>
        function addCourseFields() {
          var courseCount = document.getElementById('courseCount').value;
          var courseFields = document.getElementById('courseFields');
          courseFields.innerHTML = '';

          for (var i = 1; i <= courseCount; i++) {
            courseFields.innerHTML += `
              <label for="courseName${i}">Course ${i} Name:</label>
              <input type="text" id="courseName${i}" name="courseName${i}" required>
              <label for="courseDescription${i}">Course ${i} Description:</label>
              <textarea id="courseDescription${i}" name="courseDescription${i}" required></textarea>
            `;
          }

          document.getElementById('coursesAdded').value = 'true';
        }

        function validateForm() {
          var coursesAdded = document.getElementById('coursesAdded').value;

          if (coursesAdded === 'false') {
            alert('Please add at least one course before submitting.');
            return false;
          }

          return true;
        }
      </script>
    </section>
  </main>

  <?php
   
    $conn->close();
  ?>
</body>
</html>
