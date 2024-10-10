<?php
require_once("../../../config/root_path.php");
require_once(RUTA . "config/database/conexion.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL . 'css/index.css' ?>">
</head>

<body>
    <div class="container">
        <header>
            <?php include(RUTA . 'modules/header/tituloWeb/php/tituloWeb.php'); ?>
            <?php include(RUTA . 'modules/header/filtroBusqueda/php/filtroBusqueda.php'); ?>
            <?php include(RUTA . 'modules/header/btnPerfil/php/btnPerfil.php'); ?>
        </header>
        <main>
            <?php include(RUTA . 'modules/asideMenu/php/asideMenu.php'); ?>
        </main>
        <footer>
            footer
        </footer>
    </div>
    <script src="<?php echo BASE_URL . 'js/jquery-3.7.1.min.js'; ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="<?php echo BASE_URL . 'modules/header/filtroBusqueda/js/ajaxDeportes.js'; ?>"></script>
    <script src="<?php echo BASE_URL . 'modules/header/filtroBusqueda/js/fechaFlatpickr.js'; ?>"></script>
    <script src="<?php echo BASE_URL . 'modules/header/btnPerfil/js/btnPerfil.js'; ?>"></script>
    <script src="<?php echo BASE_URL . 'modules/asideMenu/js/menuAside.js'; ?>"></script>
</body>

</html>