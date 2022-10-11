<?php
include '../dbcon.php';
$processStatus[0]["error"] = false;
$processStatus[0]["message"] = "Connection Reset";

function getSafeValue($value){
	global $conn;
	return strip_tags(
		mysqli_real_escape_string($conn, $value)
	);
}

$val = isset($_POST['lastPostId']) && isset($_POST['postLimit']);

if($val){
    $lastPostId = getSafeValue($_POST['lastPostId']);
    $postLimit = getSafeValue($_POST['postLimit']);

    // Validation Part
    if($processStatus[0]["error"] == false && $postLimit == 0){
        $processStatus[0]["error"] = true;
        $processStatus[0]["message"] = "Invalid Parameter";
    }

    if($processStatus[0]["error"] == false){
        if($lastPostId == 0){
            $sql = "Select * from post_feed where status = 'Verified' order by id DESC LIMIT $postLimit";
            $processStatus[0]["dataList"] = $lastPostId.' '.$postLimit.' '.'1';
        }else{
            $sql = "Select * from post_feed where status = 'Verified' and blog_id < '$lastPostId' order by id DESC LIMIT $postLimit";
            $processStatus[0]["dataList"] = $lastPostId.' '.$postLimit.' '.'2';
        }

        $res = $conn->query($sql);

        if($res->num_rows > 0){
            $processStatus[0]["error"] = false;
            $processStatus[0]["message"] = "Data Retreived";

            $postFeedData = Array();
            while($row = $res->fetch_assoc()){
                // $row['updated_on'] = date('F jS Y', strtotime($row['updated_on']));
                $coverImg = $row['photo'];
                $row['photo'] = './assets/posts/'.$coverImg;
                // $row['content'] = json_encode($row['content'], JSON_UNESCAPED_SLASHES);
                $postFeedData[count($postFeedData)] = $row;
            }
            $processStatus[0]["response"] = $postFeedData;
        }
        else{
            $processStatus[0]["error"] = true;
            $processStatus[0]["message"] = "No post to fetch";
        }
    }
}
mysqli_close($conn);
header('Content-Type: application/json');
echo json_encode($processStatus);
?>