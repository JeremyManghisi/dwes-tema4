<?php
require 'modelo.php';

session_start();
if (!isset($_SESSION['usuario'])) {
    header('HTTP/1.0 401 Unauthorized');
    echo 'No tienes acceso a esta página, <a href="../login.php">inicia sesión</a>.';
    exit();
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Carrito de la compra</title>
</head>

<body>
    <header>
        <h1>SuperCarrito Shop</h1>
    </header>
    <nav>
        <ul>
            <li><strong>Home</strong></li>
            <li><a href="pagina_publica.php">Página pública</a></li>
            <li><a href='pagina_privada.php'>Página privada</a></li>
            <li><a href='logout.php'>Cerrar sesión (<?php echo $_SESSION['usuario'] ?>)</a></li>
            <li><strong>Carrito de la compra(<?= totalProductos() ?>)<strong></li>
            <li><a href='tienda.php'>Tienda</a></li>
        </ul>
    </nav>
    <main>
        <section>
            <h1>Cesta de la compra</h1>

            <?php
            if ($_SESSION) {
                echo "<ul>";
                foreach ($_SESSION as $producto => $cantidad) {
                    echo <<<END
                        <li>$producto: $cantidad</li>
                    END;
                }
                echo "</ul>";
            } else {
                echo "<p>No hay productos en el carrito de la compra</p>";
            }
            ?>
        </section>
    </main>

    <footer>
        <small><em>&copy; El SuperCarrito de la compra</em></small>
    </footer>
</body>

</html>