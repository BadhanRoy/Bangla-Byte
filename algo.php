<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sorting Algorithm Visualizer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
            background-color: #f5f5f5;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        .controls {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        button {
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        button:hover {
            background-color: #45a049;
        }
        
        button:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }
        
        select, input {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        
        .visualization {
            display: flex;
            height: 400px;
            align-items: flex-end;
            justify-content: center;
            gap: 2px;
            padding: 10px;
            border: 1px solid #ddd;
            background-color: white;
            margin-bottom: 20px;
        }
        
        .bar {
            background-color: #4CAF50;
            width: 10px;
            transition: height 0.3s, background-color 0.3s;
        }
        
        .bar.comparing {
            background-color: #f44336;
        }
        
        .bar.sorted {
            background-color: #2196F3;
        }
        
        .stats {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        
        .stat-item {
            display: flex;
            flex-direction: column;
        }
        
        .stat-value {
            font-weight: bold;
            font-size: 1.2em;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Sorting Algorithm Visualizer</h1>
        
        <div class="controls">
            <select id="algorithm">
                <option value="bubble">Bubble Sort</option>
                <option value="selection">Selection Sort</option>
                <option value="insertion">Insertion Sort</option>
                <option value="merge">Merge Sort</option>
                <option value="quick">Quick Sort</option>
            </select>
            
            <input type="range" id="speed" min="1" max="100" value="50">
            <span id="speed-value">50ms</span>
            
            <input type="range" id="size" min="5" max="100" value="30">
            <span id="size-value">30 elements</span>
            
            <button id="generate">Generate New Array</button>
            <button id="sort">Start Sorting</button>
        </div>
        
        <div class="visualization" id="visualization"></div>
        
        <div class="stats">
            <div class="stat-item">
                <span>Comparisons</span>
                <span class="stat-value" id="comparisons">0</span>
            </div>
            <div class="stat-item">
                <span>Swaps</span>
                <span class="stat-value" id="swaps">0</span>
            </div>
            <div class="stat-item">
                <span>Time</span>
                <span class="stat-value" id="time">0ms</span>
            </div>
        </div>
    </div>

    <script>
        // DOM elements
        const visualization = document.getElementById('visualization');
        const generateBtn = document.getElementById('generate');
        const sortBtn = document.getElementById('sort');
        const algorithmSelect = document.getElementById('algorithm');
        const speedSlider = document.getElementById('speed');
        const sizeSlider = document.getElementById('size');
        const speedValue = document.getElementById('speed-value');
        const sizeValue = document.getElementById('size-value');
        const comparisonsEl = document.getElementById('comparisons');
        const swapsEl = document.getElementById('swaps');
        const timeEl = document.getElementById('time');
        
        // Variables
        let array = [];
        let bars = [];
        let isSorting = false;
        let delay = 100 - speedSlider.value; // Invert speed (higher value = faster)
        let comparisons = 0;
        let swaps = 0;
        let startTime = 0;
        
        // Initialize
        updateSpeed();
        updateSize();
        generateArray();
        
        // Event listeners
        generateBtn.addEventListener('click', generateArray);
        sortBtn.addEventListener('click', startSorting);
        speedSlider.addEventListener('input', updateSpeed);
        sizeSlider.addEventListener('input', updateSize);
        
        // Functions
        function updateSpeed() {
            delay = 105 - speedSlider.value; // Adjusted for better range
            speedValue.textContent = `${delay}ms`;
        }
        
        function updateSize() {
            sizeValue.textContent = `${sizeSlider.value} elements`;
            generateArray();
        }
        
        function generateArray() {
            if (isSorting) return;
            
            const size = parseInt(sizeSlider.value);
            array = [];
            visualization.innerHTML = '';
            bars = [];
            
            for (let i = 0; i < size; i++) {
                array.push(Math.floor(Math.random() * 100) + 5); // Values between 5-105
                
                const bar = document.createElement('div');
                bar.className = 'bar';
                bar.style.height = `${array[i]}%`;
                visualization.appendChild(bar);
                bars.push(bar);
            }
            
            resetStats();
        }
        
        function resetStats() {
            comparisons = 0;
            swaps = 0;
            comparisonsEl.textContent = '0';
            swapsEl.textContent = '0';
            timeEl.textContent = '0ms';
        }
        
        function updateStats() {
            comparisonsEl.textContent = comparisons;
            swapsEl.textContent = swaps;
        }
        
        function startSorting() {
            if (isSorting) return;
            
            isSorting = true;
            generateBtn.disabled = true;
            sortBtn.disabled = true;
            resetStats();
            startTime = performance.now();
            
            const algorithm = algorithmSelect.value;
            
            switch (algorithm) {
                case 'bubble':
                    bubbleSort();
                    break;
                case 'selection':
                    selectionSort();
                    break;
                case 'insertion':
                    insertionSort();
                    break;
                case 'merge':
                    mergeSort();
                    break;
                case 'quick':
                    quickSort();
                    break;
            }
        }
        
        function finishSorting() {
            isSorting = false;
            generateBtn.disabled = false;
            sortBtn.disabled = false;
            
            const endTime = performance.now();
            timeEl.textContent = `${Math.round(endTime - startTime)}ms`;
            
            // Mark all bars as sorted
            for (let i = 0; i < bars.length; i++) {
                setTimeout(() => {
                    bars[i].classList.add('sorted');
                }, i * 10);
            }
        }
        
        // Sorting algorithms
        async function bubbleSort() {
            let n = array.length;
            
            for (let i = 0; i < n - 1; i++) {
                for (let j = 0; j < n - i - 1; j++) {
                    // Highlight bars being compared
                    bars[j].classList.add('comparing');
                    bars[j + 1].classList.add('comparing');
                    comparisons++;
                    updateStats();
                    
                    await new Promise(resolve => setTimeout(resolve, delay));
                    
                    if (array[j] > array[j + 1]) {
                        // Swap
                        [array[j], array[j + 1]] = [array[j + 1], array[j]];
                        swaps++;
                        updateStats();
                        
                        // Update bar heights
                        bars[j].style.height = `${array[j]}%`;
                        bars[j + 1].style.height = `${array[j + 1]}%`;
                        
                        await new Promise(resolve => setTimeout(resolve, delay));
                    }
                    
                    // Remove highlight
                    bars[j].classList.remove('comparing');
                    bars[j + 1].classList.remove('comparing');
                }
                
                // Mark sorted element
                bars[n - i - 1].classList.add('sorted');
            }
            
            // Mark first element as sorted
            bars[0].classList.add('sorted');
            finishSorting();
        }
        
        async function selectionSort() {
            let n = array.length;
            
            for (let i = 0; i < n - 1; i++) {
                let minIndex = i;
                
                // Highlight current min
                bars[minIndex].classList.add('comparing');
                
                for (let j = i + 1; j < n; j++) {
                    // Highlight current element being compared
                    bars[j].classList.add('comparing');
                    comparisons++;
                    updateStats();
                    
                    await new Promise(resolve => setTimeout(resolve, delay));
                    
                    if (array[j] < array[minIndex]) {
                        // Remove highlight from previous min
                        bars[minIndex].classList.remove('comparing');
                        minIndex = j;
                        // Highlight new min
                        bars[minIndex].classList.add('comparing');
                    } else {
                        // Remove highlight if not the new min
                        bars[j].classList.remove('comparing');
                    }
                }
                
                // Swap if needed
                if (minIndex !== i) {
                    [array[i], array[minIndex]] = [array[minIndex], array[i]];
                    swaps++;
                    updateStats();
                    
                    // Update bar heights
                    bars[i].style.height = `${array[i]}%`;
                    bars[minIndex].style.height = `${array[minIndex]}%`;
                    
                    await new Promise(resolve => setTimeout(resolve, delay));
                }
                
                // Remove highlights
                bars[minIndex].classList.remove('comparing');
                bars[i].classList.remove('comparing');
                
                // Mark sorted element
                bars[i].classList.add('sorted');
            }
            
            // Mark last element as sorted
            bars[n - 1].classList.add('sorted');
            finishSorting();
        }
        
        async function insertionSort() {
            let n = array.length;
            
            // Mark first element as sorted
            bars[0].classList.add('sorted');
            
            for (let i = 1; i < n; i++) {
                let key = array[i];
                let j = i - 1;
                
                // Highlight current element being inserted
                bars[i].classList.add('comparing');
                
                while (j >= 0 && array[j] > key) {
                    comparisons++;
                    updateStats();
                    
                    // Highlight element being compared
                    bars[j].classList.add('comparing');
                    
                    await new Promise(resolve => setTimeout(resolve, delay));
                    
                    array[j + 1] = array[j];
                    swaps++;
                    updateStats();
                    
                    // Update bar height
                    bars[j + 1].style.height = `${array[j + 1]}%`;
                    
                    // Remove highlight after move
                    bars[j].classList.remove('comparing');
                    
                    j--;
                }
                
                array[j + 1] = key;
                
                // Update bar height
                bars[j + 1].style.height = `${key}%`;
                
                // Remove highlight
                bars[i].classList.remove('comparing');
                
                // Mark as sorted
                bars[j + 1].classList.add('sorted');
                
                await new Promise(resolve => setTimeout(resolve, delay));
            }
            
            finishSorting();
        }
        
        // Merge Sort implementation with visualization
        async function mergeSort() {
            await mergeSortHelper(0, array.length - 1);
            finishSorting();
        }
        
        async function mergeSortHelper(l, r) {
            if (l < r) {
                const m = Math.floor((l + r) / 2);
                
                await mergeSortHelper(l, m);
                await mergeSortHelper(m + 1, r);
                await merge(l, m, r);
            }
        }
        
        async function merge(l, m, r) {
            const n1 = m - l + 1;
            const n2 = r - m;
            
            // Create temp arrays
            const L = new Array(n1);
            const R = new Array(n2);
            
            // Copy data to temp arrays
            for (let i = 0; i < n1; i++) {
                L[i] = array[l + i];
            }
            for (let j = 0; j < n2; j++) {
                R[j] = array[m + 1 + j];
            }
            
            // Merge the temp arrays
            let i = 0, j = 0, k = l;
            
            while (i < n1 && j < n2) {
                // Highlight bars being compared
                bars[l + i].classList.add('comparing');
                bars[m + 1 + j].classList.add('comparing');
                comparisons++;
                updateStats();
                
                await new Promise(resolve => setTimeout(resolve, delay));
                
                if (L[i] <= R[j]) {
                    array[k] = L[i];
                    i++;
                } else {
                    array[k] = R[j];
                    j++;
                }
                
                // Update bar height
                bars[k].style.height = `${array[k]}%`;
                swaps++;
                updateStats();
                
                // Remove highlights
                bars[l + i - 1]?.classList.remove('comparing');
                bars[m + j]?.classList.remove('comparing');
                
                k++;
                
                await new Promise(resolve => setTimeout(resolve, delay));
            }
            
            // Copy remaining elements of L[]
            while (i < n1) {
                array[k] = L[i];
                bars[k].style.height = `${array[k]}%`;
                i++;
                k++;
                swaps++;
                updateStats();
                await new Promise(resolve => setTimeout(resolve, delay));
            }
            
            // Copy remaining elements of R[]
            while (j < n2) {
                array[k] = R[j];
                bars[k].style.height = `${array[k]}%`;
                j++;
                k++;
                swaps++;
                updateStats();
                await new Promise(resolve => setTimeout(resolve, delay));
            }
            
            // Mark merged section as sorted
            for (let x = l; x <= r; x++) {
                bars[x].classList.add('sorted');
            }
        }
        
        // Quick Sort implementation with visualization
        async function quickSort() {
            await quickSortHelper(0, array.length - 1);
            finishSorting();
        }
        
        async function quickSortHelper(low, high) {
            if (low < high) {
                const pi = await partition(low, high);
                
                await quickSortHelper(low, pi - 1);
                await quickSortHelper(pi + 1, high);
            } else if (low === high) {
                // Mark single element as sorted
                bars[low].classList.add('sorted');
            }
        }
        
        async function partition(low, high) {
            const pivot = array[high];
            let i = low - 1;
            
            // Highlight pivot
            bars[high].classList.add('comparing');
            
            for (let j = low; j < high; j++) {
                // Highlight current element
                bars[j].classList.add('comparing');
                comparisons++;
                updateStats();
                
                await new Promise(resolve => setTimeout(resolve, delay));
                
                if (array[j] < pivot) {
                    i++;
                    
                    // Highlight elements to be swapped
                    if (i !== j) {
                        bars[i].classList.add('comparing');
                        await new Promise(resolve => setTimeout(resolve, delay));
                    }
                    
                    // Swap
                    [array[i], array[j]] = [array[j], array[i]];
                    swaps++;
                    updateStats();
                    
                    // Update bar heights
                    bars[i].style.height = `${array[i]}%`;
                    bars[j].style.height = `${array[j]}%`;
                    
                    // Remove highlights
                    if (i !== j) {
                        bars[i].classList.remove('comparing');
                    }
                    
                    await new Promise(resolve => setTimeout(resolve, delay));
                }
                
                // Remove current element highlight
                bars[j].classList.remove('comparing');
            }
            
            // Swap pivot to correct position
            [array[i + 1], array[high]] = [array[high], array[i + 1]];
            swaps++;
            updateStats();
            
            // Update bar heights
            bars[i + 1].style.height = `${array[i + 1]}%`;
            bars[high].style.height = `${array[high]}%`;
            
            // Remove pivot highlight
            bars[high].classList.remove('comparing');
            
            // Mark pivot as sorted
            bars[i + 1].classList.add('sorted');
            
            await new Promise(resolve => setTimeout(resolve, delay));
            
            return i + 1;
        }
    </script>
</body>
</html>