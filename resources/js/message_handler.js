document.addEventListener('DOMContentLoaded', () => {
    const messages = document.querySelectorAll('.message-popup');

    messages.forEach(message => {
        // Add a class to trigger initial pop-up animation
        message.classList.add('show-message');

        // Set a timeout to hide the message after 5 seconds (adjust as needed)
        setTimeout(() => {
            message.classList.remove('show-message');
            message.classList.add('hide-message'); // Add a class for fade-out animation

            // Remove the element from the DOM after the animation completes
            message.addEventListener('transitionend', () => {
                message.remove();
            }, { once: true });
        }, 5000); // 5000 milliseconds = 5 seconds
    });
});
