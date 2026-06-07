const introTitlText = document.querySelector(".intro-title-text");
const featureApper = document.querySelectorAll(".feature-wappaer");
const header = document.getElementById("header-vew");

window.addEventListener("scroll", ()=>{
  if(window.scrollY > 300){
    header.classList.toggle("active")
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

//hamburger
const hamburger = document.querySelector(".hamburger");
const container = document.querySelector(".hamburger-container");

hamburger.addEventListener("click", ()=>{
  hamburger.classList.toggle("active");
  container.classList.toggle("active");
});