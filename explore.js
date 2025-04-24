const buttons = document.querySelectorAll(".category-filter button");
const cards = document.querySelectorAll(".art-card");

// Category filter
buttons.forEach(btn => {
  btn.addEventListener("click", () => {
    document.querySelector(".category-filter .active")?.classList.remove("active");
    btn.classList.add("active");

    const category = btn.dataset.category;
    cards.forEach(card => {
      card.style.display = category === "all" || card.dataset.category === category ? "block" : "none";
    });
  });
});

// Cart logic
let cart = JSON.parse(localStorage.getItem("cart")) || [];

document.querySelectorAll(".art-card button").forEach(btn => {


    btn.addEventListener("click", () => {
        const card = btn.closest(".art-card");
        const title = card.querySelector("h3").innerText;
        const price = parseInt(card.querySelector("p").innerText.replace("₹", ""));
        const image = card.querySelector("img").src;
      
        cart.push({ title, price, image });
        localStorage.setItem("cart", JSON.stringify(cart));
        renderCart();
        showToast(`${title} added to cart 🛒`);
      });
      
});

const cartSidebar = document.getElementById("cartSidebar");
const toggleCartBtn = document.getElementById("toggleCart");
toggleCartBtn.addEventListener("click", () => {
  cartSidebar.classList.toggle("active");
});

function renderCart() {
  const cartItems = document.getElementById("cartItems");
  cartItems.innerHTML = "";
  let total = 0;

  cart.forEach((item, index) => {
    total += item.price;
    const li = document.createElement("li");

    li.innerHTML = `
      <div class="cart-item">
        <img src="${item.image}" alt="${item.title}">
        <div class="cart-text">
          <strong>${item.title}</strong>
          <p>₹${item.price}</p>
        </div>
        <button class="remove" data-index="${index}">×</button>
      </div>
    `;
    cartItems.appendChild(li);
  });

  document.getElementById("total").textContent = `Total: ₹${total}`;

  // Remove item
  document.querySelectorAll(".remove").forEach(btn => {
    btn.addEventListener("click", () => {
      const index = parseInt(btn.dataset.index);
      cart.splice(index, 1);
      localStorage.setItem("cart", JSON.stringify(cart));
      renderCart();
    });
  });
}

function clearCart() {
  localStorage.removeItem("cart");
  cart = [];
  renderCart();
}

renderCart();
document.getElementById("cartCount").textContent = cart.length;
function showToast(message) {
    const toast = document.getElementById("toast");
    toast.textContent = message;
    toast.classList.add("show");
  
    setTimeout(() => {
      toast.classList.remove("show");
    }, 2000);
  }
// Open Lightbox
function openLightbox(src) {
    const lightbox = document.getElementById("lightbox");
    const lightboxImg = document.getElementById("lightboxImg");
  
    lightbox.style.display = "block";
    lightboxImg.src = src;
  }
  
  // Close Lightbox
  function closeLightbox() {
    document.getElementById("lightboxImg").style.display = "none";
  }
    

  document.getElementById("lightbox").addEventListener("click", function (e) {
    if (e.target === this) {
      closeLightbox();
    }
  });
    