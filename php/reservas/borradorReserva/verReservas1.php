<html>
<head>
    <title>Buscar Reservas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h2 {
            color: #333;
        }
        form {
            background-color: lightgray;
            border: 2px solid darkgray;
            padding: 20px;
            width: 300px;
            margin: 0 auto;
            margin-top:10vh;
            text-align: center;
            border-radius: 15px;
        }
        input[type="date"] {
            padding: 10px;
            width: 100%;
            margin-bottom: 10px;
            border: 1px solid darkgray;
        }
        button[type="submit"] {
            background-color: #0074D9; /* Azul */
            color: #fff;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <form action="EstadoReservaProfeDiaz2.php" method="get">
        <h2>Buscar reservas por fecha</h2>
        <input type="date" name="fecha">
        <button type="submit">Buscar</button>
    </form>
</body>
</html>