
// Renders articles.html 19 times into .articles container with unique images
(() => {
  const container = document.querySelector(".articles");
  if (!container) return;

  const times = 19;

  const load = () =>
    fetch("articles.html", { cache: "no-store" })
      .then((res) => {
        if (!res.ok) throw new Error(`Failed to fetch articles.html (${res.status})`);
        return res.text();
      });

  Promise.all(Array.from({ length: times }, load))
    .then((htmlParts) => {
      // Insert as separate blocks so each fetch result is preserved
      container.innerHTML = htmlParts.join("\n");
      
      // Update each article image with Image1 through Image19
      const imageNames = [
        "image1.jpg", "image2.jpg", "image3.jpg", "Image4.jpg", "Image5.jpg",
        "Image7.jpg", "Image8.jpg", "image9.jpg", "Image10.jpg", "Image11.jpg",
        "image12.jpg", "Image13.jpg", "Image14.jpg", "Image15.jpg", "image16.jpg",
        "Image17.jpg", "Image18.jpg", "Image20.jpg"
      ];
      
      const images = container.querySelectorAll(".article_image img");
      images.forEach((img, index) => {
        if (imageNames[index]) {
          img.src = `images/${imageNames[index]}`;
          img.alt = `Article Image ${index + 1}`;
        }
      });

      const scrollButtons = document.querySelectorAll(".scrollbar ul li");
      const categoryButtons = document.querySelectorAll(".category_listing .list_item");
      const scrollContainer = document.querySelector(".articles_listing");
      const articleItems = Array.from(container.querySelectorAll(".article_item"));

      if (scrollContainer && articleItems.length) {
        const categoryGroups = categoryButtons.length || 1;
        const categoryChunk = Math.ceil(articleItems.length / categoryGroups);

        categoryButtons.forEach((button, buttonIndex) => {
          button.addEventListener("click", () => {
            const targetIndex = Math.min(buttonIndex * categoryChunk, articleItems.length - 1);
            const targetArticle = articleItems[targetIndex];
            if (!targetArticle) return;

            scrollContainer.scrollTo({
              top: targetArticle.offsetTop,
              left: 0,
              behavior: "smooth",
            });
          });
        });
      }

      if (scrollContainer && scrollButtons.length && articleItems.length) {
        const groups = 5;
        const chunkSize = Math.ceil(articleItems.length / groups);

        scrollButtons.forEach((button, buttonIndex) => {
          button.addEventListener("click", () => {
            const targetIndex = Math.min(buttonIndex * chunkSize, articleItems.length - 1);
            const targetArticle = articleItems[targetIndex];
            if (!targetArticle) return;

            scrollContainer.scrollTo({
              top: targetArticle.offsetTop,
              left: 0,
              behavior: "smooth",
            });
          });
        });
      }
    })
    .catch((err) => {
      console.error(err);
      container.innerHTML = "";
    });
})();

