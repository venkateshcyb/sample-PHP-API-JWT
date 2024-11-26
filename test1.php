<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// files needed to connect to database

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "test";
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set product property values
$uservalue = $data->testkey;
 
try {
   
    $conn = new mysqli($servername, $username, $password, $dbname);

   // $stmt = $conn->prepare('SELECT firstname, lastname FROM users Where id="'.$uservalue.'"');
   // $stmt = $conn->prepare('SELECT firstname, lastname FROM users Where id="'.$data->testkey.'"');
      $sql = 'SELECT firstname, lastname FROM users Where id='.$uservalue;
      $stmt = $conn->query($sql);
      //$stmt->execute();
  
    // set the resulting array to associative
    

    //$result = $stmt->fetch_assoc();  
    //$result =  $stmt->get_result();
   
   // $result = $result->fetch_assoc(); 
    $result = $stmt->fetch_assoc(); 
    //echo var_dump($result); 

  if(count($result) != 0){
 
    // set response code
    http_response_code(200);
 
    //set user success message
    
    echo json_encode(
            array(
                "message" => "Successful. Welcome Back.",
                "id" => $result["firstname"]
            )
        );
        
 
} 

else{
 
    // set response code
    http_response_code(200);
 
    // tell the user failed
    echo json_encode(array("message" => "Failure"));
}
   
  } catch(MySQLException $e) {
    //echo "Error: " . $e->getMessage();
       // set response code
       http_response_code(200);
 
       // tell the user failed
       //echo json_encode(array("message" => $e->getMessage()));
       echo json_encode(array("message" => "Failure"));
  }
  catch(Exception $e) {
    //echo "Error: " . $e->getMessage();
       // set response code
       http_response_code(200);
 
       // tell the user failed
       //echo json_encode(array("message" => $e->getMessage()));
       echo json_encode(array("message" => "PHP Failure"));
  }

  $conn = null;



?>
