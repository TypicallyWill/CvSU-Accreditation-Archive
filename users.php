<?php
session_start();
if(!isset($_SESSION['token'])){
  header('Location: login.php');
  exit;
}
require('./config.php');

$client->setAccessToken($_SESSION['token']);

if($client->isAccessTokenExpired()){
  header('Location: logout.php');
  exit;
}
$google_oauth = new Google_Service_Oauth2($client);
$user_info = $google_oauth->userinfo->get();

$user = 'root';
$password = '';
 
$database = 'cvsuaccr_db';
 
$servername='127.0.0.1';
$mysqli = new mysqli($servername, $user,
                $password, $database);
 
// Checking for connections
if ($mysqli->connect_error) {
    die('Connect Error (' .
    $mysqli->connect_errno . ') '.
    $mysqli->connect_error);
}

// getting user info for uploaded files
$first_name = $user_info['given_name'];
$last_name = $user_info['family_name'];
$file_owner = $first_name . " " . $last_name;


// Fetch user_level from the database for the current user
$email = $user_info['email'];
$query = "SELECT user_level FROM users WHERE email = '$email'";
$result = $mysqli->query($query);

if ($result) {
    $row = $result->fetch_assoc();
    $user_level = $row['user_level'];

    if ($user_level == 0) {
        // Redirect to login.php with an alert message
        echo "<script>
                alert('You are not authorized.');
                window.location.href = 'login.php';
              </script>";
        exit;
    }
} else {
    // Handle the error, such as setting a default user_level
    $user_level = 0; // Default user_level
}
 
// SQL query to select data from database
$sql = " SELECT * FROM users ORDER BY id ASC ";
$result = $mysqli->query($sql);
$mysqli->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CvSU Accreditation Archive System</title>
    <link rel="stylesheet" type="text/css" href="styles/style5.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>

<div class="container-fluid">
    <div id="main" class="main">
        <div class="box">
            <div class="profile-box">
                <div id="sidenav">
                    <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
                </div>
                <div class="profile-boxx">
                    <div class="col-md-8">
		            <div class="alert alert-info" style="margin-top:10px;"> Users </div>
                <a href="#" id="authorizationButton" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addUserModal"><span class="glyphicon glyphicon-plus"></span> Add User </a>
            </div>

            <div id="nav-bar" class="nav-bar">
          <img src="images/cvsu-logo.png" class="logo">
            <p class="title">CvSU Accreditation Archive System</p>
        <div class="navv">
          <div class="menu">
            <button class="menu-button">
              <img src="<?=$user_info['picture'];?>" referrerpolicy="no-referrer" class="menu-icon">
            </button>
            <div class="content">
            <div class="menu-content">
            <a href="profile_directory.php">Profile</a>
    <?php if ($user_level == 1): ?>
        <a href="#">Uploaded Files</a>
        <a href="logs.php">Activity logs</a>
    <?php endif; ?>
    <a href="users.php">Users</a>
    <a href="#" data-toggle="modal" data-target="#logout">Sign out</a>
</div>
            </div>
          </div>
        </div>
      </div>

      <div id="search-box">
            <input type="text" id="searchInput" placeholder="Search" size="50" oninput="search()">
      </div>

      <section>
    <table class="file-query table table-bordered table-hover table-striped">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">ACTIVE STATUS</th>
                <th class="text-center">FIRST NAME</th>
                <th class="text-center">LAST NAME</th>
                <th class="text-center">GENDER</th>
                <th class="text-center">EMAIL</th>
                <th class="text-center">USER LEVEL</th>
                <th class="text-center">COLLEGE</th>
                <th class="text-center">ACTION</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($rows = $result->fetch_assoc()) {
            ?>
                <tr class="results">
                    <td class="text-center"><?php echo $rows['id']; ?></td>
                    <td class="text-center">
                        <!-- Add a span with a specific class for styling -->
                        <span class="status <?php echo ($rows['active_status'] == 'online') ? 'online' : 'offline'; ?>"></span>
                        <?php echo $rows['active_status']; ?>
                    </td>
                    <td class="text-center"><?php echo $rows['first_name']; ?></td>
                    <td class="text-center"><?php echo $rows['last_name']; ?></td>
                    <td class="text-center"><?php echo $rows['gender']; ?></td>
                    <td class="text-center"><?php echo $rows['email']; ?></td>
                    <td class="text-center">
                        <?php
                            $userLevel = $rows['user_level'];
                            if ($userLevel == 1) {
                                    echo 'Admin';
                            } elseif ($userLevel == 2) {
                                    echo 'IDO';
                            } elseif ($userLevel == 3) {
                                    echo 'University Personnel';
                            } else {
                                    echo 'Unknown Role'; 
                            }
                         ?>
                    </td>
                    <td class="text-center"><?php echo $rows['college']; ?></td>
                    <td>
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_info"><span class="glyphicon glyphicon-list-alt"></span> Info</button>
                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal_edit"><span class="glyphicon glyphicon-list-alt"></span> Edit</button>
                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal_remove" data-email="<?php echo $rows['email']; ?>"><span class="glyphicon glyphicon-list-alt"></span> Delete</button>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</section>
    </div>
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

    
<!-- Modal add user -->
<div class="modal fade" id="addUserModal" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add User</h4>
            </div>
            <div class="modal-body">
                <form action="add_user.php" method="post">
                    <div class="form-group row">
                        <label for="first_name" class="col-sm-4 col-form-label text-right">First Name:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="last_name" class="col-sm-4 col-form-label text-right">Last Name:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="gender" class="col-sm-4 col-form-label text-right">Gender:</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="gender" name="gender" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="birthdate" class="col-sm-4 col-form-label text-right">Birthdate:</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" id="birthdate" name="birthdate" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-4 col-form-label text-right">Email:</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="form-group row">
                <label for="user_level" class="col-sm-4 col-form-label text-right">User Level:</label>
                <div class="col-sm-8">
                    <select class="form-control" id="user_level" name="user_level" onchange="toggleCollegeField()" required>
                        <option value="1">Admin</option>
                        <option value="2">IDO</option>
                        <option value="3">University Personnel</option>
                    </select>
                </div>
            </div>
            <div class="form-group row" id="collegeField" style="display: none;">
                <label for="college" class="col-sm-4 col-form-label text-right">College:</label>
                <div class="col-sm-8">
                    <select class="form-control" id="college" name="college">
                            <option value="CAFENR">CAFENR</option>
                            <option value="CAS">CAS</option>
                            <option value="CCJ">CCJ</option>
                            <option value="CED">CED</option>
                            <option value="CEMDS">CEMDS</option>
                            <option value="CEIT">CEIT</option>
                            <option value="CON">CON</option>
                            <option value="CSPEAR">CSPEAR</option>
                            <option value="CVMBS">CVMBS</option>
                            <option value="College of Medicine">College of Medicine</option>
                            <option value="Graduate School and Open Learning College">Graduate School and Open Learning College</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus"></span> Add</button>
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                    </div>
                </form>
            </div>
        </div>
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
          <p> Are you sure you want to Sign Out? </p>
        </div>
        <div class="modal-footer">
          <a href="./logout.php" class="btn btn-danger" >Sign out</a>
          <button type="button" class="btn btn-success" data-dismiss="modal"> Close </button>
        </div>
      </div>
    </div>
  </div>
</div>
    <!-- Modal Delete User -->
    <div class="modal fade" id="modal_remove" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Confirmation</h3>
            </div>
            <div class="modal-body">
                <h4 class="text-danger" id="confirmationMessage">Do you want to remove this user from the access to the system?</h4>
                <p id="userEmailToDelete" style="display: none;"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-danger" onclick="deleteUser()">Yes</button>
            </div>
        </div>
    </div>
</div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

 <script>
    $(document).on('click', '.btn-danger', function () {
        var email = $(this).closest('tr').find('td:eq(5)').text(); // Assuming the email is in the 6th column (index 5)
        $('#userEmailToDelete').text(email);

        // Show the confirmation modal
        $('#modal_remove').modal('show');
    });

    function deleteUser() {
        // Close the confirmation modal and remove the backdrop
        $('#modal_remove').modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();

        var email = $('#userEmailToDelete').text();

        $.ajax({
            type: 'POST',
            url: 'delete_user.php',
            data: { email: email },
            success: function (response) {
                // Additional actions after successful deletion
                // Show an alert message (no OK button)
                window.alert('User deleted successfully.');

                // Reload the page after a delay (e.g., 1000 milliseconds or 1 second)
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            },
            error: function (error) {
                // Show an alert message for errors
                window.alert('Error deleting user: ' + error.responseText);
            }
        });
    }
</script>




  <script>
    function toggleCollegeField() {
        var userLevelSelect = document.getElementById('user_level');
        var collegeField = document.getElementById('collegeField');

        // Check if the selected user level requires the display of the college field
        if (userLevelSelect.value == '3') { // Adjust this condition based on your user level values
            collegeField.style.display = 'block';
        } else {
            collegeField.style.display = 'none';
        }
    }
</script>

  <script>
    // search function for search box
    function search() {
        // Get input value and convert to lowercase for case-insensitive search
        var input = document.getElementById('searchInput').value.toLowerCase();

        // Get the table rows
        var rows = document.querySelectorAll('.file-query tbody tr.results');

        // Loop through each row
        rows.forEach(function (row) {
            var rowText = row.innerText.toLowerCase();
            var displayStyle = 'none';

            // If the search input is empty, show all results
            if (input === '') {
                displayStyle = '';
            } else {
                // Check if the row text includes the search input
                if (rowText.includes(input)) {
                    displayStyle = '';
                }
            }

            // Set the display style for the row
            row.style.display = displayStyle;
        });
    }
</script>

    <div id="content" class="success message"><?php if(isset($message)) { echo $message; } ?>
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
        setTimeout("delayDb()", 5000);
      }
    </script>

    <script>
        function deleteFromDrive() {
          document.getElementById('removeFromDrive').click();
        }

        function deleteClick() {
            document.getElementById('removeDb').click();
        }

        function delayDelete() {
            setTimeout("deleteClick()", 5000);
            $('#modal_remove').modal('hide');
        }
    </script>



    <script type="text/javascript" src="./js/gapi-upload.js"></script>
    <script async defer src="https://apis.google.com/js/api.js" onload="gapiLoaded()"></script>
    <script async defer src="https://accounts.google.com/gsi/client" onload="gisLoaded()"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-2.1.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  </body>
</html>