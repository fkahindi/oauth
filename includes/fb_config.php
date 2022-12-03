<?php
if(!isset($_SESSION)){
  session_start();
}
//initialize facebook sdk
require_once __DIR__ .'/../vendor/autoload.php';

$fb = new \Facebook\Facebook([
  'app_id' => '2968858586707259',
  'app_secret' => 'eaed3131ce85a3f86f63f33af7f3f69d',
  'default_graph_version' => 'v2.10',
]);

$helper = $fb->getJavaScriptHelper();
//$helper = $fb->getRedirectLoginHelper();
try {
  $accessToken = $helper->getAccessToken();
  //echo 'Access Token: '. $accessToken;
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}


try {
  if (isset($_SESSION['facebook_access_token'])) {
    $accessToken = $_SESSION['facebook_access_token'];
  } else {
    $accessToken = $helper->getAccessToken();
  }
} catch(Facebook\Exceptions\facebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (isset($accessToken)) {

  if (isset($_SESSION['facebook_access_token'])) {
    $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
  } else {
    // getting short-lived access token
    $_SESSION['facebook_access_token'] = (string) $accessToken;

    // OAuth 2.0 client handler
    $oAuth2Client = $fb->getOAuth2Client();

    // Exchanges a short-lived access token for a long-lived one
    $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);

    $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;

    // setting default access token to be used in script
    $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
  }
    // redirect the user to the profile page if it has "code" GET variable
  if (isset($_GET['code'])) {
    header('Location: https://localhost/spexproject/index.php');
    //echo 'Code Obtained successful! Here it is: ' . $_GET['code'];
  }
    // getting basic info about user
  try {
    $graphResponse = $fb->get('/me?fields=name,first_name,last_name,email,picture');
    $fbUser = $graphResponse->getGraphUser();

    // Getting user's profile data
    $fbUserData = array();
    $fbUserData['uid']  = !empty($fbUser['id'])?$fbUser['id']:'';
    $fbUserData['username'] = !empty($fbUser['first_name'])?$fbUser['first_name']:'';
    $fbUserData['fullname'] = !empty($fbUser['first_name'])?$fbUser['name']:'';
    $fbUserData['email']      = !empty($fbUser['email'])?$fbUser['email']:'';
    $fbUserData['profile_photo']    = !empty($fbUser['picture']['url'])?$fbUser['picture']['url']:'';
    $fbUserData['oauth_provider'] = 'facebook';

    $_SESSION['user_id'] = $fbUserData['uid'];
    $_SESSION['oauth_provider'] = $fbUserData['oauth_provider'];
    $_SESSION['fullname'] = $fbUserData['fullname'];
    $_SESSION['username'] = $fbUserData['name'];
    $_SESSION['email'] = $fbUserData['email'];
    $_SESSION['picture'] = $fbUserData['picture'];
    $_SESSION['loggedin'] = true;
    
    echo 'success';
    
  } catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    session_destroy();
    // redirecting user back to app login page
    header("Location: ./");
    exit;
  } catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
  }
}