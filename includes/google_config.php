<?php
if(!isset($_SESSION)){
  session_start();
}

require_once __DIR__ .'/../../google-api/vendor/autoload.php';

$headers = getallheaders();
// Get $id_token via HTTPS POST.
if(isset($_POST['credential'])){

	$id_token = $_POST['token'];
	//echo 'Yes token is: '.$id_token .' <br> Header: '. $headers['X-Requested-With'] ;


	$client = new Google_Client(['client_id' =>'1007627739117-mmn92vm3mqjimnbap1pmm2r32fq50fe4.apps.googleusercontent.com']);  // Specify the CLIENT_ID of the app that accesses the backend
	$payload = $client->verifyIdToken($id_token);
	if ($payload) {
		$uid = $payload['sub'];
		$oauth_provider = 'google';
		$username = $payload['given_name'];
		$fullname = $payload['name'];
		$email = $payload['email'];
		$picture = $payload['picture'];

		$_SESSION['user_id'] = $uid;
        $_SESSION['oauth_provider'] = $oauth_provider;
        $_SESSION['fullname'] = $fullname;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['picture'] = $picture;
    
        echo 'success';		
		
	} else {
		echo 'Invalid ID token.';
	}

}




