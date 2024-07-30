<?php
require_once '../composer/vendor/autoload.php';
require_once "../../admin/database/db.php";
require_once "../functions/globalfunctions.php";
error_reporting(E_ERROR | E_PARSE);

function verifyFacebookToken($access_token)
{
    global $db;

    // sir
    // $appID = '1213234336344178';
    // $appSecret = '45bbc67eaa9c121654894b304eb992fc';

    //mine 
    $appID = '376526152127361';
    $appSecret = 'b33f7e3cedf98b346caa2ac50ffe9088';

    $fb = new \Facebook\Facebook([
        'app_id' => $appID,
        'app_secret' => $appSecret,
        'default_graph_version' => 'v3.2'
    ]);

    try {
        $response = $fb->get('/me?fields=id,first_name,last_name,email', $access_token);
    } catch (\Facebook\Exceptions\FacebookResponseException $e) {
        echo json_encode(['success' => false, 'message' => 'Graph returned an error: ' . $e->getMessage()]);
        exit;
    } catch (\Facebook\Exceptions\FacebookSDKException $e) {
        echo json_encode(['success' => false, 'message' => 'Facebook SDK returned an error: ' . $e->getMessage()]);
        exit;
    }

    $user = $response->getGraphUser();
    
    if (!isset($user['id']) || !isset($user['email'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid user data from Facebook']);
        exit;
    }

    $facebook_id = $user['id'];
    $email = $user['email'];
    $first_name = $user['first_name'];
    $last_name = $user['last_name'];

    $stmt = $db->prepare("SELECT * FROM student WHERE facebook_id = ?");
    $stmt->bind_param("s", $facebook_id);
    if ($stmt->execute() == false) {
        echo json_encode(['success' => false, 'message' => 'Error while fetching student followups']);
        exit;
    }
    $result = $stmt->get_result();
    $result = $result->fetch_assoc();

    if ($result) {
        // User already exists
        echo json_encode([
            'success' => true,
            'existing_user' => true,
            'student' => $result,
            'facebook_id' => $facebook_id,
            'email' => $email
        ]);
    } else {
        // New user, prompt for additional details
        echo json_encode([
            'success' => true,
            'existing_user' => false,
            'email' => $email,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'facebook_id' => $facebook_id
        ]);
    }
}

$_POST = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['access_token'])) {
    verifyFacebookToken($_POST['access_token']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}


/*
change the use cases

*/