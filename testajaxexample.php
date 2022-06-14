<?php

   $data = array();
	if(isset($_POST['randomAnswer'])) {
		$data = 'You number is: ' . $_POST['randomAnswer'];       
		$print = json_encode($data);
    echo $print;
    die(); 		   
	}
 else
   echo 'no post :(';
 ?>
 <html>
    <head>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    </head>

 <body>
 <div id = "random"></div>

    <script>

        $(document).ready(function() {

        var number1 = Math.round(Math.random() * 6) + 1;
        var number2 = Math.round(Math.random() * 6) + 1;
        var randomAnswer = number1 + number2;

        $.ajax({
        method: "POST",
        dataType: "json",
        data: {randomAnswer: randomAnswer},
        success: function (result) {
            $("#random").html(result);
        }
        });

        });

    </script>

</body>
</html>