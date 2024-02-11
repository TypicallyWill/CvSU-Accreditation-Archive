<?php
session_start();
if (!isset($_SESSION['token'])) {
    header('Location: login.php');
    exit;
}
require('./config.php');

$client->setAccessToken($_SESSION['token']);

if ($client->isAccessTokenExpired()) {
    header('Location: logout.php');
    exit;
}

$google_oauth = new Google_Service_Oauth2($client);
$user_info = $google_oauth->userinfo->get();

// Function to get user level
function getUserLevel($email)
{
    global $mysqli;

    // Assuming your users table has a 'user_level' column
    $result = $mysqli->query("SELECT user_level FROM users WHERE email = '$email'");

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['user_level'];
    } else {
        // Default user level if not found
        return 0;
    }
}

// Function to generate random colors
function generateRandomColors($numColors)
{
    $colors = [];
    for ($i = 0; $i < $numColors; $i++) {
        $colors[] = 'rgba(' . rand(0, 50) . ', ' . rand(100, 200) . ', ' . rand(50, 100) . ', 0.7)';
    }
    return $colors;
}

$user = 'root';
$password = '';
$database = 'cvsuaccr_db';
$servername = '127.0.0.1';
$mysqli = new mysqli($servername, $user, $password, $database);

// Checking for connections
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

$email = $user_info['email'];

$result2 = $mysqli->query("SELECT user_level FROM users WHERE email = '$email'");
$row2 = $result2->fetch_assoc();

if ($row2['user_level'] != '0') {
    echo '<script>alert("The user is not authorized to access this page!");</script>';
    header('Location: login.php');
}

// Pre-made labels for all colleges
$premadeLabels = ['CAFENR', 'CAS', 'CCJ', 'CED', 'CEMDS', 'CEIT', 'CON', 'CSPEAR', 'CVMBS', 'COM', 'GSOLC'];

// SQL query to select data from the database
$sql = "SELECT * FROM users WHERE college IS NOT NULL AND (user_level = 2 OR user_level = 3)";
$userResult = $mysqli->query($sql);

$collegeData = array();
$filesData = array();

// Initializing college data with pre-made labels
foreach ($premadeLabels as $collegeLabel) {
    $collegeData[$collegeLabel] = 0;
    $filesData[$collegeLabel] = 0;
}

// SQL query to select data from the files table
$sqlFiles = "SELECT file_directory, COUNT(*) as fileCount FROM files GROUP BY file_directory";
$filesResult = $mysqli->query($sqlFiles);

// Collecting data for the files graph
while ($fileRow = $filesResult->fetch_assoc()) {
    $displayCollege = ($fileRow['file_directory'] === 'Graduate School and Open Learning College') ? 'GSOLC' : $fileRow['file_directory'];
    
    // Use 'COM' for display
    $displayCollegeDisplay = ($displayCollege === 'College of Medicine') ? 'COM' : $displayCollege;

    if (isset($filesData[$displayCollegeDisplay])) {
        $filesData[$displayCollegeDisplay] = $fileRow['fileCount'];
    }
}

// SQL query to select data from the users table
$sqlUsers = "SELECT college, COUNT(*) as userCount FROM users WHERE college IS NOT NULL AND (user_level = 2 OR user_level = 3) GROUP BY college";
$userResult = $mysqli->query($sqlUsers);

// Collecting data for the graph
while ($row = $userResult->fetch_assoc()) {
    $displayCollege = ($row['college'] === 'Graduate School and Open Learning College') ? 'GSOLC' : $row['college'];

    // Use 'COM' for display
    $displayCollegeDisplay = ($displayCollege === 'College of Medicine') ? 'COM' : $displayCollege;

    if (isset($collegeData[$displayCollegeDisplay])) {
        $collegeData[$displayCollegeDisplay] = $row['userCount'];
    }
}

// Function to generate the bar graph for users per college
function displayUsersPerCollegeBarGraph($data)
{
    echo '<script>';
    echo 'var ctx = document.getElementById("barChart1").getContext("2d");';
    echo 'var randomColors = ' . json_encode(generateRandomColors(count($data))) . ';';
    echo 'var myChart = new Chart(ctx, {';
    echo 'type: "bar",';
    echo 'data: {';
    echo 'labels: ' . json_encode(array_keys($data)) . ',';
    echo 'datasets: [{';
    echo 'label: "Users per College",';
    echo 'data: ' . json_encode(array_values($data)) . ',';
    echo 'backgroundColor: randomColors,';
    echo 'borderColor: randomColors,';
    echo 'borderWidth: 1';
    echo '}]';
    echo '},';
    echo 'options: {';
    echo 'scales: {';
    echo 'y: {';
    echo 'beginAtZero: true';
    echo '}';
    echo '}';
    echo '}';
    echo '});';
    echo '</script>';
}

// Function to generate the bar graph for files per college
function displayFilesPerCollegeBarGraph($data)
{
    echo '<script>';
    echo 'var ctx = document.getElementById("barChart2").getContext("2d");';
    echo 'var randomColors = ' . json_encode(generateRandomColors(count($data))) . ';';
    echo 'var myChart = new Chart(ctx, {';
    echo 'type: "bar",';
    echo 'data: {';
    echo 'labels: ' . json_encode(array_keys($data)) . ',';
    echo 'datasets: [{';
    echo 'label: "Files per College",';
    echo 'data: ' . json_encode(array_values($data)) . ',';
    echo 'backgroundColor: randomColors,';
    echo 'borderColor: randomColors,';
    echo 'borderWidth: 1';
    echo '}]';
    echo '},';
    echo 'options: {';
    echo 'scales: {';
    echo 'y: {';
    echo 'beginAtZero: true';
    echo '}';
    echo '}';
    echo '}';
    echo '});';
    echo '</script>';
}

// Display the bar graph for users per college
displayUsersPerCollegeBarGraph($collegeData);

// Display the bar graph for files per college
displayFilesPerCollegeBarGraph($filesData);

$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>CvSU Accreditation Archive System</title>
    <link rel="stylesheet" type="text/css" href="styles/style4.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* Consolidated styles... */
        .file-query {
            background: linear-gradient(rgba(255, 255, 255, .7), rgba(255, 255, 255, .7));
            border-collapse: collapse;
            z-index: 0;
            width: 765px;
        }

        th, td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #af514c;
            color: white;
            cursor: default;
        }

        td {
            color: red;
        }

        .results:hover {
            background: linear-gradient(rgba(0, 0, 0, .1), rgba(0, 0, 0, .1));
        }

        /* Adjusted style for smaller graphs */
        .outdated-boxx canvas {
            width: 300px;
            height: 150px;
        }
    </style>

</head>

<body>

<div class="container-fluid">

    <div id="main" class="main">
        <div class="profile-box">
            <div id="sidenav" class="sidenav">
                <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
            </div>
            <div class="profile-boxx">
                <div class="profile-info">
                    <p class="profile-label"
                       style="margin-left:12px;font-size:40px;color:#174a21;cursor:default;margin-top:10px;"><b>PROFILE</b></p>
                    <?php
                    // Check if user profile data is available
                    if ($user_info !== null) {
                    ?>
                        <ul>
                            <li class="profile-pic"
                                style="text-align:center;margin-right:40px;margin-bottom:20px;">
                                <img class="pic" src="<?= $user_info['picture']; ?>" referrerpolicy="no-referrer"
                                     width="150px" height="150px">
                            </li>
                            <li style="cursor:default;font-size:15px;text-align:center;margin-right:40px;margin-bottom:20px;">
                                <strong>Full Name:</strong> <?= $user_info['givenName']; ?> <?= $user_info['familyName']; ?>
                            </li>
                            <li style="cursor:default;font-size:15px;text-align:center;margin-right:40px;margin-bottom:20px;">
                                <strong>Email:</strong> <?= $user_info['email']; ?>
                            </li>
                            <li style="cursor:default;font-size:15px;text-align:center;margin-right:40px;margin-bottom:20px;">
                                <strong>User Level:</strong> Administrator
                            </li>
                        </ul>
                    <?php
                    } else {
                        echo "User profile not found.";
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="outdated-part">
            <div class="outdated-box">
                <div class="outdated-boxx">
                    <div class="alert alert-info"
                         style="margin-top:10px;width: 720px;margin-left:10px;background:linear-gradient(to right, #4CAF50, #81c784);;color: #fff;cursor:default;">
                        <b>STATISTICS</b>
                    </div>
                    <canvas id="barChart1" width="300" height="150"></canvas>
                    <canvas id="barChart2" width="300" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="nav-bar">
        <img src="images/cvsu-logo.png" class="logo">
        <p class="title">CvSU Accreditation Archive System</p>
        <div class="menu">
            <button class="menu-button">
                <img src="<?= $user_info['picture']; ?>" referrerpolicy="no-referrer" class="menu-icon">
            </button>
            <div class="menu-content">
                <a href="uploaded_files.php">Uploaded Files</a>
                <a href="outdated_files.php">Outdated Files</a>
                <a href="user_list.php">User List</a>
                <a href="logs.php">Activity Logs</a>
                <a href="#" data-toggle="modal" data-target="#logout">Sign Out</a>
            </div>
        </div>
    </div>

    <div class="side-navigation">
        <div id="mySidenav" class="side-nav-content">
            <a href="javascript:void(0)" class="close-button" onclick="closeNav()">&times;</a>
            <a href="cafenr.php">CAFENR</a>
            <a href="cas.php">CAS</a>
            <a href="ccj.php">CCJ</a>
            <a href="ced.php">CED</a>
            <a href="cemds.php">CEMDS</a>
            <a href="ceit.php">CEIT</a>
            <a href="nursing.php">CON</a>
            <a href="cspear.php">CSPEAR</a>
            <a href="cvmbs.php">CVMBS</a>
            <a href="com.php">College of Medicine</a>
            <a href="graduate_school.php">Graduate School and Open Learning College</a>
        </div>
    </div>

    <!-- Modal logout -->
    <div class="modal fade" id="logout" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> System </h4>
                </div>
                <div class="modal-body">
                    <p> Are you sure you want to sign out? </p>
                </div>
                <div class="modal-footer">
                    <a href="./logout.php" class="btn btn-danger">Sign out</a>
                    <button type="button" class="btn btn-success" data-dismiss="modal"> Close </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <div id="content" class="success message"><?php if (isset($message)) {
            echo $message;
        } ?>
    </div>

    <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
            document.getElementById("sidenav").style.visibility = "hidden";
            document.getElementById("main").style.marginLeft = "250px";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("sidenav").style.visibility = "visible";
            document.getElementById("main").style.marginLeft = "0";
        }
    </script>

    <script>
        function delayDb() {
            document.getElementById('upload').submit();
        }

        function dbUpload() {
            setTimeout("delayDb()", 10000);
        }
    </script>
    <script>
        // Function to update the first bar graph
        function updateBarGraph1(data) {
            var ctx = document.getElementById('barChart1').getContext('2d');
            var randomColors = <?php echo json_encode(generateRandomColors(count($premadeLabels))); ?>;
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($premadeLabels); ?>,
                    datasets: [{
                        label: 'Users per College',
                        data: Object.values(data),
                        backgroundColor: randomColors,
                        borderColor: randomColors,
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
        }

        // Function to update the second bar graph
        function updateBarGraph2(data) {
            var ctx = document.getElementById('barChart2').getContext('2d');
            var randomColors = <?php echo json_encode(generateRandomColors(count($premadeLabels))); ?>;
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($premadeLabels); ?>,
                    datasets: [{
                        label: 'Files per College',
                        data: Object.values(data),
                        backgroundColor: randomColors,
                        borderColor: randomColors,
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
        }

        // Call the functions with collected data and random colors
        updateBarGraph1(<?php echo json_encode($collegeData); ?>);
        updateBarGraph2(<?php echo json_encode($filesData); ?>); // Modified line to use $filesData
    </script>

    <script type="text/javascript" src="./js/gapi-upload.js"></script>
    <script async defer src="https://apis.google.com/js/api.js" onload="gapiLoaded()"></script>
    <script async defer src="https://accounts.google.com/gsi/client" onload="gisLoaded()"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-2.1.0.min.js"></script>
</body>

</html>
