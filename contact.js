document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.querySelector('.contact-card form');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = contactForm.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Sending...';

            const formData = {
                name: contactForm.querySelector('[name="name"]').value,
                email: contactForm.querySelector('[name="email"]').value,
                message: contactForm.querySelector('[name="message"]').value
            };

            fetch('submit_contact.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData)
            })
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    window.location.href = 'thanks.html';
                } else {
                    throw new Error(data.message || 'Unknown error');
                }
            })
            .catch(error => {
                alert(`Error: ${error.message}`);
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Send Message';
            });
        });
    }
});