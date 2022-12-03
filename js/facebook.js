$(document).ready(function() {
  var formError = $('.errorMsg');
  $.ajaxSetup({ cache: true });
  $.getScript('https://connect.facebook.net/en_US/sdk.js', function(){
    FB.init({
      appId: '2968858586707259',
      version: 'v15.0' // or v2.1, v2.2, v2.3, ...
    });

  });

  $('#loginbutton').click(function(){
    FB.getLoginStatus(statusChangeCallback);
  });

  function statusChangeCallback(response) {  // Called with the results from FB.getLoginStatus().
    //console.log('statusChangeCallback');
    //console.log(response);                   // The current login status of the person.
    if (response.status === 'connected') {   // Logged into your webpage and Facebook.
      var accessToken = response.authResponse.accessToken;

      aJax(accessToken); //Wait for response from server
    } else{
      // Not logged into your webpage or we are unable to tell.
      loginUser();
    }
  }

  function loginUser(){
    FB.login(function(response) {
      if (response.authResponse) {
        FB.getLoginStatus(function(response){
          if(response.status === 'connected'){
            console.log('connected!');
            var accessToken = response.authResponse.accessToken;
            aJax(accessToken); //Wait for response from server
          }else if(response.status === 'not_authorized') {
            formError.text('User cancelled login or did not fully authorize.');
          }
        });
        } else {
        formError.text('There was a problem');
        }
    });
  }

  const aJax = async(data) => {
      await $.ajax({
          url: 'https://github/spexproject/outh-tests/includes/fb_config.php',
          type: 'post',
          data: 'data',
          success: function(response){
            if(response === 'success'){
              window.location = "https://github/spexproject/outh-tests/profile.php";
            }else{
              console.log('Response from PHP says: ' + response);
            }

          }
      });
  }
});
