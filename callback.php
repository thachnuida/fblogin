<?php
    session_start();
    
    $app_id = "509011619175617";
    $app_secret = "226491c9633bf31817077cfde437fe0d";
    $redirect_uri = urlencode("http://localhost/fblogin/callback.php");    
    
    // Get code value
    $code = $_GET['code'];
    
    // Get access token info
    $facebook_access_token_uri = "https://graph.facebook.com/oauth/access_token?client_id=$app_id&redirect_uri=$redirect_uri&client_secret=$app_secret&code=$code";    
    
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $facebook_access_token_uri);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    
        
    $response = curl_exec($ch); 
    curl_close($ch);
    
    // Get access token
    $aResponse = explode("&", $response);

    $access_token = str_replace('access_token=', '', $aResponse[0]);
    
    // Get user infomation
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/me?access_token=$access_token");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    
        
    $response = curl_exec($ch); 
    curl_close($ch);
    
    $user = json_decode($response);

    //print_r($user);
    // Log user in
    $_SESSION['user_login'] = true;
    $_SESSION['user_name'] = $user->username;
    $_SESSION['access_token'] = $access_token;
    
    echo "Wellcome ". $user->username ."!";    
     echo "Wellcome ". $access_token ."!";  

?>
