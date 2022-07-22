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
        document.getElementById("beginBtn").innerHTML = `Crea Nueva Aldea ${theme}`;
        document.getElementById("beginBtn").classList.remove("btn-dark");
        document.getElementById("beginBtn").classList.remove("disabled");
        document.getElementById("beginBtn").classList.add("btn-primary");


        for (let i = 1; i < 4; i++) { // Currently 3 buttons (themes)

            if (i != btn) {
              document.getElementById("descr" + i).classList.add("d-none");
            } else {
              document.getElementById("descr" + i).classList.remove("d-none");
            }
        }


    } else {
        document.getElementById("beginBtn").innerHTML = `Elige una temática para iniciar`;
        document.getElementById("beginBtn").classList.remove("btn-primary");
        document.getElementById("beginBtn").classList.add("btn-dark");
        document.getElementById("beginBtn").classList.add("disabled");
        flkty.playPlayer(); // Flickity

        document.getElementById("descr" + btn).classList.add("d-none");

    }

};
