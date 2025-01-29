// script.js

document.querySelector('form').addEventListener('submit', function(event) {
    let answeredAll = true;
    document.querySelectorAll('.question').forEach(question => {
        const options = question.querySelectorAll('input[type="radio"]');
        if (![...options].some(option => option.checked)) {
            answeredAll = false;
            question.style.border = "1px solid red";
        } else {
            question.style.border = "none";
        }
    });
    if (!answeredAll) {
        event.preventDefault();
        alert("Please answer all questions.");
    }
});