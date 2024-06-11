<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener</title>
</head>
<body>
<form id="urlForm">
    <input type="text" name="url" id="url" placeholder="Введите URL">
    <button type="submit">Сократить</button>
    <div id="error-message" style="color: red;"></div>
</form>

<div id="shortUrl"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<script>
    const form = document.getElementById('urlForm');
    const shortUrlDiv = document.getElementById('shortUrl');
    const errorMessageDiv = document.getElementById('error-message');

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        const url = document.getElementById('url').value;

        axios.post('/shorten', { url })
            .then(response => {
                const shortUrl = response.data.short_url;
                shortUrlDiv.innerHTML = `<p>Short URL: <a href="${shortUrl}" target="_blanc">${shortUrl}</a></p>`;
                errorMessageDiv.innerHTML = ''; // Clear errors
            })
            .catch(error => {
                if (error.response && error.response.data.errors) {
                    const errors = error.response.data.errors;
                    if (errors.url) {
                        errorMessageDiv.innerHTML = errors.url[0];
                    }
                } else {
                    errorMessageDiv.innerHTML = 'An error occurred while sending the request.';
                }
                shortUrlDiv.innerHTML = ''; // Clear short URL
            });
    });
</script>
</body>
</html>
