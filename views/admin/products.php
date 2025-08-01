<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interpc.net@</title>
    <link rel="icon" href="/interpc/img/logo.png" type="image/png">
    <link href="/interpc/css/tableproducts.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <div class="d-flex justify-content-between align-items-center px-4 py-2" style="background-color: #62aaf1;">
    <h5 class="mb-0">Inventario de Productos</h5>
    <a class="btn btn-outline-primary" onclick="mostrarNotificacion()"><img src="/interpc/icons/alarm_alert.svg" alt="Uptade" width="20" height="20">Notificaciones</a>
          <!--Mostrar notificacion prueba-->
       <script>
     function mostrarNotificacion() {
    const toast = new bootstrap.Toast(document.getElementById('miToast'));
    toast.show();
  }
    
    </script>
    <a href="/interpc/index.html" class="btn btn-outline-primary"><img src="/interpc/icons/exit.svg" alt="Uptade" width="20" height="20">Salir</a>
  </div>

    <img src="/interpc/img/logo.png">
   <table class="table">
    <thead>
      <tr>
        <th scope="col">Nombre</th>
        <th scope="col">Descripción</th>
        <th scope="col">Precio</th>
        <th scope="col">Stock</th>
        <th scope="col">Categoría</th>
        <th scope="col">Imagen</th>
      </tr>
    </thead>
    <tbody>
      <?php
      error_reporting(E_ALL);
      ini_set('display_errors', 1);

      include '../../config/conex.php';
      $result = $conn->query("SELECT * FROM producto");
      while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['nombre']}</td>";
        echo "<td>{$row['descripcion']}</td>";
        echo "<td>\${$row['precio']}</td>";
        echo "<td>{$row['stock']}</td>";
        echo "<td>{$row['categoria']}</td>";
        echo "<td><img src='../../{$row['imagen']}' width='50'></td>";

        echo "<td>";

        
         echo "<button type='button' class='color-orange' data-bs-toggle='modal' data-bs-target='#editProductModal'";
         echo " data-id='{$row['producto_id']}'"; 
         echo " data-nombre='" . htmlspecialchars($row['nombre']) . "'"; 
         echo " data-descripcion='" . htmlspecialchars($row['descripcion']) . "'";
         echo " data-precio='{$row['precio']}'";
         echo " data-stock='{$row['stock']}'";
         echo " data-categoria='" . htmlspecialchars($row['categoria']) . "'";
         echo " data-imagen-path='../{$row['imagen']}'>"; 
         echo "Editar</button>";
         echo "</td>";
        echo "</tr>";
         
      }
      $conn->close();
      ?>
      
    </tbody>
  </table>

<div style="display: flex; gap: 10px;"> <!--div, botones en forma horizontal-->
<button class="color-green" data-bs-toggle="modal" data-bs-target="#addProductModal"><img src="/interpc/icons/basket.svg" alt="Basket" width="20" height="20"> Añadir producto </button>
<button class="color-blue" onclick="Mensaje()"><img src="/interpc/icons/uptade.svg" alt="Uptade" width="20" height="20">Actualizar</button>
<button class="color-red"><img src="/interpc/icons/delete.svg" alt="Uptade" width="20" height="20">Eliminar</button>
<a href="/interpc/reports/servidor.report.php" class="color-orange" style="text-decoration: none;"><img src="/interpc/icons/reports.svg" alt="Reports" width="20" height="20">Generar reporte</a>
</div>

<!-- Modal Añadir Producto -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" method="POST" action="/interpc/controllers/products.controller.php" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title" id="addProductLabel">Añadir Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre</label>
          <input type="text" class="form-control" name="nombre" required>
        </div>
        <div class="mb-3">
          <label for="descripcion" class="form-label">Descripción</label>
          <textarea class="form-control" name="descripcion" required></textarea>
        </div>
        <div class="mb-3">
          <label for="precio" class="form-label">Precio</label>
          <input type="number" step="0.01" class="form-control" name="precio" required>
        </div>
        <div class="mb-3">
          <label for="stock" class="form-label">Stock</label>
          <input type="number" class="form-control" name="stock" required>
        </div>
        <div class="mb-3">
          <label for="categoria" class="form-label">Categoría</label>
          <input type="text" class="form-control" name="categoria" required>
        </div>
        <div class="mb-3">
          <label for="imagen" class="form-label">Imagen</label>
          <input type="file" class="form-control" name="imagen" accept="image/*" required>
        </div>
        <input type="hidden" name="add_product" value="1">
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Guardar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Actualizar Producto -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="EditProductLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="/interpc/controllers/products.controller.php" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title" id="EditProductLabel">Editar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editProductId" name="producto_id">
                
                <div class="mb-3">
                    <label for="editProductName" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="editProductName" name="nombre">
                </div>
                <div class="mb-3">
                    <label for="editProductDescription" class="form-label">Descripción</label>
                    <textarea class="form-control" id="editProductDescription" name="descripcion"></textarea>
                </div>
                <div class="mb-3">
                    <label for="editProductPrice" class="form-label">Precio</label>
                    <input type="number" step="0.01" class="form-control" id="editProductPrice" name="precio">
                </div>
                <div class="mb-3">
                    <label for="editProductStock" class="form-label">Stock</label>
                    <input type="number" class="form-control" id="editProductStock" name="stock">
                </div>
                <div class="mb-3">
                    <label for="editProductCategory" class="form-label">Categoría</label>
                    <input type="text" class="form-control" id="editProductCategory" name="categoria">
                </div>
                <div class="mb-3">
                    <label for="currentProductImage" class="form-label">Imagen Actual</label>
                    <img id="currentProductImage" src="" alt="Imagen del producto" width="80" class="d-block mb-2">
                    <label for="newProductImage" class="form-label">Cambiar Imagen (opcional)</label>
                    <input type="file" class="form-control" id="newProductImage" name="imagen" accept="image/*">
                    <small class="form-text text-muted">Deja en blanco si no quieres cambiar la imagen.</small>
                </div>
                <input type="hidden" name="update_product" value="1">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="saveChangesButton">Actualizar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const editModal = document.getElementById('editProductModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        document.getElementById('editProductId').value = button.getAttribute('data-id');
        document.getElementById('editProductName').value = button.getAttribute('data-nombre') || '';
        document.getElementById('editProductDescription').value = button.getAttribute('data-descripcion') || '';
        document.getElementById('editProductPrice').value = button.getAttribute('data-precio') || '';
        document.getElementById('editProductStock').value = button.getAttribute('data-stock') || '';
        document.getElementById('editProductCategory').value = button.getAttribute('data-categoria') || '';
        document.getElementById('currentProductImage').src = button.getAttribute('data-imagen-path') || '';
    });
});
</script>
<script>
  //Script de actualizar, envio mensaje actualizacion exitosa
   window.onload = function() {
            const params = new URLSearchParams(window.location.search);
            const mensajeDiv = document.getElementById("mensaje");

             if (params.get("mensaje") === "ok") {
                mensajeDiv.style.display = "block";
                mensajeDiv.style.backgroundColor = "#d4edda";
                mensajeDiv.style.color = "#155724";
                mensajeDiv.innerText = "Producto actualizado correctamente.";

                // Ocultar luego de 3 segundos
                setTimeout(() => {
                    mensajeDiv.style.display = "none";
                }, 3000);
            }
   }
  </script>



<!-- Bootstrap JS y dependencias -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!--Mostrar notificacion-->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
  <div id="miToast" class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">
        🔔 ¡Tienes una nueva notificación!
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
    </div>
  </div>
</div>

<script>
  function Mensaje(){
  const toast = new bootstrap.Toast(document.getElementById('miToast2'));
    toast.show();
  }
</script>

<!-- Toast Mensaje-->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
  <div id="miToast2" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">
        ✅ Seleccione el boton editar para actualizar producto.
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
    </div>
  </div>
</div>


</body>
</html>