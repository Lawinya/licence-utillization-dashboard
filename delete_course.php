<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

if (isset($_GET['id']) && isset($_GET['college_id'])) {
    $courseId = $conn->real_escape_string($_GET['id']);
    $collegeId = $conn->real_escape_string($_GET['college_id']);


    $deleteCourseSql = "DELETE FROM courses WHERE course_id = $courseId";
    $conn->query($deleteCourseSql);


    header("Location: edit.php?id=$collegeId");
    exit();
} elseif (isset($_GET['college_id'])) {

    $collegeId = $conn->real_escape_string($_GET['college_id']);


    $deleteCoursesSql = "DELETE FROM courses WHERE college_id = $collegeId";
    $conn->query($deleteCoursesSql);


    $deleteCollegeSql = "DELETE FROM colleges WHERE college_id = $collegeId";
    $conn->query($deleteCollegeSql);

    header("Location: index.php");
    exit();
} else {
    echo "Error: Course ID or College ID not provided.";
}
?>