<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Регистрация</title>
</head>
<body>
    Привет
    <form action="{{ route('registration') }}" method="post">
        <button type="submit">Send</button>
    </form>
</body>
</html>