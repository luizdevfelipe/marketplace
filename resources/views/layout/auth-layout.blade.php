<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'MarketPlace')</title>
    <link rel="shortcut icon" href="resources/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/resources/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <style>
        body,
        html {
            height: 100vh;
            width: 100vw;
            background-image: url("resources/site/caixas.jpg");
            background-size: cover;
            background-repeat: no-repeat;
        }

        input {
            background-color: transparent;
        }

        input:focus {
            background-color: white;
        }

        fieldset {
            background-color: rgba(0, 0, 0, 0.082);
        }

        a::before {
            content: "\01F517";
        }

        .w350 {
            width: 350px;
        }
    </style>
</head>

<body>
    <section>
        @yield('body')
    </section>
</body>

</html>