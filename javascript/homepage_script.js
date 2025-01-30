// HOMEPAGE.TPL.PHP
function updateMinPrice() {
    var minPrice = document.getElementById("min_price").value;
    document.getElementById("min_price_display").innerText = "$" + minPrice;
}

function updateMaxPrice() {
    var maxPrice = document.getElementById("max_price").value;
    document.getElementById("max_price_display").innerText = "$" + maxPrice;
}

    document.addEventListener("DOMContentLoaded", function() {
        // Get the messages section
        var messagesSection = document.getElementById("messages");

        // Check if the messages section exists
        if (messagesSection) {
            setTimeout(function() {
                messagesSection.style.display = "none";
            }, 3500); // 3.5 sec
        }
    });


    const searchItems = document.querySelector('#search');
    if (searchItems) {
        searchItems.addEventListener('input', async function () {
            const response = await fetch('../api/api_search.php?search=' + encodeURIComponent(this.value));
            const items = await response.json();

            const section = document.querySelector('#items');
            section.innerHTML = '';

            for (const item of items) {
                const article = document.createElement('article');
                const link = document.createElement('a');
                link.href = `../pages/items.php?id=${item.id}`;
                const condition = document.createElement('span');
                condition.textContent = `[${item.condition}] | `;
                const name = document.createElement('span');
                name.textContent = `${item.brand} - ${item.model}`;
                const price = document.createElement('span');
                price.textContent = ` ($${item.price})`;
                const img = document.createElement('img');
                img.src = `../img/${item.id}.png`;

                link.appendChild(condition);
                link.appendChild(name);
                link.appendChild(price);
                link.appendChild(img);
                article.appendChild(link);
                section.appendChild(article);
            }
        });
}  
    
const applyFilters = async () => {
    const categoryCheckboxes = document.querySelectorAll('input[name="category[]"]:checked');
    const brandCheckboxes = document.querySelectorAll('input[name="brand[]"]:checked');
    const modelCheckboxes = document.querySelectorAll('input[name="model[]"]:checked');
    const sizeCheckboxes = document.querySelectorAll('input[name="size[]"]:checked');
    const conditionCheckboxes = document.querySelectorAll('input[name="condition[]"]:checked');
    const minPrice = document.getElementById('min_price').value;
    const maxPrice = document.getElementById('max_price').value;

    const categoryValues = Array.from(categoryCheckboxes).map(checkbox => checkbox.value).filter(value => value);
    const brandValues = Array.from(brandCheckboxes).map(checkbox => checkbox.value).filter(value => value);
    const modelValues = Array.from(modelCheckboxes).map(checkbox => checkbox.value).filter(value => value);
    const sizeValues = Array.from(sizeCheckboxes).map(checkbox => checkbox.value).filter(value => value);
    const conditionValues = Array.from(conditionCheckboxes).map(checkbox => checkbox.value).filter(value => value);

    const queryString = new URLSearchParams({
        category: categoryValues.join(','),
        brand: brandValues.join(','),
        model: modelValues.join(','),
        size: sizeValues.join(','),
        condition: conditionValues.join(','),
        min_price: minPrice,
        max_price: maxPrice
    }).toString();

    console.log('Query string:', queryString);

    try {
        const response = await fetch(`../api/api_filter.php?${queryString}`);
        const items = await response.json();

        if (!Array.isArray(items)) {
            console.error('Invalid response format', items);
            return;
        }

        const filteredItemsSection = document.querySelector('#items');
        filteredItemsSection.innerHTML = '';

        for (const item of items) {
            const article = document.createElement('article');
            const link = document.createElement('a');
            link.href = `../pages/items.php?id=${item.id}`;
            const condition = document.createElement('span');
            condition.textContent = `[${item.condition}] | `;
            const name = document.createElement('span');
            name.textContent = `${item.brand} - ${item.model}`;
            const price = document.createElement('span');
            price.textContent = ` ($${item.price})`;
            const img = document.createElement('img');
            img.src = item.image_url;

            link.appendChild(condition);
            link.appendChild(name);
            link.appendChild(price);
            link.appendChild(img);
            article.appendChild(link);
            filteredItemsSection.appendChild(article);
        }
    } catch (error) {
        console.error('Error fetching filtered items:', error);
    }
};

document.querySelector('button[type="button"]').addEventListener('click', applyFilters);
