<?php
include("database.php");
if (!$db) {
  echo "A connection error occurred.\n";
  exit;
}
error_reporting(0);
?>
<!-- Bootstrap stuff -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

<!-- Nav Bar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php">Crypto Market</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="query.php">Query</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admin.php">Admin</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0" action="coin.php">
      <input class="form-control mr-sm-2" type="search" name="symbol" onkeydown="upperCaseF(this)" placeholder="Coin Symbol" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>

<!-- Query INFO -->
<br><h3>Get All Trade Transactions</h3><br>

<!--  -->
    <?php
    $query = "SELECT column_name,data_type FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME= '" . $_POST['ChooseTable'] . "'";
    $result = pg_query($db, $query);
    while($item = pg_fetch_row($result)){
      ?>
        <div class="form-group">
          <label >Enter <?=$item[0]?></label>
          <input type="text" class="form-control" placeholder="Type: <?=$item[1]?>" name="<?=$item[0]?>">
        </div>
      <?php
    }
    ?>
<!--  -->
<form>
  <div class="form-group">
    <label for="coin">Select coin(s)</label>
    <select multiple class="form-control" id="exampleSelect2" name="Qcoin[]" size="8">
      <option value="All" selected='selected'>All Coins</option>
      <?php
      $query = "SELECT Symbol FROM coin";
      $result = pg_query($db, $query);
      while($item = pg_fetch_row($result)){
        ?>
        <option><?=$item[0]?></option>
        <?php
      }
      ?>
    </select>
  </div>
  <div class="form-group">
    <label for="exampleSelect2">Select exchange(s)</label>
    <select multiple class="form-control" id="exampleSelect2" name="Qexchange[]" size="5">
      <option value="All" selected='selected'>All Exchanges</option>
      <?php
      $query = "SELECT Name FROM exchange";
      $result = pg_query($db, $query);
      while($item = pg_fetch_row($result)){
        ?>
        <option><?=$item[0]?></option>
        <?php
      }
      ?>
    </select>
  </div>
  <div class="form-group">
    <label for="exampleSelect2">Enter minimum value of coin</label>
    <input type="text" class="form-control" id="exampleInputEmail1" name="Qmin" placeholder="Enter min price" value=0>
  </div>
  <div class="form-group">
    <label for="exampleSelect2">Enter maximum value of coin</label>
    <input type="text" class="form-control" id="exampleInputEmail1" name="Qmax" placeholder="Enter max price" value=10000000000>
  </div>
  <button type="submit" class="btn btn-primary" onclick='this.form.action="results.php";'>Submit</button>
</form>


<!-- Bootstrap stuff -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
<!-- Uppercase for search -->
<script>
function upperCaseF(a){
  setTimeout(function(){
    a.value = a.value.toUpperCase();
  }, 1);
}
function handleClickAction(formElement) {
href = "coin.php";
formElement.submit();
}
</script>
</body>
</html>
