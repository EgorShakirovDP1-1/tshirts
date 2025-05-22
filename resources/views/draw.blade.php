<x-app-layout>
 

  
    <a href="{{ route('draw.chooseThing') }}" class="btn bg-blue-500 text-white px-4 py-2 rounded">
    🎨 Choose a Base Image
</a>
<div class="container mx-auto mt-12 p-6 bg-white shadow-lg rounded-lg border border-gray-200">
    <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Canvas Drawing Tool 🎨</h2>

    <!-- Instructions -->
    <div class="text-center text-gray-600 mb-6">
        <p>Use the tools below to create your masterpiece! Don't forget to save your drawing.</p>
        <p>You can also upload an image to draw over it.</p>
        <p>Use the buttons to select shapes, colors, and brush styles.</p>
        <p>Press <strong>Ctrl + Z</strong> to undo and <strong>Ctrl + Y</strong> to redo your actions.</p>
    </div>

    <!-- Toolbar -->
    <div class="flex flex-wrap items-center justify-center gap-4 mb-6">
        <!-- Drawing Name -->
        <input id="drawingName" type="text" placeholder="Enter drawing name" class="w-64 px-4 py-2 border rounded" required>

        <!-- Categories Selector -->
        <label for="categories" class="font-medium text-gray-700">Select Categories:</label>
        <select id="categories" name="categories[]" multiple class="w-64 px-4 py-2 border rounded">
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
            @endforeach
        </select>

        <!-- Current Tool Display -->
        <div class="px-4 py-2 bg-gray-100 rounded font-bold text-gray-700">
            🛠️ Current Tool: <span id="currentTool">Freehand</span>
        </div>

        <!-- Shape Selector -->
        <div class="flex items-center gap-2">
            <label class="font-medium text-gray-700">🛠️ Shapes:</label>
            <button onclick="setTool('rectangle')" class="tool-btn px-3 py-2 bg-blue-400 hover:bg-blue-500 text-white rounded shadow">⬛ Rectangle</button>
            <button onclick="setTool('circle')" class="tool-btn px-3 py-2 bg-green-400 hover:bg-green-500 text-white rounded shadow">⚪ Circle</button>
            <button onclick="setTool('line')" class="tool-btn px-3 py-2 bg-purple-400 hover:bg-purple-500 text-white rounded shadow">📏 Line</button>
            <button onclick="setTool('freehand')" class="tool-btn px-3 py-2 bg-orange-400 hover:bg-orange-500 text-white rounded shadow">✍️ Freehand</button>
        </div>

        <!-- Text Tool -->
        <div class="flex items-center gap-2">
            <button onclick="setTool('text')" class="tool-btn px-3 py-2 bg-pink-500 hover:bg-pink-600 text-white rounded shadow">🔤 Text</button>
            <input type="text" id="textInput" placeholder="Enter text" class="px-3 py-2 border rounded hidden">
        </div>

        <!-- Color Picker -->
        <div class="flex items-center gap-2">
            <label for="colorPicker" class="font-medium text-gray-700">🎨 Color:</label>
            <input id="colorPicker" type="color" value="#000000" class="w-10 h-10 border rounded">
        </div>

        <!-- Brush Size -->
        <div class="flex items-center gap-2">
            <label for="brushSize" class="font-medium text-gray-700">🖌️ Brush Size:</label>
            <input id="brushSize" type="range" min="1" max="30" value="5" class="w-24">
        </div>

        <!-- Brush Style Selector -->
        <div class="flex items-center gap-2">
            <label class="font-medium text-gray-700">🖌️ Brush Style:</label>
            <button onclick="setBrushStyle('solid')" class="px-3 py-2 bg-indigo-400 hover:bg-indigo-500 text-white rounded shadow">Solid</button>
            <button onclick="setBrushStyle('dashed')" class="px-3 py-2 bg-indigo-400 hover:bg-indigo-500 text-white rounded shadow">Dashed</button>
            <button onclick="setBrushStyle('dotted')" class="px-3 py-2 bg-indigo-400 hover:bg-indigo-500 text-white rounded shadow">Dotted</button>
        </div>

        <!-- Eraser Button -->
        <button onclick="setTool('eraser')" class="tool-btn px-4 py-2 bg-gray-300 hover:bg-gray-400 text-black font-medium rounded shadow">✏️ Eraser</button>

        <!-- Clear Drawing -->
        <button onclick="clearDrawing()" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-medium rounded shadow">🗑️ Clear Drawing</button>

        <!-- Save Button -->
        <button onclick="saveDrawing()" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-medium rounded shadow">💾 Save Drawing</button>
    </div>

    <!-- Canvas Area -->
    <div class="relative flex justify-center">
        <div style="position: relative; display: inline-block; width: 800px; height: 600px;">
            <canvas id="backgroundLayer" class="border border-gray-300 rounded shadow-lg absolute left-0 top-0" style="z-index: 0; width: 100%; height: 100%;"></canvas>
            <canvas id="drawingLayer" class="border border-gray-300 rounded shadow-lg absolute left-0 top-0" style="z-index: 1; width: 100%; height: 100%;"></canvas>
        </div>
    </div>
</div>

<script>
    const backgroundCanvas = document.getElementById("backgroundLayer");
    const drawingCanvas = document.getElementById("drawingLayer");
    const bgCtx = backgroundCanvas.getContext("2d");
    const ctx = drawingCanvas.getContext("2d");

    let painting = false;
    let currentTool = 'freehand';
    let brushSize = document.getElementById('brushSize').value;
    let color = document.getElementById('colorPicker').value;
    let brushStyle = 'solid';
    let startX = 0, startY = 0;
    let shapes = { startX: 0, startY: 0 };
    let history = [];
    let redoStack = [];

    function resizeCanvases(width, height) {
        // Устанавливаем размеры canvas
        backgroundCanvas.width = width;
        backgroundCanvas.height = height;
        drawingCanvas.width = width;
        drawingCanvas.height = height;
        // Устанавливаем размеры стилей для корректного отображения
        backgroundCanvas.style.width = width + "px";
        backgroundCanvas.style.height = height + "px";
        drawingCanvas.style.width = width + "px";
        drawingCanvas.style.height = height + "px";
    }

    function initCanvas() {
        @if(isset($thing))
        const img = new Image();
        img.src = "{{ asset('storage/' . $thing->path_to_img) }}";
        img.onload = () => {
            const scale = Math.min(800 / img.width, 600 / img.height);
            const width = img.width * scale;
            const height = img.height * scale;

            resizeCanvases(width, height);

            bgCtx.clearRect(0, 0, width, height);
            bgCtx.drawImage(img, 0, 0, width, height);

            ctx.clearRect(0, 0, width, height);
            saveState();
        };
        @else
        resizeCanvases(800, 600);
        bgCtx.fillStyle = "#ffffff";
        bgCtx.fillRect(0, 0, backgroundCanvas.width, backgroundCanvas.height);
        ctx.clearRect(0, 0, drawingCanvas.width, drawingCanvas.height);
        saveState();
        @endif
    }

    initCanvas();

    function setTool(tool) {
        currentTool = tool;
        document.getElementById('currentTool').innerText = tool.charAt(0).toUpperCase() + tool.slice(1);
        document.getElementById('textInput').classList.toggle('hidden', tool !== 'text');
    }

    function setBrushStyle(style) {
        brushStyle = style;
        currentTool = 'freehand';
        document.getElementById('currentTool').innerText = "Freehand";
    }

    drawingCanvas.addEventListener('mousedown', startDrawing);
    drawingCanvas.addEventListener('mouseup', stopDrawing);
    drawingCanvas.addEventListener('mousemove', draw);
    drawingCanvas.addEventListener('click', handleTextClick);

    function startDrawing(e) {
        const rect = drawingCanvas.getBoundingClientRect();
        startX = e.clientX - rect.left;
        startY = e.clientY - rect.top;
        painting = true;
        if (['rectangle', 'circle', 'line'].includes(currentTool)) {
            shapes.startX = startX;
            shapes.startY = startY;
        }
    }

    function stopDrawing(e) {
        if (!painting) return;
        const rect = drawingCanvas.getBoundingClientRect();
        const endX = e.clientX - rect.left;
        const endY = e.clientY - rect.top;

        ctx.lineWidth = brushSize;
        ctx.strokeStyle = color;

        if (currentTool === 'rectangle') {
            ctx.setLineDash([]);
            ctx.globalCompositeOperation = 'source-over';
            ctx.strokeRect(shapes.startX, shapes.startY, endX - shapes.startX, endY - shapes.startY);
        } else if (currentTool === 'circle') {
            ctx.setLineDash([]);
            ctx.globalCompositeOperation = 'source-over';
            const radius = Math.hypot(endX - shapes.startX, endY - shapes.startY);
            ctx.beginPath();
            ctx.arc(shapes.startX, shapes.startY, radius, 0, 2 * Math.PI);
            ctx.stroke();
        } else if (currentTool === 'line') {
            ctx.setLineDash([]);
            ctx.globalCompositeOperation = 'source-over';
            ctx.beginPath();
            ctx.moveTo(shapes.startX, shapes.startY);
            ctx.lineTo(endX, endY);
            ctx.stroke();
        }

        painting = false;
        ctx.beginPath();
        saveState();
    }

    function draw(e) {
        if (!painting || !['freehand', 'eraser'].includes(currentTool)) return;

        const rect = drawingCanvas.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        ctx.lineWidth = brushSize;
        ctx.lineCap = "round";

        if (currentTool === 'eraser') {
            ctx.globalCompositeOperation = 'destination-out';
            ctx.setLineDash([]);
            ctx.strokeStyle = "rgba(0,0,0,1)";
        } else {
            ctx.globalCompositeOperation = 'source-over';
            ctx.strokeStyle = color;

            if (brushStyle === 'dashed') {
                ctx.setLineDash([10, 5]);
            } else if (brushStyle === 'dotted') {
                ctx.setLineDash([2, 6]);
            } else {
                ctx.setLineDash([]);
            }
        }

        ctx.lineTo(x, y);
        ctx.stroke();
        ctx.beginPath();
        ctx.moveTo(x, y);

        ctx.globalCompositeOperation = 'source-over';
    }

    function handleTextClick(e) {
        if (currentTool !== 'text') return;
        const text = document.getElementById('textInput').value;
        if (!text) return alert('Please enter text before clicking!');
        const rect = drawingCanvas.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        ctx.font = `${brushSize * 4}px Arial`;
        ctx.fillStyle = color;
        ctx.globalCompositeOperation = 'source-over';
        ctx.fillText(text, x, y);
        saveState();
    }

    function clearDrawing() {
        ctx.clearRect(0, 0, drawingCanvas.width, drawingCanvas.height);
        saveState();
    }

    function saveDrawing() {
        const name = document.getElementById("drawingName").value;
        const selectedCategories = Array.from(document.getElementById("categories").selectedOptions).map(opt => opt.value);
        if (!name) return alert("Please enter a name for your drawing.");

        // Сохраняем объединённое изображение
        const tempCanvas = document.createElement('canvas');
        tempCanvas.width = backgroundCanvas.width;
        tempCanvas.height = backgroundCanvas.height;
        const tempCtx = tempCanvas.getContext('2d');
        tempCtx.drawImage(backgroundCanvas, 0, 0);
        tempCtx.drawImage(drawingCanvas, 0, 0);

        const drawingData = tempCanvas.toDataURL("image/png");

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = "{{ route('drawings.store') }}";

        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = "{{ csrf_token() }}";

        const nameInput = document.createElement('input');
        nameInput.type = 'hidden';
        nameInput.name = 'name';
        nameInput.value = name;

        const drawingInput = document.createElement('input');
        drawingInput.type = 'hidden';
        drawingInput.name = 'drawing_data';
        drawingInput.value = drawingData;

        form.appendChild(csrf);
        form.appendChild(nameInput);
        form.appendChild(drawingInput);

        selectedCategories.forEach(id => {
            const catInput = document.createElement('input');
            catInput.type = 'hidden';
            catInput.name = 'categories[]';
            catInput.value = id;
            form.appendChild(catInput);
        });

        @isset($thing)
            const thingInput = document.createElement('input');
            thingInput.type = 'hidden';
            thingInput.name = 'thing_id';
            thingInput.value = "{{ $thing->id }}";
            form.appendChild(thingInput);
        @endisset

        document.body.appendChild(form);
        form.submit();
    }

    function saveState() {
        history.push(drawingCanvas.toDataURL());
        redoStack = [];
    }

    document.addEventListener('keydown', (e) => {
        if (e.ctrlKey && e.key === 'z') undo();
        if (e.ctrlKey && e.key === 'y') redo();
    });

    function undo() {
        if (history.length > 1) {
            redoStack.push(history.pop());
            const img = new Image();
            img.src = history[history.length - 1];
            img.onload = () => {
                ctx.clearRect(0, 0, drawingCanvas.width, drawingCanvas.height);
                ctx.drawImage(img, 0, 0);
            };
        }
    }

    function redo() {
        if (redoStack.length > 0) {
            const img = new Image();
            const state = redoStack.pop();
            history.push(state);
            img.src = state;
            img.onload = () => {
                ctx.clearRect(0, 0, drawingCanvas.width, drawingCanvas.height);
                ctx.drawImage(img, 0, 0);
            };
        }
    }
</script>

</x-app-layout>