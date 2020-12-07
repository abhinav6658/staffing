<?php 
$con = mysqli_connect('localhost','root','','oodlesdb');


$link = $_SERVER['PHP_SELF'];
$link_array = explode('/',$link);

$url = end($link_array);

if($url=='login'){

	login();
}elseif($url=='register'){
	register();
}else{
	$error = array('status' => 'Failed', 'status_code' => 404, 'message' => 'URL not found');
                
    echo json_encode($error);
}


 function checkApiKey() {
        global $con;
        if (isset($_POST['apikey']) && !empty($_POST['apikey'])) {
            $key = $_POST['apikey'];
            $stmt = mysqli_query($con,"SELECT apikey FROM apiuser WHERE apikey = '$key' LIMIT 1");
            $foundRows = mysqli_fetch_row($stmt);

            if ($foundRows > 0) {
                return true;
               
            } else {
               
                $error = array('status' => 'Failed', 'status_code' => 401, 'message' => 'Unauthorised access. API Key not valid');
                
                echo json_encode($error);
            }
        } else {
           
            $error = array('status' => 'failed', 'status_code' => 400, 'message' => 'Bad Request! Please provide authontication Key');
            echo json_encode($error);
        }
    }

// Registration API Code 

function register(){
 	global $con;
	$getkey  =  checkApiKey();
	$username = "";
	$email = "";
	$password = "";
	$address = "";
	$error  = array();
	//var_dump($getkey);
 	if($getkey>0){
	       
	       if(isset($_POST['username']) && !empty($_POST['username'])){
	       	$username  	   =  $_POST['username'];
	       }else{
	       	$error[] = array('status' => 'failed', 'status_code' => 403, 'message' => 'Username is required!');
	       	//echo json_encode($error);
	       }

	       if(isset($_POST['email']) && !empty($_POST['email'])){
	       	$email  	   =  $_POST['email'];
	       }else{
	       	$error[] = array('status' => 'failed', 'status_code' => 403, 'message' => 'Email ID is required!');
	       	//echo json_encode($error);
	       }

	       if(isset($_POST['password']) && !empty($_POST['password'])){
	       	$password  	   =  $_POST['password'];
	       }else{
	       	$error[] = array('status' => 'failed', 'status_code' => 403, 'message' => 'Password is required!');
	       	//echo json_encode($error);
	       }

	       if(isset($_POST['address'])){
	       	$address  	   =  $_POST['address'];
	       }


	       if(!empty($error)){

	       	echo json_encode($error);
	       
	       }else{
	       	
			       	$sql  = mysqli_query($con,"select email from register where email = '".$email."' ");

				    $checkrecord  =  mysqli_fetch_row($sql);

				   if(!empty($checkrecord)){

				   	$error = array('status' => 'failed', 'status_code' => 401, 'message' => 'User already exist');
		                
		            echo json_encode($error);

				   }else{

				   	$sql  = mysqli_query($con,"insert into register(`username`,`email`,`password`,`address`)values('".$username."','".$email."','".md5($password)."','".$address."')");

					    if($sql){
					    	$response  = array("status"=>"Success","status_code" => 200,"message" => "Successfully User Registered!");
					    	echo json_encode($response);
					    }else{
					    	$error = array('status' => 'failed', 'status_code' => 401, 'message' => 'Something went wrong! Please try again.');
					    	echo json_encode($error);
					    }
				   }
	       	}
	      
	}


}

// Login API Code

function login(){

	global $con;
	$email = "";
	$password = "";
	$error  = array();
	$getkey  =  checkApiKey();	
	
	if($getkey){

	    	
	    if(isset($_POST['email']) && !empty($_POST['email'])){
	       	$email  	   =  $_POST['email'];
	    }else{
	       	$error[] = array('status' => 'failed', 'status_code' => 403, 'message' => 'Email ID is required!');
	       	//echo json_encode($error);
	    }

	    if(isset($_POST['password']) && !empty($_POST['password'])){
	       	$password  	   =  $_POST['password'];
	    }else{
	       	$error[] = array('status' => 'failed', 'status_code' => 403, 'message' => 'Password is required!');
	       	//echo json_encode($error);
	    }

		if(!empty($error)){

	       	echo json_encode($error);
	       
	    }else{

	    	$sql  	  = mysqli_query($con,"select * from register where email = '".$email."' and password = '".md5($password)."' ");
	    	$result  =  mysqli_fetch_row($sql);

		    if($result>0){

		    	$response  = array("status"=>"Success","status_code" => "402","message" => "Successfully Login");
		    	echo json_encode($response);
		    }else{

		    	$response  = array("status"=>"Failed","status_code" => "402","message" => "Email ID or Password is Incorrect! Please try again");
		    	echo json_encode($response);	    	
		    }


	    }





	    	

	}

}


?>