// function div1(elem){
//     test2 = document.getElementById(elem);
// }



function div4(){
    document.getElementById("header").style.opacity = "0.3";
    document.getElementById("block-body").style.opacity = "0.3";
    document.getElementById("article").style.opacity = "0.3";
    document.getElementById("footer").style.opacity = "0.3";
    document.getElementById("desposer-annonce").style.display = "flex";
    document.getElementById("desposer-annonce").style.flexDirection = "column";
    document.getElementById("desposer-annonce").style.justifyContent = "space-around";
    document.getElementById("desposer-annonce").style.alignItems = "center";
    ;
}

document.getElementById("lien-deposer-annonce").addEventListener("click", div4)
