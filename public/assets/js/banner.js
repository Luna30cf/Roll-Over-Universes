banner = document.querySelector(".bannerTitle")

tab=[0,1,2,3]
i=0
setInterval(() => {
    banner.style.background="url('/images/Banner"+tab[i]+".png')"
    banner.style.backgroundSize="cover"
    banner.style.backgroundPosition="center"
    banner.style.backgroundRepeat="no-repeat"
    console.log("ok")
    i++
    if (tab.length == i){
        console.log(tab.length,i)
        i=0
    }
}, 3000);
