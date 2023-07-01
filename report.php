<?php
session_start();
require 'connection.php';

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

$user = query("SELECT * FROM user");
$designer = query("SELECT * FROM designer");
$recipe = query("SELECT * FROM recipes");
$feedback = query("SELECT * FROM contact");
$review = query("SELECT * FROM review ");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Recipes Report</title>
    <style>

        .welcome {
            text-align: center;
        }

        .page-heading {
            text-align: center;
            background-color: #00008B;
            color: #fff;
            padding: 10px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .button-container {
            margin-top: 20px;
            text-align: center;
        }

        #graphType {
            padding: 5px 10px;
            margin-right: 10px;
            font-size: 16px;
        }

        .generate-button {
            display: inline-block;
            background-color: #00008B;
            color: #fff;
            border: none;
            padding: 10px 20px;
            margin-right: 10px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .generate-button:hover {
            background-color: #333;
        }

        #graphPopup {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .popup-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        
        .dashboard-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 20px;
            margin-bottom: 20px;
        }

        .dashboard {
            text-align: center;
            border: 1px solid #ddd;
            padding: 10px;
        }

        .dashboard-heading {
            font-size: 24px;
            font-weight: bold;
        }

        .dashboard-value {
            font-size: 48px;
            color: #00008B;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <?php include 'sidenavadmin.php'; ?>

    <div class="content">
        <div class="main">
            <div class="welcome">
                <hr style="border-top: 1px solid #00008B; margin: 0;"><br>
                <h1 style="text-align:center;">Welcome back! <?php echo $_SESSION["username"];?></h1><br>
                <hr style="border-top: 1px solid #00008B; margin: 0;">
                <br><br>
            </div>
            <h1 class="page-heading">Report Management</h1>
            <br><br>
            <div class="button-container">
                <select id="graphType">
                    <option value="bar">Bar Graph</option>
                    <option value="pie">Pie Chart</option>
                    <option value="line">Line Graph</option>
                </select>
                <button class="generate-button" onclick="openGraphPopup()">Generate Graph Report</button>
            </div><br>
            <div class="dashboard-container">
                <div class="dashboard">
                    <div class="dashboard-heading">Total Users</div>
                    <div class="dashboard-value"><?php echo count($user); ?></div>
                </div>
                <div class="dashboard">
                    <div class="dashboard-heading">Total Designer</div>
                    <div class="dashboard-value"><?php echo count($designer); ?></div>
                </div>
                <div class="dashboard">
                    <div class="dashboard-heading">Total Recipe</div>
                    <div class="dashboard-value"><?php echo count($recipe); ?></div>
                </div>
                <div class="dashboard">
                    <div class="dashboard-heading">Average Rating</div>
                    <div class="dashboard-value">
                        <?php
                        $sql = "SELECT AVG(rv.userReview) AS avg_rating FROM recipes r LEFT JOIN review rv ON r.id = rv.recipe_id";
                        $result = $conn->query($sql);
                        if ($result && $result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $avgRating = $row['avg_rating'];
                            echo number_format($avgRating, 1); // Format the average rating to 1 decimal place
                        } else {
                            echo 'N/A';
                        }
                        ?>
                    </div>
                </div>
                <div class="dashboard">
                    <div class="dashboard-heading">Total Suggestion</div>
                    <div class="dashboard-value"><?php echo count($feedback); ?></div>
                </div>
                <div class="dashboard">
                    <div class="dashboard-heading">All Feedback</div>
                    <div class="dashboard-value"><?php echo count($review); ?></div>
                </div>
            </div><br>


            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Preparation Time</th>
                        <th>Cooking Time</th>
                        <th>Ingredients</th>
                        <th>Steps</th>
                        <th>Average Rating</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                // Fetch data from the database
                $sql = "SELECT r.name, r.prep_time, r.cook_time, r.ingredient, r.steps, AVG(rv.userReview) AS avg_rating
                        FROM recipes r
                        LEFT JOIN review rv ON r.id = rv.recipe_id
                        GROUP BY r.id";
                $result = $conn->query($sql);

                // Check if the query was successful
                if ($result) {
                    // Loop through the result set and generate table rows
                    while ($row = $result->fetch_assoc()) {
                        $name = $row['name'];
                        $prepTime = $row['prep_time'];
                        $cookTime = $row['cook_time'];
                        $ingredients = $row['ingredient'];
                        $steps = $row['steps'];
                        $avgRating = $row['avg_rating'];

                        echo '<tr>
                                <td>' . $name . '</td>
                                <td>' . $prepTime . '</td>
                                <td>' . $cookTime . '</td>
                                <td>' . $ingredients . '</td>
                                <td>' . $steps . '</td>
                                <td>' . $avgRating . '</td>
                            </tr>';
                    }
                } else {
                    echo 'Error retrieving data from the database: ' . $conn->error;
                }
                ?>
                </tbody>
            </table>

            <!-- Hidden graph popup -->
            <div id="graphPopup">
                <div class="popup-content">
                    <span class="close" onclick="closeGraphPopup()">&times;</span>
                    <div id="graphContainer"></div>
                </div>
            </div>

            <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
            <script>
                function openGraphPopup() {
                    // Fetch the data counts
                    var userCount = <?php echo count($user); ?>;
                    var designerCount = <?php echo count($designer); ?>;
                    var recipeCount = <?php echo count($recipe); ?>;
                    var feedbackCount = <?php echo count($feedback); ?>;
                    var reviewCount = <?php echo count($review); ?>;

                    // Get the selected graph type
                    var graphType = document.getElementById("graphType").value;

                    // Generate the graph based on the selected type using Plotly.js
                    var data, layout;

                    if (graphType === "bar") {
                        data = [{
                            x: ["Users", "Designers", "Recipes", "Feedback", "Reviews"],
                            y: [userCount, designerCount, recipeCount, feedbackCount, reviewCount],
                            type: 'bar'
                        }];
                        layout = {
                            title: 'Data Counts',
                            xaxis: {
                                title: 'Data Type'
                            },
                            yaxis: {
                                title: 'Count'
                            }
                        };
                    } else if (graphType === "pie") {
                        data = [{
                            labels: ["Users", "Designers", "Recipes", "Feedback", "Reviews"],
                            values: [userCount, designerCount, recipeCount, feedbackCount, reviewCount],
                            type: 'pie'
                        }];
                        layout = {
                            title: 'Data Distribution'
                        };
                    } else if (graphType === "line") {
                        // Prepare the data for line graph
                        var recipeNames = [];
                        var averageRatings = [];
                        <?php
                        $result->data_seek(0);
                        while ($row = $result->fetch_assoc()) {
                            echo 'recipeNames.push("' . $row['name'] . '");';
                            echo 'averageRatings.push(' . $row['avg_rating'] . ');';
                        }
                        ?>

                        data = [{
                            x: recipeNames,
                            y: averageRatings,
                            mode: 'lines',
                            type: 'scatter'
                        }];
                        layout = {
                            title: 'Average Ratings Trend',
                            xaxis: {
                                title: 'Recipe'
                            },
                            yaxis: {
                                title: 'Average Rating'
                            }
                        };
                    } else if (graphType === "scatter") {
                        // Prepare the data for scatter plot
                        var xData = []; // Array of x values
                        var yData = []; // Array of y values
                        <?php
                        // Fetch data for scatter plot from the database
                        $sql = "SELECT x_column, y_column FROM your_table";
                        $result = $conn->query($sql);
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo 'xData.push(' . $row['x_column'] . ');';
                                echo 'yData.push(' . $row['y_column'] . ');';
                            }
                        }
                        ?>

                        data = [{
                            x: xData,
                            y: yData,
                            mode: 'markers',
                            type: 'scatter'
                        }];
                        layout = {
                            title: 'Scatter Plot',
                            xaxis: {
                                title: 'X Values'
                            },
                            yaxis: {
                                title: 'Y Values'
                            }
                        };
                    } else if (graphType === "histogram") {
                        // Prepare the data for histogram
                        var ratings = []; // Array of ratings
                        <?php
                        // Fetch data for histogram from the database
                        $sql = "SELECT rating FROM your_table";
                        $result = $conn->query($sql);
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo 'ratings.push(' . $row['rating'] . ');';
                            }
                        }
                        ?>

                        data = [{
                            x: ratings,
                            type: 'histogram'
                        }];
                        layout = {
                            title: 'Rating Distribution',
                            xaxis: {
                                title: 'Rating'
                            },
                            yaxis: {
                                title: 'Frequency'
                            }
                        };
                    }

                    Plotly.newPlot('graphContainer', data, layout);

                    // Show the graph popup
                    document.getElementById("graphPopup").style.display = "block";
                }

                function closeGraphPopup() {
                    // Hide the graph popup
                    document.getElementById("graphPopup").style.display = "none";
                }
            </script>
        </div>
    </div>
</body>
</html>
