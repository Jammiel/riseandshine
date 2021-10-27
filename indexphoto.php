<?php
error_reporting(0);
require_once 'classes/initialising.php';
$db = new DB();
foreach($db->query("SELECT photo,indid FROM individualaccount") as $row){
	$pht = explode("...png",$row['photo']);
	$actpht = $pht[0].".png";
	$db->query("UPDATE individualaccount SET photo='".$actpht."' WHERE indid='".$row['indid']."'");
}
PAGE_CONTROLLER::PAGE_BUILD();
?>
