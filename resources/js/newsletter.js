document.getElementById('mailchimp-signup-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const email = document.getElementById('email').value;
    const name = document.getElementById('name').value;
    const surname = document.getElementById('surname').value;
    const responseMessage = document.getElementById('response-message');

    fetch(ajax_object.ajax_url + '?action=mailchimp_subscribe', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `email=${encodeURIComponent(email)}&name=${encodeURIComponent(name)}&surname=${encodeURIComponent(surname)}`
    })
    .then(response => response.json()) // Ensure the response is parsed as JSON
    .then(data => {
        if (data.success) {
            responseMessage.textContent = 'Successfully subscribed!';
        } else {
            // Display detailed error message from backend
            responseMessage.textContent = `Error: ${data.message || 'Unknown error occurred.'}`;
        }
    })
    .catch(error => {
        // Log the error for better debugging
        console.error('Error occurred:', error);
        responseMessage.textContent = `An error occurred: ${error.message || 'Unknown error occurred.'}`;
    });
});
