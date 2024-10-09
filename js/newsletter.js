document.getElementById('mailchimp-signup-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const email = document.getElementById('email').value;
    const name = document.getElementById('name').value;
    const surname = document.getElementById('surname').value;
    const responseMessage = document.getElementById('response-message');

    // Prepare the data to send via POST
    const data = new URLSearchParams();
    data.append('email', email);
    data.append('name', name);
    data.append('surname', surname);

    // Use the fetch API to send the data
    fetch(`${ajax_object.ajax_url}?action=mailchimp_subscribe`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: data.toString() // Properly encode the form data
    })
    .then(response => response.json()) // Parse the JSON response
    .then(data => {
        // Display success or error message based on response
        responseMessage.textContent = data.success 
            ? 'Successfully subscribed!' 
            : `Error: ${data.message || 'Unknown error occurred.'}`;
    })
    .catch(error => {
        // Handle and display any errors that occur
        console.error('Error occurred:', error);
        responseMessage.textContent = `An error occurred: ${error.message || 'Unknown error occurred.'}`;
    });
});
