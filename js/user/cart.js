export class Cart {
  cartOwner;
  cartItems;
  byStore;
  totalPrice;

  constructor(cartOwnerID, cartItems) {
    this.cartOwner = cartOwnerID;
    this.cartItems = cartItems;
    this.byStore = this.sortByStore();

    this.attachStoreCheckListener();
  }

  sortByStore() {
    const cartByStores = new Array();
    const cartStores = new Array();
    const stores = [...new Set(this.cartItems.map((p) => p.store_name))];

    let idx = 0;

    stores.forEach((c) => {
      cartByStores[idx] = this.cartItems.filter(
        (p) => p.store_name.localeCompare(c) == 0
      );
      idx++;
    });

    cartByStores.forEach((store, index) => {
      let storeContainer = document.createElement('div');
      let productArea = document.createElement('div');

      storeContainer.classList.add('cart-form-group');
      productArea.classList.add('cart-product-area');

      storeContainer.innerHTML = `
        <div class="cart-form-header">
          <div class="cart-form-checkbox">
            <div class="form-check">
              <input
                id="s${store[0].product_store}"
                value="${store[0].store_name}"
                type="checkbox"
                class="form-check-input"
              />
              <label for="s${store[0].product_store}" class="form-check-label"
                >${store[0].store_name}</label
              >
            </div>
          </div>
          <div class="cart-form-titles"></div>
        </div>
      `;

      store.forEach((product) => {
        productArea.append(new CartProduct(product));
      });

      storeContainer.append(productArea);

      storeContainer.innerHTML += `
        </div>
      `;

      cartStores[index] = storeContainer;
    });

    return cartStores;
  }

  attachStoreCheckListener() {
    this.byStore.forEach((store) => {
      const checkbox = store.querySelector('.form-check').firstElementChild;
      const children = store
        .querySelector('.cart-product-area')
        .querySelectorAll('input[type=checkbox]');
      const selectAll = document.getElementById('selectAll');

      children.forEach((child) => {
        const selectAll = document.querySelector('#selectAll');
        child.addEventListener('change', () => {
          const siblings = Array.from(
            store
              .querySelector('.cart-product-area')
              .querySelectorAll('input[type=checkbox')
          );

          if (!child.checked) {
            selectAll.checked = checkbox.checked = false;
            selectAll.nextElementSibling.innerText = 'Select All';
          } else {
            checkbox.checked = siblings.every((s) => s.checked)
              ? true
              : checkbox.checked;

            if (checkbox.checked) {
              const siblings = Array.from(
                document.querySelectorAll('.form-check > input[type=checkbox]')
              ).filter((c) => c.id != 'selectAll');

              selectAll.checked = siblings.every((s) => s.checked)
                ? true
                : selectAll.checked;

              if (selectAll.checked) {
                selectAll.nextElementSibling.innerText = 'Unselect All';
              }
            }
          }
          Cart.updateTotalPrice();
        });
      });

      checkbox.addEventListener('change', () => {
        const siblings = Array.from(
          document.querySelectorAll('.form-check > input[type=checkbox]')
        ).filter((c) => c.id != 'selectAll');

        children.forEach((child) => {
          checkbox.checked
            ? child.checked
              ? ''
              : child.click()
            : (child.checked = false);
        });

        if (!checkbox.checked) {
          selectAll.checked = false;
          selectAll.nextElementSibling.innerText = 'Select All';
        } else {
          console.log(siblings);
          selectAll.checked = siblings.every((s) => s.checked)
            ? true
            : selectAll.checked;

          selectAll.nextElementSibling.innerText = selectAll.checked
            ? 'Unselect All'
            : 'Select All';
        }

        Cart.updateTotalPrice();
      });
    });
  }

  static updateTotalPrice() {
    const total = document.getElementById('totalCart');

    let checkoutItems = Array.from(
      document.querySelectorAll('.cart-product-group')
    );

    this.totalPrice = checkoutItems.map((p) => {
      const selected = p.querySelector(
        '.cart-product-select > input[type=checkbox]'
      ).checked;

      if (selected) {
        const price =
          p.querySelector('.cart-product-misc').lastElementChild.innerText;

        return parseInt(price.slice(1));
      } else {
        return 0;
      }
    });

    this.totalPrice = this.totalPrice.reduce((x, y) => (x += y));

    total.innerText = `P${this.totalPrice}`;
  }

  static async removeFromCart(productID) {
    console.log(productID);

    return new Promise(function (resolve, reject) {
      $.ajax({
        type: 'POST',
        url: '/tindahan.ph/php/cart/crud.php',
        data: {
          type: 'remove-from-cart',
          cartItemID: productID,
        },
        success: (result) => {
          console.log(result);
          result = JSON.parse(result);
          resolve(result);
        },
      });
    });
  }
}

export class CartProduct {
  productID;
  productStore;
  productName;
  productImg;
  productVariation;
  productQuantity;
  productBasePrice;
  productTotalPrice;

  constructor(product) {
    this.productID = product.cart_item_id;
    this.productStore = product.product_store;
    this.productName = product.product_name;
    this.productImg = product.product_img;
    this.productVariation = product.variation;
    this.productQuantity = product.quantity;
    this.productBasePrice = product.price;
    this.productTotalPrice = product.price * product.quantity;

    const ret = this.createCartProduct();

    return ret;
  }

  createCartProduct() {
    let product = document.createElement('div');
    product.classList.add('cart-product-group');
    product.setAttribute('id', `prod${this.productID}`);

    product.innerHTML += `
      <div class="cart-product">
        <div class="cart-product-select">
          <input
            id="p${this.productID}"
            value="${this.productID}"
            type="checkbox"
            class="form-check-input"
          />
          <img
            src="${this.productImg}"
            alt="${this.productName}"
            class="cart-product-img"
          />
        </div>
        <div class="cart-product-info">
          <label for="p${this.productID}" class="cart-product-name"
            >${this.productName}</label
          >
          <span class="cart-product-variation"
            >${this.productVariation}</span>
        </div>
      </div>
      <div class="cart-product-misc">
        <div>P${this.productBasePrice}</div>
        <div class="cart-product-quantity">
          <i class="fa-solid fa-circle-minus"></i>
          <span id="q${this.productID}">${this.productQuantity}</span>
          <i class="fa-solid fa-circle-plus"></i>
        </div>
        <div>P${this.productTotalPrice}</div>
      </div>
      <div class="cart-form-delete" onclick="showModal(productRemove, ${this.productID})">
        <i class="fa-solid fa-trash"></i>
      </div>
    </div>
    `;

    return product;
  }

  static attachQuantityChangeListeners(product) {
    const plus = product.querySelector('.fa-circle-plus');
    const minus = product.querySelector('.fa-circle-minus');
    const quantity = product
      .querySelector('.cart-product-quantity')
      .querySelector('span');
    const base = product
      .querySelector('.cart-product-misc')
      .firstElementChild.innerText.slice(1);
    const total = product.querySelector('.cart-product-misc').lastElementChild;

    plus.addEventListener('click', () => {
      let old = parseInt(quantity.innerText);
      quantity.innerText = ++old;

      total.innerText = `P${parseInt(base) * parseInt(quantity.innerText)}`;
      Cart.updateTotalPrice();
    });

    minus.addEventListener('click', () => {
      let old = parseInt(quantity.innerText);

      quantity.innerText = old - 1 > 0 ? --old : old;

      total.innerText = `P${parseInt(base) * parseInt(quantity.innerText)}`;
      Cart.updateTotalPrice();
    });
  }
}
