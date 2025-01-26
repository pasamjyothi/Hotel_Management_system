<script src="https://accounts.google.com/gsi/client" async defer></script>
<script>
function handleCredentialResponse(response) {
    console.log("Encoded JWT ID token: " + response.credential);
  }

  function initializeGoogleSignIn() {
    google.accounts.id.initialize({
      client_id: "YOUR_GOOGLE_CLIENT_ID", 
      callback: handleCredentialResponse,
    });
    google.accounts.id.renderButton(
      document.getElementById("googleSignInButton"), 
      { theme: "outline", size: "large", text: "continue_with", shape: "pill" } 
    );
  }
  </script>