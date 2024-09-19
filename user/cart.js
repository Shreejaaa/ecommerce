// Accessing HTML elements by their IDs to manipulate cart amounts and discount codes
var productTotalAmt = document.getElementById('product_total_amt');
var shippingCharge = document.getElementById('shipping_charge');
var totalCartAmt = document.getElementById('total_cart_amt');
var discountCode = document.getElementById('discount_code1');

// Function to decrease the number of items
const decreaseNumber = (incdec, itemprice) => {
  var itemVal = document.getElementById(incdec);
  var itemPrice = document.getElementById(itemprice);
  
  if (itemVal.value <= 0) {
    // Ensures quantity cannot go below 0
    itemVal.value = 0;
    alert('Negative quantity not allowed');
  } else {
    // Decreases quantity by 1
    itemVal.value = parseInt(itemVal.value) - 1;
    itemPrice.innerHTML = parseInt(itemPrice.innerHTML) - 15; // Decreases price
    // Updates total amounts
    productTotalAmt.innerHTML = parseInt(productTotalAmt.innerHTML) - 15;
    totalCartAmt.innerHTML = parseInt(productTotalAmt.innerHTML) + parseInt(shippingCharge.innerHTML);
  }
}

// Function to increase the number of items
const increaseNumber = (incdec, itemprice) => {
  var itemVal = document.getElementById(incdec);
  var itemPrice = document.getElementById(itemprice);
  
  if (itemVal.value >= 5) {
    // Limits the quantity to a maximum of 5
    itemVal.value = 5;
    alert('Max 5 allowed');
  } else {
    // Increases quantity by 1
    itemVal.value = parseInt(itemVal.value) + 1;
    itemPrice.innerHTML = parseInt(itemPrice.innerHTML) + 15; // Increases price
    // Updates total amounts
    productTotalAmt.innerHTML = parseInt(productTotalAmt.innerHTML) + 15;
    totalCartAmt.innerHTML = parseInt(productTotalAmt.innerHTML) + parseInt(shippingCharge.innerHTML);
  }
}

// Function to apply a discount code
const discount_code = () => {
  let totalAmtCurr = parseInt(totalCartAmt.innerHTML);
  let errorTrw = document.getElementById('error_trw');
  
  if (discountCode.value === 'SubMart') {
    // Applies discount and updates the total amount
    let newTotalAmt = totalAmtCurr - 15;
    totalCartAmt.innerHTML = newTotalAmt;
    errorTrw.innerHTML = "Hurray! Code is valid";
  } else {
    errorTrw.innerHTML = "Try Again! Valid code is SubMart";
  }
}
