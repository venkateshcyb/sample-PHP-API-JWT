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
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //$stmt = $conn->prepare('SELECT firstname, lastname FROM users Where id="'.$uservalue.'"');
   // $stmt = $conn->prepare('SELECT firstname, lastname FROM users Where id="'.$data->testkey.'"');
     $sql = 'SELECT firstname, lastname FROM users Where id='.$uservalue;
 
    $stmt = $conn->prepare($sql);    

     $stmt->execute();
  
    // set the resulting array to associative
    
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();  
  // echo var_dump($result); 

  if(count($result) == 1){
 
    // set response code
    http_response_code(200);
 
    //set user success message
    
    echo json_encode(
            array(
                "message" => "Successful. Welcome Back.",
                "id" => $result[0]["firstname"]
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
       echo json_encode(array("message" => $e->getMessage()));
       //echo json_encode(array("message" => "Failure"));
  }
   catch(Exception $e) {
    //echo "Error: " . $e->getMessage();
       // set response code
       http_response_code(200);
 
       // tell the user failed
       echo json_encode(array("message" => $e->getMessage()));
       //echo json_encode(array("message" => "Failure"));
  }

  $conn = null;



?>
