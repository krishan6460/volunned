document.addEventListener("DOMContentLoaded", function () {
    let timeRemaining = 600; // 10 minutes in seconds
    const timerElement = document.getElementById('timer');
    const quizForm = document.getElementById('quiz-form');

    // Check if both elements are available
    if (!timerElement || !quizForm) {
        console.error("Timer or quiz form element not found.");
        return;
    }

    function updateTimer() {
        let minutes = Math.floor(timeRemaining / 60);
        let seconds = timeRemaining % 60;
        timerElement.textContent = `Time Remaining: ${minutes}:${seconds.toString().padStart(2, '0')}`;
        timeRemaining--;

        if (timeRemaining < 0) {
            clearInterval(timerInterval);
            alert("Time's up! Submitting your quiz.");
            quizForm.submit();
        }
    }

    // Set timer to update every second
    const timerInterval = setInterval(updateTimer, 1000);
});
