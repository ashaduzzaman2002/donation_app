<?php
include "../dbcon.php";

function getSafeValue($value){
	global $conn;
	return strip_tags(mysqli_real_escape_string($conn,$value));
}

$processStatus[0]["error"] = false;
$processStatus[0]["message"] = "No Error";

$mandatoryVal = isset($_POST["fullname"]) && isset($_POST["phone"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["address"]) && isset($_POST["pincode"]) && isset($_POST["referred_by"]) && isset($_POST["registered_on"]);

if($mandatoryVal){
    $fullname = getSafeValue($_POST['fullname']);
    $phone = "+91".getSafeValue($_POST['phone']);
    $email = getSafeValue($_POST['email']);
    $password = getSafeValue($_POST['password']);
    $address = getSafeValue($_POST['address']);
    $pincode = getSafeValue($_POST['pincode']);
    $referred_by = getSafeValue($_POST['referred_by']);
    $registered_on = getSafeValue($_POST['registered_on']);

    if($_FILES['photo']['name'] != "" && round($_FILES['photo']['size'] /1024 /1024, 2) <= 2.00 && $_FILES['adhaar']['name'] !="" &&  round($_FILES['adhaar']['size'] /1024 /1024, 2) <= 5.00 && $_FILES['pan']['name'] !="" && round($_FILES['pan']['size'] /1024 /1024, 2) <= 5.00){

        $photoName = $_FILES['photo']['name'];
        $adhaarName = $_FILES['adhaar']['name'];
        $panName = $_FILES['pan']['name'];
       
        if(!is_dir("../assets/public_files/")) {
            //mkdir("assets"); 
            mkdir("../assets/public_files"); 
        }
        //For Profile picture Naming
        $rawBaseName = uniqid();
        $extension = pathinfo($photoName, PATHINFO_EXTENSION ) != '' ? pathinfo($photoName, PATHINFO_EXTENSION ) : 'jpg';
        $counter = 0;
        $photoName = $rawBaseName . '.' . $extension;
        while(file_exists("../assets/public_files/".$photoName)) {
            $photoName = $rawBaseName . $counter . '.' . $extension;
            $counter++;
        }

        //For adhaar photo Naming
        $rawBaseName = uniqid();
        $extension = pathinfo($adhaarName, PATHINFO_EXTENSION ) != '' ? pathinfo($adhaarName, PATHINFO_EXTENSION ) : 'pdf';
        $counter = 0;
        $adhaarName = $rawBaseName . '.' . $extension;
        while(file_exists("../assets/public_files/".$adhaarName)) {
            $adhaarName = $rawBaseName . $counter . '.' . $extension;
            $counter++;
        }
        
        //For id proof Naming
        $rawBaseName = uniqid();
        $extension = pathinfo($panName, PATHINFO_EXTENSION ) != '' ? pathinfo($panName, PATHINFO_EXTENSION ) : 'pdf';
        $counter = 0;
        $panName = $rawBaseName . '.' . $extension;
        while(file_exists("../assets/public_files/".$panName)) {
            $panName = $rawBaseName . $counter . '.' . $extension;
            $counter++;
        }
    } else{
        $processStatus[0]["error"] = true;
        $processStatus[0]["message"] = "Invalid Pictures! Check Size or Sent no image.";
    }

    // Validation Part
    // if($processStatus[0]["error"] == false && strlen($username) > 0 && strlen($password) > 0){

    // } else{
    //     // Error Part
    //     $processStatus[0]["error"] = true;
    //     $processStatus[0]["message"] = "Sent Invalid Data. Please check.";
    // }

    // Will satisfy only when all validation is true
    if($processStatus[0]['error'] == false){

        if(move_uploaded_file($_FILES['photo']['tmp_name'],"../assets/public_files/".$photoName) && move_uploaded_file($_FILES['adhaar']['tmp_name'],"../assets/public_files/".$adhaarName) && move_uploaded_file($_FILES['pan']['tmp_name'],"../assets/public_files/".$panName)){
            // Data Inserting Part
            $sql = "Insert into public set
                fullname = '$fullname',
                phone = '$phone',
                email = '$email',
                adhaar = '$adhaarName',
                pan = '$panName',
                password = '$password',
                address = '$address',
                pincode = '$pincode',
                referred_by = '$referred_by',
                registered_on = '$registered_on',
                photo = '$photoName'
                ";
            $conn->query($sql);
            if($conn->affected_rows > 0){
                $processStatus[0]["error"] = false;
                $processStatus[0]["message"] = "Registered Successfully";
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
    $processStatus[0]["message"] = "FN, PHN, EM, PSS, ADR, PIN, RBY, RO  is mandatory.";
}
mysqli_close($conn);
header('Content-Type: application/json');
echo json_encode($processStatus);
?>