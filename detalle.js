document.addEventListener('DOMContentLoaded', function() {
  var cloneButton = document.getElementById('cloneButton');
  var deleteButton = document.getElementById('deleteButton');
  var container = document.getElementById('detalle-container');

  // Actualiza la visibilidad del botón de eliminar según la cantidad de boxes
  function updateDeleteButton() {
    var boxes = container.querySelectorAll('.detalle-box');
    deleteButton.style.display = boxes.length > 1 ? 'inline-block' : 'none';
  }
  
  // Función para recalcular el total de una fila (cantidad * precio)
  function recalculateRow(row) {
    var cantidadInput = row.querySelector('.cantidad');
    var precioInput = row.querySelector('.precio');
    var totalCell = row.querySelector('.total');

    var cantidad = parseFloat(cantidadInput.value) || 0;
    var precio = parseFloat(precioInput.value) || 0;
    var rowTotal = cantidad * precio;

    totalCell.textContent = rowTotal.toFixed(2);
    console.log('Fila recalculada:', rowTotal);
  }

  // Función para actualizar el Total Neto sumando todos los totales de las filas, calcular IVA y Total
  function updateTotalNeto() {
    var rows = document.querySelectorAll('.detalle-box tbody tr');
    var totalNeto = 0;
    rows.forEach(function(row) {
      var rowTotal = parseFloat(row.querySelector('.total').textContent) || 0;
      totalNeto += rowTotal;
    });
    
    // Actualiza el Total Neto
    document.getElementById('totalNeto').textContent = totalNeto.toFixed(2);
    
    // Calcular el IVA (19% del Total Neto)
    var iva = totalNeto * 0.19;
    document.getElementById('iva').textContent = iva.toFixed(2);
    
    // Calcular el Total (Total Neto + IVA)
    var total = totalNeto + iva;
    document.getElementById('total').textContent = total.toFixed(2);
    
    console.log('Total Neto:', totalNeto, 'IVA:', iva, 'Total:', total);
  }

  // Clonar el box de detalle y limpiar sus campos
  cloneButton.addEventListener('click', function() {
    var originalBox = container.querySelector('.detalle-box');
    var clone = originalBox.cloneNode(true);
    
    // Limpiar los inputs del clon
    var inputs = clone.querySelectorAll('input');
    inputs.forEach(function(input) {
      input.value = "";
    });
    
    // Reiniciar la celda de total a 0.00
    var totalCells = clone.querySelectorAll('.total');
    totalCells.forEach(function(cell) {
      cell.textContent = "0.00";
    });
    
    container.appendChild(clone);
    updateDeleteButton();
    updateTotalNeto();
  });
  
  // Eliminar el último box de detalle (solo si hay más de uno)
  deleteButton.addEventListener('click', function() {
    var boxes = container.querySelectorAll('.detalle-box');
    if (boxes.length > 1) {
      container.removeChild(boxes[boxes.length - 1]);
      updateDeleteButton();
      updateTotalNeto();
    }
  });
  
  // Delegación de eventos: cuando se modifiquen los inputs de cantidad o precio, actualizar la fila y totales
  container.addEventListener('input', function(event) {
    if (event.target.matches('.cantidad') || event.target.matches('.precio')) {
      var row = event.target.closest('tr');
      recalculateRow(row);
      updateTotalNeto();
    }
  });
});
