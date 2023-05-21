var pMygale = document.getElementById('paragrapheMygale');
var tMygale = document.getElementById('sousTitreMygale');
var cliked = true;

function handleClick() {
    cliked = !cliked;
    console.log(cliked);

    if (cliked) {
        pMygale.style.display = "block";

    } else {
        pMygale.style.display = "none";
        tMygale.style.marginBottom = "10px";



    }
}

