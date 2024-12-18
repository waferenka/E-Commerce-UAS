// Js Kategori
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
// End Js Kategori