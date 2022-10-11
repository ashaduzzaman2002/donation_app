<?php 

  $processStatus[0]["error"] = false;
  $processStatus[0]["message"] = "Connection Reset";

  $processStatus[0]['field1'] = $_POST['field1'];
  	// $val = isset($_POST["username"]) && isset($_POST["password"]);

  	// if($val){
  	//     $username = strtoupper(mysqli_real_escape_string($conn, $_POST['username']));
    //     $password = mysqli_real_escape_string($conn, $_POST['password']);

    //    	// Validation Part
    //   	if($processStatus[0]["error"] == false && strlen($username) > 0 && strlen($password) > 0){
    //       	$processStatus[0]["error"] = false;
    //   	}else{
    // 		$processStatus[0]["error"] = true;
    // 		$processStatus[0]["message"] = "Fill details correctly";
    //   	}

    //    	//If everything is Correct
    //    	if($processStatus[0]["error"] == false){
       		
    //         $sql = "Select * from salesagent where

    //         username = '$username'
    //         and password = '$password'

    //         ";
    //         $res = mysqli_query($conn, $sql);
    //         if(mysqli_num_rows($res) == 1){
    //             $processStatus[0]["error"] = false;
    //             $row = mysqli_fetch_assoc($res);
    //             $row['profilePic'] = "https://aryagold.co.in/assets/salesAgentFiles/".$row['profilePic'];
    //             $processStatus[0]["userData"] = $row;
    //         }else{
    //             $processStatus[0]["error"] = true;
    //       		$processStatus[0]["message"] = "Invalid Username or Password";
    //         }
    //    	}
  	// }else{
    //   	$processStatus[0]["error"] = true;
    //   	$processStatus[0]["message"] = "Send all Parameters";
  	// }

  	// mysqli_close($conn);
  	//print_r($processStatus);

  	//Open them When on Server
	header('Content-Type: application/json');
	  // tell browser that its a json data
	echo json_encode($processStatus);
	  //converting array to JSON string

?>