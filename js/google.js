function handleCredentialResponse(response) {
     // decodeJwtResponse() is a custom function defined by you
     // to decode the credential response.
     const responsePayload = decodeJwtResponse(response.credential);

     console.log("ID: " + responsePayload.sub);
     console.log('Full Name: ' + responsePayload.name);
     console.log('Given Name: ' + responsePayload.given_name);
     console.log('Family Name: ' + responsePayload.family_name);
     console.log("Image URL: " + responsePayload.picture);
     console.log("Email: " + responsePayload.email);
     const token = response.credential;
     console.log('Response is: ' + token);

    $.ajax({
      type:'POST',
      url: 'https://github/spexproject/outh-tests/includes/google_config.php',
      data: {
        'credential': 1,
        'token': token
      },
      // Always include an `X-Requested-With` header in every AJAX request,
      // to protect against CSRF attacks.
     /*  headers: {
        'X-Requested-With': 'XMLHttpRequest'
      },
      contentType: 'application/octet-stream; charset=utf-8', */
      success:  function(result){
        // Handle or verify the server response.
        
        if(result === 'success'){
          window.location = "https://github/spexproject/outh-tests/profile.php";
        }else{
          console.log('Response from PHP says: ' + result);
        }
      }
      
    })
    /* $.ajax({
      type: 'POST',
      url: 'https://localhost/spexproject/includes/google_authenticate.php',
      // Always include an `X-Requested-With` header in every AJAX request,
      // to protect against CSRF attacks.
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'token': token
      },
      contentType: 'application/octet-stream; charset=utf-8',
      success: function(result) {
        // Handle or verify the server response.
        console.log('PHP says: '+ result);
      },
      processData: false,
      data: {'ajax-call': true}

    }); */
  }
  function decodeJwtResponse (token) {
    var base64Url = token.split('.')[1];
    var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    var jsonPayload = decodeURIComponent(window.atob(base64).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));

    return JSON.parse(jsonPayload);
}