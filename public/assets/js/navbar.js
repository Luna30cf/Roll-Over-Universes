document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("search");
        const sortPrice = document.getElementById("sortPrice");
        const filterCategory = document.getElementById("filterCategory");
        const minPriceFilter = document.getElementById("minPrice");
        const maxPriceFilter = document.getElementById("maxPrice");
        const articlesContainer = document.querySelector(".article-container");
        const noResultsMessage = document.getElementById("noResultsMessage");
        const articles = Array.from(document.querySelectorAll(".article-card"));
    
        if (!articlesContainer || articles.length === 0) {
            console.error("Aucun article trouvé ou container manquant.");
            return;
        }
    
        function filterAndSortArticles() {
            console.log("Filtrage activé !");
    
            const searchText = searchInput?.value.toLowerCase() || "";
            const selectedCategory = filterCategory?.value || "";
            const sortOption = sortPrice?.value || "";
            const minPrice = parseFloat(minPriceFilter?.value) || 0;
            const maxPrice = parseFloat(maxPriceFilter?.value) || Infinity;
    
            let filteredArticles = articles.filter(article => {
                const name = article.dataset.name.toLowerCase();
                const category = article.dataset.category;
                const price = parseFloat(article.dataset.price);
    
                const matchesSearch = name.includes(searchText);
                const matchesCategory = selectedCategory === "" || category === selectedCategory;
                const matchesPrice = price >= minPrice && price <= maxPrice;
    
                return matchesSearch && matchesCategory && matchesPrice;
            });
    
            // Afficher ou cacher le message "Aucun résultat"
            if (filteredArticles.length === 0) {
                noResultsMessage.style.display = "block";
            } else {
                noResultsMessage.style.display = "none";
            }
    
            // Tri des articles par prix
            if (sortOption === "asc") {
                filteredArticles.sort((a, b) => parseFloat(a.dataset.price) - parseFloat(b.dataset.price));
            } else if (sortOption === "desc") {
                filteredArticles.sort((a, b) => parseFloat(b.dataset.price) - parseFloat(a.dataset.price));
            }
    
            // Vider le conteneur et afficher les articles filtrés/triés
            articlesContainer.innerHTML = "";
            filteredArticles.forEach(article => articlesContainer.appendChild(article));
        }
    
        searchInput.addEventListener("input", filterAndSortArticles);
        sortPrice.addEventListener("change", filterAndSortArticles);
        filterCategory.addEventListener("change", filterAndSortArticles);
        minPriceFilter.addEventListener("input", filterAndSortArticles);
        maxPriceFilter.addEventListener("input", filterAndSortArticles);
    
        console.log("Filtres et tri activés !");
    });
    