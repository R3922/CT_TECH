document.addEventListener('DOMContentLoaded', function() {
  var cloneButton = document.getElementById('cloneButton');
  var deleteButton = document.getElementById('deleteButton');
  var container = document.getElementById('detalle-container');
  // Obtenemos el tbody donde se encuentran las filas
  var tableBody = container.querySelector('.detalle-table tbody');
  // La fila base (plantilla) que se clonará
  var templateRow = tableBody.querySelector('#detalle-row');

  // Actualiza la visibilidad del botón de eliminar según la cantidad de filas de detalle (excluyendo filas de comentarios)
  function updateDeleteButton() {
    var rows = tableBody.querySelectorAll('tr:not(.comment-row)');
    deleteButton.style.display = rows.length > 1 ? 'inline-block' : 'none';
  }

  // Función auxiliar para formatear números: redondea al entero más cercano y agrega separadores de miles según el formato español
  function formatNumber(value) {
    return Math.round(value).toLocaleString('es-ES', {
      minimumFractionDigits: 0,
      maximumFractionDigits: 0
    });
  }
  
  // Recalcula el total de una fila (cantidad * precio)
  function recalculateRow(row) {
    var cantidadInput = row.querySelector('.cantidad');
    var precioInput = row.querySelector('.precio');
    var totalCell = row.querySelector('.total');

    var cantidad = parseFloat(cantidadInput.value) || 0;
    var precio = parseFloat(precioInput.value) || 0;
    var rowTotal = cantidad * precio;

    totalCell.textContent = formatNumber(rowTotal);
    console.log('Fila recalculada:', rowTotal);
  }

  // Actualiza el Total Neto sumando los totales de las filas de detalle y calcula IVA y Total
  function updateTotalNeto() {
    // Solo se consideran las filas de detalle, excluyendo las filas de comentarios
    var rows = tableBody.querySelectorAll('tr:not(.comment-row)');
    var totalNeto = 0;
    rows.forEach(function(row) {
      var totalCell = row.querySelector('.total');
      if (totalCell) {
        // Se elimina el separador de miles para parsear el número
        var rowText = totalCell.textContent;
        var rowNumber = parseFloat(rowText.replace(/\./g, '')) || 0;
        totalNeto += rowNumber;
      }
    });
    
    document.getElementById('totalNeto').textContent = formatNumber(totalNeto);
    
    var iva = totalNeto * 0.19;
    document.getElementById('iva').textContent = formatNumber(iva);
    
    var total = totalNeto + iva;
    document.getElementById('total').textContent = formatNumber(total);
    
    console.log('Total Neto:', totalNeto, 'IVA:', iva, 'Total:', total);
  }

  // Clona la fila de detalle (plantilla) y limpia sus campos
  cloneButton.addEventListener('click', function() {
    var newRow = templateRow.cloneNode(true);
    // Elimina el id para evitar duplicados en el DOM
    newRow.removeAttribute('id');
    
    // Limpia todos los inputs de la nueva fila
    var inputs = newRow.querySelectorAll('input');
    inputs.forEach(function(input) {
      input.value = "";
    });
    
    // Reinicia la celda de total a "0"
    var totalCell = newRow.querySelector('.total');
    totalCell.textContent = "0";
    
    // Agrega la nueva fila al final del tbody
    tableBody.appendChild(newRow);
    updateDeleteButton();
    updateTotalNeto();
  });
  
  // Elimina la última fila de detalle (solo si hay más de una)
  deleteButton.addEventListener('click', function() {
    var rows = tableBody.querySelectorAll('tr:not(.comment-row)');
    if (rows.length > 1) {
      tableBody.removeChild(rows[rows.length - 1]);
      updateDeleteButton();
      updateTotalNeto();
    }
  });
  
  // Delegación de eventos: cuando se modifiquen los inputs de cantidad o precio, recalcula la fila y actualiza los totales
  tableBody.addEventListener('input', function(event) {
    if (event.target.matches('.cantidad') || event.target.matches('.precio')) {
      var row = event.target.closest('tr');
      // Asegurarse de que la fila no sea una fila de comentarios
      if (!row.classList.contains('comment-row')) {
        recalculateRow(row);
        updateTotalNeto();
      }
    }
  });
  
  updateDeleteButton();
});
