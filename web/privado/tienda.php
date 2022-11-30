<?php
require 'modelo.php';

session_start();
//Restringir acceso
if (!isset($_SESSION['usuario'])) {
    header('HTTP/1.0 401 Unauthorized');
    echo 'No tienes acceso a esta página, <a href="../login.php">inicia sesión</a>.';
    exit();
}

$productoNuevo = [];
//Una funcion que se utiliza para comprobar si el producto enviado es igual a la id de modelo.php 
function productoValido($producto) {
global $productos;

$resultado = array_filter($productos, fn($p) => $p['id'] == $producto);

if (count($resultado) == 1) {
return $productos[$producto];
} else {
return false;
}
}
//Se hacen las validaciones y saneado
if ($_POST) {
$datos = [
'producto' => htmlspecialchars(trim($_POST['producto'])),
'cantidad' => htmlspecialchars(trim($_POST['cantidad']))
];

$argumentos = [
'producto' => [
'filter' => FILTER_CALLBACK,
'options' => 'productoValido'
],
'cantidad' => [
'filter' => FILTER_VALIDATE_INT,
'options' => ['min_range' => 1]
]
];

$validaciones = filter_var_array($datos, $argumentos);
//Si pasa las validaciones se crean las variables 
if ($validaciones['producto'] !== false && $validaciones['cantidad'] !== false) {
$producto = $datos['producto'];
$cantidad = $datos['cantidad'];
$_SESSION[$producto] = $cantidad;
$productoNuevo[$producto] = $cantidad;
}
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
            <li>Home</li>
            <li><a href="pagina_publica.php">Página pública</a></li>
            <li><a href='privado/pagina_privada.php'>Página privada</a></li>
            <li><a href='logout.php'>Cerrar sesión (<?php echo $_SESSION['usuario'] ?>)</a></li>
            <li><a href='carrito.php'>Carrito de la compra()</a></li>
            <li><strong>Tienda</strong></li>
        </ul>
    </nav>

    <main>
        <?php if ($productoNuevo) { ?>
            <section>
                <p>
                    Se ha añadido un nuevo producto:
                </p>
                <p>
                <ul>

                    <li><?= array_key_first($productoNuevo) . ": " . $productoNuevo[array_key_first($productoNuevo)] ?></li>
                </ul>
                </p>
            </section>
        <?php } ?>

        <section>
            <form action="" method="post">
                <p>
                    <label for="producto">Elige un producto</label>
                    <select name="producto" id="producto">
                        <?php
                        //Se valida y se muestran los productos con un foreach
                        foreach ($productos as $producto) {
                            echo "<option value='{$producto['id']}'>{$producto['valor']}</option>";
                            if (isset($validaciones) && $validaciones['producto'] === false) {
                                echo "<p>$producto no es una opción válida</p>";
                            }
                        }
                        ?>
                    </select>
                </p>
                <p>
                    <label for="cantidad">Elige la cantidad</label>
                    <input type="number" name="cantidad" id="cantidad">
                    <?php
                    if (isset($validaciones) && $validaciones['cantidad'] === false) {
                        echo "<p>{$datos['cantidad']} no es una cantidad válida, elige una cantidad mayor que 0</p>";
                    }
                    ?>
                </p>
                <p>
                    <input type="submit" value="Añadir al carrito">
                </p>
            </form>
        </section>
    </main>

    <footer>
        <small><em>&copy; El SuperCarrito de la compra</em></small>
    </footer>
</body>

</html>