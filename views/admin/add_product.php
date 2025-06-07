<form action="products.controller.php" method="POST" enctype="multipart/form-data">
    <label for="nombre">Nombre:</label><br>
    <input type="text" id="nombre" name="nombre" required><br><br>

    <label for="descripcion">Descripción:</label><br>
    <textarea id="descripcion" name="descripcion" rows="3"></textarea><br><br>

    <label for="precio">Precio:</label><br>
    <input type="number" id="precio" name="precio" step="0.01" required><br><br>

    <label for="stock">Stock:</label><br>
    <input type="number" id="stock" name="stock" required><br><br>

    <label for="categoria">Categoría:</label><br>
    <input type="text" id="categoria" name="categoria"><br><br>

    <label for="imagen">Imagen:</label><br>
    <input type="file" id="imagen" name="imagen" accept="image/*"><br><br>

    <input type="submit" name="add_product" value="Guardar Producto">
</form>