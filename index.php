<?php

// Connect to the database
require_once('database.php');
// Set the default category to the ID of 1
if (!isset($category_id)) {
$category_id = filter_input(INPUT_GET, 'category_id', 
FILTER_VALIDATE_INT);
if ($category_id == NULL || $category_id == FALSE) {
$category_id = 1;
}
}
// Get name for current category
$queryCategory = "SELECT * FROM categories
WHERE categoryID = :category_id";
$statement1 = $db->prepare($queryCategory);
$statement1->bindValue(':category_id', $category_id);
$statement1->execute();
$category = $statement1->fetch();
$statement1->closeCursor();
$category_name = $category['categoryName'];
// Get all categories
$queryAllCategories = 'SELECT * FROM categories
ORDER BY categoryID';
$statement2 = $db->prepare($queryAllCategories);
$statement2->execute();
$categories = $statement2->fetchAll();
$statement2->closeCursor();
// Get records for selected category
$queryRecords = "SELECT * FROM records
WHERE categoryID = :category_id
ORDER BY recordID";
$statement3 = $db->prepare($queryRecords);
$statement3->bindValue(':category_id', $category_id);
$statement3->execute();
$records = $statement3->fetchAll();
$statement3->closeCursor();
?>
<!DOCTYPE html>
<html>
<!-- the head section -->
<head>
<title>Your Music</title>
<link rel="stylesheet" type="text/css" href="styles/main.scss">
<link rel="stylesheet" type="text/css" href="styles/main.css">

</head>
<!-- the body section -->
<body>
<?php include './includes/header.php';?>
<main>
<h4 className= "genre"></h4> 
<h3 className= "genre">Playlists</h3>

<br>
<break>

<aside>
<!-- display a list of categories in the sidebar-->

<nav>
<ul>
<?php foreach ($categories as $category) : ?>
<li><a href=".?category_id=<?php echo $category['categoryID']; ?>">
<?php echo $category['categoryName']; ?>
</a>
</li>
<?php endforeach; ?>
</ul>
</nav>
</aside>
<section>
<!-- display a table of records from the database -->
<h2><?php echo $category_name; ?></h2>
<table className = "table">
<tr>
<th>Song Art</th>
<th>Song name</th>
<th>Album</th>
<th>Artist</th>
<th>Release Date</th>

</tr>
<?php foreach ($records as $record) : ?>
<tr>
<td><img src="image_uploads/<?php echo $record['image']; ?>" width="100px" height="100px" /></td>
<td><?php echo $record['name']; ?></td>
<td><?php echo $record['Albums']; ?></td>
<td><?php echo $record['artist']; ?></td>
<td><?php echo $record['releasedate']; ?></td>


</tr>
<?php endforeach; ?>
</table>
<p><a href="logout.php"> Log out<a/a></p>
<p><a href="login.php"> Log in<a/a></p>
<p><a href="register.php"> register<a/a></p>
<p><a href="manage_songs.php"> Manager Songs<a/a></p>
</section>
</main>
<?php include './includes/footer.php';?>
</body>
</html>