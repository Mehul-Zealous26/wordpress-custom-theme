document.querySelectorAll(".industry-tab").forEach((tab, index) => {
            tab.setAttribute("data-id", index); //give id particular tab
            tab.addEventListener("click", () => {
                document.querySelectorAll(".industry-tab").forEach(t => t.classList.remove("active")); //remove all active tabs 
                tab.classList.add("active"); //add active on clicked tab
                document.querySelectorAll(".category-sub-content").forEach(c => c.classList.remove("active")); //remove all active tabs from sub content
                const id = tab.getAttribute("data-id"); //get id
                const targetContent = document.getElementById("content-tab-" + id); //give id to selected content
                if (targetContent) {
                    targetContent.classList.add("active"); // active particular tab
                }
            });
        });

    document.addEventListener("DOMContentLoaded", function () { //after loading all content then it will run
    const swiper = new Swiper(".main-banner-swiper", {
        loop: true,
        slidesPerView: 1,
        autoplay: {
            delay: 3000,
        },
        pagination: {
            el: ".banner-slider-cont .swiper-pagination", 
            clickable: true,
        },
    });
});


    