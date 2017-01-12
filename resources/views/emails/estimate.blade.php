<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cotización</title>
</head>
<body>
    <header>
        <p>Hola, {{ $estimate->client->name }}</p>
    </header>

    <div class="message">{{ $request->input('message') }}</div>
    <!-- /.message -->

    <div class="notes">{{ $estimate->notes }}</div>
    <!-- /.notes -->

    <footer>
        <p>Artífice</p>
    </footer>
</body>
</html>
