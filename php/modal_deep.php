
<head>
  
  <title>modal</title>
  <style type="text/css">
    /* Estilos para el modal */
    .modal {
      position: fixed;
      top: 0;
      right: 0;
      bottom: 0;
      left: 0;
      background-color: rgba(0, 0, 0, 0.5);
      display: none;
    }

    .modal-dialog {
      position: relative;
      margin: 15% auto;
      width: 300px;
      background-color: #fff;
      padding: 20px;
      border: 1px solid #ddd;
    }

    .modal-header {
      background-color: #f0f0f0;
    }

    .modal-title {
      color: #337ab7;
    }

    .modal-body {
      padding: 20px;
    }

    .color-picker {
      width: 100%;
    }

    .color-picker input[type="color"] {
      width: 100%;
    }

    .btn-secondary {
      background-color: #337ab7;
    }

  </style>
</head>
<body>
  
<!-- El botón que abre el modal -->
  <button id="btn-modal" class="btn btn-success">Abrir modal</button>

  <!-- El contenido del modal -->
  <div id="modal" class="modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Modal title</h4>
        </div>
        <div class="modal-body">
          <label for="color1">Color 1:</label>
          <input type="color" id="color1" name="color1"><br><br>
          <label for="color2">Color 2:</label>
          <input type="color" id="color2" name="color2"><br><br>
          <!-- Botón para cerrar el modal -->
          <button class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    // Agrega el evento de click al botón para abrir el modal
    document.getElementById('btn-modal').addEventListener('click', function() {
      document.getElementById('modal').style.display = 'block';
    });

    // Agrega el evento de click al botón para cerrar el modal
    document.querySelector('.btn-secondary').addEventListener('click', function() {
      document.getElementById('modal').style.display = 'none';
    });
  </script>
</body>