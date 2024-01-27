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

$email = $user_info['email'];
$owner_email = $user_info['email'];

$user = 'root';
$password = '';

$database = 'cvsuaccr_db';

$servername = '127.0.0.1';
$mysqli = new mysqli($servername, $user,
    $password, $database);

// Checking for connections
if ($mysqli->connect_error) {
    die('Connect Error (' .
        $mysqli->connect_errno . ') ' .
        $mysqli->connect_error);
}


// Function to get user level
function getUserLevel() {
  global $user_info, $mysqli;

  // Assuming your users table has a 'user_level' column
  $email = $user_info['email'];
  $result = $mysqli->query("SELECT user_level FROM users WHERE email = '$email'");

  if ($result && $result->num_rows > 0) {
      $row = $result->fetch_assoc();
      return $row['user_level'];
  } else {
      // Default user level if not found
      return 0;
  }
}


// Pagination
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 5; // Number of rows per page set to 5
$offset = ($page - 1) * $limit; // Corrected offset calculation
$totalRecords = $mysqli->query("SELECT COUNT(*) as total FROM files WHERE file_directory = 'College of Medicine' && CURDATE() <= valid_until || file_directory = 'General' && CURDATE() <= valid_until ")->fetch_assoc()['total'];
$totalPages = ceil($totalRecords / $limit);

// Get the selected sorting option and order from the form
$sortOption = isset($_GET['sort']) ? $_GET['sort'] : 'id';
$order = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'DESC' : 'ASC';

// If sorting by date, add specific order by clause for date
if ($sortOption === 'upload_date') {
    // Check if the user selected the order by date old to new
    $dateOrder = ($order === 'desc') ? 'ASC' : 'DESC';

    $sql = "SELECT * FROM files WHERE file_directory = 'College of Medicine' && CURDATE() <= valid_until || file_directory = 'General' && CURDATE() <= valid_until ORDER BY STR_TO_DATE(upload_date, '%Y-%m-%d') $dateOrder LIMIT $limit OFFSET $offset";
} else {
    // For other columns
    $sql = "SELECT * FROM files WHERE file_directory = 'College of Medicine' && CURDATE() <= valid_until || file_directory = 'General' && CURDATE() <= valid_until ORDER BY $sortOption $order LIMIT $limit OFFSET $offset";
}

$result = $mysqli->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CvSU Accreditation Archive System</title>
    <link rel="stylesheet" type="text/css" href="styles/style5.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <style>
        .pagination {
          margin-left: 15px;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div id="main" class="main">
        <div class="box">
            <div class="profile-box">
            <div id="sidenav" style="<?php echo (getUserLevel() == 2) ? 'display:none;' : ''; echo (getUserLevel() == 3) ? 'display:none;' : '';?>">
                    <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
                </div>
                <div class="profile-boxx">
                    <div class="col-md-8">
		            <div class="alert alert-info" style="margin-top:10px;width:450px"> College of Medicine</div>
                <a href="#" id="authorizationButton" style="<?php echo (getUserLevel() == 3) ? 'display:none;' : '';?>" onclick="handleAuthClick()" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-plus"></span> Upload File </a>
                <input id="user-email" value="<?php echo $owner_email?>" hidden></input>
                 <!-- Add this form element to select sorting option and order -->
                 <form class="sort-form" method="GET">
    <label for="sort">Sort By:</label>
    <select class="form-select" name="sort" id="sort">
        <option value="id">ID</option>
        <option value="file_name">Name</option>
        <option value="file_owner">Owner</option>
        <option value="upload_date">Date Uploaded</option>
        <option value="valid_until">Validity</option>
        <option value="file_course">Course</option>
        <!-- Add more options based on your columns -->
    </select>

    <label for="order">Order:</label>
    <select class="form-select" name="order" id="order">
        <option value="asc">Ascending</option>
        <option value="desc">Descending</option>
    </select>

    <button type="submit" class="btn btn-primary">Sort</button>
</form>
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
                <a href="admin_dashboard.php" style="<?php echo (getUserLevel() != 0) ? 'display:none;' : ''; ?>">Profile</a>
                <a href="ido_dashboard.php" style="<?php echo (getUserLevel() != 1) ? 'display:none;' : ''; ?>">Profile</a>
                <a href="faculty_dashboard.php" style="<?php echo (getUserLevel() != 2) ? 'display:none;' : ''; ?>">Profile</a>
                <a href="profile.php" style="<?php echo (getUserLevel() != 3) ? 'display:none;' : ''; ?>">Profile</a>
                <a href="uploaded_files.php" style="<?php echo (getUserLevel() == 3) ? 'display:none;' : ''; ?>">Uploaded Files</a>
                <a href="outdated_files.php" style="<?php echo (getUserLevel() == 3) ? 'display:none;' : ''; ?>">Outdated Files</a>
                <a href="user_list.php" style="<?php echo (getUserLevel() != 0) ? 'display:none;' : ''; ?>">User List</a>
                <a href="logs.php" style="<?php echo (getUserLevel() != 0) ? 'display:none;' : ''; ?>">Activity Logs</a>
                <a href="#" data-toggle="modal" data-target="#logout">Sign Out</a>
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
            <th class="text-center">NAME</th>
            <th class="text-center" style="width: 125px;">OWNER</th>
            <th class="text-center">DATE UPLOADED</th>
            <th class="text-center">VALID UNTIL</th>
            <th class="text-center">COLLEGE</th>
            <th class="text-center">COURSE</th>
            <th class="text-center">TAGS</th>
            <th class="text-center" colspan="3">ACTIONS</th>
          </tr>
        </thead>
        <tbody>
        <?php
              while ($rows = $result->fetch_assoc()) {
                  $id = $rows['id'];
                  $fileId = $rows['file_id'];

                  // Convert upload_date to a timestamp
                  $dateUploaded = strtotime($rows["upload_date"]);

                  // Check if the file is older than 5 years
                  $isOlderThan5Years = (time() - $dateUploaded) > (5 * 365 * 24 * 60 * 60);

                  // Convert valid_until to a timestamp
                  $validUntil = strtotime($rows["valid_until"]);
                  
                  // Get the current date as a timestamp
                  $currentDate = strtotime(date("Y-m-d"));
                  
                  // Check if the file is outdated based on valid_until
                  $isOutdated = $currentDate > $validUntil;

                  // Use a class to set the text color based on the conditions
                  $rowClass = $isOlderThan5Years || $isOutdated ? 'color:red' : '';
              ?>

            <tr class="results" style="<?php echo $rowClass;?>">
              <td class="text-center"><?php echo $rows['id']; ?></td>
              <td class="text-center"><?php echo $rows['file_name']; ?></td>
              <td class="text-center"><?php echo $rows['file_owner'];?></td>
              <td class="text-center"><?php echo $rows['upload_date'];?></td>
              <td class="text-center"><?php echo $rows['valid_until'];?></td>
              <td class="text-center"><?php echo $rows['file_directory'];?></td>
              <td class="text-center"><?php echo $rows['file_course'];?></td>
              <td class="text-center">
                <?php
                $tags = explode(',', $rows['file_tags']);
                $cleanedTags = [];

                foreach ($tags as $tag) {
                    $tag = trim($tag);
                    if (!empty($tag)) {
                        // Remove "×" marks and extra commas
                        $tag = str_replace('×', '', $tag);
                        $cleanedTags[] = '' . htmlspecialchars($tag);
                    }
                }

                $formattedTags = implode(', ', $cleanedTags);
                echo rtrim($formattedTags, ' ');
                ?>
              </td>
              <td>
              <button class="btn btn-info btn-sm" onclick="copyLink('<?php echo $rows['file_viewLink'];?>')"><span class="glyphicon glyphicon glyphicon-copy"></span> Copy Link</button>
              <button class="btn btn-primary btn-sm" onclick="openLink('<?php echo $rows['file_viewLink'];?>')"><span class="glyphicon glyphicon-eye-open"></span> View</button>
                <button class="btn btn-success btn-sm" onclick="openLink('<?php echo $rows['file_downloadLink'];?>')"><span class="glyphicon glyphicon-download-alt"></span> Download</button>
                <?php
                  if ($rows['owner_email'] == $email) {
                  ?>
                  <button class="btn btn-danger btn-delete" type="button" onclick="handleAuthClick()" data-toggle="modal" data-target="#modal_remove" data-id="<?php echo $fileId;?>" style="<?php echo (getUserLevel() == 3) ? 'display:none;' : '';?>"><span class="glyphicon glyphicon-trash"></span> Remove</button>
                  <?php
                  }
                ?>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
<!-- Modified Pagination -->
<div class="pagination-container">
    <?php if ($page > 1): ?>
        <a href="?page=<?php echo $page - 1; ?>" class="pagination-link">Previous</a>
    <?php endif; ?>

    <div class="pagination-info">
        <span>Page <?php echo $page; ?> of <?php echo $totalPages; ?></span>
    </div>

    <?php if ($page < $totalPages): ?>
        <a href="?page=<?php echo $page + 1; ?>" class="pagination-link">Next</a>
    <?php endif; ?>

    <!-- Page input field -->
    <form action="" method="GET" class="pagination-form">
        <label for="pageInput" class="pagination-label">Go to Page:</label>
        <input type="number" id="pageInput" name="page" min="1" max="<?php echo $totalPages; ?>" value="<?php echo $page; ?>" class="pagination-input">
        <button type="submit" class="pagination-button">Go</button>
    </form>
</div>

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


          <!-- Modal Upload -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Upload File</h4>
        </div>
        <div class="modal-body">
        <form action="upload.php" method="POST" enctype="multipart/form-data" id="upload" onsubmit="return false;">
        <input type="file" name="file" id="fileInput" accept=".pdf, .docx, .png, .jpg, .jpeg">
        <br>
        <label for="directories">File Directory:</label>
          <div class="fixed-dropdown">
            <select name="directories" id="directories" onchange="updateCourseOptions();showCourse();" required>
                <option value=""></option>
                <option value="College of Medicine">College of Medicine</option>
                </select>
            </div>

            <br></br>
            <div class="courses" id="courses">
            <label for="course">Course :</label>
            <div class="fixed-dropdown">
              <select name="course" id="course">
                <option value=""></option>
              </select>
            </div>
          </div>

        <br><br>
        <label for="validUntil">Valid Until:</label>
        <input type="date" name="validUntil" id="validUntil" class="form-control">
        <br>
        <input type="hidden" name="tags" id="hiddenTagsInput" value="">
        <label for="tags">Tags (Press Enter to add a tag):</label>
        <div id="tagsInputContainer" style="display: flex; flex-wrap: wrap; gap: 5px; padding: 5px; border: 1px solid #ccc; border-radius: 5px;"></div>
        <input type="text" name="tagsInputVisible" id="tagsInput" class="form-control" placeholder="Enter tags..." onkeydown="handleTagInput(event)">
            </form>
        </div>
        <div class="modal-footer">
        <a href="#" id="uploadButton" onclick="uploadFile();dbUpload();" type="submit" value="Upload File" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-plus"></span> Upload </a>
        <a href="#"  class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-remove"></span> Cancel </a>
        </div>
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
          <p> Are you sure you want to sign out? </p>
        </div>
        <div class="modal-footer">
          <a href="./logout.php" class="btn btn-danger" >Sign out</a>
          <button type="button" class="btn btn-success" data-dismiss="modal"> Close </button>
        </div>
      </div>
    </div>
  </div>
</div>

    <!-- Modal Delete -->

    <div class="modal fade" id="modal_remove" aria-hidden="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">System</h3>
      </div>
      <div class="modal-body">
        <h4 class="text-danger">Are you sure you want to remove this file?</h4>
      </div>
      <div class="modal-footer">
        <a type="button" class="btn btn-success" data-dismiss="modal">No</a>
        <button type="button" class="btn btn-danger btn-del" data-dismiss="modal">Yes</button>
        <button class="remove-db" id="removeDb" type="button" hidden></button>
      </div>
    </div>
  </div>
</div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


  <script>
    function openLink(link) {
      window.open(link, "_blank");
    }

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

    function copyLink(link) {
      var viewLink = link;

      navigator.clipboard.writeText(viewLink);

      // Alert the copied text
      alert("Copied the link: " + viewLink);
    }

    function showCourse() {
      var directories = document.getElementById("directories").value;

      if (directories === "General") {
        document.getElementById("courses").style.display = "none";
      }
      else if (directories === "CAFENR") {
        document.getElementById("courses").style.display = "block";
      }
      else if (directories === "CAS") {
        document.getElementById("courses").style.display = "block";
      }
      else if (directories === "CCJ") {
        document.getElementById("courses").style.display = "block";
      }
      else if (directories === "CED") {
        document.getElementById("courses").style.display = "block";
      }
      else if (directories === "CEIT") {
        document.getElementById("courses").style.display = "block";
      }
      else if (directories === "CEMDS") {
        document.getElementById("courses").style.display = "block";
      }
      else if (directories === "CON") {
        document.getElementById("courses").style.display = "block";
      }
      else if (directories === "CSPEAR") {
        document.getElementById("courses").style.display = "block";
      }
      else if (directories === "CVMBS") {
        document.getElementById("courses").style.display = "block";
      }
      else if (directories === "College of Medicine") {
        document.getElementById("courses").style.display = "none";
      }
      else if (directories === "Graduate School and Open Learning College") {
        document.getElementById("courses").style.display = "block";
      }
      else {
        document.getElementById("courses").style.display = "none";
      }
    }

    function updateCourseOptions() {
      var selectedCollege = document.getElementById('directories').value;
      var courseDropdown = document.getElementById('course');
      courseDropdown.innerHTML = ''; // Clear existing options

      if (selectedCollege !== '') {
        var courses = getCourseOptions(selectedCollege);

        // Populate "Course" dropdown with options
        for (var i = 0; i < courses.length; i++) {
          var option = document.createElement('option');
          option.value = courses[i];
          option.text = courses[i];
          courseDropdown.add(option);
        }
      }
    }

    // Function to get course options based on selected college
    function getCourseOptions(college) {
      var courseOptions = {
          'CAFENR': ['Bachelor of Science in Agriculture', 'Bachelor of Science in Environmental Science', 'Bachelor of Science in Food Technology', 'Bachelor of Science in Land Use Design and Management', 'Bachelor in Agricultural Entrepreneurship', 'Certificate in Agricultural Science'],
          'CAS': ['Bachelor of Science in Biology', 'Bachelor of Arts in Journalism', 'Bachelor of Arts in English', 'Bachelor of Science in Psychology', 'Bachelor of Arts in Political Science', 'Bachelor of Science in Social Work', 'Bachelor of Science in Applied Mathematics (Major in Statistics)'], 
          'CCJ': ['Bachelor of Science in Criminology', 'Bachelor of Science in Industrial Security Administration'], 
          'CED': ['Bachelor of Secondary Education', 'Bachelor of Elementary Education', 'Bachelor of Hotel and Restaurant Management', 'Bachelor of Tourism Management'], 
          'CEMDS': ['Bachelor of Science in Office Administration', 'Bachelor of Science in Accountancy', 'Bachelor of Science in Business Administration', 'Bachelor of Science in Economics', 'Bachelor of Science in Development Management', 'Bachelor of Science in International Studies'], 
          'CEIT': ['Bachelor of Science in Agricultural and Biosystems Engineering', 'Bachelor of Science in Architecture', 'Bachelor of Science in Civil Engineering', 'Bachelor of Science in Computer Engineering', 'Bachelor of Science in Computer Science', 'Bachelor of Science in Electrical Engineering', 'Bachelor of Science in Electronics Engineering', 'Bachelor of Science in Industrial Engineering', 'Bachelor of Science in Industrial Technology', 'Bachelor of Science in Information Technology', 'Bachelor of Science in Office Administration'], 
          'CON': ['Bachelor of Science in Nursing', 'Bachelor of Science in Medical Technology', 'Bachelor of Science in Midwifery'], 
          'CSPEAR': ['Bachelor of Physical Education', 'Bachelor in Sports and Recreational Management'], 
          'CVMBS': ['Doctor of Veterinary Medicine', 'Bachelor of Science in Veterinary Technology', 'Bachelor of Science in Animal Health and Management', 'Bachelor of Science in Biomedical Science'], 
          'Graduate School and Open Learning College': ['Doctor of Philosophy in Agricultural', 'Doctor of Philosophy in Education', 'Doctor of Philosophy in Management', 'Master of Arts in Education', 'Master of Agriculture', 'Master of Engineering', 'Master in Information Technology', 'Master of Management', 'Master of Business Administration', 'Master of Professional Studies', 'Master of Science in Agriculture', 'Master of Science in Biology', 'Master of Science in Food Science'], 
        // Add options for other colleges
      };

      return courseOptions[college] || [];
    }

    function addTag(tag) {
      var tagsInputContainer = document.getElementById('tagsInputContainer');

      if (tag.trim() !== "") {
        var tagElement = document.createElement('span');
        tagElement.className = 'badge badge-primary';
        tagElement.style.marginRight = '5px';
        tagElement.style.padding = '5px 10px';
        tagElement.style.borderRadius = '10px';
        tagElement.style.background = '#5bc0de';
        tagElement.style.color = '#fff';
        tagElement.innerHTML = tag + '<span onclick="removeTag(this)" style="cursor: pointer; margin-left: 5px;">&times;</span>';

        tagsInputContainer.appendChild(tagElement);

        // Update the hidden input field with the current tags
        updateHiddenTagsInput();
      }
    }

    // Function to remove tag
    function removeTag(tagElement) {
      tagElement.parentNode.remove();
      // Update the hidden input field after removing a tag
      updateHiddenTagsInput();
    }

    // Function to update the hidden input field with the current tags
    function updateHiddenTagsInput() {
      var tagsInputContainer = document.getElementById('tagsInputContainer');
      var hiddenTagsInput = document.getElementById('hiddenTagsInput');
      var tags = [];

      // Get all tags from the visible tag elements
      tagsInputContainer.querySelectorAll('span').forEach(function (tagElement) {
        tags.push(tagElement.innerText.trim());
      });

      // Update the hidden input field value
      hiddenTagsInput.value = tags.join(',');
    }

      // Handle Enter key press in tags input
    function handleTagInput(event) {
      if (event.key === "Enter") {
        event.preventDefault(); // Prevent the default behavior (form submission)
        var tagsInput = document.getElementById('tagsInput');
        var tags = tagsInput.value.trim();

        // Remove any special characters except letters, numbers, and spaces
        tags = tags.replace(/[^a-zA-Z0-9\s]/g, '');

        // Remove extra spaces and split tags by space
        var tagArray = tags.split(/\s+/);

        // Filter out empty tags
        tagArray = tagArray.filter(tag => tag.trim() !== '');

        // Join tags with commas
        tags = tagArray.join(',');

        // Add the tag to the input
        addTag(tags);

        // Clear the input after adding tags
        tagsInput.value = "";

        // Update the hidden input field with the current tags
        updateHiddenTagsInput();
      }
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
        if (document.getElementById('directories').value == "") {
          alert('No file directory selected.');
        }
        else {
          document.getElementById('upload').submit();
        }
      }

      function dbUpload() {
        setTimeout("delayDb()", 3000);
      }
    </script>

    <script>
      var userEmail = document.getElementById('user-email').value;

      // Get the button and modal elements
      var openModalButton = document.querySelectorAll('.btn-delete');
      var modal = document.getElementById('modal_remove');
      var buttonInsideModal = document.querySelector('.btn-del');

      // Attach a click event listener to each button
      openModalButton.forEach(function(button) {
          button.addEventListener('click', function() {
            // Get the data-id attribute value of the clicked button
            var dataId = button.getAttribute('data-id');

            // Open the modal and pass the data-id
            showModalWithDataId(dataId);
          });
      });

      // Function to show the modal with data-id parameter
      function showModalWithDataId(dataId) {


        // Display or manipulate the modal as needed
        modal.style.display = 'block';

        // Attach a click event listener to the button inside the modal
      buttonInsideModal.addEventListener('click', function() {
        // Use the data-id inside the modal as needed
        deleteFile(userEmail,dataId);
        setTimeout(function() {
          removeFromDb(dataId);
        }, 3000);
      });
      }
      
      function deleteFromDrive() {
        document.getElementById('removeFromDrive').click();
      }

      function deleteClick() {
          document.getElementById('removeDb').click();
      }

      function delayDelete() {
          setTimeout("deleteClick()", 3000);
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