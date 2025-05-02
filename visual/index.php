<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sorting Algorithm Visualizer</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <h1><i class="fas fa-sort-amount-down"></i> Sorting Algorithm Visualizer</h1>
            <p>Visualize how different sorting algorithms work</p>
        </header>

        <div class="control-panel">
            <div class="control-group">
                <label for="array-size">Array Size:</label>
                <input type="range" id="array-size" min="10" max="100" value="50">
                <span id="size-value">50</span>
            </div>

            <div class="control-group">
                <label for="speed">Speed:</label>
                <input type="range" id="speed" min="1" max="10" value="5">
                <span id="speed-value">5</span>
            </div>

            <div class="control-group algorithm-select">
                <button class="algorithm-btn active" data-algo="bubble">
                    <i class="fas fa-bubbles"></i> Bubble Sort
                </button>
                <button class="algorithm-btn" data-algo="merge">
                    <i class="fas fa-merge"></i> Merge Sort
                </button>
            </div>

            <div class="control-group actions">
                <button id="generate-btn" class="action-btn">
                    <i class="fas fa-random"></i> Generate New Array
                </button>
                <button id="sort-btn" class="action-btn primary">
                    <i class="fas fa-play"></i> Start Sorting
                </button>
            </div>
        </div>

        <div class="visualization-container">
            <div id="array-container"></div>
        </div>

        <div class="stats-panel">
            <div class="stat">
                <span class="stat-label">Comparisons:</span>
                <span id="comparisons" class="stat-value">0</span>
            </div>
            <div class="stat">
                <span class="stat-label">Swaps:</span>
                <span id="swaps" class="stat-value">0</span>
            </div>
            <div class="stat">
                <span class="stat-label">Time:</span>
                <span id="time" class="stat-value">0 ms</span>
            </div>
        </div>

        <div class="info-panel">
            <div class="info-tab active" data-tab="about">
                <i class="fas fa-info-circle"></i> About
            </div>
            <div class="info-tab" data-tab="complexity">
                <i class="fas fa-chart-line"></i> Complexity
            </div>
            <div class="info-content" id="about-content">
                <h3>Sorting Algorithm Visualizer</h3>
                <p>This tool helps you visualize how different sorting algorithms work by animating the sorting process step by step.</p>
                <p>Select an algorithm, adjust the array size and speed, then click "Start Sorting" to begin the visualization.</p>
            </div>
            <div class="info-content hidden" id="complexity-content">
                <h3>Algorithm Complexities</h3>
                <table>
                    <tr>
                        <th>Algorithm</th>
                        <th>Best Case</th>
                        <th>Average Case</th>
                        <th>Worst Case</th>
                        <th>Space</th>
                    </tr>
                    <tr>
                        <td>Bubble Sort</td>
                        <td>O(n)</td>
                        <td>O(n²)</td>
                        <td>O(n²)</td>
                        <td>O(1)</td>
                    </tr>
                    <tr>
                        <td>Merge Sort</td>
                        <td>O(n log n)</td>
                        <td>O(n log n)</td>
                        <td>O(n log n)</td>
                        <td>O(n)</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>