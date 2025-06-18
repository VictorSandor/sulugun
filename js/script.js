document.querySelectorAll(".category-link").forEach((item) => {
  item.item;
  addEventListener("click", (event) => {
    event.preventDefault();
    document
      .querySelector(item.getAttribute("href"))
      .scrollIntoView({ behavior: "smooth" });
  });
});
