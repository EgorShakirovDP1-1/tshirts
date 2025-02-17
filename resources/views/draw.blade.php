<x-app-layout>
   


    <div class="max-w-4xl mx-auto mt-12 p-8 bg-white shadow-lg rounded-lg border border-gray-200">
        <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Canvas Drawing Tool 🎨</h2>

        <div class="flex flex-wrap items-center justify-center gap-6 mb-6">
            <label for="drawingName" class="font-medium text-gray-700">🎨 Drawing Name:</label>
            <input id="drawingName" type="text" placeholder="Enter drawing name" class="w-64 px-4 py-2 border rounded">

            <button onclick="saveDrawing()" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-medium rounded shadow">
                💾 Save Drawing
            </button>
        </div>

        <div class="relative flex justify-center">
            <canvas id="drawingCanvas" class="border border-gray-300 rounded shadow-lg"></canvas>
        </div>
    </div>

    <script>
        let canvas = document.getElementById("drawingCanvas");
        let ctx = canvas.getContext("2d");
        let painting = false;

        function resizeCanvas() {
            canvas.width = 800;
            canvas.height = 500;
        }
        resizeCanvas();

        function startPosition(e) {
            painting = true;
            draw(e);
        }

        function stopPosition() {
            painting = false;
            ctx.beginPath();
        }

        function draw(e) {
            if (!painting) return;
            ctx.lineWidth = 5;
            ctx.lineCap = "round";
            ctx.strokeStyle = "#000";

            ctx.lineTo(e.offsetX, e.offsetY);
            ctx.stroke();
            ctx.beginPath();
            ctx.moveTo(e.offsetX, e.offsetY);
        }

        canvas.addEventListener("mousedown", startPosition);
        canvas.addEventListener("mouseup", stopPosition);
        canvas.addEventListener("mousemove", draw);

        function saveDrawing() {
        let name = document.getElementById("drawingName").value;
        if (!name) {
            alert("Please provide a name for your drawing.");
            return;
        }

        let drawingData = canvas.toDataURL();

        let form = document.createElement('form');
        form.method = 'POST';
        form.action = "{{ route('drawings.store') }}";

        let csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = "{{ csrf_token() }}";
        form.appendChild(csrf);

        let nameInput = document.createElement('input');
        nameInput.type = 'hidden';
        nameInput.name = 'name';
        nameInput.value = name;
        form.appendChild(nameInput);

        let drawingInput = document.createElement('input');
        drawingInput.type = 'hidden';
        drawingInput.name = 'drawing_data';
        drawingInput.value = drawingData;
        form.appendChild(drawingInput);

        document.body.appendChild(form);
        form.submit();
    }
    </script>
</x-app-layout>
