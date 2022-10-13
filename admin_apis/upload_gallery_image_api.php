<?php
include "../dbcon.php";

function getSafeValue($value){
	global $conn;
	return strip_tags(mysqli_real_escape_string($conn,$value));
}

$processStatus[0]["error"] = false;
$processStatus[0]["message"] = "No Error";

$mandatoryVal = isset($_POST["caption"]);

if($mandatoryVal){
    $caption = getSafeValue($_POST['caption']);

    if($_FILES['gallery_photo']['name'] != "" && round($_FILES['gallery_photo']['size'] /1024 /1024, 2) <= 3.00){

        $photoName = $_FILES['gallery_photo']['name'];
       
        if(!is_dir("../assets/gallery_files/")) {
            //mkdir("assets"); 
            mkdir("../assets/gallery_files"); 
        }
        //For new gallery picture Naming
        $rawBaseName = uniqid();
        $extension = pathinfo($photoName, PATHINFO_EXTENSION ) != '' ? pathinfo($photoName, PATHINFO_EXTENSION ) : 'jpg';
        $counter = 0;
        $photoName = $rawBaseName . '.' . $extension;
        while(file_exists("../assets/gallery_files/".$photoName)) {
            $photoName = $rawBaseName . $counter . '.' . $extension;
            $counter++;
        }
    } else{
        $processStatus[0]["error"] = true;
        $processStatus[0]["message"] = "Invalid Pictures! Check Size or Sent no image.";
    }

    // Will satisfy only when all validation is true
    if($processStatus[0]['error'] == false){

        if(move_uploaded_file($_FILES['gallery_photo']['tmp_name'],"../assets/gallery_files/".$photoName)){
            // Data Inserting Part

            $conn->query("Insert into gallery set
            caption = '$caption',
            photo = '$photoName'
            ");
            if($conn->affected_rows > 0){
                $processStatus[0]["error"] = false;
                $processStatus[0]["message"] = "Photo Uploaded";
            } else{
                // Error Part
                $processStatus[0]["error"] = true;
                $processStatus[0]["message"] = "Database Query Error. Approach Administrator.";
            }
        } else{
            // Error Part
            $processStatus[0]["error"] = true;
            $processStatus[0]["message"] = "File upload failed. Try again.";
        }
    } 
} else{
    // Error Part
    $processStatus[0]["error"] = true;
    $processStatus[0]["message"] = "CPT, PHO  is mandatory.";
}
mysqli_close($conn);
header('Content-Type: application/json');
echo json_encode($processStatus);
?>