document.addEventListener('DOMContentLoaded', function() {
    // Delegación de eventos en el tbody para que funcione en filas nuevas (clonadas)
    document.querySelector('.detalle-table tbody').addEventListener('click', function(e) {
      // Si se presiona el botón "Comentarios"
      if (e.target && e.target.classList.contains('comment-btn')) {
        var row = e.target.closest('tr');
        var nextRow = row.nextElementSibling;
        // Si ya existe una fila de comentarios justo debajo, se alterna su visibilidad
        if (nextRow && nextRow.classList.contains('comment-row')) {
          nextRow.style.display = (nextRow.style.display === 'none' || nextRow.style.display === '') 
                                    ? 'table-row' 
                                    : 'none';
        } else {
          // Si no existe, se crea la fila de comentarios y se inserta después de la fila actual
          var commentRow = document.createElement('tr');
          commentRow.classList.add('comment-row');
          // Se asume que la tabla tiene 5 columnas, por ello se usa colspan=5.
          // Si el número de columnas cambia, ajusta este valor.
          var commentCell = document.createElement('td');
          commentCell.colSpan = row.children.length;
          commentCell.innerHTML = `
            <div class="inline-comments-box" style="margin: 5px 0;">
              <textarea placeholder="Escribe tus comentarios" style="width:100%; height: 100px;"></textarea>
              <br>
              <button class="close-comment-btn" type="button">Cerrar Comentarios</button>
            </div>
          `;
          commentRow.appendChild(commentCell);
          // Inserta la nueva fila justo después de la fila actual
          if (row.nextSibling) {
            row.parentNode.insertBefore(commentRow, row.nextSibling);
          } else {
            row.parentNode.appendChild(commentRow);
          }
        }
      }
  
      // Si se presiona el botón "Cerrar Comentarios" dentro de una fila de comentarios, la oculta
      if (e.target && e.target.classList.contains('close-comment-btn')) {
        var commentRow = e.target.closest('tr.comment-row');
        if (commentRow) {
          commentRow.style.display = 'none';
        }
      }
    });
  });
  