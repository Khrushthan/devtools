<?php

/*************************

Status - 0:new 1:ok 2:delete 3:update

**************************/

// print_r($_SERVER); die();

require("configure.php");
//connect
$mysqli = new mysqli($db_host, $db_user, $db_password, $db_database);
if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}

//echo "\nTEST\n________________";

//print_r($_SERVER);

$res = $mysqli->query("SELECT * FROM vhosts WHERE status<>1");
$content_original=file_get_contents($project_directory."/vhost_template");

$restart = false;

while( $obj=$res->fetch_object() ){
	$restart = true;
	$filename = $apache_vhosts_dir."/".$obj->vhost_name.".conf";
	$filename_target = $apache_vhosts_active_dir."/".$obj->vhost_name.".conf";
		
	if($obj->status==0){
		// adding new record
		
		echo "\n".$obj->vhost_name." => ".$obj->server_path;
		$content = str_replace("%%server_path%%",$obj->server_path,$content_original);
		$content = str_replace("%%vhost_name%%",$obj->vhost_name,$content);
		

		$fp = fopen($filename, 'w');
		fwrite($fp, $content);
		fclose($fp);
		symlink($filename, $filename_target);
		
	//	echo "\n $content \n";
		$mysqli->query("UPDATE vhosts SET status=1 WHERE id=".$obj->id);
	
	}elseif($obj->status==2 || $obj->status==3){
		// delete file
		unlink($filename);
		unlink($filename_target);
		if($obj->status==3){
			echo "\n".$obj->vhost_name." => ".$obj->server_path;
			$content = str_replace("%%server_path%%",$obj->server_path,$content_original);
			$content = str_replace("%%vhost_name%%",$obj->vhost_name,$content);
			

			$fp = fopen($filename, 'w');
			fwrite($fp, $content);
			fclose($fp);
			symlink($filename, $filename_target);
			$mysqli->query("UPDATE vhosts SET status=1 WHERE id=".$obj->id);
		}else{
			$mysqli->query("DELETE FROM vhosts WHERE id=".$obj->id);
		}
	}
}

if($restart){
	echo "\n STOP Apache: ".exec('service apache2 stop');
	echo "\n START Apache: ".exec('service apache2 start');
	echo "\n___________________\n";
}

