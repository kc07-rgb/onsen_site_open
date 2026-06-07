const introTitlText = document.querySelector(".intro-title-text");
const featureApper = document.querySelectorAll(".feature-wappaer");
const header = document.getElementById("header-vew");


window.addEventListener("scroll", ()=>{
  if(window.scrollY > 300){
    header.classList.add("active")
  } else{
    header.classList.remove("active")
  }
    const rect = introTitlText.getBoundingClientRect();

    if (rect.top < window.innerHeight * 0.9) {
        introTitlText.classList.add("active");
    }
});


const observer = new IntersectionObserver((entries) =>{
    entries.forEach(entry => {
        if(entry.isIntersecting){
            entry.target.classList.add("active");
        }
    });
}, {
  threshold: 0.2   // 20% 見えたら発火
});
featureApper.forEach(element => {
  observer.observe(element);
});

console.log(window.scrollY);
console.log(window.innerHeight);
console.log(introTitlText.offsetTop);


//window.addEventListener("scroll", ()=>{
//  introTitlText.forEach((element, index) => {
//  element.classList.add('active');
//});
//});



//for(let i = 0; i < introTitlText.length; i++){
//
//    //.introTitlTextのオフセットの高さを取得
//    var targetTop = introTitlText[i].offsetTop;
//
//    //画面のスクロール量 + 300px > .introTitlTextのオフセットの高さを取得
//    if(window.scrollY + 500 > targetTop){
//    
//      //書くintroTitlTextにクラスshowを追加
//      introTitlText[i].classList.add('active');
//    }
//  }