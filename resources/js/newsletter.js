document.getElementById('mailchimp-signup-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const email = document.getElementById('email').value;
    const name = document.getElementById('name').value;
    const surname = document.getElementById('surname').value;
    const responseMessage = document.getElementById('response-message');

    // Clear any previous messages
    responseMessage.textContent = '';
    responseMessage.classList.remove('text-red-500', 'text-green-500');

    // Prepare the data to send via POST
    const data = new URLSearchParams();
    data.append('email', email);
    data.append('name', name);
    data.append('surname', surname);
    data.append('action', 'mailchimp_subscribe');

    // Use the fetch API to send the data
    fetch(ajax_object.ajax_url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: data.toString()
    })
    .then(response => response.json())
    .then(data => {
        // Display success or error message
        responseMessage.textContent = data.data.message;
        
        // Add appropriate color class based on success/error
        if (data.success) {
            responseMessage.classList.add('text-green-500');
            // Clear the form on success
            document.getElementById('mailchimp-signup-form').reset();
        } else {
            responseMessage.classList.add('text-red-500');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        responseMessage.textContent = ajax_object.generic_error;
        responseMessage.classList.add('text-red-500');
    });
});
