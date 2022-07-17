// Flickity
let elem = document.querySelector('.main-carousel');
let flkty = new Flickity( elem, {
  // options
  wrapAround: true,
  autoPlay: true

});
// End Flickity

// Restricts theme selector buttons to only one at a time
const themeSelector = (theme, btn) => {
    let selected = false;

    for (let i = 1; i < 4; i++) { // Currently 3 buttons (themes)
        let currentBtn = document.getElementById("themeBtn" + i);

        if (currentBtn.classList.contains("active")) {
            selected = true;
        }

        if (i != btn) {
          currentBtn.classList.remove("active");
        }
    }

    if (selected) {
        document.getElementById("beginBtn").innerHTML = `Begin ${theme} Setup`;
        document.getElementById("beginBtn").classList.remove("disabled");
    } else {
        document.getElementById("beginBtn").innerHTML = `Select Theme to Begin Setup`;
        document.getElementById("beginBtn").classList.add("disabled");
        flkty.playPlayer(); // Flickity
    }

};
