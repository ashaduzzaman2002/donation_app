<?php
include "function.inc.php";
//print_r($_POST);
$start = date("d-m-Y h:i a");
$added_on= date('Y-m-d h:i:s',strtotime('+5 hour +30 minutes',strtotime($start)));

//Admin-Blog and Article Tools
if(isset($_POST['from']) && $_POST['from'] == "Create_Article_Publish"){
    if ($_FILES['coverImg']['name'] !=""){
        $fname = $_FILES['coverImg']['name'];
        $adminId = getSafeValue($_POST['adminId']);
        $blogTitle = getSafeValue($_POST['blogTitle']);
        $category = getSafeValue($_POST['category']);
        $content = mysqli_real_escape_string($conn, $_POST['content']);
        $blogAction = getSafeValue($_POST['blogAction']);
        
        if (round($_FILES['coverImg']['size'] /1024 /1024, 2) > 5.00) {
            die("The file is too big. Max size is 7 mb");
        }
        if(!is_dir("../assets/blog_images/")) {
            //mkdir("assets"); 
            mkdir("../assets/blog_images"); 
        }
        $rawBaseName = uniqid();
        $extension = pathinfo($fname, PATHINFO_EXTENSION ) != '' ? pathinfo($fname, PATHINFO_EXTENSION ) : 'jpg';
        $counter = 0;
        $fname = $rawBaseName . '.' . $extension;
        while(file_exists("../assets/blog_images/".$fname)) {
            $fname = $rawBaseName . $counter . '.' . $extension;
            $counter++;
        }
        if(move_uploaded_file($_FILES['coverImg']['tmp_name'],"../assets/blog_images/".$fname)){
            $conn->query("Insert into news_content set 

            	title = '$blogTitle',
            	category = '$category',
            	content = '$content',
            	type = 'Article',
            	admin_id = '$adminId', 
            	published_on = '$added_on', 
            	updated_on = '$added_on',
            	cover_img = '$fname',
            	status = '$blogAction',
            	likes = '0'
            	 
            	");
            if($conn->affected_rows>0){
                echo "Success";
                exit();
            }
            else{
	            echo "Failed";
	            exit();
	        }
        } 
        else{
            echo "Failed";
            exit();
        }
    }
}
elseif(isset($_POST['from']) && $_POST['from'] == "Edit_Article_Publish"){
    if($_POST['is_cover_img'] == 'yes_image'){
        if ($_FILES['coverImg']['name'] !=""){
            $blogId = getSafeValue($_POST['blogId']);
            $fname = $_FILES['coverImg']['name'];
            $old_cover_img = '../assets/blog_images/'.$_POST['old_cover_img'];
            $blogTitle = getSafeValue($_POST['blogTitle']);
            $category = getSafeValue($_POST['category']);
            $content = mysqli_real_escape_string($conn, $_POST['content']);
            $blogAction = getSafeValue($_POST['blogAction']);
            
            if (round($_FILES['coverImg']['size'] /1024 /1024, 2) > 5.00) {
                die("The file is too big. Max size is 5 mb");
            }
            if(!is_dir("../assets/blog_images/")) {
                mkdir("../assets/blog_images/"); 
            }
            $rawBaseName = uniqid();
	        $extension = pathinfo($fname, PATHINFO_EXTENSION ) != '' ? pathinfo($fname, PATHINFO_EXTENSION ) : 'jpg';
	        $counter = 0;
	        $fname = $rawBaseName . '.' . $extension;
	        while(file_exists("../assets/blog_images/".$fname)) {
	            $fname = $rawBaseName . $counter . '.' . $extension;
	            $counter++;
	        }
            if(move_uploaded_file($_FILES['coverImg']['tmp_name'],"../assets/blog_images/".$fname)){
                unlink($old_cover_img);
                $conn->query("Update news_content set 

                	updated_on = '$added_on', 
                	status = '$blogAction', 
                	cover_img = '$fname', 
                	title = '$blogTitle', 
                	category='$category', 
                	content = '$content' 

                	where id = '$blogId'

                ");
                if($conn->affected_rows>0){
                    echo "Success";
                    exit();
                }else{
                	echo "Failed";
                	exit();
                }
            } 
            else{
                echo "Failed";
                exit();
            }
        }
    }
    else{
        $blogId = getSafeValue($_POST['blogId']);
        $blogTitle = getSafeValue($_POST['blogTitle']);
        $content = mysqli_real_escape_string($conn, $_POST['content']);
        $category = getSafeValue($_POST['category']);
        $blogAction = getSafeValue($_POST['blogAction']);

        $conn->query("Update news_content set 
        	updated_on = '$added_on', 
        	status = '$blogAction',
        	title = '$blogTitle', 
        	category='$category', 
        	content = '$content' 

        	where id = '$blogId'
        ");
        if($conn->affected_rows>0){
            echo "Success";
            exit();
        }
        else{
            echo "Failed";
            exit();
        }
    }
}
elseif(isset($_POST['activeArticle'])){
    $blogId = getSafeValue($_POST['activeArticle']);
    $conn->query("Update news_content set status = 'Active' where id = '$blogId'");
    header("Location:articles_list");
}
elseif(isset($_POST['draftArticle'])){
    $blogId = getSafeValue($_POST['draftArticle']);
    $conn->query("Update news_content set status = 'Draft' where id = '$blogId'");
    header("Location:articles_list");
}
elseif(isset($_POST['deleteArticle'])){
    $blogId = getSafeValue($_POST['deleteArticle']);
    $row = mysqli_fetch_assoc(mysqli_query($conn, "Select * from news_content where id = '$blogId'"));
    $coverImgLink = '../assets/blog_images/'.$row['cover_img'];
    unlink($coverImgLink);
    $conn->query("Delete from news_content where id = '$blogId'");
    header("Location:articles_list");
}



//Admin-Video and Video Tools
if(isset($_POST['from']) && $_POST['from'] == "Create_Video_Publish"){

    $adminId = getSafeValue($_POST['adminId']);
    $blogTitle = getSafeValue($_POST['blogTitle']);
    $category = getSafeValue($_POST['category']);
    $videoUrl = getSafeValue($_POST['videoUrl']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $blogAction = getSafeValue($_POST['blogAction']);
        
    $conn->query("Insert into news_content set 

        title = '$blogTitle',
        category = '$category',
        content = '$content',
        type = 'Video',
        admin_id = '$adminId', 
        published_on = '$added_on', 
        updated_on = '$added_on',
        cover_img = '$videoUrl',
        status = '$blogAction',
        likes = '0'
         
        ");
    if($conn->affected_rows>0){
        echo "Success";
        exit();
    }
    else{
        echo "Failed";
        exit();
    }
}
elseif(isset($_POST['from']) && $_POST['from'] == "Edit_Video_Publish"){
    $blogId = getSafeValue($_POST['blogId']);
    $blogTitle = getSafeValue($_POST['blogTitle']);
    $category = getSafeValue($_POST['category']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $videoUrl = getSafeValue($_POST['videoUrl']);
    $blogAction = getSafeValue($_POST['blogAction']);

    $conn->query("Update news_content set 

        updated_on = '$added_on', 
        status = '$blogAction', 
        cover_img = '$videoUrl', 
        title = '$blogTitle', 
        category='$category', 
        content = '$content' 

        where id = '$blogId'

    ");
    if($conn->affected_rows>0){
        echo "Success";
        exit();
    }else{
        echo "Failed";
        exit();
    }
}
elseif(isset($_POST['activeVideo'])){
    $blogId = getSafeValue($_POST['activeVideo']);
    $conn->query("Update news_content set status = 'Active' where id = '$blogId'");
    header("Location:videos_list");
}
elseif(isset($_POST['draftVideo'])){
    $blogId = getSafeValue($_POST['draftVideo']);
    $conn->query("Update news_content set status = 'Draft' where id = '$blogId'");
    header("Location:videos_list");
}
elseif(isset($_POST['deleteVideo'])){
    $blogId = getSafeValue($_POST['deleteVideo']);
    $conn->query("Delete from news_content where id = '$blogId'");
    header("Location:videos_list");
}





//Admin-App Management Tools
// elseif(isset($_POST['updateAppMaintenance'])){
// 	foreach ($_POST as $key => $value) {
// 		$_POST[$key] = getSafeValue($value);
// 	}
// 	$tutorApp = isset($_POST['tutorApp']) ? 'True' : 'False';
// 	$studentApp = isset($_POST['studentApp']) ? 'True' : 'False';
// 	$conn->query("Update app_management set suspend = '$tutorApp', updated_on = '$added_on' where user_type = 'Tutor'");
// 	$conn->query("Update app_management set suspend = '$studentApp', updated_on = '$added_on' where user_type = 'Student'");
// 	header("Location:appManagement");
// }
// elseif(isset($_POST['updateTutorAppVersion'])){
// 	foreach ($_POST as $key => $value) {
// 		$_POST[$key] = getSafeValue($value);
// 	}
// 	//print_r($_POST);
// 	$androidAppVersion = $_POST['androidAppVersion'];
// 	$iosAppVersion = $_POST['iosAppVersion'];
// 	$conn->query("Update app_management set android_version = '$androidAppVersion', ios_version = '$iosAppVersion', updated_on = '$added_on' where user_type = 'Tutor'");
// 	header("Location:appManagement");
// }
// elseif(isset($_POST['updateStudentAppVersion'])){
// 	foreach ($_POST as $key => $value) {
// 		$_POST[$key] = getSafeValue($value);
// 	}
// 	//print_r($_POST);
// 	$androidAppVersion = $_POST['androidAppVersion'];
// 	$iosAppVersion = $_POST['iosAppVersion'];
// 	$conn->query("Update app_management set android_version = '$androidAppVersion', ios_version = '$iosAppVersion', updated_on = '$added_on' where user_type = 'Student'");
// 	header("Location:appManagement");
// }
?>