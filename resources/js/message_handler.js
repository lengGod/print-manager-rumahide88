document.addEventListener('DOMContentLoaded', () => {
    const messages = document.querySelectorAll('.message-popup');

    messages.forEach(message => {
        message.classList.add('show-message');

        setTimeout(() => {
            message.classList.remove('show-message');
            message.classList.add('hide-message');

            // Wait for the CSS transition to complete, then remove the element
            // A more robust approach might be a second setTimeout based on transition duration
            const transitionDuration = parseFloat(getComputedStyle(message).transitionDuration) * 1000;
            const animationDuration = isNaN(transitionDuration) ? 500 : transitionDuration; // Default to 500ms if not found

            setTimeout(() => {
                message.remove();
            }, animationDuration + 50); // Add a small buffer just in case
        }, 5000); // Initial display duration
    });
});