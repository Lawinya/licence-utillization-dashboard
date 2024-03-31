<?php

include 'db.php';

$collegesQuery = "SELECT * FROM colleges";
$collegesResult = $conn->query($collegesQuery);


$selectedCollege = isset($_POST['selectedCollege']) ? $conn->real_escape_string($_POST['selectedCollege']) : '';
$searchTerm = isset($_POST['search']) ? $conn->real_escape_string($_POST['search']) : '';

$sql = "SELECT colleges.college_id, colleges.college_name, GROUP_CONCAT(courses.course_name SEPARATOR ', ') AS courses_list, 
               GROUP_CONCAT(courses.course_description SEPARATOR ', ') AS courses_description, colleges.college_location
        FROM colleges
        LEFT JOIN courses ON colleges.college_id = courses.college_id";


if (!empty($selectedCollege)) {
    $sql .= " WHERE colleges.college_id = $selectedCollege";
}

if (!empty($searchTerm)) {
    if (!empty($selectedCollege)) {
        $sql .= " AND";
    } else {
        $sql .= " WHERE";
    }

    $sql .= " (colleges.college_name LIKE '%$searchTerm%' OR
              courses.course_name LIKE '%$searchTerm%' OR
              courses.course_description LIKE '%$searchTerm%' OR
              colleges.college_location LIKE '%$searchTerm%')";
}

$sql .= " GROUP BY colleges.college_id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <title>College Details</title>
    <link rel="stylesheet" href="./display.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <header>
        <h1>College Details</h1>
    </header>

    <main>
        <form method="post" id="collegeForm">
            <label for="selectedCollege">Select College:</label>
            <select name="selectedCollege" id="selectedCollege">
                <option value="">-- Select College --</option>
                <option value="">All Colleges</option>
                <?php
                while ($college = $collegesResult->fetch_assoc()) {
                    $selected = ($college['college_id'] == $selectedCollege) ? 'selected' : '';
                    echo "<option value='{$college['college_id']}' $selected>{$college['college_name']}</option>";
                }
                ?>
            </select>

            <label id="search" for="search">Search:</label>
            <input type="text" name="search" id="search" placeholder="Search by any field">

            <button type="submit">Submit</button>
        </form>

        <section id="collegeDetails">
            <?php
            if ($result->num_rows > 0) {
                echo '<table>';
                echo '<thead>';
                echo '<tr>';
                echo '<th>College Name</th>';
                echo '<th>Courses</th>';
                echo '<th>Course Descriptions</th>';
                echo '<th>College Location</th>';
                echo '<th colspan="2">Actions</th>'; 
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row['college_name'] . '</td>';
                    echo '<td><ol><li>' . str_replace(', ', '</li><li>', $row['courses_list']) . '</li></ol></td>';
                    echo '<td><ol><li>' . str_replace(', ', '</li><li>', $row['courses_description']) . '</li></ol></td>';
                    echo '<td>' . $row['college_location'] . '</td>';
                    echo '<td><a href="edit.php?id=' . $row['college_id'] . '" class="action-link edit-link">Edit</a></td>';
            
                   
                    echo '<td><a href="delete.php?id=' . $row['college_id'] . '" class="action-link delete-link" onclick="return confirm(\'Are you sure?\')">Delete</a></td>';
        
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<p>No data found.</p>';
            }
            ?>
        </section>
    </main>

    <?php
    
    $conn->close();
    ?>

    <script>
        
        document.getElementById('selectedCollege').addEventListener('change', function() {
            document.getElementById('collegeForm').submit();
        });
    </script>
</body>
</html>
