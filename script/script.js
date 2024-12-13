//Kategori
document.addEventListener('DOMContentLoaded', function() {
    const defaultCategory = 'd1';
    showCategory(defaultCategory);

    document.querySelectorAll('.category').forEach(category => {
        category.addEventListener('click', function() {
            const selectedCategory = this.getAttribute('data-category');
            showCategory(selectedCategory);

            document.querySelectorAll('.category').forEach(cat => {
                cat.classList.remove('active');
            });

            this.classList.add('active');
        });
    });

    function showCategory(category) {
        document.querySelectorAll('.product').forEach(product => {
            product.classList.remove('active');
        });

        document.querySelectorAll(`.product[data-category="${category}"]`).forEach(product => {
            product.classList.add('active');
        });

        document.querySelectorAll('.category').forEach(cat => {
            if (cat.getAttribute('data-category') === category) {
                cat.classList.add('active');
            } else {
                cat.classList.remove('active');
            }
        });
    }
});
//End Kategori

//Limiter Text
document.addEventListener('DOMContentLoaded', function() {
    const productItems = document.querySelectorAll('.products, .product');
    productItems.forEach(function(item) {
        const h3Element = item.querySelector('h3');
        const text = h3Element.textContent;
        const maxLength = 25;
        if (text.length > maxLength) {
            h3Element.textContent = text.slice(0, maxLength) + '...';
		}
	});
});
//End Limiter Text