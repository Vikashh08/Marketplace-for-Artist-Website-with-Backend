window.onload = function () {
    // FILTER LOGIC
    const filterButtons = document.querySelectorAll(".filter-btn");
    const artCards = document.querySelectorAll(".art-card");
  
    filterButtons.forEach((btn) => {
      btn.addEventListener("click", () => {
        document.querySelector(".filter-btn.active")?.classList.remove("active");
        btn.classList.add("active");
        const category = btn.dataset.category;
  
        artCards.forEach((card) => {
          const match = card.dataset.category === category || category === "all";
          card.style.display = match ? "block" : "none";
        });
      });
    });
  
    // ENHANCED CART LOGIC
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
  
    const cartCount = document.getElementById("cartCount");
    const cartModal = document.getElementById("cartModal");
    const cartItems = document.getElementById("cartItems");
    const cartTotal = document.getElementById("cartTotal");
  
    document.querySelectorAll(".add-cart").forEach((btn) => {
      btn.addEventListener("click", () => {
        const card = btn.parentElement;
        const title = card.querySelector("h4").innerText;
        const artist = card.querySelector("p").innerText;
        const price = parseFloat(card.querySelector("span").innerText.replace("$", ""));
  
        const existingItem = cart.find((item) => item.title === title && item.artist === artist);
  
        if (existingItem) {
          existingItem.quantity += 1;
        } else {
          cart.push({ title, artist, price, quantity: 1 });
        }
  
        localStorage.setItem("cart", JSON.stringify(cart));
        updateCartCount();
      });
    });
  
    function updateCartCount() {
      const count = cart.reduce((sum, item) => sum + item.quantity, 0);
      cartCount.innerText = count;
    }
  
    function showCartItems() {
      cartItems.innerHTML = "";
      let total = 0;
  
      cart.forEach((item, index) => {
        total += item.price * item.quantity;
  
        const li = document.createElement("li");
        li.innerHTML = `
          <strong>${item.title}</strong> by ${item.artist}<br>
          $${item.price} x ${item.quantity} = $${(item.price * item.quantity).toFixed(2)}
          <br>
          <button class="remove-btn" data-index="${index}">Remove</button>
        `;
        cartItems.appendChild(li);
      });
  
      cartTotal.innerText = `Total: $${total.toFixed(2)}`;
  
      // Add remove logic
      document.querySelectorAll(".remove-btn").forEach((btn) => {
        btn.addEventListener("click", () => {
          const index = btn.dataset.index;
          cart.splice(index, 1);
          localStorage.setItem("cart", JSON.stringify(cart));
          updateCartCount();
          showCartItems();
        });
      });
    }
  
    updateCartCount();
  
    document.getElementById("openCart").addEventListener("click", () => {
      cartModal.style.display = "block";
      showCartItems();
    });
  
    document.getElementById("closeCart").addEventListener("click", () => {
      cartModal.style.display = "none";
    });
  };
  