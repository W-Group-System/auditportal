<!DOCTYPE html>
<html lang="en">
<head>
  <title>Whistle Blower</title>
  <meta charset="utf-8">
  <link rel="shortcut icon" href="{{ URL::asset('images/icon.png')}}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
    .loader {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('login_css/img/loader.gif') }}") 50% 50% no-repeat white;
        opacity: .8;
        background-size: 120px 120px;
    }

</style>
</head>
<body>
<div id="loader" style="display:none;" class="loader">
</div>

<form method='post' action='{{url('new-whistle')}}' onsubmit='show();' class="form-horizontal"  enctype="multipart/form-data" >
@csrf
<div class="container">
    <h2>WHISTLEBLOWER REPORT</h2>
      <label for="issue">Issue:</label>
      <textarea  class="form-control" id='issue' placeholder="Issue" name="issue" required></textarea>

      <label for="pwd">Name of Respondent:</label>
      <input type="text" class="form-control" id="pwd" placeholder="(an alleged employee who is the subject of the report filed by the whistleblower)" name="name_of_respondent" required>
   
      <label for="department">Department of Respondent:</label>
      <input type="text" class="form-control" id="department" placeholder="Department of Respondent" name="department" required>

      <label for="risk">Risk:</label>
      <select class='form-control' id='risk' name='risk' required>
        <option value=''> </option>
        <option value='High'>High</option>
        <option value='Medium'>Medium</option>
        <option value='Low'>Low</option>
      </select>
      <label for="date_of_incident">Date of Incident:</label>
      <input type="date" class="form-control" id="date_of_incident" max='{{date('Y-m-d')}}' name="date_of_incident" required>

      <label for="proof">Proof:</label>
      <input type="file" class="form-control" id="proof"  name="proof[]" multiple required>

  
        <label for="name_of_whistleblower">Name of Whistleblower:</label>
        <input type="text" class="form-control" id="name_of_whistleblower" placeholder="(an employee who informs on a person or organization engaged in an illicit activity)" name="name_of_whistleblower" required>
     <br>
        <div class='row'>
    <div class='col-md-12'> <button type="submit" class="btn btn-info">Submit</button></div>
       
     </div>

</div>
</form>
@include('sweetalert::alert')
<script>
    function show() {
        document.getElementById("loader").style.display = "block";
    }
</script>
</body>
</html>
