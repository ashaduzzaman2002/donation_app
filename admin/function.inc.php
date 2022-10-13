<?php

include "../dbcon.php";

function getSafeValue($value){
	global $conn;
	return strip_tags(
		mysqli_real_escape_string($conn, $value)
	);
}

function getAdmins(){
	global $conn;
	$adminsData = Array();
	$res = mysqli_query($conn, "Select * from admin order by id");
	if(mysqli_num_rows($res) > 0){
		while($row = mysqli_fetch_assoc($res)){
			$adminsData[$row['id']] = $row;
		}
	}
	return $adminsData;
}

function getUniqueVisitors(){
	global $conn;
	$usersData = Array();
	$res = mysqli_query($conn, "Select * from user_visit group by ip_city");
	if(mysqli_num_rows($res) > 0){
		while($row = mysqli_fetch_assoc($res)){
			$usersData[$row['id']] = $row;
		}
	}
	return $usersData;
}

function getArticlesList(){
	global $conn;
	$articlesData = Array();
	$res = mysqli_query($conn, "Select * from news_content where type = 'Article' order by id desc");
	if(mysqli_num_rows($res) > 0){
		while($row = mysqli_fetch_assoc($res)){
			$articlesData[$row['id']] = $row;
		}
	}
	return $articlesData;
}
function getSpecificArticle($blogId){
	global $conn;
	$blogsIdData = Array();
	$res = mysqli_query($conn, "Select * from news_content where id = '$blogId' and type = 'Article'");
	if(mysqli_num_rows($res) > 0){
		while($row = mysqli_fetch_assoc($res)){
			$blogsIdData = $row;
		}
	}
	return $blogsIdData;
}

function getVideosList(){
	global $conn;
	$videosData = Array();
	$res = mysqli_query($conn, "Select * from news_content where type = 'Video' order by id desc");
	if(mysqli_num_rows($res) > 0){
		while($row = mysqli_fetch_assoc($res)){
			$videosData[$row['id']] = $row;
		}
	}
	return $videosData;
}
function getSpecificVideo($blogId){
	global $conn;
	$videoIdData = Array();
	$res = mysqli_query($conn, "Select * from news_content where id = '$blogId' and type = 'Video'");
	if(mysqli_num_rows($res) > 0){
		while($row = mysqli_fetch_assoc($res)){
			$videoIdData = $row;
		}
	}
	return $videoIdData;
}


function getAppDetails(){
	global $conn;
	$appData = Array();
	$res = mysqli_query($conn, "Select * from app_management");
	if(mysqli_num_rows($res) > 0){
		while($row = mysqli_fetch_assoc($res)){
			$appData[$row['user_type']] = $row;
		}
	}
	return $appData;
}
?>