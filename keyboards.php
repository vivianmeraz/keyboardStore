<?php
 #require_once("assets/config/db.php");

if(!isset($_GET['p']) ) {
   $p = 1;
} else {
   $p = $_GET['p'];
}

if(!isset($_GET['show']) ) {
   $show = 6;
} else {
   $show = $_GET['show'];
}

if(!isset($_GET['sort']) ) {
   $sort = "";
} else {
   $sort = $_GET['sort'];
}

$resultsPerPage = $show;

$sql = "SELECT * FROM PRODUCT_TABLE WHERE product_Type = 'keyboard'";
$query = $pdo->prepare( $sql );
$query->execute();
$rowCount = $query->rowCount();
$numberOfPages = ceil($rowCount/$resultsPerPage);


$pageFirstResult = ($p - 1) * $resultsPerPage;

if(strcmp($sort, "alpha") == 0) {
    $sql = "SELECT * FROM PRODUCT_TABLE WHERE product_Type = 'keyboard' ORDER BY `product_Title` ASC LIMIT $pageFirstResult , $show ";
}
elseif (strcmp($sort, "priceAsc") == 0) {
    $sql = "SELECT * FROM PRODUCT_TABLE WHERE product_Type = 'keyboard' ORDER BY product_BasePrice ASC LIMIT $pageFirstResult , $show ";
}
elseif (strcmp($sort, "priceDesc") == 0) {
    $sql = "SELECT * FROM PRODUCT_TABLE WHERE product_Type = 'keyboard' ORDER BY product_BasePrice DESC LIMIT $pageFirstResult , $show ";
}
elseif (strcmp($sort, "avail") == 0) {
$sql = "SELECT * FROM PRODUCT_TABLE WHERE product_Type = 'keyboard' ORDER BY product_Quantity LIMIT $pageFirstResult , $show ";
}
else {
    $sql = "SELECT * FROM PRODUCT_TABLE WHERE product_Type = 'keyboard' LIMIT $pageFirstResult , $resultsPerPage ";
}

$query = $pdo->prepare( $sql );
$query -> execute();
$result = $query->fetchAll( PDO::FETCH_ASSOC );

$keyboards = array();
$keyboard = array();

//"description" => htmlentities($row['product_Description']),
foreach ($result as $row)
{
    $keyboard = array("img" => htmlentities($row['image_Link']), "name" => htmlentities($row['product_Title']), "brand" => htmlentities($row['product_BrandName']), 
    "price" => htmlentities($row['product_BasePrice']), 
    );
    array_push($keyboards, $keyboard);
}

?>

<?=template_header('Keyboards');?>

    <script src="assets/js/createItemBoxes.js"></script>

    <div class="ps-5 mt-5 mb-4 row">
        <div class="col-2">
        <div class="dropdown float-end">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
          <?php
          if(strcmp($sort, "alpha") == 0) {
            echo "Alphabetical";
          }
          elseif(strcmp($sort, "priceAsc") == 0) {
          echo "Price(low to high)";
          }
          elseif(strcmp($sort, "priceDesc") == 0) {
          echo "Price(high to low)";
          }
          elseif(strcmp($sort, "avail") == 0) {
          echo "Availability";
          }
          else {
          echo "Select Sort By";
          }
          ?>
          
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
          <?php
          
          if(strcmp($sort, "") != 0) {
            echo '<li><a class="dropdown-item" href="index.php?page=keyboards">Select Sort By</a></li>';
          }
          if(strcmp($sort, "alpha") != 0) {
            echo '<li><a class="dropdown-item" href="index.php?page=keyboards&sort=alpha&show='.$show.'">Alphabetical</a></li>';
          }
          if(strcmp($sort, "priceAsc") != 0) {
            echo '<li><a class="dropdown-item" href="index.php?page=keyboards&sort=priceAsc&show='.$show.'">Price(low to high)</a></li>';
          }
          if(strcmp($sort, "priceDesc") != 0) {
            echo '<li><a class="dropdown-item" href="index.php?page=keyboards&sort=priceDesc&show='.$show.'">Price(high to low)</a></li>';
          }
          if(strcmp($sort, "avail") != 0) {
            echo '<li><a class="dropdown-item" href="index.php?page=keyboards&sort=avail&show='.$show.'">Availability</a></li>';
          }
          
          ?>
          </ul>
      </div>
      
      <div class="dropdown float-end me-2">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
          <?php
          if($show == 3) {
            echo "Show By 3";
          }
          elseif($show == 6) {
          echo "Show By 6";
          }
          elseif($show == 15) {
          echo "Show By 15";
          }
          elseif($show == 50) {
          echo "Show By 50";
          }
          else {
          echo "Select Show By";
          }
          ?>
          
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
          <?php
          
          if($show != 3) {
            echo '<li><a class="dropdown-item" href="index.php?page=keyboards&sort='.$sort.'&show=3">Show By 3</a></li>';
          }
          if($show != 6) {
            echo '<li><a class="dropdown-item" href="index.php?page=keyboards&sort='.$sort.'&show=6">Show By 6</a></li>';
          }
          if($show != 15) {
            echo '<li><a class="dropdown-item" href="index.php?page=keyboards&sort='.$sort.'&show=15">Show By 15</a></li>';
          }
          if($show != 50) {
            echo '<li><a class="dropdown-item" href="index.php?page=keyboards&sort='.$sort.'&show=50">Show By 50</a></li>';
          }
          
          ?>
          </ul>
      </div>
      
      
          </div>
            <div class="col-7 row" id="itemsDiv">
            <h2 class="text-left pb-2" id="header">Keyboards</h2>
            </div>
            <div class="col-2 px-5 pt-4 pb-2">
            <div class="w-100 border-bottom pt-4">
            <h5>
    Keyboard Brands
    </h5>
  </div>
  <div class="card-body p-0 pt-2">
  Perixx<br>
  Keychron<br>
  Redragon<br>
  Acer<br>
    Apex<br>
    Steel Series<br>
  </div>
</div>
            </div>
          </div>   
  <script>
        const keyboardsJSON = JSON.parse( '<?php echo json_encode($keyboards) ?>' );
        showItems(keyboardsJSON);
    </script>
    
    <?php
    
    echo '<div class="mb-4 row col-7 offset-2">';
    echo '<div class="col-3 offset-1">';
    echo 'Showing items '.($p*$resultsPerPage-$resultsPerPage + 1).' - '.(min($p*$resultsPerPage,$rowCount) );
    echo '</div>';
    
    echo '<div class="col-3 ps-5 ms-5">';
    
    if($p > 1) {
      echo '<a class="float-start me-2" href = "index.php?page=keyboards&sort='.$sort.'&show='.$show.'&p=1"> First </a>';
      echo '<a class="float-start me-2" href = "index.php?page=keyboards&sort='.$sort.'&show='.$show.'&p='.($p-1).'"> <i class="bi bi-chevron-left"></i> </a>';

    }
    echo '<span class="float-start mx-2">(Page '.$p.'/'.$numberOfPages.')</span>';


    if($p < $numberOfPages) {
      echo '<a class="float-start ms-2" href = "index.php?page=keyboards&sort='.$sort.'&show='.$show.'&p='.($p+1).'"><i class="bi bi-chevron-right"></i> </a>';
      echo '<a class="float-start ms-2" href = "index.php?page=keyboards&sort='.$sort.'&show='.$show.'&p='.$numberOfPages.'"> Last</a>';      
    }
echo '</div>';
echo '</div>';
    
?>
    
<?=template_footer()?>


