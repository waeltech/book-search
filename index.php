<?php
include("includes/header.inc.php");
echo header1("Home Page");
include("includes/nav.inc.php");

//connection to the database
include("config.php");
$conn=ConnectionFactory::connect();
$dosearch = false;

$results = array();
$search_term = "";
if ( isset( $_GET['search_for'] ) ) {

$search_term = $_GET['search_for']; // getting the value from the user
}



?>
<div class="container">
<div id="search"> 
<form action="" method="GET">
 
     <h2> Search by Book Name - ISBN or Author </h2>
    <label for="search-field">Search</label>
          <input type="search" name="search_for" placeholder="Enter your search term..." results="5" value="<?php echo $search_term; ?>">
          <p class="error">
          <?php
          if ( isset( $_GET['search_for'] ) ) {

               $search_term = $_GET['search_for']; // getting the value from the user
               $count = mb_strlen( $search_term );
               if ($search_term == "")
               {
                    $dosearch = false;
                    echo "please enter a book title, ISBN or author name to start search";
               }
               else if ($count < 3)
               {
                  echo "please make sure you write more than 2 characters";
                            $dosearch = false;
   
               }
               else {
                  $dosearch = true;
               }
          }
            ?>
          </p>
          <input type="submit" class ="btn-1" value="Search">
        <br/>
</form>
</div>
<div id="result"> <?php
//Check if search data was submitted
// ******************************************************************************** getting the value from the database **********************************************************************  
if ( isset( $_GET['search_for'] ) ) {
 // Include the search class
  require_once( "classes/books.class.php");
  
  
 if ($dosearch == true) {
 // Store search term into a variable
 $search_term = $_GET['search_for']; // getting the value from the user
                    // How many items to list per page
                    $limit = 2;
                    // Find out how many items are in the table
                    $total = $conn->query("SELECT COUNT(*) AS num FROM book
                                        INNER JOIN authorbook ON book.isbn = authorbook.isbn
                                        INNER JOIN author ON authorbook.author_id = author.author_id
                                        WHERE book.title LIKE '%$search_term%'
                                        OR book.isbn LIKE '%$search_term%'
                                        OR author.f_name LIKE  '%$search_term%'
                                        OR author.l_name LIKE  '%$search_term%'")->fetchColumn();
                    // working out How many pages
                    $pages = ceil($total / $limit);

                    // What page are we currently on?
                    $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
                        'options' => array(
                        'default'   => 1,
                        'min_range' => 1,
                        ),
                    )));
                    // Calculate the offset for the query
                    $offset = ($page - 1) * $limit;
                    
                    // Some information to display to the user
                    $start = $offset + 1;
                    $end = min(($offset + $limit), $total);
                    
     // select book table and join the rest of tables to book table.
     $query = "SELECT DISTINCT * FROM book
     INNER JOIN authorbook ON book.isbn = authorbook.isbn
     INNER JOIN author ON authorbook.author_id = author.author_id 
     WHERE book.title LIKE  :search_term OR book.isbn LIKE  :search_term OR author.f_name LIKE  :search_term OR author.l_name LIKE  :search_term
     ORDER BY title DESC
     LIMIT :limit
     OFFSET :offset  
     ";
     $stmt = $conn->prepare($query);
     $stmt->bindValue(':search_term',"%$search_term%");  //bind the value to search tearm like
     $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
     $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
     $stmt->execute();
     
     if ($total == 0) {
         echo "<p class='error'> No result found, please try another searh term</p>";
     }
     else {
               echo "<p class='found'> we found $total books matchs our record </p>"; // show number of books matchs found
     }
     
     while ($result1 = $stmt->fetchObject()) {              // generate the link for each record 
          echo "<div class='item'>";
          echo "<p><a href=details.php?id=$result1->isbn> <img src=images/books/$result1->isbn> $result1->title </a> </p>";
          echo "</div>";

     }
     if ($pages > 1 ) {  // if the number of pages is more than 1 show the paging mechanisem 
     // The "back" link
      $prevlink = ($page > 1) ? '<a href="?page=1&search_for='.$search_term.'" title="First page">&laquo;</a> <a href="?page=' . ($page - 1). ' & search_for='.$search_term.'" title="Previous page">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';

      // The "forward" link
      $nextlink = ($page < $pages) ? '<a href="?page=' . ($page + 1) . '&search_for='.$search_term.'" title="Next page">&rsaquo;</a> <a href="?page=' . $pages . '&search_for='.$search_term.'" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';
     
      // Display the paging information back - next 
      echo '<div id="paging"><p>', $prevlink, ' Page ', $page, ' of ', $pages, ' pages', $nextlink, ' </p></div>';  
}
}
} //end of do search
// ******************************************************************************** end of getting the value from the database **********************************************************************  
         
?></div>
</div>
<?php
include("includes/footer.inc.php");




?>
</body>
</html>

