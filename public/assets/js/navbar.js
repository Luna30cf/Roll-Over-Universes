categories = document.querySelectorAll(".navbarCategorie")
navbar = document.querySelector(".navbarMenu")
// searchIcon = document.querySelector(".")

dev = false

categories.forEach(cat => {
    cat.addEventListener("mouseenter", function(e){
            navbar.classList.add("navbarDevelopp")
            cat.classList.add("categorieUnderline")
    })

    navbar.addEventListener("mouseleave", function(e){
            navbar.classList.remove("navbarDevelopp")
            cat.classList.remove("categorieUnderline")
    })
});


// search