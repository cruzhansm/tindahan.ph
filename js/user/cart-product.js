class Cart {
  ownerID;
  storeList;
  cartStores;
  checkoutProducts;

  constructor(ownerID) {
    this.ownerID = ownerID;
    this.checkoutProducts = new Array();

    // PULL FROM BACKEND
    this.storeList = [
      [1, 'Store 1'],
      [2, 'Store 2'],
      [3, 'Store 3']
    ];

    this.cartStores = new Array();
  }

  createCart() {
    let cart = document.querySelector('.container-form');

    this.storeList.forEach((store, index) => {
      this.cartStores.push(new CartStore(store[0], store[1]));
      cart.append(this.cartStores[index].createCartStore());
    });
  }

  selectAll() {

  }

  checkout() {
    
  }

  addToProductList(product) {
    this.checkoutProducts.push(product);
  }

  addProductToCart() {
    // BACKEND PUSH TO CART
  }

  removeProductFromCart(product) {
    // UPDATE FRONTEND
    // BACKEND REMOVE FROM CART
  }

  removeStoreFromCart() {
    // BACKEND REMOVE ALL OCCURENCES OF PRODUCTS BELONG TO THIS STORE
  }

  updateTotalPrice() {

  }
}

class CartStore {
  sid;
  sname;
  sproducts;
  // cart;

  constructor(sid, sname) {
    this.sid = sid;
    this.sname = sname;
    // this.cart = cart;
    this.sproducts = [
      {
        'id': 1,
        'name': 'Abu Name',
        'price': 100,
        'store': 'Partner',
        'img': '/assets/images/fries.jpg',
        'variation': 1,
        'quantity': 5,
        'cart': 1
      },
      {
        'id': 2,
        'name': 'Dhabi Name',
        'price': 75,
        'store': 'Partner',
        'img': '/assets/images/fries.jpg',
        'variation': 1,
        'quantity': 1,
        'cart': 1
      }
    ]; // BACKEND PULL
  }

  createCartStore() {

    // Containers
    let container = document.createElement('div');
    let store = document.createElement('div');
    let storeHeader = document.createElement('div');
    let headerCheckbox = document.createElement('div');
    let headerTitles = document.createElement('div');

    // Individual elements
    let headerCheck = document.createElement('div');
    let checkbox = document.createElement('input');
    let textLabel = document.createElement('label');

    container.classList.add('cart-form-group');
    store.classList.add('cart-product-area');
    storeHeader.classList.add('cart-form-header');
    headerCheckbox.classList.add('cart-form-checkbox');
    headerTitles.classList.add('cart-form-titles');

    headerCheck.classList.add('form-check');
    checkbox.classList.add('form-check-input');
    textLabel.classList.add('form-check-label');

    container.setAttribute('id', `s${this.sid}`);
    checkbox.setAttribute('type', 'checkbox');
    checkbox.setAttribute('value', `store${this.sid}`);
    checkbox.setAttribute('id', `store${this.sid}`);
    textLabel.setAttribute('for', `store${this.sid}`);
    textLabel.innerText = this.sname;

    // Checkbox and label
    headerCheck.append(checkbox);
    headerCheck.append(textLabel);

    // Checkbox area
    headerCheckbox.append(headerCheck);

    // Header itself
    storeHeader.append(headerCheckbox);
    storeHeader.append(headerTitles);

    // Store itself
    this.sproducts.forEach((product) => {
      let newProduct = new CartProduct(product.id, 
                                       product.name,
                                       product.price,
                                       product.store,
                                       product.img,
                                       product.variation,
                                       product.quantity,
                                       product.cart);
      store.innerHTML += (newProduct.createCartProduct(this.sid));
    });
    
    // Store container
    container.append(storeHeader);
    container.append(store);

    return container;
  }

  removeFrom() {
    this.cart.removeStoreFromCart(this);
  }
}

class CartProduct extends Product {
  cart;

  constructor(pid, pname, pprice, pstore, pimg, pvariation, pquantity, cart) {
    super(pid, pname, pprice, pstore, pimg);
    this.pvariation = pvariation;
    this.pquantity = pquantity;
    this.cart = cart;
  }

  createCartProduct(sid) {

    return `
      <div class="cart-product-group" id="p${this.pid}">
        <div class="cart-product">
          <div class="cart-product-select">
            <input class="form-check-input" type="checkbox" value="product${this.pid}">
            <img class="cart-product-img" src="${this.pimg}">
          </div>
          <div class="cart-product-info">
            <div class="cart-product-name">${this.pname}</div>
            <div class="cart-product-variation">Variation#${this.pvariation}</div>
          </div>
        </div>
        <div class="cart-product-misc">
          <div>P ${this.pprice}</div>
          <div class="cart-product-quantity">
            <i class="fa-solid fa-circle-minus" onclick="updateProduct(1, ${sid}, ${this.pid})"></i>
            <span>${this.pquantity.toString()}</span>
            <i class="fa-solid fa-circle-plus" onclick="updateProduct(2, ${sid}, ${this.pid})"></i>
          </div>
          <div>P ${this.pprice * this.pquantity}</div>
        </div>
      </div>`;

    // Containers
    // let container = document.createElement('div');
    // let product = document.createElement('div');
    // let productSelect = document.createElement('div');
    // let productInfo = document.createElement('div');
    // let productActions = document.createElement('div');
    
    // // Individual Elements
    // let productCheck = document.createElement('input');
    // let productImg = document.createElement('img');
    // let productName = document.createElement('div');
    // let productVariation = document.createElement('div');
    // let productUnitPrice = document.createElement('div');
    // let productQuantity = document.createElement('div');
    // let productTotalPrice = document.createElement('div');
    // let actionMinus = document.createElement('i');
    // let currentNumber = document.createElement('span');
    // let actionPlus = document.createElement('i');

    // container.classList.add('cart-product-group');
    // product.classList.add('cart-product');
    // productSelect.classList.add('cart-product-select');
    // productInfo.classList.add('cart-product-info');
    // productActions.classList.add('cart-product-misc');

    // productCheck.classList.add('form-check-input');
    // productImg.classList.add('cart-product-img');
    // productName.classList.add('cart-product-name');
    // productVariation.classList.add('cart-product-variation');
    // productQuantity.classList.add('cart-product-quantity');
    // actionMinus.classList.add('fa-solid', 'fa-circle-minus');
    // actionPlus.classList.add('fa-solid', 'fa-circle-plus');
    
    // container.setAttribute('id', `p${this.pid}`);
    // productCheck.setAttribute('type', 'checkbox');
    // productCheck.setAttribute('value', `product${this.pid}`);
    // productImg.setAttribute('src', this.pimg);
    // productName.innerText = this.pname;
    // productVariation.innerText = `Variation#${this.pvariation}`;
    // productUnitPrice.innerText = `P ${this.pprice}`;
    // productTotalPrice.innerText = `P ${(this.pprice * 
    //                                     this.pquantity)}`;
    // actionMinus.setAttribute('onclick', `updateProduct(1,${sid}, ${this.pid})`);
    // actionPlus.setAttribute('onclick', `updateProduct(2, ${sid}, ${this.pid})`);
    // currentNumber.innerText = this.pquantity.toString();

    // // Checkbox and image
    // productSelect.append(productCheck);
    // productSelect.append(productImg);

    // // Product info
    // productInfo.append(productName);
    // productInfo.append(productVariation);

    // // Product quantity
    // productQuantity.append(actionMinus);
    // productQuantity.append(currentNumber);
    // productQuantity.append(actionPlus);

    // // Product itself
    // product.append(productSelect);
    // product.append(productInfo);

    // // Product actions
    // productActions.append(productUnitPrice);
    // productActions.append(productQuantity);
    // productActions.append(productTotalPrice);

    // // Product container
    // container.append(product);
    // container.append(productActions);

    // return container;
  }

  // addToCart() {
  //   this.cart.addToProductList(this);
  // }

  // removeFromCart() {
  //   this.cart.removeProductFromCart(product);
  // }
}