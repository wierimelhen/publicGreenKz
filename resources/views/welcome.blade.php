<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>City controller</title>

    <!-- Styles -->

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>



<body>



    <!-- React root DOM -->

    <div id="user">

    </div>



    <!-- React JS -->

    <script src="{{ asset('js/app.js') }}" defer></script>

    <div id="getcoords"
        style="  display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0 0 0 / 87%);
        align-content: center;
        text-align: center "
  >
    <button
    onclick="location.href='getcoords'"
    id='getcoords'
    type="button"
        style="
        background-color: #5c7000;
        margin: 15% auto;
        padding: 20px;
        color: #fff;
        border: 1px solid #085d07;
        border-radius: 10px;
        font-weight: 700;
        width: 80%;">
                    Сформировать GPS-координаты
    </button>
    </div>

</body>

</html>

<!-- onclick="location.href='getcoords'"  -->
