<?=template_header('switch-guide');?>

<link rel="stylesheet" href="/assets/css/switch-guide.css">
<link rel="stylesheet" href="/assets/css/global.css">

<div class="container mx-auto min-vh-100" id="main-container">

  <!-- Content Goes Here -->

    <br>
    <h1> Switch Guide</h1>

  <div class="accordion" id="accordionExample">

    <div class="accordion-item">
      <h2 class="accordion-header" id="headingOne">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Linear Switch Keys
        </button>
      </h2>
      <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          <strong></strong>Linear switch keys provide a smooth key press with quiet noise level.<br>
          
          <br>These keys are: <br><br>

          + Great for typing because keystrokes are smooth and quiet.<br>

          + Great for gaming if keystrokes are preferred to be smooth and tactile feedback is not desired. <br>
        </div>
      </div>
    </div>

    <div class="accordion-item">
      <h2 class="accordion-header" id="headingTwo">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Tactile Switch Keys
        </button>
      </h2>
      <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          <strong></strong> Tactile switch keys provide a feedback bump for each each key press with moderate noise.<br>
          <br>These keys are: <br><br>

          + Great for typing or gaming if a small bump and feedback noise is desired.<br>
        </div>
      </div>
    </div>

    <div class="accordion-item">
      <h2 class="accordion-header" id="headingThree">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Clicky Switch Keys
        </button>
      </h2>
      <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          <strong></strong> Clicky switch keys provide a feedback bump for each key press with a loud and clicky noise.<br>
          <br>These keys are: <br><br>

          + Great for gaming if a loud feedback is desired to know that the key was pressed.<br>

          - Generally not great for typing because of the high noise level.<br>
        </div>
      </div>
    </div>
  
  </div>

</div>
  <?=template_footer()?>
