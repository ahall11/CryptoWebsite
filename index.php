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

<br>
<h3>Top Crypto Currency Coins</h3>
<br>
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col"><a href="index.php?sort=symbol">Symbol</a></th>
      <th scope="col"><a href="index.php?sort=name">Name</a></th>
      <th scope="col"><a href="index.php?sort=mcap">Market Cap</th>
      <th scope="col"><a href="index.php?sort=price">Price</a></th>
      <th scope="col"><a href="index.php?sort=csupply">Current Supply</a></th>
      <th scope="col"><a href="index.php?sort=msupply">Max Supply</a></th>
    </tr>
  </thead>
  <tbody>
    <?php
      $query = "SELECT c.Symbol,c.Name,c.Url,c.Max_supply,c.Current_supply,p.Price
                FROM coin c, current_price p
                WHERE c.Symbol = p.Symbol AND Purchase_Time = (SELECT MAX(Purchase_Time) FROM current_price p2 WHERE p.Symbol = p2.Symbol)";
      if ($_GET['sort'] == 'symbol'){
        $query .= " ORDER BY c.Symbol";
      }
      elseif($_GET['sort'] == 'name'){
        $query .= " ORDER BY c.Name";
      }
      elseif($_GET['sort'] == 'price'){
        $query .= " ORDER BY p.Price DESC";
      }
      elseif($_GET['sort'] == 'csupply'){
        $query .= " ORDER BY c.Current_supply=0, c.Current_supply DESC";
      }
      elseif($_GET['sort'] == 'msupply'){
        $query .= " ORDER BY c.Max_supply=0, c.Max_supply DESC";
      }
      elseif($_GET['sort'] == 'mcap'){
        $query .= " ORDER BY (c.Current_supply * p.Price)=0, (c.Current_supply * p.Price) DESC";
      }
      else{
        $query .= " ORDER BY (c.Current_supply * p.Price)=0, (c.Current_supply * p.Price) DESC";
      }
      $result = pg_query($db, $query);
      $i = 1;
      while($row = pg_fetch_row($result)){
        $mc=$row[4]*$row[5];
        if(!$row[3]){
          $row[3]=0;
        }
        if(!$row[4]){
          $row[4]=0;
        }
        ?>
        <tr class='clickable-row' data-href='coin.php?symbol=<?=$row[0]?>'>
          <th scope="row"><?= $i ?></th>
          <td><?= $row[0] ?></td>
          <td><?= $row[1] ?></td>
          <td><?= $mc?></td>
          <td><?= $row[5] ?></td>
          <td><?= $row[4] ?></td>
          <td><?= $row[3] ?></td>
        </tr>
        </input>
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
    <!-- Clicking on row -->
    <script>
      jQuery(document).ready(function($) {
      $(".clickable-row").click(function() {
          window.location = $(this).data("href");
        });});
    </script>
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


