document.addEventListener('DOMContentLoaded', function() {
    const uploadButton = document.getElementById('uploadButton');
    const imageInput = document.getElementById('imageInput');
    const gallery = document.getElementById('gallery');
  
    uploadButton.addEventListener('click', function() {
      if (imageInput.files && imageInput.files[0]) {
        const file = imageInput.files[0];
        const reader = new FileReader();
  
        reader.onload = function(e) {
          // Creamos un contenedor para la imagen y el botón de eliminar
          const imageContainer = document.createElement('div');
          imageContainer.classList.add('gallery-item');
  
          const img = document.createElement('img');
          img.src = e.target.result;
          img.alt = file.name;
  
          // Botón para eliminar la imagen (mostrará solo una "×")
          const deleteButton = document.createElement('button');
          deleteButton.textContent = '×';
          deleteButton.classList.add('delete-image');
          deleteButton.addEventListener('click', function() {
            gallery.removeChild(imageContainer);
          });
  
          // Agregamos la imagen y el botón al contenedor
          imageContainer.appendChild(img);
          imageContainer.appendChild(deleteButton);
          // Agregamos el contenedor a la galería
          gallery.appendChild(imageContainer);
  
          // Limpiamos el input para permitir nuevas cargas
          imageInput.value = "";
        };
  
        reader.readAsDataURL(file);
      } else {
        alert("Por favor, selecciona una imagen.");
      }
    });
  });
  