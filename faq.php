<?=template_header('faq');?>

<link rel="stylesheet" href="/assets/css/faq.css">
<link rel="stylesheet" href="/assets/css/global.css">

<div class="container mx-auto min-vh-100" id="main-container">

  <!-- Content Goes Here -->

    <br>
    <h1> FAQS</h1>

  <div class="accordion" id="accordionExample">

    <div class="accordion-item">
      <h2 class="accordion-header" id="headingOne">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Who are we?
        </button>
      </h2>
      <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          <strong></strong>We are a group of students within San Antonio, Texas. We go to school at The University of Texas at San Antonio. Our group includes Jaydan Scheel, Chris Ackerley, Allison Clay, Tyler Nguyen, Alec Layton, Jasper Garcia, and Vivian Meraz.
        </div>
      </div>
    </div>

    <div class="accordion-item">
      <h2 class="accordion-header" id="headingTwo">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Why are we doing this?
        </button>
      </h2>
      <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          <strong></strong>Sometimes, when buying keyboards, mice, keycaps, or really any type of computer accessory, there are too many options to pick from, and can yield all sorts
             of different quality product, from being the real deal to a cheap knockoff. That's why we compiled a website of the best computer accessories that we know of and 
             have found the best deals for each of these products. (And because it is part of our grade :D) 
        </div>
      </div>
    </div>

    <div class="accordion-item">
      <h2 class="accordion-header" id="headingTwoPointFive">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwoPointFive" aria-expanded="false" aria-controls="collapseTwoPointFive">
          How long does it take to process my order?
        </button>
      </h2>
      <div id="collapseTwoPointFive" class="accordion-collapse collapse" aria-labelledby="headingTwoPointFive" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          <strong></strong> Your order will take 1-2 days to be processed for shipping. On our end, we will make sure to put the most effort possible to fill out the orders as fast as 
          possible. We are college students, so we are working in our dorms and rooms, so please be patient.
        </div>
      </div>
    </div>

    <div class="accordion-item">
      <h2 class="accordion-header" id="headingThree">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          When can I expect my order to arrive?
        </button>
      </h2>
      <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          <strong></strong> Your order's shipping time depends on your location. Via USPS information, 2-8 business dates for domestic delivery, and for international shipping,
          it should take 1-2 weeks. 
        </div>
      </div>
    </div>

    <div class="accordion-item">
      <h2 class="accordion-header" id="headingFour">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
          What is your return policy?
        </button>
      </h2>
      <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          <strong></strong> If you are not 100% satisfied with the purchase for any reason, just contact us and we'll be happy to provid a free pre-paid return label for any
           order shipped within North America. Return the order to us within 30 days of when the order was shipped, and we'll process a full refund back to the original payment 
           method. Customers from outside North America are not eligible for returns.After 30 days, if the product has not been burned or damaged, we will be able to offer store 
           credit only. Customers will be responsible for shipping costs for returns made past 30 days.
        </div>
      </div>
    </div>
    
  
  </div>

</div>
  <?=template_footer()?>
