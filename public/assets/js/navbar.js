document.addEventListener("DOMContentLoaded", function () {
    const searchForm = document.getElementById("searchForm");
    const searchInput = document.getElementById("search");
    const sortPrice = document.getElementById("sortPrice");
    const filterCategory = document.getElementById("filterCategory");
    const minPriceFilter = document.getElementById("minPrice");
    const maxPriceFilter = document.getElementById("maxPrice");
    const articlesContainer = document.querySelector(".article-container");
    const noResultsMessage = document.getElementById("noResultsMessage");

    function applyFilters() {
        const searchText = searchInput?.value.trim() || "";
        const selectedCategory = filterCategory?.value || "";
        const sortOption = sortPrice?.value || "";
        const minPrice = minPriceFilter?.value || "";
        const maxPrice = maxPriceFilter?.value || "";

        let url = new URL(window.location.origin + "/articles");
        if (searchText) url.searchParams.set("search", searchText);
        if (selectedCategory) url.searchParams.set("category", selectedCategory);
        if (sortOption) url.searchParams.set("sort", sortOption);
        if (minPrice) url.searchParams.set("minPrice", minPrice);
        if (maxPrice) url.searchParams.set("maxPrice", maxPrice);

        window.location.href = url.toString();
    }

    // Appliquer les filtres dès le chargement si on est déjà sur /articles
    function loadFiltersFromURL() {
        if (!window.location.pathname.includes("/articles")) return;

        const params = new URLSearchParams(window.location.search);
        if (params.has("search")) searchInput.value = params.get("search");
        if (params.has("category")) filterCategory.value = params.get("category");
        if (params.has("sort")) sortPrice.value = params.get("sort");
        if (params.has("minPrice")) minPriceFilter.value = params.get("minPrice");
        if (params.has("maxPrice")) maxPriceFilter.value = params.get("maxPrice");

        filterArticles();
    }

    function filterArticles() {
        const searchText = searchInput?.value.toLowerCase() || "";
        const selectedCategory = filterCategory?.value || "";
        const minPrice = parseFloat(minPriceFilter?.value) || 0;
        const maxPrice = parseFloat(maxPriceFilter?.value) || Infinity;
        const sortOption = sortPrice?.value || "";

        let articles = Array.from(document.querySelectorAll(".article-card"));

        let filteredArticles = articles.filter(article => {
            const name = article.dataset.name.toLowerCase();
            const category = article.dataset.category;
            const price = parseFloat(article.dataset.price);

            const matchesSearch = !searchText || name.includes(searchText);
            const matchesCategory = !selectedCategory || category === selectedCategory;
            const matchesPrice = price >= minPrice && price <= maxPrice;

            return matchesSearch && matchesCategory && matchesPrice;
        });

        if (sortOption === "asc") {
            filteredArticles.sort((a, b) => parseFloat(a.dataset.price) - parseFloat(b.dataset.price));
        } else if (sortOption === "desc") {
            filteredArticles.sort((a, b) => parseFloat(b.dataset.price) - parseFloat(a.dataset.price));
        }

        articlesContainer.innerHTML = "";
        filteredArticles.forEach(article => articlesContainer.appendChild(article));

        noResultsMessage.style.display = filteredArticles.length === 0 ? "block" : "none";
    }

    searchForm?.addEventListener("submit", function (event) {
        event.preventDefault();
        applyFilters();
    });

    loadFiltersFromURL();
});


