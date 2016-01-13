<?php
include("includes/header.inc.php");
echo header1("Welcome to my design Page");
include("includes/nav.inc.php");
include ("config.php");

?>
<div class="container">
<div>
     <h1> scenario for PHP book search </h1>
     <p> PHP Book Search Engine is a advanced search engine for books, you can search by Book Name, Author or ISBN. </p>
     <p> Books have many author - authors have many books. </p>
     <p> category have many books - books have many category. </p>


</div>


<div>
     <h1> Class Diagram </h1>
     <img class="dsgimage" src="images/classdg.jpg"/>
</div>
<div>
     <h1> Physical Diagram </h1>
     <img class="dsgimage" src="images/physicaldg.jpg"/>
</div>

<div>
     <h1> Sql Designer view </h1>
     <img class="dsgimage" src="images/sqlrelation.jpg"/>
</div>



<?php
// Include my book Class.
  
  include("classes/books.class.php");
  books::connect_it(ConnectionFactory::connect());
  // using the function to display all stored date from table books
  $books=books::allbooks("book");
  if ($books !== false ){
          echo "<h1> Books Table </h1>";

    print "<table>
               <tr>
                    <th> isbn </th>
                    <th> title </th>
                    <th> description </th>
                    <th> price </th>
                    <th> publisher </th>
                    <th> edition </th>
                    <th> pages </th>

               </tr>" ;
               
  
  foreach($books as $row) {
      echo '<tr><td>' .$row->isbn. '</td><td>' .$row->title. '</td><td>' .$row->description. '</td>
      <td>' .$row->price. '</td><td>' .$row->publisher. '</td><td>' .$row->edition. '</td><td>' .$row->pages. '</td></tr>';
    }
        echo "</table>";

    }
    
      // calling function from class to display all stored date from table categories
  $cat=books::allbooks("category");
  if ($cat !== false ){
     echo "<h1> Categories Table </h1>";
     print "<table>
               <tr>
                    <th> id </th>
                    <th> name </th>

               </tr>" ;
               
  
     foreach($cat as $row) {
     echo '<tr><td>' .$row->cat_id. '</td><td>' .$row->cat_name. '</td></tr>';
    }
    echo "</table>";
    }
    
          // calling function from class to display all stored date from table categories
  $cat_book =books::allbooks("categorybook");
  if ($cat_book !== false ){
     echo "<h1> categorybook Table </h1>";
     print "<table>
               <tr>
                    <th> category_id </th>
                    <th> isbn </th>

               </tr>" ;
               
  
  foreach($cat_book as $row) {
      echo '<tr><td>' .$row->cat_id. '</td><td>' .$row->isbn. '</td></tr>';
    }
    echo "</table>";
    }
    
           // calling function from class to display all stored date from table authors
  $authors =books::allbooks("author");
  if ($authors !== false ){
     echo "<h1> Author Table </h1>";
    print "<table>
               <tr>
                    <th> author_id </th>
                    <th> f_name </th>
                    <th> l_name </th>
               </tr>" ;
               
  
  foreach($authors as $row) {
      echo '<tr><td>' .$row->author_id. '</td><td>' .$row->f_name. '</td><td>' .$row->l_name. '</td></tr>';
    }
    echo "</table>";
    }
               // calling function from class to display all stored date from table authors
  $authors =books::allbooks("authorbook");
  if ($authors !== false ){
     echo "<h1> Authorbook Table </h1>";
    print "<table>
               <tr>
                    <th> isbn </th>
                    <th> author_id </th>
               </tr>" ;
               
  
  foreach($authors as $row) {
      echo '<tr><td>' .$row->isbn. '</td><td>' .$row->author_id. '</td></tr>';
    }
    echo "</table>";
    }
?>
</div>
<?php
include("includes/footer.inc.php");
?>

