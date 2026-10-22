<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro de Recuperación</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #ffffff;
            padding: 40px;
            width: 450px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
        }
        h2 {
            color: #555555;
            font-size: 24px;
            margin-bottom: 25px;
            font-weight: normal;
        }
        label {
            display: block;
            color: #666666;
            font-size: 13px;
            margin-bottom: 8px;
        }
        .input-group {
            margin-bottom: 20px;
        }
        input[type="email"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #cccccc;
            background-color: #f9f9f9;
            box-sizing: border-box;
            border-radius: 2px;
        }
        .btn-enviar {
            width: 100%;
            background-color: #6c8ebf;
            color: white;
            border: none;
            padding: 12px;
            font-size: 15px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border-radius: 2px;
            margin-bottom: 15px;
        }
        .btn-enviar:hover {
            background-color: #597da8;
        }
        .btn-volver {
            display: block;
            text-align: center;
            color: #6c8ebf;
            text-decoration: none;
            font-size: 14px;
        }
        .btn-volver:hover {
            text-decoration: underline;
        }
        .footer-text {
            margin-top: 30px;
            color: #999999;
            font-size: 11px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Recuperar Contraseña</h2>
        
        <form action="recuperar.php" method="POST">
            <div class="input-group">
                <label for="correo">Introduce tu dirección de correo electrónico</label>
                <input type="email" id="correo" name="correo" required>
            </div>

            <button type="submit" class="btn-enviar">
                <span>✉</span> Enviar
            </button>

            <a href="#" class="btn-volver">Volver</a>
        </form>
    </div>

</body>
</html>