<?php
 #require_once("assets/config/db.php");
 
 #set page, show, and sort in the URL
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

#get term from URL, split into array by spaces, 
#make SQL statement (concat database fields into long string and search if the term is within the string),
#add AND statements between, but break before the loop is over (no AND after last statement)
$term = $_GET["term"];
$terms = explode(" ", $term);
$sqlTerms ="";
$i = 0;
foreach($terms as $t) {
  $sqlTerms .= 'concat(product_BrandName, product_Title, product_Type, product_Tags) LIKE "%'.$t.'%"';
  $i += 1;
  if($i == count($terms)){
    break;
  } 
  $sqlTerms .= ' AND ';
}

#concat the SQL statement onto SELECT statement
$sql = 'SELECT * FROM PRODUCT_TABLE WHERE '.$sqlTerms;

#product_BrandName LIKE "%'.$term.'%" OR product_Title LIKE "%'.$term.'%" OR product_Type LIKE "%'.$term.'%"';

#save the final SQL statement so we can concat later (ORDER BY, LIMIT, ETC)
$sqlString = $sql;

#execute the SQL statement
$query = $pdo->prepare( $sql );
$query->execute();
$rowCount = $query->rowCount();
if($rowCount == 0 && strcmp($term, "") == 0) {
  $sql = 'SELECT * FROM PRODUCT_TABLE ';
  $query = $pdo->prepare( $sql );
  $query->execute();
  $rowCount = $query->rowCount();
}

#find the number of pages
$numberOfPages = ceil($rowCount/$show);

#index of first item to be shown on the page
$pageFirstResult = ($p - 1) * $show;

#check the sort value and change the SQL statement accordingly
if(strcmp($sort, "alpha") == 0) {
    $sql = $sqlString.'ORDER BY `product_Title` ASC LIMIT '.$pageFirstResult.' , '.$show ;
}
elseif (strcmp($sort, "priceAsc") == 0) {
    $sql = $sqlString.' ORDER BY product_BasePrice ASC LIMIT '.$pageFirstResult.' , '.$show;
}
elseif (strcmp($sort, "priceDesc") == 0) {
    $sql = $sqlString.' ORDER BY product_BasePrice DESC LIMIT '.$pageFirstResult.' , '.$show ;
}
elseif (strcmp($sort, "avail") == 0) {
$sql = $sqlString.' ORDER BY product_Quantity DESC LIMIT '.$pageFirstResult.' , '.$show;
}
elseif (strcmp($sort, "date") == 0) {
$sql = $sqlString.' ORDER BY date_Added DESC LIMIT '.$pageFirstResult.' , '.$show;
}
else {
    $sql = $sqlString.' LIMIT '.$pageFirstResult.' , '.$show;
}

$query = $pdo->prepare( $sql );
$query -> execute();
$result = $query->fetchAll( PDO::FETCH_ASSOC );

#make an object of each matching search results, and put them into an array of objects
$items = array();
$item = array();
//"description" => htmlentities($row['product_Description']),
foreach ($result as $row)
{
    $item = array("img" => htmlentities($row['image_Link']), "name" => htmlentities($row['product_Title']), "brand" => htmlentities($row['product_BrandName']), 
    "price" => htmlentities($row['product_BasePrice']), "id" => htmlentities($row['product_ID']),
    );
    array_push($items, $item);
}

?>

<?=template_header('Search');?>

    <style>
        .box:hover {
          border: 3px solid aquamarine;
        }
        .box{
          border: 3px solid transparent;
        }
    </style>
  
    <script src="assets/js/createItemBoxes.js"></script>
  
    <div class="ps-5 mt-5 mb-4 row">
        <div class="col-xl-2 col-4">
        <div class="dropdown float-end">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
          
          <?php
          #change what the sort button says based on what sort is set to
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
          elseif(strcmp($sort, "date") == 0) {
          echo "Date(from newest)";
          }
          else {
          echo "Select Sort By";
          }
          ?>
          
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
          
          <?php
          #compose the button options based on what sort is not set to currently
          
          if(strcmp($sort, "") != 0) {
            echo '<li><a class="dropdown-item" href="index.php?page=search&term='.$term.'&show='.$show.'">Select Sort By</a></li>';
          }
          if(strcmp($sort, "alpha") != 0) {
            echo '<li><a class="dropdown-item" href="index.php?page=search&term='.$term.'&sort=alpha&show='.$show.'">Alphabetical</a></li>';
          }
          if(strcmp($sort, "priceAsc") != 0) {
            echo '<li><a class="dropdown-item" href="index.php?page=search&term='.$term.'&sort=priceAsc&show='.$show.'">Price(low to high)</a></li>';
          }
          if(strcmp($sort, "priceDesc") != 0) {
            echo '<li><a class="dropdown-item" href="index.php?page=search&term='.$term.'&sort=priceDesc&show='.$show.'">Price(high to low)</a></li>';
          }
                    if(strcmp($sort, "date") != 0) {
            echo '<li><a class="dropdown-item" href="index.php?page=search&term='.$term.'&sort=date&show='.$show.'">Date(from newest)</a></li>';
          }
          if(strcmp($sort, "avail") != 0) {
            echo '<li><a class="dropdown-item" href="index.php?page=search&term='.$term.'&sort=avail&show='.$show.'">Availability</a></li>';
          }
          
          ?>
          </ul>
      </div>
      
      <div class="dropdown float-end me-2">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
          
          <?php
          #set what the show button says
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
          #compose show by list based on what show by is not set to currently
          
          if($show != 3) {
            echo '<li><a class="dropdown-item" href="index.php?page=search&term='.$term.'&sort='.$sort.'&show=3">Show 3 Items Per Page</a></li>';
          }
          if($show != 6) {
            echo '<li><a class="dropdown-item" href="index.php?page=search&term='.$term.'&sort='.$sort.'&show=6">Show 6 Items Per Page</a></li>';
          }
          if($show != 15) {
            echo '<li><a class="dropdown-item" href="index.php?page=search&term='.$term.'&sort='.$sort.'&show=15">Show 15 Items Per Page</a></li>';
          }
          if($show != 50) {
            echo '<li><a class="dropdown-item" href="index.php?page=search&term='.$term.'&sort='.$sort.'&show=50">Show 50 Items Per Page</a></li>';
          }
          
          ?>
          </ul>
      </div>
      
      
          </div>
            <div class="col-7 row" id="itemsDiv">
            <p class="text-left pb-2" id="header">
            
            <?php
            #echo the search results found for the term
            echo $rowCount.' search results found for "'.$term.'"';
            ?>
            </p>
            </div>   
          </div>   
  <script>
        //send the array of objects to js file to load onto the page in boxes  
        const itemsJSON = JSON.parse( '<?php echo json_encode($items) ?>' );
        showItems(itemsJSON);
    </script>
    
    <?php
    #show the item numbers on the current page
    echo '<div class="mb-4 row col-xl-7 offset-xl-2">';
    echo '<div class="col-xl-3 col-4 offset-xl-1">';
    if($rowCount > 0) {
      echo 'Showing items '.($p*$show-$show + 1).' - '.(min($p*$show,$rowCount) );
    }
 
    echo '</div>';
    
    echo '<div class="col-xl-3 col-5 ps-xl-5 ms-xl-5">';
    
    #show "First" and "<" for previous, if not on page 1
    if($p > 1) {
      echo '<a class="float-start me-2" href = "index.php?page=search&term='.$term.'&sort='.$sort.'&show='.$show.'&p=1"> First </a>';
      echo '<a class="float-start me-2" href = "index.php?page=search&term='.$term.'&sort='.$sort.'&show='.$show.'&p='.($p-1).'"> <i class="bi bi-chevron-left"></i> </a>';

    #show the current page number out of the total page number
    }
    if($numberOfPages > 0) {
      echo '<span class="float-start mx-2">(Page '.$p.'/'.$numberOfPages.')</span>';
    }

    #if not on the last page, show "Last" and ">" for next
    if($p < $numberOfPages) {
      echo '<a class="float-start ms-2" href = "index.php?page=search&term='.$term.'&sort='.$sort.'&show='.$show.'&p='.($p+1).'"><i class="bi bi-chevron-right"></i> </a>';
      echo '<a class="float-start ms-2" href = "index.php?page=search&term='.$term.'&sort='.$sort.'&show='.$show.'&p='.$numberOfPages.'"> Last</a>';      
    }
echo '</div>';
echo '</div>';
    
?>
    
<?=template_footer()?>


