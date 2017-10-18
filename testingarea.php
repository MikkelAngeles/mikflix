<?php

$title 	     =  "lol";
$file  		 =  "test.mp4";
$uploadedBy  =  "admin";

$mainDir = "movies/completed/".$title;
$subDir  = $mainDir."/subs";


//if(!file_exists($subDir) && !is_dir($subDir)) {
		//mkdir($subDir);
		//$tmpDir = 'movies/tmp/'.$uploadedBy.'/subs';
		$old = "movies/tmp/".$uploadedBy."/subs";
		$new = "movies/completed/".$title."/subs";

		echo "Old: ".$old."<br>";
		echo "New: ".$new."<br>";

		//rename("movies/tmp/".$uploadedBy."/subs", "movies/completed/".$title."/subs");
		foreach(glob($old.'/*.*') as $file) {
			$newFile = str_replace($old."/", "", $new."/".$file);
			echo "Old: ".$file."<br>";
			echo "New: ".$newFile."<br>";
			//echo "New Path: ".$fileOnly."<br>";
			rename($file, $newFile);
		}

	//}

?>