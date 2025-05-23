// Newsletter Subscription
document.addEventListener('DOMContentLoaded', function() {
    const newsletterForm = document.getElementById('newsletter-form');
    const newsletterEmail = document.getElementById('newsletter-email');
    const newsletterMessage = document.getElementById('newsletter-message');

    newsletterForm.addEventListener('submit', async function(e) {
      e.preventDefault();

      const email = newsletterEmail.value.trim();
      if (!email) return;

      try {
        // Update this URL to match your actual API endpoint
        const response = await fetch('/api/newsletter/subscribe', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          body: JSON.stringify({ email })
        });

        if (response.ok) {
          newsletterMessage.textContent = 'Thank you for subscribing!';
          newsletterMessage.className = 'mt-2 text-sm text-green-400';
          newsletterEmail.value = '';
        } else {
          const data = await response.json();
          newsletterMessage.textContent = data.message || 'Subscription failed. Please try again.';
          newsletterMessage.className = 'mt-2 text-sm text-red-400';
        }
      } catch (error) {
        newsletterMessage.textContent = 'An error occurred. Please try again later.';
        newsletterMessage.className = 'mt-2 text-sm text-red-400';
      }
    });
  });
