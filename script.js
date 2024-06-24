const searchBar = document.querySelector('.search-bar');
const searchInput = document.querySelector('.search-bar input');
const navUl = document.querySelector('nav ul');
const searchResults = document.querySelector('.search-results');
const overlay = document.querySelector('.overlay');

const products = [
    { name: "Jam", price: "Rp124.000", image: "imgs/b1.png" },
    { name: "Hoodie", price: "Rp124.000", image: "imgs/e1.png" },
    { name: "Spatula", price: "Rp124.000", image: "imgs/d1.png" },
];

const popularSearch = { image: "imgs/a1.png", name: "Kursi Biasa", price: "Rp124.000" }

let sliderIndex = 0;

function slideLeft() {
    const slider = document.querySelector('.slider1');
    const items = document.querySelectorAll('.slider1-item');
    const itemsPerPage = 5;
    sliderIndex = Math.max(sliderIndex - itemsPerPage, 0);
    const itemWidth = items[0].clientWidth + parseInt(getComputedStyle(items[0]).marginRight);
    slider.style.transform = `translateX(-${sliderIndex * itemWidth}px)`;
}

function slideRight() {
    const slider = document.querySelector('.slider1');
    const items = document.querySelectorAll('.slider1-item');
    const itemsPerPage = 5;
    const maxIndex = items.length - itemsPerPage;
    sliderIndex = Math.min(sliderIndex + itemsPerPage, maxIndex-1.);
    const itemWidth = items[0].clientWidth + parseInt(getComputedStyle(items[0]).marginRight);
    slider.style.transform = `translateX(-${sliderIndex * itemWidth}px)`;
}

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

document.addEventListener('DOMContentLoaded', function() {
    const defaultCategory = 'd1';
    showCategory(defaultCategory);

    document.querySelectorAll('.help').forEach(help => {
        help.addEventListener('click', function() {
            const selectedCategory = this.getAttribute('data-category');
            showCategory(selectedCategory);

            document.querySelectorAll('.help').forEach(cat => {
                cat.classList.remove('active');
            });

            this.classList.add('active');
        });
    });

    function showCategory(help) {
        document.querySelectorAll('.helpcontent').forEach(helpcontent => {
            helpcontent.classList.remove('active');
        });

        document.querySelectorAll(`.helpcontent[data-category="${help}"]`).forEach(helpcontent => {
            helpcontent.classList.add('active');
        });

        document.querySelectorAll('.help').forEach(cat => {
            if (cat.getAttribute('data-category') === help) {
                cat.classList.add('active');
            } else {
                cat.classList.remove('active');
            }
        });
    }
});

searchInput.addEventListener('focus', () => {
    searchBar.classList.add('expanded');
    navUl.classList.add('nav-hidden');
    overlay.style.display = 'block';
    displayPopularSearch();
});

searchInput.addEventListener('blur', () => {
    setTimeout(() => {
        searchBar.classList.remove('expanded');
        navUl.classList.remove('nav-hidden');
        searchResults.style.display = 'none';
        overlay.style.display = 'none';
    }, 200);
});

searchInput.addEventListener('input', () => {
    const searchTerm = searchInput.value.toLowerCase();
    searchResults.innerHTML = '';
    const filteredProducts = products.filter(product => product.name.toLowerCase().includes(searchTerm));

    if (filteredProducts.length > 0 && searchTerm !== '') {
        filteredProducts.forEach(product => {
            const item = document.createElement('div');
            item.classList.add('search-result-item');
            item.innerHTML = `
                <img src="${product.image}" alt="${product.name}" class="se1">
                <div>
                    <div class="se3">${product.name}</div>
                    <div class="se3">${product.price}</div>
                </div>
            `;
            searchResults.appendChild(item);
        });
        searchResults.style.display = 'block';
    } else if (searchTerm === '') {
        displayPopularSearch();
    } else {
        const noResult = document.createElement('div');
        noResult.classList.add('search-result-item');
        noResult.innerHTML = `<div>Produk Tidak Ditemukan</div>`;
        searchResults.appendChild(noResult);
        searchResults.style.display = 'block';
    }
});

function displayPopularSearch() {
    searchResults.innerHTML = '';
    const item = document.createElement('div');
    item.classList.add('search-result-item');
    item.innerHTML = `
        <div>
            <div><h3 style="margin-bottom: 10px;" class="se2">Paling Populer</h3></div>
            <div><img src="${popularSearch.image}" alt="${popularSearch.name}"class="se1"></div>
            <div class="se3">${popularSearch.name}</div>
            <div class="se3">${popularSearch.price}</div>
        </div>
    `;
    searchResults.appendChild(item);
    searchResults.style.display = 'block';
}

function changeImage(imageSrc) {
    document.getElementById('mainImage').src = imageSrc;
}

function changeQuantity(amount) {
    let quantityInput = document.getElementById('quantity');
    let currentQuantity = parseInt(quantityInput.value);
    if (currentQuantity + amount > 0) {
        quantityInput.value = currentQuantity + amount;
    }
}