<?php
$input = $_POST['Input'];
?>
<h1>Bolton College GPT</h1>
<div class="back-button">
<input type="button" class="button" name="Back" value="Back" onclick="location.href='?page=Main';">
</div>
<form action="" method="post">
<section id="query">
<textarea name="Input" class="query" id="Input" placeholder="Enter text..." style="height:200px; width:500px;"><?php echo $data['SMART Target']?></textarea>
</section>
<section id="button">
<input class="button" type="submit" value="Submit">
</section>
</form>
<?php
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.openai.com/v1/completions',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
   "model": "text-davinci-003",
   "prompt": "'.$input.'",
   "temperature": 0,
   "max_tokens": 2049,
   "echo": false
   }',
    CURLOPT_HTTPHEADER => array(
      'Authorization: Bearer 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',
      'Content-Type: application/json'
    ),
  ));
  if(isset($_POST['Input'])) {

  $response = curl_exec($curl);

  curl_close($curl);

  $response_data = json_decode($response, true);
  }
  ?>
<section id="result">
<p class="result" value="Result" style="width:500px; height:200px; margin-left:240px;"><?php echo $response_data["choices"][0]["text"]?></p>
</section>
