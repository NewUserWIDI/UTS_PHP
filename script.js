addEventListener("DOMContentLoaded", () => {
  document.body.classList.add("fade-in"); 

  const items = document.querySelectorAll("[data-aos]");
  const tampil = () => {
    items.forEach(el => {
      if (el.getBoundingClientRect().top < innerHeight - 100)
        el.classList.add("aos-active"); 
    });
  };
  addEventListener("scroll", tampil);
  tampil(); 
});


document.querySelectorAll("a[href]").forEach(link => {
  const url = link.getAttribute("href");
  if (url && !url.startsWith("#") && !url.startsWith("mailto")) {
    link.addEventListener("click", e => {
      e.preventDefault();
      document.body.classList.replace("fade-in", "fade-out");
      setTimeout(() => (location.href = url), 500); 
    });
  }
});
