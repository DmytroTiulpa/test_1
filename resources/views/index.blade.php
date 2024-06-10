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
    </form>

    <div id="shortUrl"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    <script>
        const form = document.getElementById('urlForm');
        const shortUrlDiv = document.getElementById('shortUrl');

        form.addEventListener('submit', function(event) {
            event.preventDefault();
            const url = document.getElementById('url').value;

            axios.post('/shorten', { url })
                .then(response => {
                    const shortUrl = response.data.short_url;
                    shortUrlDiv.innerHTML = `<p>Короткий URL: <a href="${shortUrl}">${shortUrl}</a></p>`;
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
</body>
</html>
