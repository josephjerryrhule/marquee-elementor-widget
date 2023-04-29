(function () {
  [].slice
    .call(document.querySelectorAll("select.cs-select"))
    .forEach(function (el) {
      new SelectFx(el, {
        stickyPlaceholder: false,
        onChange: function (val) {
          document.querySelector("div.cs-placeholder").style.backgroundColor =
            val;
        },
      });
    });
})();

const holdIcon = document.querySelector("div.selectplaceholder");
const options = document.querySelector(".cs-options");

holdIcon.addEventListener("click", () => {
  options.classList.add("cs-active");
});

options.addEventListener("click", () => {
  options.classList.remove("cs-active");
});
