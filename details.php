<?php
include("includes/header.inc.php");
echo header1("Book Details");
include("includes/nav.inc.php");
$catid = "";
include ("config.php");
$book_id = $_GET['id']; //getting the book to display the result for the current chosen book
if(!isset($_GET['id']))  //check if the user visited this page via link or redirected by the search form // if by link show message say go back to the search form
{
	echo "<h1>You shouldn't have got to this page, please go back to the search form and search for a book. </h1>";
	exit;
}
$query = "SELECT * FROM book
     INNER JOIN categorybook ON book.isbn = categorybook.isbn
     INNER JOIN authorbook ON book.isbn = authorbook.isbn
     INNER JOIN author ON authorbook.author_id = author.author_id  WHERE book.isbn=:id";

$stmt = $conn->prepare($query);
$stmt->bindValue(':id',$book_id);
$stmt->execute();
echo "<div class='container'>";
if($book=$stmt->fetch(PDO::FETCH_OBJ))
{
	echo "<p class='title'>$book->title</p>
	<p>by $book->f_name $book->l_name </p>";

	echo "<div class='detatilsleft'> <img class='bookimg'src=images/books/$book->isbn.jpg> </div>";
	
	echo "<div class='description'>
	<h3><span> Description </span></h3>
			<br/><span> $book->description</span>
		</div>";
	echo "<div class='detatilsright'>
	<h3><span>Book details</span></h3>
	<p><b>ISBN:</b>$book->isbn </p>
	<p class='title'>$book->title</p>
	<p class='price'><b>Price : </b>&pound$book->price</p>
		<p> <b>Author : </b>$book->f_name $book->l_name</p>
			<p> <b>No of Pages :</b> $book->pages</p>
			<p> <b>Publisher : </b>$book->publisher</p></div>";
	$catid= $book->cat_id;
	$currenrbook = $book->title;
}	
	$otherResult = array(); // array to store the related book
	// select other books related to the same category as the current book 
	$query = "SELECT * FROM categorybook
	     INNER JOIN book ON categorybook.isbn = book.isbn 
	  WHERE categorybook.cat_id=:id";
	$stmt = $conn->prepare($query);
	$stmt->bindValue(':id',$catid);
	$stmt->execute();
	while ($books = $stmt->fetchObject()) {
		if ($currenrbook != $books->title) // if the current book in the result don't remove it.
		{
		$otherResult[] = "<p><a href=details.php?id=$books->isbn> <img src=images/books/$books->isbn> $books->title </a> </p>";
		}
		}
		
		$result1 = $otherResult;   // to remove ant duplicate books and display it once.
                    $total_records = count($result1); //counting number of books
		    	echo "<div class='others'>";

                        echo "<p class='found'> We found another $total_records books related to the same category </p> ";
                         foreach ($result1 as $result123)
                         {
				echo "<div class='item'>";
                              print $result123;
			      echo "</div>";

                         }
			echo "</div>";
	echo "</div>";
echo "";


$conn=NULL;
include("includes/footer.inc.php");
?>