<?php
// Set the password
$password = '1234';

// Get the hash, letting the salt be automatically generated
$hash = password_hash($password, PASSWORD_DEFAULT);
// $hash = "$2y$10$814gdlqiYG7TT/WDI9B4bumudexPoaLQd1xIs7hCQhe4CWKWEVGTa";

echo $hash;

if (password_verify($password, $hash)){
 echo "\n 1";
}

else {
  echo "\n 0";
}
?>
