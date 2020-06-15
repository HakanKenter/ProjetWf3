header = document.getElementById("header");
blockBody = document.getElementById("block-body");
article = document.getElementById("article");
footer = document.getElementById("footer");
deposerAnnonce = document.getElementById("deposer-annonce");
// eventClick = addEventListener('click', NoneDeposerAnnonce);

// __________________________________________________________________________________________________________________________________________________________________________

function blockDeposerAnnonce(){

    header.style.opacity = "0.3";
    blockBody.style.opacity = "0.3";
    article.style.opacity = "0.3";
    footer.style.opacity = "0.3";
    document.getElementById("desposer-annonce").style.display = "flex";
    document.getElementById("desposer-annonce").style.flexDirection = "column";
    document.getElementById("desposer-annonce").style.justifyContent = "space-around";
    document.getElementById("desposer-annonce").style.alignItems = "center";
};

document.getElementById("lien-deposer-annonce").addEventListener("click", blockDeposerAnnonce);

// __________________________________________________________________________________________________________________________________________________________________________


function NoneDeposerAnnonce(){

    header.style.opacity = "1";
    blockBody.style.opacity = "1";
    article.style.opacity = "1";
    footer.style.opacity = "1";
    document.getElementById("desposer-annonce").style.display = "none";
}

if(blockDeposerAnnonce){
    console.log('yesss');
    header.addEventListener("click", NoneDeposerAnnonce);
    blockBody.addEventListener("click", NoneDeposerAnnonce);
    article.addEventListener("click", NoneDeposerAnnonce);
    footer.addEventListener("click", NoneDeposerAnnonce);
}

// __________________________________________________________________________________________________________________________________________________________________________


// Animation "Bienvenue"

var textWrapper = document.querySelector('.ml2');
textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

anime.timeline({loop: true})
  .add({
    targets: '.ml2 .letter',
    scale: [4,1],
    opacity: [0,1],
    translateZ: 0,
    easing: "easeOutExpo",
    duration: 950,
    delay: (el, i) => 70*i
  }).add({
    targets: '.ml2',
    opacity: 0,
    duration: 1000,
    easing: "easeOutExpo",
    delay: 1000000000000000
  });

function copyToClipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
  }
