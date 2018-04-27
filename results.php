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

<!-- Result Stuff -->
<br><h3>Query Results:</h3><br>

<?php
  $coins = $_GET["Qcoin"];
  $exchanges = $_GET["Qexchange"];
  $min = $_GET["Qmin"];
  $max = $_GET["Qmax"];

  $query = "SELECT p.Symbol, p.Purchase_Time, p.Price, p.Volume, e.Name, e.Url
            FROM coin c, exchange e, current_price p
            WHERE (c.Symbol = p.Symbol AND e.Url = p.Exchange_url) AND (";
  foreach($coins as $index=>$coin){
    if($coin === "All"){
      break;
    }
    $query .= "c.Symbol = '" . $coin . "'";
    if($coins[$index+1]){
      $query .= " OR ";
    }
    else{
      $query .= ") ";
    }
  }
  $query .= "AND ( ";
  foreach($exchanges as $index=>$exchange){
    if($exchange === "All"){
      $query = rtrim($query, "AND ( ");
      break;
    }
    $query .= "e.Name = '" . $exchange . "'";
    if($exchanges[$index+1]){
      $query .= " OR ";
    }
    else{
      $query .= ") ";
    }
  }
  $query .= " AND ( ";
  $query .= "p.Price > $min AND p.Price < $max";
  $query .= ");";
  $result = pg_query($db, $query);
  ?>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Symbol</th>
        <th scope="col">Purchase Time</th>
        <th scope="col">Price</th>
        <th scope="col">Volume</th>
        <th scope="col">Exchange Name</th>
      </tr>
    </thead>
    <tbody>
  <?php
  $i = 1;
  while($item = pg_fetch_row($result)){
    ?>
      <tr>
        <th scope="row"><?=$i?></th>
        <td><?=$item[0]?></td>
        <td><?=$item[1]?></td>
        <td><?=$item[2]?></td>
        <td><?=$item[3]?></td>
        <td><?=$item[4]?></td>
      </tr>
    <?php
    $i++;
  }
  ?>
    </tbody>
  </table>

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
