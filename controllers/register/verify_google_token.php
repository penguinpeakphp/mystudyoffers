<?php
require_once '../composer/vendor/autoload.php';
require_once "../../admin/database/db.php";
require_once "../functions/globalfunctions.php";

function verifyGoogleToken($id_token)
{
    global $db;

    $clientID = '670817371755-pomo5q87gsc1ebaajdf2dd06ha3prv5q.apps.googleusercontent.com';

    $client = new Google_Client(['client_id' => $clientID]);
    $payload = $client->verifyIdToken($id_token);

    if ($payload) {
        $google_id = $payload['sub'];
        $email = $payload['email'];
        $first_name = $payload['given_name'];
        $last_name = $payload['family_name'];

        $stmt = $db->prepare("SELECT * FROM student WHERE google_id = ?");
        $stmt->bind_param("s", $google_id);
        if ($stmt->execute() == false) {
            failure($response, "Error while fetching student followups");
        }
        $result = $stmt->get_result();
        $result = $result->fetch_assoc();

        if ($result) {
            // User already exists
            echo json_encode(['success' => true, 'existing_user' => true, 'student' => $result, 'google_id' => $google_id, 'email' => $email]);
        } else {
            // New user, prompt for additional details
            echo json_encode(['success' => true, 'existing_user' => false, 'email' => $email, 'first_name' => $first_name, 'last_name' => $last_name, 'google_id' => $google_id]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid ID token']);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idtoken'])) {
    verifyGoogleToken($_POST['idtoken']);
}
