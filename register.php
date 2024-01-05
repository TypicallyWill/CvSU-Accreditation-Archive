<!DOCTYPE html>
<html lang="en">
 
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Access Required</title>
  <style>
    @import url(https://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600);
 
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
 
    body {
      font-weight: 300;
      font-size: 12px;
      color: #272727;
      background: linear-gradient(rgba(60, 60, 60), rgba(150, 150, 150));
      font-family: "Roboto", arial, sans-serif;
    }
 
    .container {
      max-width: 400px;
      width: 100%;
      margin: 0 auto;
      position: relative;
      margin-bottom: 340px;
    }
 
    #contact input {
      font: 400 12px/16px;
      border: 1px solid #CCC;
      background: #FFF;
      margin: 10 5px;
      padding: 10px;
      margin-right: 10px;
    }
 
    h1 {
      margin-bottom: 30px;
      font-size: 30px;
      font-family: "Roboto", arial, sans-serif;
    }
 
    #contactt {
      background: #F9F9F9;
      padding: 25px;
      margin: 50px 0;
    }

    .info1 {
      width: 320px;
    }
 
    fieldset {
      border: medium none !important;
      margin: 0 0 10px;
      padding: 0;
      -moz-box-sizing: border-box;
      -webkit-box-sizing: border-box;
      box-sizing: border-box;
    }

    .info {
      float: left;
      margin-right: 15px;
    }

    .request {
        cursor: default;
    }
 
    textarea {
      height: 100px;
      max-width: 100%;
      resize: none;
      width: 100%;
    }
 
    button {
      cursor: pointer;
      width: 100%;
      border: none;
      background: rgb(17, 146, 60);
      color: #FFF;
      margin: 0 0 5px;
      padding: 10px;
      font-size: 20px;
    }
 
    button:hover {
      background-color: rgb(15, 95, 42);
    }

    legend {
        margin:-10px 0;
        font-family: "Roboto", arial, sans-serif;
        font-size: 13px;
        margin-bottom: 0px;
    }
    select {
        width: 20vw;
        height: 3vh;
    }
    option {
        width: 100%
    }

    .college-selection {
      display: none;
    }
  </style>
</head>
 
<body>
  <div class="container">
    <div id="contactt">
    <form id="contact" action="mail.php" method="post">
      <h1>Access Request</h1>
 
      <fieldset>
        <input class="info1" placeholder="First Name" name="first_name" type="text" tabindex="1" id="first_name" onkeyup="copy()" autofocus required>
      </fieldset>
      <fieldset>
        <input class="info1" placeholder="Last Name" name="last_name" type="text" tabindex="1" id="last_name" onkeyup="copy()" autofocus required>
      </fieldset>
      <fieldset>
        <input class="info1" placeholder="Email Address" name="email" type="email" tabindex="2" id="email"  onkeyup="copy()"required>
      </fieldset>
      <fieldset>
        <legend class="user-level">Access as</legend>
            <select name="user_level" id="user_level" onchange="showCollege(); copy3();" required>
            <option value=""></option>
            <option value="1">IDO</option>
            <option value="2">Faculty</option>
            <option value="3">Student</option>
        </select>
      </fieldset>
      <div id="college-selection" class="college-selection">
      <fieldset>
        <legend class="college">College</legend>
            <select name="college" id="college" onchange="copy4()">
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
      </fieldset>
      </div>
      <fieldset>
        <input class="request" type="text" name="subject" tabindex="4" value="Request for System Access" readonly hidden>
      </fieldset>
      <fieldset>
        <button type="submit" name="send" id="contact-submit" onclick="dbSubmit()">Submit Now</button>
      </fieldset>
    </form>
    </div>

    <form id="dbContact" action="access_request.php" method="post" hidden>
      <input class="info1" type="text" name="firstname" id="firstname">
      <input class="info1" type="text" name="lastname" id="lastname">
      <input class="info1" type="email" name="user_email" id="user_email">
      <input name="user_access" type="text" id="user_access">
      <input name="user_college" type="text" id="user_college">
    </form>
  </div>

  <script>
    function showCollege() {
      var userLevel = document.getElementById("user_level").value;

      if (userLevel === "2") {
        document.getElementById("college-selection").style.display = "block";
      }
      else if (userLevel === "3") {
        document.getElementById("college-selection").style.display = "block";
      }
      else {
        document.getElementById("college-selection").style.display = "none";
      }
    }

    function copy() {
      var first_name = document.getElementById('first_name');
      var firstname = document.getElementById('firstname');
      firstname.value = first_name.value;
      var last_name = document.getElementById('last_name');
      var lastname = document.getElementById('lastname');
      lastname.value = last_name.value;
      var email = document.getElementById('email');
      var user_email = document.getElementById('user_email');
      user_email.value = email.value;
      var date = document.getElementById('date');
      var birthdate = document.getElementById('birthdate');
      birthdate.value = date.value;
    }

    function copy2() {
      var gender = document.querySelector('input[name="gender"]:checked');
      var user_gender = document.getElementById('user_gender');
      user_gender.value = gender.value;
    }

    function copy3() {
      var user_level = document.getElementById('user_level');
      var user_access = document.getElementById('user_access');
      var college = document.getElementById('college');
      var user_college = document.getElementById('user_college');
      user_access.value = user_level.value;
      if (user_access.value == 1) {
        college.value = " ";
        user_college.value = " ";
      }
    }

    function copy4() {
      var college = document.getElementById('college');
      var user_college = document.getElementById('user_college');
      user_college.value = college.value;
    }

    function dbSubmit() {
    var form1 = document.getElementById('dbContact');
    var formData1 = new FormData(form1);
    var form2 = document.getElementById('contact');
    var formData2 = new FormData(form2);

    var xhr1 = new XMLHttpRequest();
    xhr1.open('POST', 'access_request.php', true);
    xhr1.send(formData1);

    var xhr2 = new XMLHttpRequest();
    xhr2.open('POST', 'mail.php', true);
    xhr2.send(formData2);

    return true;
  }
  </script>
</body>
 
</html>