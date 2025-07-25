<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Interpc.net@</title>
    <link rel="icon" href="../img/logo.png">
    <link href="../css/interpc.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Catálogo de Productos</h1>
            <right><img src="../img/logo.png" width="50px" height="50px"></right>
            <p>Encuentra los mejores productos de tecnología en Interpc.net</p>
        </div>

        <div class="filters">
            <div class="filter-group">
                <label for="category-filter">Categoría:</label>
                <select id="category-filter">
                    <option value="">Todas las categorías</option>
                    <option value="tecnologia">Tecnología</option>
                </select>

                <label for="price-filter">Precio máximo:</label>
                <input type="number" id="price-filter" placeholder="Ej: 500" min="0">

                <label for="search-filter">Buscar:</label>
                <input type="text" id="search-filter" placeholder="Nombre del producto...">

                <label for="car-filter">Carrito:</label>
                <button class="car-filter" onclick="showCart()" data-bs-toggle="modal" data-bs-target="#cartModal">Ver carrito</button>

          
            </div>
        </div>

        <div class="products-grid" id="products-container">
            <!-- View productos -->
        </div>
                
                    
                </div>
    </div>

    <script>
    let allProducts = [];
    let cart = [];

    function getStockClass(stock) {
        if (stock >= 4) return 'stock-high';
        if (stock >= 2) return 'stock-medium';
        return 'stock-low';
    }

    function getStockText(stock) {
        if (stock >= 4) return 'En Stock';
        if (stock >= 2) return 'Pocas Unidades';
        return 'Última Unidad';
    }

    function formatPrice(price) {
        return new Intl.NumberFormat('es-US', {
            style: 'currency',
            currency: 'USD'
        }).format(price);
    }

    function createProductCard(product) {
        return `
            <div class="product-card">
                <div class="product-image">
                    <img src="../${product.imagen}" alt="${product.nombre}">
                    <div class="stock-badge ${getStockClass(product.stock)}">
                        ${getStockText(product.stock)}
                    </div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">${product.nombre}</h3>
                    <p class="product-description">${product.descripcion}</p>
                    <span class="product-category">${product.categoria}</span>
                    <div class="product-price">${formatPrice(product.precio)}</div>
                    <div class="product-stock">Stock disponible: ${product.stock} unidades</div>
                    <button class="btn-contact" onclick="addToCart('${product.nombre}')">
                        Añadir al carrito
                    </button>
                </div>
            </div>
        `;
    }

    function renderProducts(productsToRender) {
        const container = document.getElementById('products-container');

        if (productsToRender.length === 0) {
            container.innerHTML = `
                <div class="no-products">
                    <h3>No se encontraron productos</h3>
                    <p>Intenta ajustar los filtros de búsqueda</p>
                </div>
            `;
            return;
        }

        container.innerHTML = productsToRender.map(createProductCard).join('');
    }

    function filterProducts() {
        const categoryFilter = document.getElementById('category-filter').value;
        const priceFilter = parseFloat(document.getElementById('price-filter').value) || Infinity;
        const searchFilter = document.getElementById('search-filter').value.toLowerCase();

        const filtered = allProducts.filter(product => {
            const matchesCategory = !categoryFilter || product.categoria === categoryFilter;
            const matchesPrice = parseFloat(product.precio) <= priceFilter;
            const matchesSearch = !searchFilter || product.nombre.toLowerCase().includes(searchFilter);
            return matchesCategory && matchesPrice && matchesSearch;
        });

        renderProducts(filtered);
    }

    // Función modificada para sumar cantidad en el carrito
    function addToCart(productName) {
        const product = allProducts.find(p => p.nombre === productName);
        if (!product) {
            alert('Producto no encontrado.');
            return;
        }

        // Buscar si producto ya está en el carrito
        const index = cart.findIndex(item => item.producto_id === product.producto_id);
        if (index !== -1) {
            // Sumar cantidad
            cart[index].cantidad += 1;
        } else {
            // Agregar producto con cantidad 1
            cart.push({
                producto_id: product.producto_id,
                nombre: product.nombre,
                precio: parseFloat(product.precio),
                cantidad: 1
            });
        }
        alert(`${productName} se ha añadido al carrito.`);
    }

    // Mostrar carrito con cantidades y subtotal
    function showCart() {
        const cartItemsContainer = document.getElementById('cart-items');
        if (cart.length === 0) {
            cartItemsContainer.innerHTML = '<p>El carrito está vacío.</p>';
            return;
        }

        let html = '<ul class="list-group">';
        cart.forEach(item => {
            html += `
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">${item.nombre}</h6>
                        <small>Cantidad: ${item.cantidad}</small>
                    </div>
                    <span class="badge bg-primary rounded-pill">${formatPrice(item.precio * item.cantidad)}</span>
                </li>
            `;
        });
        html += '</ul>';

        cartItemsContainer.innerHTML = html;
    }

    // Cargar productos desde backend
    async function loadProducts() {
        try {
            const res = await fetch('../models/products.model.php');
            const data = await res.json();

            if (data.error) {
                throw new Error(data.error);
            }

            allProducts = data;
            renderProducts(allProducts);
        } catch (error) {
            console.error("Error al cargar productos:", error);
            document.getElementById('products-container').innerHTML = `
                <div class="no-products">
                    <h3>Error al cargar productos</h3>
                    <p>Intenta más tarde</p>
                </div>
            `;
        }
    }

    // Guardar carrito y redirigir a página de pago
    function saveCartAndRedirect() {
        fetch('../controllers/carrito.controller.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
             credentials: 'include',
            body: JSON.stringify({ cart: cart })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.location.href = `../views/pay/pay.php?carrito_id=${data.carrito_id}`;
            } else {
                alert("Error al guardar el carrito: " + data.message);
            }
        })
        .catch(err => {
            console.error("Error:", err);
            alert("Error al conectar con el servidor.");
        });
    }

    // Listeners para filtros
    document.getElementById('category-filter').addEventListener('change', filterProducts);
    document.getElementById('price-filter').addEventListener('input', filterProducts);
    document.getElementById('search-filter').addEventListener('input', filterProducts);

    // Cargar productos 
    loadProducts();
</script>

<!-- Modal del carrito -->
<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cartModalLabel">Carrito de Compras</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body" id="cart-items">
        <!-- Productos del carrito se cargan aquí -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button class="btn btn-primary" onclick="saveCartAndRedirect()">Proceder al pago</button>
      </div>
    </div>
  </div>
</div>


<script>
    function saveCartAndRedirect() {
    fetch('../controllers/carrito.controller.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ cart: cart })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Redirigir al pago con el ID del carrito
            window.location.href = `../views/pay/pay.php?carrito_id=${data.carrito_id}`;
        } else {
            alert("Error al guardar el carrito"  + data.message);
        }
    })
    .catch(err => {
        console.error("Error:", err);
        alert("Error al conectar con el servidor.");
    });
}

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
