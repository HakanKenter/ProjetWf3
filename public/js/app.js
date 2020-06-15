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

function copyToClipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
  }
