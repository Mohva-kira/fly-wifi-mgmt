<?php
include_once './config/database.php';
use Firebase\JWT\JWT;
require_once('../vendor/autoload.php');



header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$secret = getenv('SECRET_KEY');
$serverName = getenv('SEVERNAME');
$issuer = getenv('ISSUER');
$mobile_number = '';
$password = '';

$databaseService = new DatabaseService();
$conn = $databaseService->getConnection();



$data = json_decode(file_get_contents("php://input"));

$mobile_number = $data->mobile_number;
$password = $data->password;

$table_name = 'moble_numbers';

$query = "SELECT * FROM " . $table_name . " WHERE mobile_number = ? LIMIT 0,1";

$stmt = $conn->prepare( $query );
$stmt->bindParam(1, $mobile_number);
$stmt->execute();
$num = $stmt->rowCount();

if($num > 0){
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $id = $row['id'];
    $role = $row['role'];
    $password2 = $row['verfication_code'];

    if(password_verify($password, $password2))
    {
        $secret_key = $secret;
        $issuer_claim = $issuer; // this can be the servername
        $audience_claim = $serverName;
        $issuedat_claim = time(); // issued at
        $notbefore_claim = $issuedat_claim + 10; //not before in seconds
        $expire_claim = $issuedat_claim + 60; // expire time in seconds
        $token = array(
            "iss" => $issuer_claim,
            "aud" => $audience_claim,
            "iat" => $issuedat_claim,
            "nbf" => $notbefore_claim,
            "exp" => $expire_claim,
            "data" => array(
                "id" => $id,
                "firstname" => $firstname,
                "lastname" => $lastname,
                "mobile_number" => $mobile_number,
                "role" => $role
            ));

        http_response_code(200);

        $jwt = JWT::encode($token, $secret_key, 'HS256' );
//        $client->call(new CreateUser(
//            [
//                "id" => $id, // optional
//                "name" => $firstname, // optional
//                "photo" => "photo url", // optional
//                "role_names" => [$role], // optional
//                "group_ids" => [
//                    "Q7FjSysvBuHz",
//                ], // optional
//
//            ]));
        echo json_encode(
            array(
                "message" => "Successful login.",
                "jwt" => $jwt,
                "id" => $id,
                "mobile_number" => $mobile_number,
                "role" => $role,
                "expireAt" => $expire_claim,
                "mobile_number" => $mobile_number,
            ));
    }
    else{

        http_response_code(401);
        echo json_encode(array("message" => "Login failed.", "password" => $password));

    }
}
?>