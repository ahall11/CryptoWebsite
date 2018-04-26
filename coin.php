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

<?php
  $query = "SELECT name
            FROM coin
            WHERE Symbol = '" . $_GET['symbol'] . "'";
  $result = pg_query($db, $query);
  $check = pg_fetch_row($result);
  if(!$check){
    ?>
    <br>
    <h2>There is currently no coin with the symbol, <?=$_GET['symbol']?>.</h2>
    <br><br>
    <h4>Here is the list of coin symbols:</h4>
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">Symbol</th>
          <th scope="col">Name</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $query = "SELECT c.Symbol,c.Name,c.Url,c.Max_supply,c.Current_supply,p.Price
                    FROM coin c, current_price p
                    WHERE c.Symbol = p.Symbol AND Purchase_Time = (SELECT MAX(Purchase_Time) FROM current_price p2 WHERE p.Symbol = p2.Symbol) ORDER BY c.Symbol";
          $result = pg_query($db, $query);
          while($row = pg_fetch_row($result)){
            ?>
            <tr class='clickable-row' data-href='coin.php?symbol=<?=$row[0]?>'>
              <td><?= $row[0] ?></td>
              <td><?= $row[1] ?></td>
            </tr>
            </input>
            <?php
          }
        ?>
      </tbody>
    </table>
    <?php
  }
  else{
?>

    <!-- Coin Title -->
    <?php
      $query = "SELECT Url,Name
                FROM coin
                WHERE Symbol = '" . $_GET['symbol'] . "'";
      $result = pg_query($db, $query);
      $url = pg_fetch_row($result);
    ?>
    <br>
    <h2><a href="<?=$url[0]?>"><?=$url[1]?></a></h2>
    <br>

    <!-- Members -->
    <h4>Team Members</h4>
    <table class="table table-sm">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">First</th>
          <th scope="col">Middle</th>
          <th scope="col">Last</th>
          <th scope="col">Position</th>
          <th scope="col">Year of Experience</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $query = "SELECT t.Fname, t.Mname, t.Lname, t.Position, t.Yrs_experience
                    FROM team_member t, coin c
                    WHERE t.Symbol = c.Symbol AND c.Symbol = '" . $_GET['symbol'] . "' ORDER BY t.Yrs_experience DESC";

          $result = pg_query($db, $query);
          $i = 1;
          while(($row = pg_fetch_row($result)) && ($i <=50)){
            ?>
            <tr>
              <th scope="row"><?= $i ?></th>
              <td><?= $row[0] ?></td>
              <td><?= $row[1] ?></td>
              <td><?= $row[2] ?></td>
              <td><?= $row[3] ?></td>
              <td><?= $row[4] ?></td>
            </tr>
            </input>
            <?php
            $i++;
          }
        ?>
      </tbody>
    </table>
    <br>

    <!-- Trades -->
    <h4>Most Recent Trades</h4>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Time</th>
          <th scope="col">Price</th>
          <th scope="col">Current Supply</th>
          <th scope="col">Exchange</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $query = "SELECT p.Purchase_Time,p.Price,c.Current_supply,e.Name,e.Url
                    FROM exchange e, current_price p, coin c
                    WHERE e.Url = p.Exchange_url AND c.Symbol = p.Symbol AND p.Symbol = '" . $_GET['symbol'] . "'" . " ORDER BY p.Purchase_Time DESC";
          // Sorting query


          $result = pg_query($db, $query);
          $i = 1;
          // Get past 50 trades
          while(($row = pg_fetch_row($result)) && ($i <=50)){
            ?>
            <tr>
              <th scope="row"><?= $i ?></th>
              <td><?= $row[0] ?></td>
              <td><?= $row[1] ?></td>
              <td><?= $row[2] ?></td>
              <td><a href="<?=$row[4]?>"><?= $row[3] ?></a></td>
            </tr>
            </input>
            <?php
            $i++;
          }
        ?>
      </tbody>
    </table>
    <?php
    }
    ?>

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
    </script>
  </body>
</html>
