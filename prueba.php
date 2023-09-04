<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuadrícula de 12x5 con Arrastrar y Soltar</title>
    <style>
        .grid-container {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            grid-template-rows: repeat(5, 1fr);
            gap: 10px;
            width: 100%;
            height: 400px; /* Ajusta la altura según tus necesidades */
            border: 2px dashed #ccc;
            padding: 10px;
            position: relative; /* Establece la posición relativa para calcular las coordenadas */
        }

        .grid-item {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 10px;
            overflow: auto;
            position: absolute; /* Establece la posición absoluta para mover libremente */
        }

        /* Estilos adicionales para resaltar el arrastrar y soltar */
        .grid-item.dragging {
            background-color: #3498db;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="grid-container" id="container">
        <!-- Puedes arrastrar y soltar elementos aquí -->
    </div>

    <div class="draggable-item" draggable="true" data-type="campo1" id ="campo1">
    <label for="campoTexto">Campo de Texto:</label>
    <input type="text" id="campoTexto" name="campoTexto" placeholder="Escribe aquí">
</div>

<div class="draggable-item" draggable="true" data-type="campo2" id="campo2">
    <label for="opcionSelect">Selecciona una opción:</label>
    <select id="opcionSelect" name="opcionSelect">
        <option value="opcion1">Opción 1</option>
        <option value="opcion2">Opción 2</option>
        <option value="opcion3">Opción 3</option>
    </select>
</div>

<div class="draggable-item" draggable="true" data-type="campo3" id="campo3">
    <fieldset>
        <legend>Elije una opción:</legend>
        <input type="radio" id="opcion1" name="opcion" value="opcion1">
        <label for="opcion1">Opción 1</label><br>
        <input type="radio" id="opcion2" name="opcion" value="opcion2">
        <label for="opcion2">Opción 2</label><br>
        <input type="radio" id="opcion3" name="opcion" value="opcion3">
        <label for="opcion3">Opción 3</label><br>
    </fieldset>
</div>

<div class="draggable-item" draggable="true" data-type="campo4" id="campo4">
    <label for="opcion1">Opción 1:</label>
    <input type="checkbox" id="opcion1" name="opcion1" value="opcion1">
    <label for="opcion2">Opción 2:</label>
    <input type="checkbox" id="opcion2" name="opcion2" value="opcion2">
    <label for="opcion3">Opción 3:</label>
    <input type="checkbox" id="opcion3" name="opcion3" value="opcion3">
</div>

<div class="draggable-item" draggable="true" data-type="campo5" id="campo5">
    <input type="submit" value="Enviar">
</div>

<div class="draggable-item" draggable="true" data-type="campo6" id="campo6">
    <input type="reset" value="Restablecer">
</div>

<div class="draggable-item" draggable="true" data-type="campo7" id="campo7">
    <label for="fecha">Selecciona una fecha:</label>
    <input type="date" id="fecha" name="fecha">
</div>

<div class="draggable-item" draggable="true" data-type="campo9" id="campo9">
    <label for="hora">Selecciona una hora:</label>
    <input type="time" id="hora" name="hora">
</div>

<div class="draggable-item" draggable="true" data-type="campo10" id="campo10">
    <label for="fechaHora">Selecciona una fecha y hora:</label>
    <input type="datetime-local" id="fechaHora" name="fechaHora">
</div>

<div class="draggable-item" draggable="true" data-type="campo11" id="campo11">
    <label for="correo">Correo Electrónico:</label>
    <input type="email" id="correo" name="correo" placeholder="correo@example.com">
</div>

<div class="draggable-item" draggable="true" data-type="campo12" id="campo12">
    <label for="contrasena">Contraseña:</label>
    <input type="password" id="contrasena" name="contrasena">
</div>

<div class="draggable-item" draggable="true" data-type="campo13" id="campo13">
    <label for="numero">Número:</label>
    <input type="number" id="numero" name="numero" min="1" max="100" step="1">
</div>


    <script>
        const container = document.getElementById('container');
        const draggableItems = document.querySelectorAll('.draggable-item');
        let draggedItem = null;

        // Añade un manejador de eventos para iniciar el arrastre
        draggableItems.forEach((item) => {
            item.addEventListener('dragstart', (e) => {
                e.dataTransfer.setData('text/plain', e.target.getAttribute('data-type'));
                draggedItem = e.target;
                e.target.classList.add('dragging');
            });

            item.addEventListener('dragend', (e) => {
                e.target.classList.remove('dragging');
            });
        });

        // Evita el comportamiento predeterminado que impide el arrastrar y soltar
        container.addEventListener('dragover', (e) => {
            e.preventDefault();
        });

        // Maneja el evento de soltar
        container.addEventListener('drop', (e) => {
           
            e.preventDefault();
            const data = e.dataTransfer.getData('text/plain');
            console.log(data)
    
                // Crea un nuevo elemento div en la cuadrícula
                const gridItem =  document.getElementById(data);
                console.log(gridItem)
                //  document.createElement('div');
                gridItem.setAttribute('class', 'grid-item');
                // gridItem.textContent = `Campo ${data}`;

                // Calcula las coordenadas de la celda más cercana
                const cellWidth = container.offsetWidth / 12;
                const cellHeight = container.offsetHeight / 5;
                let column = Math.floor((e.clientX - container.getBoundingClientRect().left) / cellWidth);
                let row = Math.floor((e.clientY - container.getBoundingClientRect().top) / cellHeight);

                // Verifica si la celda está ocupada y busca la siguiente celda disponible
                while (document.querySelector(`.grid-item[data-row="${row}"][data-column="${column}"]`)) {
                    column++;
                    if (column >= 12) {
                        column = 0;
                        row++;
                    }
                    if (row >= 5) {
                        // Todas las celdas están ocupadas, detener
                        break;
                    }
                }

                // Establece las coordenadas de la celda en los atributos de datos
                gridItem.setAttribute('data-row', row);
                gridItem.setAttribute('data-column', column);

                // Establece la posición del elemento en la celda
                gridItem.style.left = (column * cellWidth) + 'px';
                gridItem.style.top = (row * cellHeight) + 'px';

                container.appendChild(gridItem);
            
        });
    </script>
</body>
</html>
