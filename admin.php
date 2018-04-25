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
        <a class="nav-link" href="admin.php">Admin</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0" action="coin.php">
      <input class="form-control mr-sm-2" type="search" name="symbol" onkeydown="upperCaseF(this)" placeholder="Coin Symbol" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>

<h1>Admin Panel</h1>
<?php
if($_POST['ChooseType']=="INSERT" && $_POST['ChooseTable'] && !$_POST['Edit']){
  ?>
  <h4><?=$_POST['ChooseType']?> Statement</h4>
  <form name="ExecuteQuery" method="post" action="admin.php">
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
      <input name="ChooseType2" type="hidden" value="<?=$_POST['ChooseType']?>">
      <input name="ChooseTable2" type="hidden" value="<?=$_POST['ChooseTable']?>">
      <input name="Password" type="hidden" value="comp163">
      <input name="Edit" type="hidden" value="INSERT">
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
<?php
}
elseif($_POST['ChooseType']=="DELETE" && $_POST['ChooseTable'] && !$_POST['Edit']){
  ?>
  <h4><?=$_POST['ChooseType']?> Statement</h4>
  <form name="ExecuteQuery" method="post" action="admin.php">
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
      <input type="radio" name="drop" value="deleteall">Drop Entire Table</input>
      <input name="ChooseType2" type="hidden" value="<?=$_POST['ChooseType']?>">
      <input name="ChooseTable2" type="hidden" value="<?=$_POST['ChooseTable']?>">
      <input name="Password" type="hidden" value="comp163">
      <input name="Edit" type="hidden" value="DELETE">
      <br>
      <br>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
<?php
}
elseif($_POST['ChooseType']=="SELECT" && $_POST['ChooseTable'] && !$_POST['Edit']){
  ?>
  <h4><?=$_POST['ChooseType']?> Statement</h4>
  <form name="ExecuteQuery" method="post" action="admin.php">
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
      <input name="ChooseType2" type="hidden" value="<?=$_POST['ChooseType']?>">
      <input name="ChooseTable2" type="hidden" value="<?=$_POST['ChooseTable']?>">
      <input name="Password" type="hidden" value="comp163">
      <input name="Edit" type="hidden" value="SELECT">
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
<?php
}
if($_POST['Edit'] == "INSERT"){
  $query = "SELECT column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME= '" . $_POST['ChooseTable2'] . "'";
  $result = pg_query($db, $query);
  $rows = pg_fetch_all($result);

  $query = "SELECT data_type FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME= '" . $_POST['ChooseTable2'] . "'";
  $result = pg_query($db, $query);
  $rows2 = pg_fetch_all($result);

  $query2 = $_POST['ChooseType2'] . " INTO " . $_POST['ChooseTable2'] . "(";
  $flag = 0;
  foreach($rows as $row){
    if(reset($rows) != $row && $flag){
      $query2 .= ",";
    }
    $flag = 0;
    foreach($row as $item){
      if($_POST[$item]){
        $query2 .= $item;
        $flag = 1;
      }
    }
  }
  $query2 = rtrim($query2,",");
  $query2 .= ") VALUES (";
  $flag = 0;
  foreach($rows as $key=>$row){
    $flag = 0;
    foreach($row as $key2=>$item){
      if($_POST[$item]){
        foreach($rows2[$key] as $test){
          if((strpos($test, 'character') !== false) || (strpos($test, 'timestamp') !== false)){
          $query2 .= "'";
          }
        }
        $query2 .= $_POST[$item];
        foreach($rows2[$key] as $test){
          if((strpos($test, 'character') !== false) || (strpos($test, 'timestamp') !== false)){
          $query2 .= "'";
          }
        }
        $flag = 1;
      }
    }
    if((end($rows) != $row) && $flag == 1){
      $query2 .= ",";
    }
  }
  $query2 = rtrim($query2,",");
  $query2 .= ");";
  print "Executed: " . $query2;
  $result = pg_query($db, $query2);
  if($result){
    print"Successful";
  }
  else{
    print"\nFailed:";
    print pg_last_error();
  }
}
elseif($_POST['Edit'] == "DELETE"){
  $query = "SELECT column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME= '" . $_POST['ChooseTable2'] . "'";
  $result = pg_query($db, $query);
  $rows = pg_fetch_all($result);

  $query = "SELECT data_type FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME= '" . $_POST['ChooseTable2'] . "'";
  $result = pg_query($db, $query);
  $rows2 = pg_fetch_all($result);

  $query2 = "DELETE FROM " . $_POST['ChooseTable2'] . " WHERE ";
  foreach($rows as $key=>$row){
    if(reset($rows) != $row && $flag){
      $query2 .= " AND ";
    }
    $flag = 0;
    foreach($row as $item){
      if($_POST[$item]){
        $query2 .= $item . " = ";
        foreach($rows2[$key] as $test){
          if(strpos($test, 'character') !== false){
          $query2 .= "'";
          }
        }
        $query2 .= $_POST[$item];
        foreach($rows2[$key] as $test){
          if(strpos($test, 'character') !== false){
          $query2 .= "'";
          }
        }
        $flag = 1;
      }
    }
  }
  $query2 = rtrim($query2," AND ") . ";";
  print "Executed: " . $query2;
  if($_POST['drop']=='deleteall'){
    $query2 = "DELETE FROM " . $_POST['ChooseTable2'] . ";";
  }
  $result = pg_query($db, $query2);
  if($result){
    print"Successful";
  }
  else{
    print"\nFailed:";
    print pg_last_error();
  }
}
elseif($_POST['Edit'] == "SELECT"){
 $query = "SELECT column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME= '" . $_POST['ChooseTable2'] . "'";
  $result = pg_query($db, $query);
  $rows = pg_fetch_all($result);

  $query = "SELECT data_type FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME= '" . $_POST['ChooseTable2'] . "'";
  $result = pg_query($db, $query);
  $rows2 = pg_fetch_all($result);

  $query2 = "SELECT * FROM " . $_POST['ChooseTable2'] . " WHERE ";
  foreach($rows as $key=>$row){
    if(reset($rows) != $row && $flag){
      $query2 .= " AND ";
    }
    $flag = 0;
    foreach($row as $item){
      if($_POST[$item]){
        $query2 .= $item . " = ";
        foreach($rows2[$key] as $test){
          if(strpos($test, 'character') !== false){
          $query2 .= "'";
          }
        }
        $query2 .= $_POST[$item];
        foreach($rows2[$key] as $test){
          if(strpos($test, 'character') !== false){
          $query2 .= "'";
          }
        }
        $flag = 1;
      }
    }
  }
  $query2 = rtrim($query2," AND ") . ";";
  print "Executed: " . $query2;
  if($_POST['drop']=='deleteall'){
    $query2 = "DELETE FROM " . $_POST['ChooseTable2'] . ";";
  }
  $result = pg_query($db, $query2);
  $rows = pg_fetch_all($result);
  if($result){
    print"Successful";
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
  else{
    print"\nFailed:";
    print pg_last_error();
  }
}

if((!$_POST['ChooseTable']) && ((!$_POST['Password']) || ($_POST['Password']) != "comp163")){
?>
<?php
if($_POST['Password']){
?>
<h4>WRONG PASSWORD RENTER</h4>
<?php
}
else{
?>
<h4>Enter Password</h4>
<?php
}
?>
<form name="Sigin" method="post" action="admin.php">
  <div class="form-group">
     <input type="password" class="form-control" id="exampleInputEmail1" name="Password" placeholder="Enter password">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<?php
}

if((!$_POST['ChooseTable']) && ($_POST['Password'] == "comp163")){
?>
<h4>Choose Query</h4>
<form name="ChoseQuery" method="post" action="admin.php">
  <div class="form-group">
    <label >Select Statement Type</label>
    <select class="form-control" id="exampleFormControlSelect1" name="ChooseType">
      <option>INSERT</option>
      <option>DELETE</option>
      <!-- <option>UPDATE</option> -->
      <option>SELECT</option>
    </select>
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">Select Table You Would Like to Work With</label>
    <select class="form-control" id="exampleFormControlSelect1" name="ChooseTable">
      <option>coin</option>
      <option>current_price</option>
      <option>exchange</option>
      <option>isateam</option>
      <option>price</option>
      <option>team_member</option>
    </select>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<?php
}
?>

<!-- Query entry box -->
<?php
if((!$_POST['ChooseTable']) && ($_POST['Password'] == "comp163")){
?>
<h4>Raw Query Tool</h4>
<form name="SQLQuery" method="post" action="admin.php">
  <div class="form-group">
    <textarea class="form-control" name="SQLString" id="exampleFormControlTextarea1" rows="3"></textarea>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<?php
}

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
    <!-- Uppercase for search -->
    <script>
    function upperCaseF(a){
      setTimeout(function(){
          a.value = a.value.toUpperCase();
      }, 1);
    }
    </script>
  </body>
</html>

