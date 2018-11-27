<!DOCTYPE HTML>
<html>
    <body>
	<?php
	require('./config/config.php');
	
	$db_name = $_POST["db_name"];
	$db = $connection->selectDatabase($db_name);
	?>

	Instructions:
	    <ul>
		<li>Only provide the query.</li>
		<li>For example: for db.collectionName.find({query}):</li>
		<ul>
		    <li>Select collectionName from the list and then input the {query} in the text box, curly braces included 
		</ul>
	    </ul>
	    <br>
	    
	    <form action="query.php" method="post">
		Select Collection: 
		<select name ="collection_name" onchange="showUser(this.value)"><br>
		    <?php
 		    foreach ($db->listCollections() as $collection) {
			echo "<option value = \"{$collection->getName()}\">{$collection->getName()}</option>"; 
		    }?>
		</select>
		find(<input type="text" name="query">)<br>
		<input type="hidden" value="<?php echo $db_name ?>" name="db_name" />
		<input type="submit">
	    </form>
    </body>
</html>
