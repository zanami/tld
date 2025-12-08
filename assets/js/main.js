(function () {
  "use strict";

  // ======= Sticky
  window.onscroll = function () {
    const ud_header = document.querySelector(".ud-header");
    const sticky = ud_header.offsetTop;
    const logo = document.querySelectorAll(".header-logo");

    if (window.pageYOffset > sticky) {
      ud_header.classList.add("dark-display");
    } else {
      ud_header.classList.remove("dark-display");
    }

    if (logo.length) {
      // === logo change
      if (ud_header.classList.contains("dark")) {
        document.querySelector(".header-logo").src =
            "assets/images/logo/logo-white.svg"
      } else {
        document.querySelector(".header-logo").src =
            "assets/images/logo/logo.svg"
      }
    }

    if (document.documentElement.classList.contains("dark")) {
      if (logo.length) {
        // === logo change
        if (ud_header.classList.contains("sticky")) {
          document.querySelector(".header-logo").src =
              "assets/images/logo/logo-white.svg"
        }
      }
    }
  }

  // ===== wow js
  new WOW().init();

  // ====== scroll top js
  function scrollTo(element, to = 0, duration = 500) {
    const start = element.scrollTop;
    const change = to - start;
    const increment = 20;
    let currentTime = 0;

    const animateScroll = () => {
      currentTime += increment;

      const val = Math.easeInOutQuad(currentTime, start, change, duration);

      element.scrollTop = val;

      if (currentTime < duration) {
        setTimeout(animateScroll, increment);
      }
    };

    animateScroll();
  }

  Math.easeInOutQuad = function (t, b, c, d) {
    t /= d / 2;
    if (t < 1) return (c / 2) * t * t + b;
    t--;
    return (-c / 2) * (t * (t - 2) - 1) + b;
  };


})();
