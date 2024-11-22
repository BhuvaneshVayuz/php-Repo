<?php function createGreeting($name, $age, $color, $message) {
  
  if ($age < 18) {
      $ageMessage = "Bhag jaa!";
  } else {
      $ageMessage = "yes sirr!";
  }
  return "Hello, $name! $ageMessage Your $color cold drink with label '$message'.";
}

$errorMessages = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST['name'])) {
      $errorMessages[] = "Name is required.";
  }

  if (empty($_POST['age'])) {
      $errorMessages[] = "Age is required.";
  }

  if (empty($_POST['color'])) {
      $errorMessages[] = "Favorite color is required.";
  }

  if (empty($_POST['message'])) {
      $errorMessages[] = "Message is required.";
  }

  if (empty($errorMessages)) {
      $name = $_POST['name'];
      $age = $_POST['age'];
      $color = $_POST['color'];
      $message = $_POST['message'];

      $greeting = createGreeting($name, $age, $color, $message);
      echo "<p class='message'>$greeting</p>";
  } else {
      echo "<ul class='error'>";
      foreach ($errorMessages as $error) {
          echo "<li>$error</li>";
      }
      echo "</ul>";
  }
}


?>