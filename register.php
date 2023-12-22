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
      line-height: 30px;
      color: #272727;
      background-color: #616161;
      font-family: "Roboto", arial, sans-serif;
    }
 
    .container {
      max-width: 400px;
      width: 100%;
      margin: 0 auto;
      position: relative;
    }
 
    #contact input {
      font: 400 12px/16px;
      width: 100%;
      border: 1px solid #CCC;
      background: #FFF;
      margin: 10 5px;
      padding: 10px;
    }
 
    h1 {
      margin-bottom: 30px;
      font-size: 30px;
      font-family: "Roboto", arial, sans-serif;
    }
 
    #contact {
      background: #F9F9F9;
      padding: 25px;
      margin: 50px 0;
    }
 
 
    fieldset {
      border: medium none !important;
      margin: 0 0 10px;
      padding: 0;
      -moz-box-sizing: border-box;
      -webkit-box-sizing: border-box;
      box-sizing: border-box;
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
  </style>
</head>
 
<body>
  <div class="container">
    <form id="contact" action="mail.php" method="post">
      <h1>Access Request</h1>
 
      <fieldset>
        <input placeholder="Name" name="name" type="text" tabindex="1" autofocus>
      </fieldset>
      <fieldset>
        <input placeholder="Email Address" name="email" type="email" tabindex="2">
      </fieldset>
      <fieldset>
        <legend class="birthdate">Birthdate</legend>
            <input name="birthdate" type="date" id="date">
      </fieldset>
      <fieldset>
        <legend class="college">College</legend>
            <select name="college">
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
      <fieldset>
        <input class="request" type="text" name="subject" tabindex="4" value="Request for System Access" readonly>
      </fieldset>
 
      <fieldset>
        <button type="submit" name="send" id="contact-submit">Submit Now</button>
      </fieldset>
    </form>
  </div>
</body>
 
</html>