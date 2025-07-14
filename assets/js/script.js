document.addEventListener("DOMContentLoaded", () => {
  const toggleBtn = document.querySelector(".menu-toggle");
  const sidebar = document.querySelector(".sidebar");
  const content = document.querySelector(".main-content");

  if (toggleBtn && sidebar) {
    toggleBtn.addEventListener("click", () => {
      sidebar.classList.toggle("active");
      if (content) content.classList.toggle("shifted");
    });
  }

  // Optional: category filtering (if you have dropdown)
  const categorySearch = document.getElementById("categorySearch");
  if (categorySearch) {
    categorySearch.addEventListener("change", () => {
      const selectedCategory = categorySearch.value.toLowerCase();
      const cards = document.querySelectorAll(".blog-card");

      cards.forEach(card => {
        const cardCategory = card.getAttribute("data-category").toLowerCase();
        card.style.display = (selectedCategory === "all" || selectedCategory === cardCategory) ? "block" : "none";
      });
    });
  }
});
