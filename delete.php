<?php

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
   
    $collegeId = $conn->real_escape_string($_GET['id']);

   
    $deleteCoursesQuery = "DELETE FROM courses WHERE college_id = $collegeId";
    if ($conn->query($deleteCoursesQuery)) {
       
        $deleteCollegeQuery = "DELETE FROM colleges WHERE college_id = $collegeId";
        if ($conn->query($deleteCollegeQuery)) {
            
            header("Location: display.php");
            exit();
        } else {
            echo "Error deleting college: " . $conn->error;
        }
    } else {
        echo "Error deleting courses: " . $conn->error;
    }
} else {
    
    header("Location: display.php");
    exit();
}


$conn->close();
?>
