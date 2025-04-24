// login.js
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.querySelector('.boho-login-card form');
    
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = loginForm.querySelector('input[name="email"]').value;
            const password = loginForm.querySelector('input[name="password"]').value;
            
            fetch('login.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'index.html';
                } else {
                    alert(data.message || 'Login failed. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });
    }
});