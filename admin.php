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

<h1>Admin Panel</h1>
<form name="SQLQuery" method="post" action="admin.php">
  <div class="form-group">
    <label for="exampleFormControlTextarea1">SQL Query</label>
    <textarea class="form-control" name="SQLString" id="exampleFormControlTextarea1" rows="3"></textarea>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

<?php
if($_POST['SQLString']){
  $query = $_POST['SQLString'];
  $result = pg_query($db, $query);
  $rows = pg_fetch_all($result);
  ?>
  <h4>Query Result:</h4>
  <?php
  if(strpos($query, 'SELECT') !== false){
  ?>
  <ul>
    <?php
    foreach($rows as $row){
      ?>
      <li>
      <?php
      $listitem="";
      foreach($row as $item){
        $listitem .= $item . ", ";
      }
      ?>
      <?=$listitem?>
      </li>
      <?php
    }
    ?>
  </ul>
  <?php
  }
  elseif(strpos($query, 'INSERT') !== false){
    ?>
    <p>Successfully inserted statement: <?=$query?></p>
    <?php
  }
  elseif(strpos($query, 'DELETE') !== false){
    ?>
    <p>Successfully deleted statement: <?=$query?></p>
    <?php
  }
}
?>

    <!-- Bootstrap stuff -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
  </body>
</html>

