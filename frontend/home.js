document.addEventListener("DOMContentLoaded", function() {
    // 1. AI Assistant Chatbot Toggle Logic
    const chatBtn = document.getElementById('open-chat-btn');
    const chatWindow = document.getElementById('chat-window');

    if (chatBtn && chatWindow) {
        chatWindow.style.display = 'none'; // Ensure chat is hidden on load

        chatBtn.addEventListener('click', function() {
            // Toggle the visibility of the chat window
            if (chatWindow.style.display === 'none') {
                chatWindow.style.display = 'flex';
                // Optional: Change button icon to an 'X' or 'close' icon
            } else {
                chatWindow.style.display = 'none';
            }
        });
    }

    // 2. Add other homepage-specific logic below (e.g., promotional popups, dynamic content loading)
    
});