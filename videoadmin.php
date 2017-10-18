
<?php
	include 'header.php';

$rs = queryServer("SELECT * FROM `movies` where status = 1 order by id DESC");
?>
<div class="well">
	<h1>Video administration</h1>
</div>
<div class="well">
<table style="width: 100%" class="table table-striped">
	<tr><td><h1>Active</h1></td></tr>
	<tr>
		<th>id</th>
		<th>title</th>
		<th>file</th>
		<th>size</th>
		<th>uploadedBy</th>
		<th>uploaded</th>
		<th>modifiedBy</th>
		<th>modified</th>
		<th>status</th>
		<th></th>
	</tr>
<?php

while($row = mysqli_fetch_assoc($rs)) {
	?>

	    
		
		<tr>
			<td> <?php echo $row['id']; ?></td>
			<td> <?php echo $row['title']; ?></td>
			<td> 
				<video width="100px" height="auto" controls>
					<source src="movies/completed/<?php echo $row['title']; ?>/<?php echo $row['file']; ?>" type="video/mp4" id="sourcePreview">
					<?php echo $row['title']; ?>
					</source>
				</video	
			</td>
			<td> <?php echo $row['size']; ?></td>
			<td> <?php echo $row['uploadedBy']; ?></td>
			<td> <?php echo $row['uploaded']; ?></td>
			<td> <?php echo $row['modifiedBy']; ?></td>
			<td> <?php echo $row['modified']; ?></td>
			<td> <?php echo $row['status']; ?></td>
			<td>
				<form action="hollywood.php" method="post">
					<input type="text" name="authKey" id="authKey" hidden value="delete">
			        <input type="text" name="id" id="id" hidden value="<?php echo $row['id']; ?>">
			        <input type="text" name="user" hidden value="<?php echo $currentUser ?>">
			        <input type="submit" name="submit" value="Delete">
			    </form>
			</td>
		</tr>
	
<?php	
}
?>

<tr><td><h1>Archived</h1></td></tr>
<tr>
		<th>id</th>
		<th>title</th>
		<th>file</th>
		<th>size</th>
		<th>uploadedBy</th>
		<th>uploaded</th>
		<th>modifiedBy</th>
		<th>modified</th>
		<th>status</th>
		<th></th>
	</tr>
<?php
$rs = queryServer("SELECT * FROM `movies` where status = 0 order by id DESC");
?><?php
while($row = mysqli_fetch_assoc($rs)) {
	?>
		
		<tr>
			<td> <?php echo $row['id']; ?></td>
			<td> <?php echo $row['title']; ?></td>
			<td> 
				<video width="100px" height="auto" controls>
					<source src="movies/archive/<?php echo $row['title']; ?>/<?php echo $row['file']; ?>" type="video/mp4" id="sourcePreview">
					<?php echo $row['title']; ?>
					</source>
				</video	
			</td>
			<td> <?php echo $row['size']; ?></td>
			<td> <?php echo $row['uploadedBy']; ?></td>
			<td> <?php echo $row['uploaded']; ?></td>
			<td> <?php echo $row['modifiedBy']; ?></td>
			<td> <?php echo $row['modified']; ?></td>
			<td> <?php echo $row['status']; ?></td>
			<td>
				<form action="hollywood.php" method="post">
					<input type="text" name="authKey" id="authKey" hidden value="restore">
			        <input type="text" name="id" id="id" hidden value="<?php echo $row['id']; ?>">
			        <input type="text" name="user" hidden value="<?php echo $currentUser ?>">
			        <input type="submit" name="submit" value="Restore">
			    </form>
			</td>
		</tr>
	
<?php	
}
?>
</table>
</div>
