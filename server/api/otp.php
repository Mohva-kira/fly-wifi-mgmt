<?php

include_once '../config/database.php';

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// Load and initialize database class
require_once './db.class.php';
require '../vendor/autoload.php';
use Firebase\JWT\JWT;
use Twilio\Rest\Client;


$data = json_decode(file_get_contents("php://input"));

$mobile = $data->mobile;
$otp = $data->otp;

$db = new DB();

$statusMsg = $receipient_no = '';
$otpDisplay = $verified = 0;

// If mobile number submitted by the user
if (isset($mobile)) {
    if (!empty($mobile)) {
        // Recipient mobile number
        $recipient_no = $mobile;

        // Generate random verification code
        $rand_no = rand(10000, 99999);
        echo json_encode(array("message" => "Rand No set."));
        // Check previous entry
        $conditions = array(
            'mobile_number' => $recipient_no,
        );
        $checkPrev = $db->checkRow($conditions);
        echo json_encode(array("message" => "Checking...."));
        // Insert or update otp in the database
        if ($checkPrev) {
            echo json_encode(array("message" => "Mobile exist"));
            $otpData = array(
                'verification_code' => $rand_no
            );
            $insert = $db->update($otpData, $conditions);
        } else {
            $otpData = array(
                'mobile_number' => $recipient_no,
                'verification_code' => $rand_no,
                'verified' => 0
            );
            $insert = $db->insert($otpData);
        }

        if ($insert) {
            echo json_encode(array("message" => "try sending sms"));
            // Send otp to user via SMS
            $message = 'Cher utilisateur, votre mot de passe unique est le ' . $rand_no . '. Merci. FLY WIFI';



            // Your Account SID and Auth Token from twilio.com/console
            $account_sid = 'AC80c536d1280e654dd5338508d4e25394';
            $auth_token = '3c3f14f77446899013766bea77fdf6fb';
            // In production, these should be environment variables. E.g.:
            // $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]

            // A Twilio number you own with SMS capabilities
            $twilio_number = "+19897955779";

            $client = new Client($account_sid, $auth_token);
            $client->messages->create(
                // Where to send a text message (your cell phone?)
                '+' . $mobile,
                array(
                    'from' => $twilio_number,
                    'body' => $message
                )
            );
        } else {
            $statusMsg = array(
                'status' => 'error',
                'msg' => 'Some problem occurred, please try again.'
            );
        }
    } else {
        $statusMsg = array(
            'status' => 'error',
            'msg' => 'Please enter your mobile number.'
        );
    }

    // If verification code submitted by the user
} elseif (isset($otp) && !empty($otp)) {
    $otpDisplay = 1;
    $recipient_no = $mobile;
    if (!empty($otp)) {
        $otp_code = $otp;

        // Verify otp code
        $conditions = array(
            'mobile_number' => $recipient_no,
            'verification_code' => $otp_code
        );
        $check = $db->checkRow($conditions);

        if ($check) {
            $otpData = array(
                'verified' => 1
            );
            $update = $db->update($otpData, $conditions);

            $statusMsg = array(
                'status' => 'success',
                'msg' => 'Thank you! Your phone number has been verified.'
            );

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
                )
            );

            http_response_code(200);

            $jwt = JWT::encode($token, $secret_key, 'HS256');
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
                )
            );

            $verified = 1;
        } else {
            $statusMsg = array(
                'status' => 'error',
                'msg' => 'Verification code incorrect, please try again.'
            );
        }
    } else {
        $statusMsg = array(
            'status' => 'error',
            'msg' => 'Please enter the verification code.'
        );
    }
}
