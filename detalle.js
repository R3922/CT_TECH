document.addEventListener('DOMContentLoaded', function() {
    var cloneButton = document.getElementById('cloneButton');
    var deleteButton = document.getElementById('deleteButton');
    var container = document.getElementById('detalle-container');
    
    // Actualiza la visibilidad del botón de eliminar según la cantidad de boxes
    function updateDeleteButton() {
      var boxes = container.querySelectorAll('.detalle-box');
      deleteButton.style.display = boxes.length > 1 ? 'inline-block' : 'none';
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
    });
    
    // Eliminar el último box de detalle (solo si hay más de uno)
    deleteButton.addEventListener('click', function() {
      var boxes = container.querySelectorAll('.detalle-box');
      if (boxes.length > 1) {
        container.removeChild(boxes[boxes.length - 1]);
        updateDeleteButton();
      }
    });
    
    // Función para actualizar el total de una fila (multiplicación de cantidad * precio)
    function updateRowTotal(row) {
      var cantidadInput = row.querySelector('.cantidad');
      var precioInput = row.querySelector('.precio');
      var totalCell = row.querySelector('.total');
      
      var cantidad = parseFloat(cantidadInput.value) || 0;
      var precio = parseFloat(precioInput.value) || 0;
      var total = cantidad * precio;
      totalCell.textContent = total.toFixed(2);
    }
    
    // Delegación de eventos: cuando se modifiquen los inputs, actualizar el total
    container.addEventListener('input', function(event) {
      if (event.target.matches('.cantidad') || event.target.matches('.precio')) {
        var row = event.target.closest('tr');
        if (row) {
          updateRowTotal(row);
        }
      }
    });
  });
  