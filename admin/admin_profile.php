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
?>
<<!DOCTYPE html>
<html>
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>CvSU Accreditation Archive System</title>
        <link rel="stylesheet" type="text/css" href="styles/style4.css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    </head>
  <body>

    <div class="container">

      <div class="nav-bar">
        <img src="images/cvsu-logo.png" class="logo">
          <p class="title">CvSU Accreditation Archive System - Admin</p>
        <div class="menu" style=>
          <button class="menu-button">
            <img src="<?=$user_info['picture'];?>" referrerpolicy="no-referrer" class="menu-icon">
          </button>
          <div class="menu-content">
            <a href="profile.php">Profile</a>
            <a href="uploaded_files.php">Uploaded Files</a>
            <a href="#" data-toggle="modal" data-target="#logout">Sign out</a>
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

        <div id="sidenav">
          <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
        </div>
      </div>

      <div id="main" class="main">
        <div class="profile-box">
          <div class="profile-info">
            <br></br>
          <ul>
            <li><img src="<?=$user_info['picture'];?>" referrerpolicy="no-referrer"></li>
            <li><strong>ID:</strong> <?=$user_info['id'];?></li>
            <li><strong>Full Name:</strong> <?=$user_info['givenName'];?> <?=$user_info['familyName'];?></li>
            <li><strong>Email:</strong> <?=$user_info['email'];?></li>
          </ul>
          <br></br>
          <div class="upload-file">
              <a href="#" id="authorizationButton" onclick="handleAuthClick()" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-plus"></span> Add File </a>
          </div>
        </div>
      </div>


 <!-- Modal -->
 <div class="modal fade" id="myModal" role="dialog" style="min-width: 1500px">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Upload File</h4>
        </div>
        <div class="modal-body">
        <form action="upload.php" method="POST" enctype="multipart/form-data" id="upload" onsubmit="return false;">
        <input type="file" name="file" id="fileInput" accept=".pdf, .docx, .png, .jpg, .jpeg">
        <label for="directories">File Directory:</label>
        <select name="directories" id="directories">
        <option value=""></option>
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

        <br></br>
        <label for="area">File Area:</label>
        <select name="area" id="area">
              <option value=""></option>
              <option value="Area 1">Vison, Mission, Goals and Objective</option>
							<option value="Area 2">Faculty</option>
							<option value="Area 3">Curricular</option>
							<option value="Area 4">Support to Students</option>
							<option value="Area 5">Research</option>
							<option value="Area 6">Extension and Community Involvement</option>
							<option value="Area 7">Library</option>
							<option value="Area 8">Physical Plan and Facilities</option>
							<option value="Area 9">Laboratories</option>
							<option value="Area 10">Administration</option>
        </select>
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
 <div class="modal fade" id="logout" role="dialog" style="min-width: 1500px">
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <div id="content" class="success message"><?php if(isset($message)) { echo $message; } ?>
    </div>

    <script>
      function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
        document.getElementById("sidenav").style.marginLeft = "250px";
        document.getElementById("main").style.marginLeft = "250px";
      }
    
      function closeNav() {	
        document.getElementById("mySidenav").style.width = "0";
        document.getElementById("sidenav").style.marginLeft= "0";
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