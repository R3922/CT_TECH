document.getElementById('clientForm').addEventListener('input', function() {
    // Obtener los valores del formulario
    var vendedor = document.getElementById('nom_ven').value;
    var fecha = document.getElementById('fecha').value;
    var correo = document.getElementById('correo').value;
    var cliente = document.getElementById('cliente').value;
    var giro = document.getElementById('giro').value;
    var rut = document.getElementById('rut').value;
    var lugar = document.getElementById('lugar').value;
    var contacto = document.getElementById('contacto').value;
  
  
    // Actualizar la tabla en la cabecera (suponiendo que la tabla tiene la clase header-table)
    var headerTable = document.querySelector('.header-table');
    if(headerTable) {
      headerTable.innerHTML = `
        <tr>
          <th>Fecha:</th>
          <td>${vendedor}</td>
        </tr>
        <tr>
          <th>Fecha:</th>
          <td>${fecha}</td>
        </tr>
        <tr>
          <th>Cliente:</th>
          <td>${cliente}</td>
        </tr>
        <tr>
          <th>Cliente:</th>
          <td>${giro}</td>
        </tr>
        <tr>
          <th>R.U.T:</th>
          <td>${rut}</td>
        </tr>
        <tr>
          <th>Lugar:</th>
          <td>${lugar}</td>
        </tr>
        <tr>
          <th>Contacto:</th>
          <td>${contacto}</td>
        </tr>
        <tr>
          <th>Correo:</th>
          <td>${correo}</td>
        </tr>
        
      `;
    }
  });
  