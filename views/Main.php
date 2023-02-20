<?php
$input = $_POST['Input'];
if(isset($_POST['columnID'])) {
$delete = $comms->delete($_POST['studentNumber'], $_POST['firstName'], $_POST['lastName'], $_POST['smartTarget'], $_POST['gptFeedback']);
}
?>
<h1>Bolton College GPT</h1>
<section class="align-center">
<input type="button" class="button" value="Review" onclick="location.href='?page=Review';">
</section>
<section id="view">
  <table>
    <tr>
      <th>Student Number</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>SMART Target</th>
      <th>GPT Feedback</th>
      <th>Delete</th>
    </tr>
    <?php
    $Data = $comms->getData();
    foreach($Data as $column) {
      $curl = curl_init();
      $fields = array(
        "model" => "text-davinci-003",
        "prompt" => "Please analyse the following text against the following rubric: 1. Has an issue been identified? 2. Has a goal been specified to resolve the issue? 3. Has a date been set to resolve the issue? ".$column['SMART Target'],
        "temperature" => 0,
        "max_tokens" => 2049,
        "echo" => false
      );
      $fields = json_encode($fields);
      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.openai.com/v1/completions',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $fields,
        CURLOPT_HTTPHEADER => array(
          'Authorization: Bearer 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',
          'Content-Type: application/json'
        ),
      ));
      if($column['GPT Feedback'] == "" || $column['GPT Feedback'] == "[value-6]") {
      $response = curl_exec($curl);

      curl_close($curl);

      $response_data = json_decode($response, true);
      $feedback = $response_data["choices"][0]["text"];
      $update = $comms->feedback($feedback, $column['SMART Target']);
    }

      else {
        $feedback = $column['GPT Feedback'];

      }
          ?>
          <tr>
            <td><?php echo $column['Student Number']?></td>
            <td><?php echo $column['First Name']?></td>
            <td><?php echo $column['Last Name']?></td>
            <td><?php echo $column['SMART Target']?></td>
            <td value="Result"><?php echo $feedback?></td>
            <td style="justify-content:center; align-items: center; display: flex;"><form action="" method="post">
            <input type="hidden" name="studentNumber" value="<?php echo $column["Student Number"]?>">
            <input type="hidden" name="firstName" value="<?php echo $column["First Name"]?>">
            <input type="hidden" name="lastName" value="<?php echo $column["Last Name"]?>">
            <input type="hidden" name="smartTarget" value="<?php echo $column["SMART Target"]?>">
            <input type="hidden" name="gptFeedback" value="<?php echo $column["GPT Feedback"]?>">
            <input type="hidden" name="columnID" value="1">
            <input type="submit" value="X" onclick="return confirm('Are you sure you want to delete?')" class="delete"></input></form></td>
          </tr>
    <?php
          }
  ?>
  </table>
</section>
