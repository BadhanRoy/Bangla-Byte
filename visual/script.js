document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const arrayContainer = document.getElementById('array-container');
    const generateBtn = document.getElementById('generate-btn');
    const sortBtn = document.getElementById('sort-btn');
    const sizeSlider = document.getElementById('array-size');
    const sizeValue = document.getElementById('size-value');
    const speedSlider = document.getElementById('speed');
    const speedValue = document.getElementById('speed-value');
    const algorithmBtns = document.querySelectorAll('.algorithm-btn');
    const comparisonsDisplay = document.getElementById('comparisons');
    const swapsDisplay = document.getElementById('swaps');
    const timeDisplay = document.getElementById('time');
    const infoTabs = document.querySelectorAll('.info-tab');
    const infoContents = document.querySelectorAll('.info-content');

    // Variables
    let array = [];
    let arraySize = parseInt(sizeSlider.value);
    let speed = parseInt(speedSlider.value);
    let selectedAlgorithm = 'bubble';
    let isSorting = false;
    let animationSpeed = 1000 / speed;
    let comparisons = 0;
    let swaps = 0;
    let startTime = 0;

    // Initialize
    generateNewArray();

    // Event Listeners
    sizeSlider.addEventListener('input', function() {
        arraySize = parseInt(this.value);
        sizeValue.textContent = arraySize;
        if (!isSorting) {
            generateNewArray();
        }
    });

    speedSlider.addEventListener('input', function() {
        speed = parseInt(this.value);
        speedValue.textContent = speed;
        animationSpeed = 1000 / speed;
    });

    generateBtn.addEventListener('click', function() {
        if (!isSorting) {
            generateNewArray();
        }
    });

    sortBtn.addEventListener('click', function() {
        if (!isSorting) {
            startSorting();
        }
    });

    algorithmBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            if (!isSorting) {
                algorithmBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                selectedAlgorithm = this.dataset.algo;
            }
        });
    });

    infoTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const tabName = this.dataset.tab;
            
            infoTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            infoContents.forEach(content => {
                content.classList.add('hidden');
                if (content.id === `${tabName}-content`) {
                    content.classList.remove('hidden');
                }
            });
        });
    });

    // Functions
    function generateNewArray() {
        array = [];
        for (let i = 0; i < arraySize; i++) {
            array.push(Math.floor(Math.random() * 350) + 20);
        }
        renderArray();
        resetStats();
    }

    function renderArray(highlightIndices = {}, sortedIndices = []) {
        arrayContainer.innerHTML = '';
        const containerWidth = arrayContainer.clientWidth;
        const barWidth = Math.max(2, (containerWidth / arraySize) - 2);
        
        array.forEach((value, index) => {
            const bar = document.createElement('div');
            bar.className = 'array-bar';
            bar.style.height = `${value}px`;
            bar.style.width = `${barWidth}px`;
            
            if (highlightIndices[index] === 'comparing') {
                bar.classList.add('comparing');
            } else if (highlightIndices[index] === 'swapping') {
                bar.classList.add('swapping');
            } else if (sortedIndices.includes(index)) {
                bar.classList.add('sorted');
            }
            
            arrayContainer.appendChild(bar);
        });
    }

    function resetStats() {
        comparisons = 0;
        swaps = 0;
        comparisonsDisplay.textContent = '0';
        swapsDisplay.textContent = '0';
        timeDisplay.textContent = '0 ms';
    }

    function updateStats() {
        comparisonsDisplay.textContent = comparisons;
        swapsDisplay.textContent = swaps;
    }

    async function startSorting() {
        isSorting = true;
        sortBtn.disabled = true;
        generateBtn.disabled = true;
        startTime = performance.now();
        
        resetStats();
        
        if (selectedAlgorithm === 'bubble') {
            await bubbleSort();
        } else if (selectedAlgorithm === 'merge') {
            await mergeSort();
        }
        
        // Mark all as sorted
        const sortedIndices = Array.from({length: array.length}, (_, i) => i);
        renderArray({}, sortedIndices);
        
        const endTime = performance.now();
        timeDisplay.textContent = `${Math.round(endTime - startTime)} ms`;
        
        isSorting = false;
        sortBtn.disabled = false;
        generateBtn.disabled = false;
    }

    // Sorting Algorithms
    async function bubbleSort() {
        let n = array.length;
        let sortedIndices = [];
        
        for (let i = 0; i < n - 1; i++) {
            for (let j = 0; j < n - i - 1; j++) {
                // Highlight comparing elements
                renderArray({
                    [j]: 'comparing',
                    [j+1]: 'comparing'
                }, sortedIndices);
                comparisons++;
                updateStats();
                await sleep(animationSpeed);
                
                if (array[j] > array[j+1]) {
                    // Swap elements
                    [array[j], array[j+1]] = [array[j+1], array[j]];
                    swaps++;
                    updateStats();
                    
                    // Highlight swapping elements
                    renderArray({
                        [j]: 'swapping',
                        [j+1]: 'swapping'
                    }, sortedIndices);
                    await sleep(animationSpeed);
                }
            }
            sortedIndices.push(n - i - 1);
        }
        sortedIndices.push(0);
    }

    async function mergeSort() {
        await mergeSortHelper(0, array.length - 1);
    }

    async function mergeSortHelper(l, r) {
        if (l >= r) return;
        
        const m = l + Math.floor((r - l) / 2);
        await mergeSortHelper(l, m);
        await mergeSortHelper(m + 1, r);
        await merge(l, m, r);
    }

    async function merge(l, m, r) {
        let n1 = m - l + 1;
        let n2 = r - m;
        
        let L = new Array(n1);
        let R = new Array(n2);
        
        for (let i = 0; i < n1; i++) {
            L[i] = array[l + i];
        }
        for (let j = 0; j < n2; j++) {
            R[j] = array[m + 1 + j];
        }
        
        let i = 0, j = 0, k = l;
        
        while (i < n1 && j < n2) {
            // Highlight comparing elements
            const leftIndex = l + i;
            const rightIndex = m + 1 + j;
            
            renderArray({
                [leftIndex]: 'comparing',
                [rightIndex]: 'comparing'
            });
            comparisons++;
            updateStats();
            await sleep(animationSpeed);
            
            if (L[i] <= R[j]) {
                array[k] = L[i];
                i++;
            } else {
                array[k] = R[j];
                j++;
                swaps++;
                updateStats();
            }
            
            // Highlight the element being placed
            renderArray({
                [k]: 'swapping'
            });
            await sleep(animationSpeed);
            
            k++;
        }
        
        while (i < n1) {
            array[k] = L[i];
            i++;
            k++;
            
            // Highlight the element being placed
            renderArray({
                [k-1]: 'swapping'
            });
            await sleep(animationSpeed);
        }
        
        while (j < n2) {
            array[k] = R[j];
            j++;
            k++;
            
            // Highlight the element being placed
            renderArray({
                [k-1]: 'swapping'
            });
            await sleep(animationSpeed);
        }
    }

    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }
});