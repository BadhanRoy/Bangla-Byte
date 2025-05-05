document.addEventListener('DOMContentLoaded', function() {
    const timerElement = document.getElementById('timer');
    const submitBtn = document.getElementById('submit-answer');
    const solutionElement = document.getElementById('solution');
    const nextProblemBtn = document.getElementById('next-problem');
    const quizForm = document.getElementById('quiz-form');
    
    // Set timer for 20 minutes (1200 seconds)
   
    let timerInterval;
    
    
    
    function loadNextProblem() {
        fetch(window.location.href, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Cache-Control': 'no-cache'
            }
        })
        .then(response => response.json())
        .then(problem => {
            document.getElementById('problem-title').textContent = problem.title;
            document.getElementById('problem-desc').textContent = problem.description;
            document.getElementById('problem-code').textContent = problem.code;
            
            // Update options
            const optionsContainer = quizForm.querySelector('.option');
            quizForm.innerHTML = '';
            
            problem.options.forEach((option, index) => {
                const optionDiv = document.createElement('div');
                optionDiv.className = 'option';
                
                const input = document.createElement('input');
                input.type = 'radio';
                input.id = `option${index}`;
                input.name = 'answer';
                input.value = option[0];
                
                const label = document.createElement('label');
                label.htmlFor = `option${index}`;
                label.textContent = option;
                
                optionDiv.appendChild(input);
                optionDiv.appendChild(label);
                quizForm.appendChild(optionDiv);
            });
            
            // Add submit button back
            const submitBtn = document.createElement('button');
            submitBtn.type = 'button';
            submitBtn.id = 'submit-answer';
            submitBtn.textContent = 'জমা দিন';
            quizForm.appendChild(submitBtn);
            
            // Update solution
            document.getElementById('explanation').textContent = problem.explanation;
            document.getElementById('correct-answer').textContent = `সঠিক উত্তর: ${problem.correct}`;
            solutionElement.style.display = 'none';
            
            // Reset timer
          
            startTimer();
        })
        .catch(error => {
            console.error('Error loading next problem:', error);
            window.location.reload();
        });
    }
    
    // Submit answer
    submitBtn.addEventListener('click', function() {
        const selectedOption = document.querySelector('input[name="answer"]:checked');
        
        if (!selectedOption) {
            alert('দয়া করে একটি উত্তর নির্বাচন করুন');
            return;
        }
        
        solutionElement.style.display = 'block';
    });
    
    // Next problem button
    nextProblemBtn.addEventListener('click', function() {
        loadNextProblem();
    });
    
    // Start the timer
    
});