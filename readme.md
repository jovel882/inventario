<h1 style="text-align: center;">Prueba de desarrollo inventario.</h1>
<p><span style="color: #00ff00;">El software cuenta con:</span></p>
<ol>
<li>Migraciones para crear toda la estructura de BD.</li>
<li>Modelos necesarios.</li>
<li>Factories para generar la carga inicial con datos de pruebas.</li>
<li>Seeders para cargar los datos inciales.</li>
<li>Sistema de roles y perfiles. Se definieron 3 roles:
<ul>
<li>Clientes</li>
<li>Proveedores</li>
<li>Super administrador</li>
</ul>
</li>
<li>Modulos de gestion de productos y ordenes con:
<ul>
<li>Controlador</li>
<li>Vistas</li>
<li>Implementacion de softdeletes.</li>
<li>Politicas de acceso para que solo los proveedores puedan editar unicamente sus entidades y que los admins puedan editar cualquier entidad.</li>
<li>Validaciones con Form Request.</li>
<li>Visualizacion de inventario por producto.</li>
</ul>
</li>
<li>Despliegue en Heroku bajo la URL:&nbsp;<a href="http://inventario-prueba-2019.herokuapp.com/">http://inventario-prueba-2019.herokuapp.com/</a><br />
<ul>
<li>Usuario super admin:
<ul>
<li>user : <a href="mailto:jovel882@gmail.com">jovel882@gmail.com</a></li>
<li>pass: 123456789</li>
</ul>
</li>
<li>Usuario Proveedor 1:
<ul>
<li>user:&nbsp;<a href="mailto:larmstrong@example.com">larmstrong@example.com</a></li>
<li>pass: secret</li>
</ul>
</li>
<li>Usuario Proveedor 2:</li>
<ul>
<li>user:&nbsp;concepcion29@example.net</li>
<li>pass: secret</li>
</ul>
</ul>
</li>
</ol>
<p><span style="color: #ff0000;">El software no cuenta con:</span></p>
<ol>
<li>Creacion de facturas, aunque los modelos qudaron muy encamidanos para ser desarrolladas las interfaces.</li>
<li>Informes de ventas.</li>
<li>Framework FrontEnd.</li>
</ol>
<h2 style="text-align: center;">John Fredy Velasco Bare&ntilde;o</h2>
<h4 style="text-align: center;">jovel882@gmail.com</h4>
<p>&nbsp;</p>
<p>&nbsp;</p>