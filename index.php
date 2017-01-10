<html>
	<head>
	<link rel="icon" href="favicon.ico" type="image/x-icon"/>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
		<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
		<style>
			body {
				font-family: 'Oswald', sans-serif;
				font-size: 12px;
			}
			h1 {
				width:98%;
				background-color: #CCC;
				color:white;
				padding: 2px 0 2px 10px;
			}
			h1 a {
				color:white;
				text-decoration:none;
			}
			h1 a:hover {
				color:navy;
			}
		</style>
	</head>
	<body>
<?php

/*************************
Status - 0:new 1:ok 2:delete 3:update
**************************/

echo '<h1><a href="/">[Home] Ican Dev Tools</a></h1>';

require("configure.php");
//connect
$mysqli = new mysqli($db_host, $db_user, $db_password, $db_database);
if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}

/*
$res = $mysqli->query("SELECT 'choices to please everybody.' AS _msg FROM DUAL");
$row = $res->fetch_assoc();
echo $row['_msg'];
*/

// echo "<pre>"; print_r($_POST);

if( isset($_POST['vhost_name']) ){

	if( isset($_POST['item2del']) ){
		foreach($_POST['item2del'] AS $k => $v){
			$status = $mysqli->query("SELECT status FROM vhosts WHERE id=".$k)->fetch_object()->status;
			if($status!=2){
				$mysqli->query("UPDATE vhosts SET status=2 WHERE id=".$k);
			}else{
				$mysqli->query("UPDATE vhosts SET status=1 WHERE id=".$k);
			}
		}
	}
	
	if( isset($_POST['vhost_name']) ){
		$res = $mysqli->query("SELECT * FROM vhosts");
		while($row = $res->fetch_object()){
			// echo "\n<br>".$row->id.": ".$_POST['vhost_name'][$row->id]." => ".$row->vhost_name;
			if($_POST['vhost_name'][$row->id]!=$row->vhost_name || $_POST['server_path'][$row->id]!=$row->server_path){
				$mysqli->query("UPDATE vhosts SET status=3, server_path='".$_POST['server_path'][$row->id]."', vhost_name='".$_POST['vhost_name'][$row->id]."' WHERE id=".$row->id);
			}
		}
	}	
	if( isset($_POST['apply56php']) ){
		$res = $mysqli->query("SELECT * FROM vhosts");
		while($row = $res->fetch_object()){

			if( isset($_POST['apply56php'][$row->id])){ // we have that item in a records
				$htfile=$row->server_path.='/.htaccess';
				// echo $htfile." = ";
				$content = file_get_contents('php5.6-fpm.conf');

				if( is_file($htfile) ){
					$content2 = file_get_contents($htfile);
					// htfile already there
					if(strpos($content2,'php5.6-fpm')===false){
						file_put_contents($htfile, $content.$content2.PHP_EOL);
					}
				}else{
					// new created
					//file_put_contents($htfile, $content.PHP_EOL , FILE_APPEND | LOCK_EX);
					$handle = fopen($htfile, 'w') or die('Cannot open file:  '.$htfile);
					fwrite($handle, $content);
					
				}
			}
		}
	}
	
	

}


// ******************************
// step1: first page
if(!isset($_POST['step'])){

	
//print_r($_SERVER);

	$res = $mysqli->query("SELECT * FROM vhosts");
	$out_current='';
	
	
	//*****************************
	// normal page
	//*****************************
	if(!isset($_GET['edit'])){
		
	
		while($row = $res->fetch_object()){
			$out_current .=  $_SERVER['SERVER_ADDR']."	".$row->vhost_name."	#path:".$row->server_path."\n";
		}
		echo "Current /windows/system32/drivers/hosts<br><textarea style=\"width:600px;height:80px\">".$out_current."</textarea>";
		
		
		
		
	//*****************************
	// "editing" page
	//*****************************
	}else{
		
		$out_current = '<table><tr>
			<th>Delete</th>
			<th>Status</th>
			<th>Name</th>
			<th>Path</th>
			<th>Apply php 5.6</th>
				</tr>';
		while($row = $res->fetch_object()){
			//$status=$res->status;

			
			$out_current .= '<tr>
				<td><input type="checkbox" name="item2del['.$row->id.']" value="1" /></td>
				<td>'.$row->status.'</td>
				<td><input name="vhost_name['.$row->id.']" size="32" value="'.$row->vhost_name.'"></td>
				<td><input name="server_path['.$row->id.']" size="60" value="'.$row->server_path.'"></td>
				<td><input type="checkbox" name="apply56php['.$row->id.']" value="1" /></td>
					</tr>';
		}
		$out_current.='</table>';
		
		echo '<form method="post">Host to edit: <br><ol>'.$out_current.'</ol><input type="submit" value=":: update ::"></form>';
	
	}
	
	echo '
	<h2>Step 1:</h2>
	<form method="post">
	<input type="hidden" name="step" value="2" />
	<label>VHost Name <input type="text" name="vhost_name1" size="48" value="loc.test1"/></label><br/>
	<label>Server Path <input type="text" name="server_path1" size="48" value="/var/www/html/loc.test1"/></label>
	<hr/>
	<sup>in www, accesses via samba share use: /var/www/html/%sitename%</sup><br/>
	<hr/>
	<input type="submit" value="Create New VHost!"/>
	
	</form>
	<a href="?edit=1">Edit Records</a> | <a href="/">View Normal</a>
	';
	
	$res1 = $mysqli->query("SELECT * FROM backup");
	$row1 = $res1->fetch_object();
	
	if($row1->backup_active==1){
		$checkbox = '<input type="checkbox" name="backup_active" checked="checked" value="1"/>';
		
	}else{
		$checkbox = '<input type="checkbox" name="backup_active" value="1"/>';
	}
	
	
	if(isset($_GET['back'])){
		$back_txt='<p style="color:green">Backup Information Updated</p>';
	}else{
		$back_txt='';
	}
	
	echo '
	<hr>
	<br/><br/><br/><br/>
	<h2>Backup Info:</h2>
	'.$back_txt.'
	<form method="post">
	<input type="hidden" name="step" value="3" />
	<label>Backup File Path (just put your username) <input type="text" name="backup_url" size="48" value="'.$row1->backup_url.'"/></label><br/>
	<label>Backup Active '.$checkbox.'</label><hr/>
	<input type="submit" value="Update Backup Information!"/>
	
	</form>

	';

}else{
	//******************************************************
	// step2: processing
	
	if($_POST['step']==2){
		if(!empty($_POST['server_path1']) && !empty($_POST['vhost_name1']) ){
			// quick check
			$res = $mysqli->query("SELECT * FROM vhosts WHERE vhost_name='".$_POST['vhost_name1']."'");
			if($res->num_rows > 0){
				echo "You have VHost in your system already! [".$res->num_rows."]";
			}else{
				$mysqli->query("INSERT INTO vhosts (vhost_name,server_path) VALUES ('".$_POST['vhost_name1']."','".$_POST['server_path1']."')");
				echo "Added new VHost:<b>".$_POST['vhost_name1']."</b> Pointing to:<b>".$_POST['server_path1']."</b>";
			}
		
		}
	}

	if($_POST['step']==3){
//		print_r($_POST);
		
		$mysqli->query("UPDATE backup SET backup_url='".$_POST['backup_url']."'");
		if(isset($_POST['backup_active'])){
			$mysqli->query("UPDATE backup SET backup_active='".$_POST['backup_active']."'");
		}else{
			$mysqli->query("UPDATE backup SET backup_active='0'");
		}
		header("location: /index.php?back=1");
	}
}


$mysqli->close(); // cleaning is good




?>
</body>
</html>