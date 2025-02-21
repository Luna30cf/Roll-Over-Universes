categories = document.querySelectorAll(".navbarCategorie")
navbar = document.querySelector(".navbarMenu")

dev = false

categories.forEach(cat => {
    cat.addEventListener("click", function(e){
        console.log(dev)
        if (dev == true){
            navbar.classList.remove("navbarDevelopp")
            
            dev=false
        }else{
            navbar.classList.add("navbarDevelopp")
            dev=true
        }
    })
});