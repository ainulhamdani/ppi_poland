<!-- <meta name="google-signin-client_id" content="1082863603784-hpn3uloet7chbgus9l5rq4rh7s5bj3ic.apps.googleusercontent.com">
<script src="https://apis.google.com/js/platform.js" async defer></script>
<script>
function onSignIn(googleUser) {
  var profile = googleUser.getBasicProfile();
  console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
  console.log('Name: ' + profile.getName());
  console.log('Image URL: ' + profile.getImageUrl());
  console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
  signOut();
}
function signOut() {
  var auth2 = gapi.auth2.getAuthInstance();
  auth2.signOut().then(function () {
    console.log('User signed out.');
  });
}
</script>
<style>
.abcRioButton.abcRioButtonLightBlue { width:100% !important; margin: 0 auto;}
</style> -->
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">
<script src="https://apis.google.com/js/api:client.js"></script>
<script>
var googleUser = {};
var startApp = function() {
  gapi.load('auth2', function(){
    // Retrieve the singleton for the GoogleAuth library and set up the client.
    auth2 = gapi.auth2.init({
      client_id: '1082863603784-hpn3uloet7chbgus9l5rq4rh7s5bj3ic.apps.googleusercontent.com',
      cookiepolicy: 'single_host_origin',
      // Request scopes in addition to 'profile' and 'email'
      //scope: 'additional_scope'
    });
    attachSignin(document.getElementById('google-sign'));
  });
};

function attachSignin(element) {
  console.log(element.id);
  auth2.attachClickHandler(element, {}, onSignIn, function(error) {
        alert(JSON.stringify(error, undefined, 2));
      });
}
function onSignIn(googleUser) {
  var profile = googleUser.getBasicProfile();
  document.getElementById('fullname').value = profile.getName();
  document.getElementById('email').value = profile.getEmail();
  signOut();
}
function signOut() {
  var auth2 = gapi.auth2.getAuthInstance();
  auth2.signOut().then(function () {});
}
startApp();
</script>
