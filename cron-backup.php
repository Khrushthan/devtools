<?php

/*************************

Status - 0:new 1:ok 2:delete 3:update

**************************/

//print_r($_SERVER);
require("configure.php");
//connect
$mysqli = new mysqli($db_host, $db_user, $db_password, $db_database);
if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}

//echo "\nTEST\n________________";

//print_r($_SERVER);

$res = $mysqli->query("SELECT * FROM backup");
$obj=$res->fetch_object();


$path = '/mnt/backup/NewBackupsAll/';

if($obj->backup_active==1){
	echo "==> FILES Backup\n";
	@mkdir($path.$obj->backup_url);
	@mkdir($path.$obj->backup_url.'/www');
	@mkdir($path.$obj->backup_url.'/mnt');
	
	echo exec("rsync -zraL --delete '/var/www/' '".$path.$obj->backup_url."/www'"); //$path.$obj->backup_url
	//echo exec("rsync -zral '/mnt/hgfs/code' '".$path.$obj->backup_url."/mnt'"); //$path.$obj->backup_url
	
	echo "==> DB Backup\n";
	$sql='SHOW DATABASES';
	$res1 = $mysqli->query($sql);
	@mkdir($path.$obj->backup_url.'/DB');
	@mkdir($path.$obj->backup_url.'/DB/'.date('d'));
	while( $obj1=$res1->fetch_object() ){
		if($obj1->Database!='information_schema' && $obj1->Database!='performance_schema' &&  $obj1->Database!='mysql' ){
			echo exec("/usr/bin/mysqldump  --force --opt --user=root -pdeveloper010pass --databases ".$obj1->Database." | gzip > '".$path.$obj->backup_url.'/DB/'.date('d').'/'.$obj1->Database.".gz' ");
		}
	}
	
	
	
}else{
	echo 'Backup Is Not Active!';
}

