
let numPic=1;
let dotnum=1;
let slideshowInterval;
let dotInterval;

Slidedot(dotnum);
SlideShow(numPic);
startSlides();

function startSlides() {
    slideshowInterval = setInterval(AutoshowSlides, 5000);
    dotInterval = setInterval(AutoSlideDot, 5000);
}

function stopSlides() {
    clearInterval(slideshowInterval);
    clearInterval(dotInterval);
}

function plusSlides(n){
    stopSlides();
    SlideShow(numPic += n);
    Slidedot(dotnum +=n);
    startSlides();
}
function SlideShow(n) {
    const x=document.getElementsByClassName("mySlides");
    if (n > x.length) {
        numPic = 1;
    }
    if (n < 1) {
        numPic = x.length;
    }
    for (let i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }
    x[numPic - 1].style.display = "flex";
}

function AutoshowSlides(){
    let i;
    const x = document.getElementsByClassName("mySlides");
    for (i = 0; i < x.length; i++) {
      x[i].style.display = "none";
    }
    numPic++;
    if (numPic > x.length) {numPic = 1}
    x[numPic-1].style.display = "flex";
}

function currentSlide(n){
    stopSlides();
    let i;
    const x=document.getElementsByClassName("mySlides");
    for(i=0;i<x.length;i++){
        x[i].style.display="none";
    }
    x[n-1].style.display="flex";
    dotnum=n;
    numPic=n;
    Slidedot(dotnum);
    startSlides();
}

function Slidedot(n){
    let i;
    const y=document.getElementsByClassName("dot");
    if (n > y.length) {
        dotnum = 1;
    }
    if (n < 1) {
        dotnum = y.length;
    }
    for(i=0;i<y.length;i++){
        y[i].style.backgroundColor="lightgrey";
    }
    y[dotnum-1].style.backgroundColor="grey";
}

function AutoSlideDot(){
    let i;
    const y=document.getElementsByClassName("dot");
    for(i=0;i<y.length;i++){
        y[i].style.backgroundColor="lightgrey";
    }
    if(dotnum>y.length){
        dotnum=1;
    }
    dotnum++;
    if (dotnum > y.length){
        dotnum = 1;
    }
    y[dotnum-1].style.backgroundColor="grey";
}
