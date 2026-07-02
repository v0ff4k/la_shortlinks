<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>URL Shortener</title>
</head>
<body>
    <h1>Создать короткую ссылку</h1>
    <form action="/api/urls" method="POST">
        @csrf
        <input type="url" name="original_url" required placeholder="https://example.com">
        <button type="submit">Сократить</button>
    </form>
</body>
</html>
