<?php
//db con
include 'db.php';


$collegesQuery = "SELECT * FROM colleges";
$collegesResult = $conn->query($collegesQuery);


$selectedCollege = isset($_POST['selectedCollege']) ? $conn->real_escape_string($_POST['selectedCollege']) : '';

$sql = "SELECT colleges.college_id, colleges.college_name, GROUP_CONCAT(courses.course_name SEPARATOR ', ') AS courses_list, 
               GROUP_CONCAT(courses.course_description SEPARATOR ', ') AS courses_description, colleges.college_location
        FROM colleges
        LEFT JOIN courses ON colleges.college_id = courses.college_id";


if (!empty($selectedCollege)) {
    $sql .= " WHERE colleges.college_id = $selectedCollege";
}

$sql .= " GROUP BY colleges.college_id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Details</title>
    <link rel="stylesheet" href="./chart.css">
    <!-- Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

            
        </form>

        <section id="collegeDetails" class="charts">
            <?php
            if ($result->num_rows > 0) {

                $barChartData = [];
                $barChartLabels = [];


                $pieChartData = [];
                $pieChartLabels = [];

                while ($row = $result->fetch_assoc()) {
                    $barChartLabels[] = $row['college_name'];
                    $barChartData[] = count(explode(', ', $row['courses_list']));


                    $courses = explode(', ', $row['courses_list']);
                    foreach ($courses as $course) {
                        if (!in_array($course, $pieChartLabels)) {
                            $pieChartLabels[] = $course;
                            $pieChartData[$course] = 1;
                        } else {
                            $pieChartData[$course]++;
                        }
                    }
                }


                $barChartLabelsJSON = json_encode($barChartLabels);
                $barChartDataJSON = json_encode($barChartData);

                $pieChartLabelsJSON = json_encode(array_values($pieChartLabels));
                $pieChartDataJSON = json_encode(array_values($pieChartData));
                ?>



                <div class="charts">
                    <div style="width:60%" class="chart-container">
                        <canvas id="courseBarChart"></canvas>
                    </div>


                    <div style="width:30%" class="chart-container">
                        <canvas id="coursePieChart"></canvas>
                    </div>
                </div>


                <script>

                    var ctxBar = document.getElementById('courseBarChart').getContext('2d');
                    var courseBarChart = new Chart(ctxBar, {
                        type: 'bar',
                        data: {
                            labels: <?php echo $barChartLabelsJSON; ?>,
                            datasets: [{
                                label: 'Number of Courses',
                                data: <?php echo $barChartDataJSON; ?>,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });


                    var ctxPie = document.getElementById('coursePieChart').getContext('2d');
                    var coursePieChart = new Chart(ctxPie, {
                        type: 'pie',
                        data: {
                            labels: <?php echo $pieChartLabelsJSON; ?>,
                            datasets: [{
                                label: 'number of courses',
                                data: <?php echo $pieChartDataJSON; ?>,

                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            title: {
                                display: true,
                                text: 'Distribution of Courses'
                            }
                        }
                    });

                </script>

                <?php
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

        document.getElementById('selectedCollege').addEventListener('change', function () {
            document.getElementById('collegeForm').submit();
        });
    </script>
</body>

</html>