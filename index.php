<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Librería Online</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Librería Online</h1>
        <nav>
            <ul>
                <li><a class="btn" href="index.php">Inicio</a></li>
                <li><a class="btn" href="libros.php">Libros</a></li>
                <li><a class="btn" href="autores.php">Autores</a></li>
                <li><a class="btn" href="contacto.php">Contacto</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <?php
        // Conexión a la base de datos
        $conexion = new mysqli('sql307.infinityfree.com', 'if0_36989115', 'VnYGOxCbrrg', 'if0_36989115_dblibreria');
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }
      

        $pagina_actual = basename($_SERVER['PHP_SELF']);

        switch ($pagina_actual) {
            case 'libros.php':
                echo "<h2>Nuestros Libros</h2>";
                $query = "SELECT titulo FROM titulos WHERE id_titulo IN (SELECT id_titulo FROM titulo_autor);";
                $resultado = $conexion->query($query);
                if ($resultado->num_rows > 0) {
                    echo "<ul>";
                    while ($fila = $resultado->fetch_assoc()) {
                        echo "<li>{$fila['titulo']}</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>No se encontraron libros.</p>";
                }
                break;
           case 'autores.php':
           echo "<h2>Nuestros Autores</h2>";
           $query = "SELECT CONCAT(nombre, ' ', apellido) AS nombre_completo FROM autores";
           $resultado = $conexion->query($query);
           if ($resultado->num_rows > 0) {
           echo "<ul>";
             while ($fila = $resultado->fetch_assoc()) {
            echo "<li>{$fila['nombre_completo']}</li>";
          }
        echo "</ul>";
    } else {
        echo "<p>No se encontraron autores.</p>";
    }
    break;
            case 'contacto.php':
                echo "<h2>Ponte en contacto con nosotros</h2>";
                include 'fade-in.php'; // Incluye el efecto fade-in
                ?>
                <section class="fade-in">
                    <h2>Formulario de Contacto</h2>
                    <?php
                    // Comprueba si la sesión ya está activa antes de iniciarla
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    
                    // Mostrar el mensaje de éxito si existe
                    if (isset($_SESSION['mensaje'])) {
                        echo '<p style="color: green;">' . $_SESSION['mensaje'] . '</p>';
                        unset($_SESSION['mensaje']); // Limpiar el mensaje para que no se muestre nuevamente al actualizar la página
                    }
                    ?>
                    <form id="contact-form" action="contacto.php" method="post">
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" required>

                        <label for="correo">Correo:</label>
                        <input type="email" name="correo" id="correo" required>

                        <label for="asunto">Asunto:</label>
                        <input type="text" name="asunto" id="asunto" required>

                        <label for="comentario">Comentario:</label>
                        <textarea name="comentario" id="comentario" rows="4" required></textarea>

                        <button type="submit">Enviar</button>
                    </form>

                    <div id="success-message" style="display: none;">
                        <p>¡Gracias por tu mensaje! Nos pondremos en contacto contigo pronto.</p>
                    </div>
                </section>
                <?php
                break;
            default:
                echo "<h2>Bienvenido a nuestra Librería Online</h2>";
                echo "<p>Explora nuestra colección de libros y autores.</p>";
        }

        // Cerrar la conexión
        $conexion->close();
        ?>
    </main>

    <footer>
        <p> <?php echo date('Y'); ?> Librería Online. Todos los derechos reservados.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>