import { products } from "./items.js";

const shoppingCart = document.getElementById("shoppingCart");
const closeCart = document.getElementById("closeCart");

const itemContainer = document.getElementById("itemContainer");
const cartContainer = document.getElementById("cartContainer");
const eachCartItemContainer = document.getElementById("eachCartItemContainer");
const totalItem = document.getElementById("totalItem");

const cartTitle = document.getElementById("cartTitle");
const totalPrice = document.getElementById("totalPrice");
const totalPriceContainer = document.getElementById("totalPriceContainer");


// Parse the stored cart items or initialize an empty array
let cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];

totalItem.innerText = cartItems.length;

for (let index = 0; index < products.length; index++) {
    const { id, productName, productPrice, productImg } = products[index];
    itemContainer.innerHTML +=
        ` <div class="card">` +
        ` <article class="cardImg">` +
        ` <img src="./img/${productImg}" alt="">` +
        `</article> ` +
        ` <div class="itemDescContainer">` +
        `<article class="itemDesc">` +
        `<h1 class="itemName">${productName}</h1>` +
        `<p class="itemPrice">${productPrice}$</p>` +
        ` </article> ` +
        `<div class="addtocart" id="addtocart${id}")'>` +
        `<i class="fa-solid fa-cart-plus"></i>` +
        ` </div>` +
        ` </div>` +
        `</div>`;
}

for (let index = 0; index < products.length; index++) {
    const { id } = products[index];
    document.getElementById(`addtocart${id}`).onclick = () => {
        if (cartItems.length < 3 && !cartItems.includes(id)) {
            // Check if the number of items in the cart is less than 3
            cartItems.push(id);
            localStorage.setItem("cartItems", JSON.stringify(cartItems));
            totalItem.innerText = cartItems.length;
            displayItemInCart();
        }
    };
}

shoppingCart.onclick = () => {
    cartContainer.classList.add("showCartContainer");
    displayItemInCart();
};

closeCart.onclick = () => {
    cartContainer.classList.remove("showCartContainer");
};

const displayItemInCart = () => {
    const cartItemCount = cartItems.length;

    cartTitle.innerText =
        cartItemCount > 0 ?
        `${cartItemCount} Item${cartItemCount > 1 ? "s" : ""} In Cart` :
        "No Item";

    eachCartItemContainer.innerHTML = "";

    if (cartItems.length > 0) {
        totalPrice.innerText = cartItems
            .reduce((total, itemId) => {
                const selectedItem = products.find((item) => item.id === itemId);
                return total + parseFloat(selectedItem.productPrice);
            }, 0)
            .toFixed(2);

        totalPriceContainer.style.display = "block";
        const paymentContainer = document.getElementById("paymentContainer");
        paymentContainer.style.display = "block";

        cartItems.forEach((itemId) => {
            const selectedItem = products.find((item) => item.id === itemId);
            eachCartItemContainer.innerHTML +=
                `<div class="eachCart">` +
                `<img src="./img/${selectedItem.productImg}" class="cartImg" alt="">` +
                `<div class="cartDesc">` +
                `<h1 class="cartItemName">${selectedItem.productName}</h1>` +
                `<p class="cartItemPrice">${selectedItem.productPrice}$</p>` +
                `<button class="remove" id="remove${itemId}">Remove</button>` +
                `</div>` +
                `</div>`;
        });
    } else {
        cartTitle.innerText = "No Item";
        totalPriceContainer.style.display = "none";
    }

    onRemoveButton();
};

const onRemoveButton = () => {
    cartItems.forEach((itemId) => {
        document.getElementById(`remove${itemId}`).onclick = () => {
            cartItems = cartItems.filter((id) => id !== itemId);
            localStorage.setItem("cartItems", JSON.stringify(cartItems));
            totalItem.innerText = cartItems.length;
            displayItemInCart();
        };
    });
};

// Add event listener for window focus to auto-refresh cart
window.addEventListener("focus", () => {
    cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];
    totalItem.innerText = cartItems.length;
    displayItemInCart();
});

// Update the window focus event listener to fetch and update cartItems
window.addEventListener('focus', () => {
    cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];
    totalItem.innerText = cartItems.length;
    displayItemInCart();
});

// Call displayItemInCart when the page loads to show initial cart state
displayItemInCart();

const calculateTotalAmount = () => {
    // Fetch the latest cart items from local storage
    cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];

    const totalAmount = cartItems.reduce((total, itemId) => {
        const selectedItem = products.find(item => item.id === itemId);
        return total + parseFloat(selectedItem.productPrice);
    }, 0);

    return totalAmount.toFixed(2);
};


const getCartItems = () => {
    return cartItems.map((itemId) => {
        const selectedItem = products.find((item) => item.id === itemId);
        return {
            id: selectedItem.id,
            name: selectedItem.productName,
            description: `Description for ${selectedItem.productName}`,
            quantity: "1",
            amount_per_unit: selectedItem.productPrice,
            total_amount: selectedItem.productPrice,
        };
    });
};

goSell.config({
    containerID: "root",
    gateway: {
        publicKey: "pk_test_clV68Dj23fwkGi4WtyB1rLCb",
        merchantId: null,
        language: "en",
        contactInfo: true,
        supportedCurrencies: "all",
        supportedPaymentMethods: "all",
        saveCardOption: false,
        customerCards: true,
        notifications: "standard",
        callback: (response) => {
            console.log("response", response);
        },
        onClose: () => {
            console.log("onClose Event");
        },
        backgroundImg: {
            url: "imgURL",
            opacity: "0.5",
        },
        labels: {
            cardNumber: "Card Number",
            expirationDate: "MM/YY",
            cvv: "CVV",
            cardHolder: "Name on Card",
            actionButton: "Pay",
        },
        style: {
            base: {
                color: "#5ff35353",
                lineHeight: "18px",
                fontFamily: "sans-serif",
                fontSmoothing: "antialiased",
                fontSize: "16px",
                "::placeholder": {
                    color: "rgba(0, 0, 0, 0.26)",
                    fontSize: "15px",
                },
            },
            invalid: {
                color: "red",
                iconColor: "#fa755a ",
            },
        },
    },
    customer: {
        id: null,
        first_name: "First Name",
        middle_name: "Middle Name",
        last_name: "Last Name",
        email: "demo@email.com",
        phone: {
            country_code: "965",
            number: "99999999",
        },
    },
    order: {
        amount: calculateTotalAmount(),
        currency: "USD",
        items: getCartItems(),
        shipping: null,
        taxes: null,
    },
    transaction: {
        mode: "charge",
        charge: {
            saveCard: false,
            threeDSecure: true,
            description: "Payment Received!",
            statement_descriptor: "Contact us to receive your product.",
            reference: {
                transaction: "txn_0001",
                order: "ord_0001",
            },
            hashstring: "",
            metadata: {},
            receipt: {
                email: false,
                sms: true,
            },
            redirect: "http://localhost:8080/project/index.php",
            post: null,
        },
    },
});


async function PaymentSuccess(ev) {
    ev.preventDefault();

    // Fetch customer information from the server (replace with your actual endpoint)
    const customerInfoResponse = await fetch('get_customer_info.php', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        },
    });

    if (!customerInfoResponse.ok) {
        console.error('Failed to fetch customer information.');
        return;
    }

    const customerInfo = await customerInfoResponse.json();

    // Prepare Discord webhook payload with customer information
    const webhookBody = {
        content: `Payment successful for order number: ${response.transaction.reference.order}`,
        embeds: [{
            title: 'Customer Information',
            fields: [{
                name: 'Name',
                value: customerInfo.name,
            }, {
                name: 'Email',
                value: customerInfo.email,
            }, {
                name: 'Phone',
                value: customerInfo.phone,
            }],
        }],
    };

    // Replace the webhook URL with your actual Discord webhook URL
    const webhookUrl = 'https://discord.com/api/webhooks/your_webhook_url';

    // Send the Discord webhook
    const webhookResponse = await fetch(webhookUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(webhookBody),
    });

    if (!webhookResponse.ok) {
        console.error('Failed to send Discord webhook.');
        return;
    }

    // Handle the successful payment, e.g., redirect to a success page
    window.location.href = 'success.php';
}