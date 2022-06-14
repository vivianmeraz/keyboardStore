<?php

?>

<?=template_header('Checkout & Review Order');?>

    <script src="assets/js/checkout.js"></script>

    <div class="container mt-5">
    <h4 class="text-center">Checkout & Review Order</h4>
        <div class="row">
            <div class="col-md-8">

                <h5 class="fw-bold show border-bottom">Shipping</h5>
                <div id="shipping-div" class="row align-items-start mb-2 show collapse-shipping">

                    <div class="col-sm-10 mb-2 show">
                        <div><strong>Name</strong><br>Address<br>City, State, Zip Code
                        </div>
                        <div id="shipping-div" class="row align-items-start mb-2">
                            <div class="shipping-method-selection-div">
                                <div class="row border my-3 py-2">
                                    <div class="col-1">
                                        <input class="form-check-input" type="radio" name="shippingRadio"
                                            id="shippingRadio" checked>
                                    </div>
                                    <div class="col-9">
                                        <b>Arrives in 5 - 7 days</b>
                                    </div>
                                    <div class="col-2">
                                        $5.00
                                    </div>
                                </div>
                                <div class="row border py-2">
                                    <div class="col-1">
                                        <input class="form-check-input" type="radio" name="shippingRadio"
                                            id="shippingRadio">
                                    </div>
                                    <div class="col-9">
                                        <b>Arrives in 2 - 3 days</b>
                                    </div>
                                    <div class="col-2">
                                        $20.00
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <a class="float-end mb-2" onclick="swapToHide('shipping-div', 'change-shipping-div')">
                            Change
                        </a>
                    </div>
                </div>
                <div class="d-none" id="change-shipping-div">
                    <div class="row" id="change-shipping-inner">
                        <script>
                            const card = new Object();
                            card.name = "Bob LastName";
                            card.street = "123 best street"
                            card.address = "cool city, XL 78782"
                            makeAddressCards("change-shipping-inner", "Shipping", [card, card, card]);
                        </script>
                        <div class="col-sm-6 my-2">
                            <div class="card">
                                <div class="card-body p-3">
                                    <button onclick="swapToHide('change-shipping-div', 'add-shipping-div')"
                                        class="btn btn-primary my-2">Add New Address
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8"></div>
                        <div class="col-3">
                            <button onclick="swapToHide('change-shipping-div', 'shipping-div')"
                                class="btn btn-primary my-2">Save &
                                Continue
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mb-3 d-none" id="add-shipping-div">
                    <div class="row mb-4">
                        <div class="form-floating col-6">
                            <input type="text" class="form-control" id="FirstName" placeholder="FirstName">
                            <label for="FirstName">FirstName</label>
                        </div>
                        <div class="form-floating col-6">
                            <input type="text" class="form-control" id="LastName" placeholder="LastName">
                            <label for="LastName">LastName</label>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="form-floating col-12">
                            <input type="text" class="form-control" id="FirstName" placeholder="FirstName">
                            <label for="FirstName">Street Address</label>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="form-floating col-3">
                            <input type="text" class="form-control" id="FirstName" placeholder="FirstName">
                            <label for="FirstName">Zip Code</label>
                        </div>
                        <div class="form-floating col-3">
                            <input type="text" class="form-control" id="LastName" placeholder="LastName">
                            <label for="LastName">City</label>
                        </div>
                        <div class="form-floating col-6">
                            <input type="text" class="form-control" id="LastName" placeholder="LastName">
                            <label for="LastName">State</label>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="form-floating col-6">
                            <input type="text" class="form-control" id="FirstName" placeholder="FirstName">
                            <label for="FirstName">Phone Number</label>
                        </div>
                        <div class="col-2">

                        </div>
                        <div class="form-floating col-1">
                            <button class="btn mx-auto p-1 mt-1"
                                onclick="swapToHide('add-shipping-div', 'shipping-div')">Cancel</button>
                        </div>
                        <div class="form-floating col-3">
                            <button class="bg-danger rounded-0 btn text-white w-100"
                                onclick="swapToHide('add-shipping-div', 'shipping-div')">Save & Continue</button>
                        </div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="" name="" value="something" checked>
                        <label class="form-check-label">Save as Default Shipping Address</label><br>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="" name="" value="something">
                        <label class="form-check-label">Save as Default Billing Address</label><br>
                    </div>
                </div>

                <h5 class="fw-bold show border-bottom">Payment</h5>
                <div id="payment-div" class="row align-items-start mb-2">

                    <div class="col-10 mb-2 show">
                        <div><strong>Card ending in: XXXX</strong><br>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="default-check" name="default-check"
                                    value="something" checked>
                                <label class="form-check-label">Save as Default Payment Method</label><br>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="billing-check" name="billing-check"
                                    onclick="diffBilling()" value="something" checked>
                                <label class="form-check-label">Billing Address same as Shipping Address</label><br>
                                <div id="billing-address-div"></div>

                                <div class="d-none" id="change-billing">
                                        <script>
                                            card.name = "Bob LastName";
                                            card.street = "123 best street"
                                            card.address = "cool city, XL 78782"
                                            makeAddressCards("change-billing", "billing", [card, card],"Billing Address:");
                                        </script>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="col-2">
                        <a class="float-end mb-2" onclick="swapToHide('payment-div', 'change-payment-div')"
                            role="button">
                            Change Payment
                        </a>
                    </div>
                </div>

                <div class="d-none" id="change-payment-div">
                    <script>
                        const paymentCard = new Object();
                        paymentCard.name = "Bob LastName";
                        paymentCard.number= 1234;
                        paymentCard.type = "Visa"
                        makePaymentCards("change-payment-div", "payment", [paymentCard,paymentCard]);
                    </script>
                        <div class="col-sm-6 my-2">
                            <div class="card">
                                <div class="card-body p-3">
                                    <button onclick="swapToHide('change-payment-div', 'add-payment-div')"
                                        class="btn btn-primary my-2">Add Card
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 m-md-4">

                            <button onclick="swapToHide('change-payment-div', 'payment-div')" class="btn btn-primary">Save &
                                Continue
                            </button>
                        </div>
                </div>
                
                <div class="mb-3 d-none" id="add-payment-div">
                    <div class="row mb-4">
                        <div class="form-floating col-md-6">
                            <input type="text" class="form-control" id="FirstName" placeholder="FirstName">
                            <label for="FirstName">Name As It Appears On Card</label>
                        </div>
                        <div class="form-floating col-md-6">
                            <input type="text" class="form-control" id="LastName" placeholder="LastName">
                            <label for="LastName">Card Number</label>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="form-floating col-md-3">
                            <input type="text" class="form-control" id="FirstName" placeholder="FirstName">
                            <label for="FirstName">Expiration Date</label>
                        </div>
                        <div class="form-floating col-md-3">
                            <input type="password" class="form-control" id="LastName" placeholder="LastName">
                            <label for="LastName">Security Code</label>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="form-floating col-md-1">
                            <button class="btn mx-auto p-1 mt-1"
                                onclick="swapToHide('add-payment-div', 'payment-div')">Cancel</button>
                        </div>
                        <div class="form-floating col-3">
                            <button class="bg-danger rounded-0 btn text-white w-100"
                                onclick="swapToHide('add-payment-div', 'payment-div')">Save & Continue</button>
                        </div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="" name="" value="something">
                        <label class="form-check-label">Save as Default Billing Address</label><br>
                    </div>
                </div>


            </div>
            <div class="col-md-4">
                <div class=" border border-2">
                    <div class="m-3">
                        <p>
                            Subtotal
                        </p>
                        <p>
                            Shipping & Handling
                        </p>
                        <p class="border-bottom">
                            Tax
                        </p>
                        <h4>Total: $123.45</h4><div class="mx-auto w-75">
                        <button class="btn btn-danger w-100 my-1">Place Order</button>
                        </div>
                        <div class="row">
                            <h6>Cart(# Items)</h6>
                            <div class="col-3">
                                #1 Image
                            </div>
                            <div class="col-7">
                                description
                            </div>
                            <div class="col-2">
                                $123.45
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
   <?=template_footer()?>
