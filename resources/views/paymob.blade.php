<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Paymob</title>
</head>
<body>
    <form action="{{route('paymob.checkout')}}" method="post">
        @csrf

        <input type="submit" value="Pay">
    </form>
</body>
</html>