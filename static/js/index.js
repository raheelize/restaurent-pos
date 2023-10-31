AJAX_URL = "backend/requestHandler.php";

cardsData = [];
categoryData = [];
categoryContainer = document.getElementById("category-list");
cardsContainer = document.getElementById("cards-container");
addedItemList = document.querySelector(".added-item-list");
shoppingCart = [];
discountPercentage = 0;
discountAmount = 0;

salesTax = 0;
salesTaxAmount = 0;

totalAmount = 0;

function getCategoryList() {
  var formData = new FormData();
  formData.append("action", "GET_CATEGORY_LIST");
  fetch(AJAX_URL, {
    method: "POST",
    body: formData,
  })
    .then(function (response) {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.json();
    })
    .then(function (data) {
      // Handle the data
      data.categories.forEach(function (value) {
        categoryData.push({
          typeId: value.type_id,
          typeName: value.type_name,
        });
      });

      displayCategroies(categoryData);
    })
    .catch(function (error) {
      // Handle errors
      toastr.error("Fetch error:", error);
      console.error("Fetch error:", error);
    });
}
function getItemList() {
  var formData = new FormData();
  formData.append("action", "GET_ITEM_LIST");
  fetch(AJAX_URL, {
    method: "POST",
    body: formData,
  })
    .then(function (response) {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.json();
    })
    .then(function (data) {
      // Handle the data
      cardsData.length = 0;
      data.items.forEach(function (value) {
        cardsData.push({
          itemId: value.item_id,
          imagePath: value.item_image,
          itemName: value.item_name,
          itemPrice: value.item_price,
          itemCategory: value.type_name,
        });
      });

      displayItems(cardsData);
    })
    .catch(function (error) {
      // Handle errors
      toastr.error("Fetch error:", error);
      console.error("Fetch error:", error);
    });
}

function displayCategroies(data) {
  // categoryContainer.innerHTML = "";

  data.forEach((card) => {
    const cardElement = document.createElement("span");
    cardElement.classList.add("category-item");
    tabId = card.typeName.replace(/\s+/g, "");
    cardElement.innerHTML = `${card.typeName}`;
    cardElement.addEventListener("click", () => {
      filterItemsByCategory(`${card.typeName}`);
    });

    categoryContainer.appendChild(cardElement);
  });
}

function displayItems(data) {
  cardsContainer.innerHTML = "";
  data.forEach((card) => {
    const cardElement = document.createElement("div");
    cardElement.classList.add("col-sm-12", "col-md-3", "my-2");
    cardElement.innerHTML = `
                  <div class="card-section ${card.itemCategory}" >
                    <div class="d-flex align-items-center justify-content-center">
                      <img
                        src="${card.imagePath}"
                        alt="food"
                        class="d-block"
                      />
                    </div>
                    <div class="px-3 pb-2">
                      <p class="text-secondary item-title" style = "height:80px; display:table-cell; vertical-align:bottom;">${card.itemName}                
                      </p>
                      <small><b>PKR ${card.itemPrice}/-</b></small>
                    </div>
                  </div>
                `;

    cardElement.addEventListener("click", () => {
      addItemToCart(card);
    });

    cardsContainer.appendChild(cardElement);
  });
}

function addItemToCart(item) {
  const existingItemIndex = shoppingCart.findIndex(
    (cartItem) => cartItem.itemName === item.itemName
  );

  if (existingItemIndex !== -1) {
    // Item already exists in cart, increment quantity and update total price
    shoppingCart[existingItemIndex].quantity++;
    shoppingCart[existingItemIndex].totalPrice =
      shoppingCart[existingItemIndex].quantity *
      shoppingCart[existingItemIndex].itemPrice;
  } else {
    const cartItem = {
      itemId: item.itemId,
      itemCategory: item.itemCategory,
      imagePath: item.imagePath,
      itemName: item.itemName,
      itemPrice: item.itemPrice,
      quantity: 1,
      totalPrice: item.itemPrice,
    };
    shoppingCart.push(cartItem);
  }

  updateCartDisplay();

  if (shoppingCart.length <= 0) {
    $(".other-charges").hide();
  }
}

function removeItemFromCart(itemName) {
  const existingItemIndex = shoppingCart.findIndex(
    (cartItem) => cartItem.itemName === itemName
  );

  if (existingItemIndex !== -1) {
    shoppingCart[existingItemIndex].quantity--;

    if (shoppingCart[existingItemIndex].quantity === 0) {
      shoppingCart.splice(existingItemIndex, 1);
    } else {
      shoppingCart[existingItemIndex].totalPrice =
        shoppingCart[existingItemIndex].quantity *
        shoppingCart[existingItemIndex].itemPrice;
    }

    updateCartDisplay();
  }
}

function emptyCart() {
  shoppingCart.length = 0;
  updateCartDisplay();
}

// Function to update the displayed cart
function updateCartDisplay() {
  addedItemList.innerHTML = "";

  shoppingCart.forEach((cartItem) => {
    const itemElement = document.createElement("div");
    itemElement.classList.add("added-item");

    itemElement.innerHTML = `
        <div class="d-flex align-items-center">
          <img src="${cartItem.imagePath}" width="50" height="50" alt="item" />
          <div class="item-details ml-1">
            <p class="pb-0 mb-0 text-secondary">${cartItem.itemName}</p>
            <small class="pb-0 mb-0 text-dark">${cartItem.itemPrice}</small>
          </div>
        </div>
        <div class="d-flex">
          <button class="subtract">-</button>
          <div class="value">${cartItem.quantity}</div>
          <button class="add">+</button>
        </div>
      `;

    addedItemList.appendChild(itemElement);

    updateTotal();
  });
}

function updateTotal() {
  const totalElement = document.getElementById("total");
  const itemTotal = calculateTotalPrice();

  const discountPercentageElement = document.getElementById("order-discount");
  const discountAmountElement = document.getElementById("discountAmount");
  discountPercentage = discountPercentageElement.value;

  const includeSalesTax = document.getElementById("sales-tax");
  const salesTaxAmountElement = document.getElementById("salesTaxAmount");

  if (includeSalesTax.checked) {
    salesTax = 5;
  } else {
    salesTax = 0;
  }

  salesTaxAmount = (itemTotal.toFixed(2) * salesTax) / 100;
  discountAmount = (itemTotal.toFixed(2) * discountPercentage) / 100;
  totalAmount = itemTotal.toFixed(2) - discountAmount + salesTaxAmount;

  discountAmountElement.textContent = `PKR. ${discountAmount.toFixed(2)}/-`;
  salesTaxAmountElement.textContent = `PKR. ${salesTaxAmount.toFixed(2)}/-`;
  totalElement.textContent = `PKR. ${totalAmount.toFixed(2)}/-`;
}

// Event delegation for incrementing and decrementing quantities
addedItemList.addEventListener("click", (event) => {
  if (event.target.classList.contains("add")) {
    const itemName =
      event.target.parentElement.previousElementSibling.querySelector(
        ".text-secondary"
      ).textContent;
    const item = shoppingCart.find(
      (cartItem) => cartItem.itemName === itemName
    );
    if (item) {
      addItemToCart(item);
    }
  }

  if (event.target.classList.contains("subtract")) {
    const itemName =
      event.target.parentElement.previousElementSibling.querySelector(
        ".text-secondary"
      ).textContent;
    removeItemFromCart(itemName);
  }
});

function calculateTotalPrice() {
  let totalPrice = 0;
  shoppingCart.forEach((cartItem) => {
    totalPrice += cartItem.totalPrice;
  });
  return totalPrice;
}

// SEARCH ITEMS

function filterItemsByCategory(category) {
  const filteredItems = cardsData.filter((card) => {
    return card.itemCategory.includes(category);
  });
  displayItems(filteredItems);
}

function filterItems() {
  const filterValue = document
    .getElementById("filterInput")
    .value.toLowerCase();

  const filteredItems = cardsData.filter((card) => {
    return card.itemName.toLowerCase().includes(filterValue);
  });

  displayItems(filteredItems);

  if (filterValue.length <= 0) {
    document.querySelector(".clear-search-btn").style.display = "none";
  } else {
    document.querySelector(".clear-search-btn").style.display = "inline";
  }
}

function clearSearch() {
  document.getElementById("filterInput").value = "";
  filterItems();
}

// ORDER METHODS
function placeOrder() {
  if (shoppingCart.length <= 0) {
    toastr.error("Cart is Empty");
  } else {
    if (discountPercentage < 0) {
      toastr.error("Discount Cannot be Less than Zero");
      return false;
    }

    $.ajax({
      type: "POST",
      url: AJAX_URL,
      async: false,
      data: {
        orderlist: shoppingCart,
        salesTaxAmount: salesTaxAmount,
        discountPercentage: discountPercentage,
        discountAmount: discountAmount,
        action: "PLACE_ORDER",
      },
      success: function (response) {
        response = $.parseJSON(response);
        if (response["status"]) {
          toastr.success("Order Successfully Placed.");
          $("#order_id").text(response["order_id"]);
          dispalyOrderDetails();
        } else {
          toastr.error("Order Failed. Please try again.");
        }
      },
    });
  }
}

function dispalyOrderDetails() {
  const orderItems = document.getElementById("order-items-list");
  orderItems.innerHTML = "";

  shoppingCart.forEach((cartItem) => {
    const itemElement = document.createElement("tr");
    itemElement.innerHTML = `
          <td>${cartItem.itemName}</td>
          <td>${cartItem.itemPrice}</td>
          <td>${cartItem.quantity}</td>
          <td>${
            cartItem.quantity.toFixed(2) * cartItem.itemPrice.toFixed(2)
          }</td>
    `;
    orderItems.appendChild(itemElement);
  });

  // Add Discount and Sales Tax in Receipt as well

  const salesTaxReceipt = document.getElementById("order-sales-tax");
  const discountPercentageReceipt = document.getElementById(
    "order-discount-percentage"
  );
  const discountReceipt = document.getElementById("order-discount-receipt");
  const grandTotalReceipt = document.getElementById("order-grand-total");

  const totalPrice = calculateTotalPrice();

  salesTaxAmount = (totalPrice.toFixed(2) * salesTax) / 100;
  discountAmount = (totalPrice.toFixed(2) * discountPercentage) / 100;
  totalAmount = totalPrice.toFixed(2) - discountAmount + salesTaxAmount;

  salesTaxReceipt.textContent = `PKR. ${salesTaxAmount.toFixed(2)}/-`;
  discountPercentageReceipt.textContent = `(${discountPercentage}%)`;
  discountReceipt.textContent = `PKR. ${discountAmount.toFixed(2)}/-`;
  grandTotalReceipt.textContent = `PKR. ${totalAmount.toFixed(2)}/-`;

  $("#orderDetailsModal").modal();
  emptyCart();
}

function printOrderReceipt() {
  orderId = $("#order_id").text();
  location.href = "/burgershop/receipt.html?orderId=" + orderId;
}

function printCartItems() {
  if (shoppingCart.length <= 0) {
    toastr.error("Cart is Empty");
    return false;
  } else {
    content = "";
    const date = new Date();
    const day = date.getDate().toString().padStart(2, "0");
    const month = (date.getMonth() + 1).toString().padStart(2, "0");
    const year = date.getFullYear();
    const hours = date.getHours().toString().padStart(2, "0");
    const minutes = date.getMinutes().toString().padStart(2, "0");
    const seconds = date.getSeconds().toString().padStart(2, "0");

    const formattedDate = `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;

    const tableNumber = document.getElementById("tableNumber").value;
    const orderType = document.getElementById("orderType").value;
    const customerName = document.getElementById("customerName").value;

    
    if (orderType != "DINE IN") {
      if (customerName.length <=0){
        toastr.error("Please Enter Customer Name");
        return false;
      }
      key = "Customer Name : ";
      value = customerName;
    }else{
      if (tableNumber.length <=0){
        toastr.error("Please Enter Table Number");
        return false;
      }
      key = "Table#";
      value = tableNumber;

    }
    // datetime = datetime.toLocaleDateString("en-US");
    printContent = `
  <html>
  <body>
  <center><b>Tanzy's Kitchen</b></center><br>
  <center><b>KITCHEN RECEIPT</b></center><br>
  <small><p style = 'line-height:7px'><b>Print Time:</b> ${formattedDate}</p></small>
  <small><p style = 'line-height:7px'><b>Order Type:</b> ${orderType}</p></small>
  <small><p style = 'line-height:7px'><b>${key}</b> ${value}</p></small>
  <b>Details:</b>
  <table border = "1">
    <thead>
      <tr>
        <th>Item Name</th>
        <th>Rate</th>
        <th>Qty</th>
        <th>Subtotal</th>
      </tr>
    </thead> 
    <tbody>
      `;

    total = 0;
    shoppingCart.forEach((cartItem) => {
      total += cartItem.quantity.toFixed(2) * cartItem.itemPrice.toFixed(2);
      printContent += `<tr><th>${cartItem.itemName}</th>
    <td>${cartItem.itemPrice}</td>
    <td>${cartItem.quantity}</td>
    <th>${cartItem.quantity.toFixed(2) * cartItem.itemPrice.toFixed(2)}</th>
    </tr>`;
    });

    printContent += `</tbody>
  <tr><th colspan='3'>Net Total</th><td>${total}</td></tr>
  <tr><th colspan='3'>Service Charges(${salesTax}%)</th><td>${salesTaxAmount}</td></tr>
  <tr><th colspan='3'>Discount</th><td>${discountAmount}</td></tr>
  <tr><th colspan='3'>Grand Total</th><th>${totalAmount}</th></tr>
  </table></body></html>`;


  printSelectedContent(printContent)

    // orignalPage = document.body.innerHTML;
    // document.body.innerHTML = printContent;
    // window.print();
    // document.body.innerHTML = orignalPage;
  }
}

function printSelectedContent(printContent) {


    var printWindow = window.open('', '_blank');
    printWindow.document.open();
    printWindow.document.write(printContent);
    printWindow.document.close();
    printWindow.print();
    // printWindow.close();
}


document.getElementById("orderType").addEventListener("change", function () {
  const orderType = this.value;
  const tableNumberBlock = document.getElementById("tableNumberBlock");
  const customerNameBlock = document.getElementById("customerNameBlock");

  if (orderType == "DINE IN") {

    tableNumberBlock.style.display = "block";
    customerNameBlock.style.display = "none";
  } else {

    tableNumberBlock.style.display = "none";
    customerNameBlock.style.display = "block";
  }
});
//   TRIGGER METHODS ON DOCUMENT READY

$(document).ready(function () {
  getCategoryList();
  getItemList();
  // Initial update of the cart display
  updateCartDisplay();
});
