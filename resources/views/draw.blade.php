<x-app-layout>
    <div class="max-w-5xl mx-auto mt-12 p-6 bg-white shadow-lg rounded-lg border border-gray-200">
        <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Canvas Drawing Tool 🎨</h2>
        <div class="mt-4">
    <label for="categories" class="block text-sm font-medium text-gray-700">Select Categories:</label>
    <div class="mb-4">
    <label class="block font-semibold mb-2">Choose Categories:</label>
    <div class="grid grid-cols-2 gap-2">
        @foreach($categories as $category)
            <label class="flex items-center space-x-2">
                <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                       {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                <span>{{ $category->category_name }}</span>
            </label>
        @endforeach
    </div>
</div>



</div>
        <!-- Toolbar -->
        <div class="flex flex-wrap items-center justify-center gap-6 mb-6">
            <!-- Drawing Name -->
            <input id="drawingName" type="text" placeholder="Enter drawing name" class="w-64 px-4 py-2 border rounded" required>

            <!-- Tool Mode Display -->
            <div class="px-4 py-2 bg-gray-100 rounded font-bold text-gray-700">
                🛠️ Current Tool: <span id="currentTool">Freehand</span>
            </div>

            <!-- Shape Selector -->
            <div class="flex items-center gap-4">
                <label class="font-medium text-gray-700">🛠️ Shapes:</label>
                <button onclick="setTool('rectangle')" class="tool-btn px-3 py-2 bg-blue-400 hover:bg-blue-500 text-white rounded shadow">⬛ Rectangle</button>
                <button onclick="setTool('circle')" class="tool-btn px-3 py-2 bg-green-400 hover:bg-green-500 text-white rounded shadow">⚪ Circle</button>
                <button onclick="setTool('line')" class="tool-btn px-3 py-2 bg-purple-400 hover:bg-purple-500 text-white rounded shadow">📏 Line</button>
                <button onclick="setTool('freehand')" class="tool-btn px-3 py-2 bg-orange-400 hover:bg-orange-500 text-white rounded shadow">✍️ Freehand</button>
            </div>

            <!-- Text Tool -->
            <button onclick="setTool('text')" class="tool-btn px-3 py-2 bg-pink-500 hover:bg-pink-600 text-white rounded shadow">🔤 Text</button>
            <input type="text" id="textInput" placeholder="Enter text" class="px-3 py-2 border rounded hidden">

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
            <div class="flex items-center gap-4">
                <label class="font-medium text-gray-700">🖌️ Brush Style:</label>
                <button onclick="setBrushStyle('solid')" class="px-3 py-2 bg-indigo-400 hover:bg-indigo-500 text-white rounded shadow">Solid</button>
                <button onclick="setBrushStyle('dashed')" class="px-3 py-2 bg-indigo-400 hover:bg-indigo-500 text-white rounded shadow">Dashed</button>
                <button onclick="setBrushStyle('dotted')" class="px-3 py-2 bg-indigo-400 hover:bg-indigo-500 text-white rounded shadow">Dotted</button>
            </div>

            <!-- Eraser Button -->
            <button onclick="setTool('eraser')" class="tool-btn px-4 py-2 bg-gray-300 hover:bg-gray-400 text-black font-medium rounded shadow">✏️ Eraser</button>

            <!-- Clear Drawing -->
            <button onclick="clearDrawing()" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-medium rounded shadow">🗑️ Clear Drawing</button>

            <!-- Upload Image -->
            <input type="file" id="imageUpload" accept="image/png, image/jpeg" class="px-2 py-1 border rounded">

            <!-- Save Button -->
            <button onclick="saveDrawing()" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-medium rounded shadow">💾 Save Drawing</button>
        </div>

        <!-- Canvas Area -->
        <div class="relative flex justify-center">
            <canvas id="drawingCanvas" class="border border-gray-300 rounded shadow-lg"></canvas>
        </div>
    </div>

    <script>
        const canvas = document.getElementById("drawingCanvas");
        const ctx = canvas.getContext("2d");

        let painting = false;
        let currentTool = 'freehand';
        let brushSize = document.getElementById('brushSize').value;
        let color = document.getElementById('colorPicker').value;
        let brushStyle = 'solid';
        let startX = 0, startY = 0;
        let shapes = { startX: 0, startY: 0 };
        let history = [];
        let redoStack = [];

        // Initialize canvas
        function initCanvas() {
            canvas.width = 800;
            canvas.height = 600;
            ctx.fillStyle = "#ffffff";
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            saveState();
        }
        initCanvas();

        // Set tool and display
        function setTool(tool) {
            currentTool = tool;
            document.getElementById('currentTool').innerText = tool.charAt(0).toUpperCase() + tool.slice(1);
            if (tool === 'text') {
                document.getElementById('textInput').classList.remove('hidden');
            } else {
                document.getElementById('textInput').classList.add('hidden');
            }
        }

        // Set brush style
        function setBrushStyle(style) {
            brushStyle = style;
            currentTool = 'freehand';
            document.getElementById('currentTool').innerText = "Freehand";
        }

        // Drawing event listeners
        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mouseup', stopDrawing);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('click', handleTextClick);

        function startDrawing(e) {
            const rect = canvas.getBoundingClientRect();
            startX = e.clientX - rect.left;
            startY = e.clientY - rect.top;

            if (['rectangle', 'circle', 'line'].includes(currentTool)) {
                shapes.startX = startX;
                shapes.startY = startY;
                painting = true;
            } else if (currentTool === 'freehand' || currentTool === 'eraser') {
                painting = true;
            }
        }

        function stopDrawing(e) {
            if (painting && ['rectangle', 'circle', 'line'].includes(currentTool)) {
                const rect = canvas.getBoundingClientRect();
                const endX = e.clientX - rect.left;
                const endY = e.clientY - rect.top;

                ctx.strokeStyle = color;
                ctx.lineWidth = brushSize;

                if (currentTool === 'rectangle') {
                    ctx.strokeRect(shapes.startX, shapes.startY, endX - shapes.startX, endY - shapes.startY);
                } else if (currentTool === 'circle') {
                    const radius = Math.sqrt(Math.pow(endX - shapes.startX, 2) + Math.pow(endY - shapes.startY, 2));
                    ctx.beginPath();
                    ctx.arc(shapes.startX, shapes.startY, radius, 0, 2 * Math.PI);
                    ctx.stroke();
                } else if (currentTool === 'line') {
                    ctx.beginPath();
                    ctx.moveTo(shapes.startX, shapes.startY);
                    ctx.lineTo(endX, endY);
                    ctx.stroke();
                }
                saveState();
            }
            painting = false;
            ctx.beginPath();
        }

        function draw(e) {
            // Update brush size dynamically
document.getElementById('brushSize').addEventListener('input', function () {
    brushSize = this.value;
});

// Update color dynamically
document.getElementById('colorPicker').addEventListener('input', function () {
    color = this.value;
});

    if (!painting || !['freehand', 'eraser'].includes(currentTool)) return;

    // Dynamically get the brush size and color to reflect real-time changes
    let dynamicBrushSize = document.getElementById('brushSize').value;
    let dynamicColor = document.getElementById('colorPicker').value;

    ctx.lineWidth = dynamicBrushSize;
    ctx.lineCap = "round";

    ctx.strokeStyle = currentTool === 'eraser' ? "#FFFFFF" : dynamicColor;

    if (brushStyle === 'dashed') {
        ctx.setLineDash([10, 5]);
    } else if (brushStyle === 'dotted') {
        ctx.setLineDash([2, 6]);
    } else {
        ctx.setLineDash([]);
    }

    const rect = canvas.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;

    ctx.lineTo(x, y);
    ctx.stroke();
    ctx.beginPath();
    ctx.moveTo(x, y);
}


        // Handle text placement
        function handleTextClick(e) {
            if (currentTool !== 'text') return;
            const text = document.getElementById('textInput').value;
            if (!text) return alert('Please enter text before clicking!');

            const rect = canvas.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            ctx.font = `${brushSize * 4}px Arial`;
            ctx.fillStyle = color;
            ctx.fillText(text, x, y);
            saveState();
        }

        // Clear drawing
        function clearDrawing() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.fillStyle = "#ffffff";
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            saveState();
        }

        // Upload image
        document.getElementById('imageUpload').addEventListener('change', function (event) {
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function (e) {
                const img = new Image();
                img.src = e.target.result;

                img.onload = function () {
                    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                    saveState();
                };
            };

            reader.readAsDataURL(file);
        });

        // Save the drawing
        function saveDrawing() {
            const name = document.getElementById("drawingName").value;
            if (!name) {
                alert("Please enter a name for your drawing.");
                return;
            }

            const drawingData = canvas.toDataURL("image/png");

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

            document.body.appendChild(form);
            form.submit();
        }

        // Save canvas state for undo/redo
        function saveState() {
            history.push(canvas.toDataURL());
            redoStack = [];
        }

        // Undo and redo with Ctrl+Z / Ctrl+Y
        document.addEventListener('keydown', (e) => {
            if (e.ctrlKey && e.key === 'z') {
                undo();
            } else if (e.ctrlKey && e.key === 'y') {
                redo();
            }
        });

        function undo() {
            if (history.length > 1) {
                redoStack.push(history.pop());
                const img = new Image();
                img.src = history[history.length - 1];
                img.onload = () => {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
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
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    ctx.drawImage(img, 0, 0);
                };
            }
        }
    </script>
</x-app-layout>
