let sidebar = document.querySelector('.sidebar');
let sidebarIcon = document.querySelector('.sidebar-icon');
let productCards = document.querySelectorAll('.product-card');

productCards.forEach(card => {
    card.addEventListener('click', function() {
        let productName = card.querySelector('h3').textContent;
        let productGender = card.querySelector('.product-gender').textContent; 
        sidebar.innerHTML = `
            <h2>Product Info</h2>
            <div class="product-info">
                <p><strong>Name:</strong> ${productName}</p>
                <p><strong>Gender:</strong> ${productGender}</p>
               
            </div>
        `;
        sidebar.classList.add('open');
    });
});

window.addEventListener('click', function(e) {
    if (!sidebar.contains(e.target) && !sidebarIcon.contains(e.target)) {
        sidebar.classList.remove('open');
    }
});
