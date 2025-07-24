<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? "E-budget email layout" }}</title>
</head>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap');

    :root {
        font-family: 'Roboto', sans-serif;

        font-synthesis: none;
        text-rendering: optimizeLegibility;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
        padding: .5rem 1rem;
    }

    tfoot>tr>td,
    tfoot>tr>th {
        font-weight: bold;
        text-align: right;
    }

    @media screen and (max-width: 400px) {
        td {
            padding: .2rem .5rem;
            font-size: .9rem;
        }
    }
</style>

<body>
    <main>
        {{ $slot }}
    </main>
</body>

</html>
