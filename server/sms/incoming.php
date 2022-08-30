<?php
include_once '../config/database.php';

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$sender = '';
$receiver = '';
$msgdata = '';
$recvtime = '';
$msgid = '';
$conn = null;

$databaseService = new DatabaseService();
$conn = $databaseService->getConnection();

$data = json_decode(file_get_contents("php://input"));

$sender = $_GET['sender'];
$receiver = $_GET['receiver'];
$msgdata = $_GET['msgdata'];
$recvtime = $_GET['recvtime'];
$msgid = $_GET['msgid'];




$table_name = 'sms';

$query = "INSERT INTO " . $table_name . "
                SET sender = :sender,
                    receiver = :receiver,
                    msgdata = :msgdata,
                    recvtime = :recvtime,
                    msgid = :msgid";

$stmt = $conn->prepare($query);

$stmt->bindParam(':sender', $sender);
$stmt->bindParam(':receiver', $receiver);
$stmt->bindParam(':msgdata', $msgdata);


$stmt->bindParam(':recvtime', $recvtime);
$stmt->bindParam(':msgid', $msgid);


if($stmt->execute()){

    http_response_code(200);
    echo json_encode(array("message" => "Sms registered successfully."));
}
else{
    http_response_code(400);

    echo json_encode(array("message" => "Unable to register the sms."));
}
?>