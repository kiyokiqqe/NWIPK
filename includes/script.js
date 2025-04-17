document.addEventListener("DOMContentLoaded", function () {
    console.log("Script loaded"); // Перевірка завантаження скрипта
    
    const elements = document.querySelectorAll(".hero .content, .cta, .feature");

    function revealElements() {
        elements.forEach(el => {
            if (el.getBoundingClientRect().top < window.innerHeight * 0.85) {
                el.classList.add("visible");
                console.log(el, "added .visible");
            }
        });
    }

    revealElements(); // Викликаємо при завантаженні
    window.addEventListener("scroll", revealElements); // Актуалізація при прокручуванні
});
