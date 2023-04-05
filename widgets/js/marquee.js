const speed = 60;
const marquee = document.querySelector(".marqueeimages-area");
const content = document.querySelector(".marquee-inner");
const images = content.querySelectorAll("img");

for (let i = 0; i < images.length; i++) {
  content.appendChild(images[i].cloneNode(true));
}

const duration = (content.offsetWidth + content.offsetWidth) / speed;

content.style.animationDuration = duration + "s";
