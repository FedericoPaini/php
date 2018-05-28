<?php

echo "Type one number to factor: ";
$f = fgets(STDIN);

function factorThis($n) {
  if ($n === 1) {
    return $n;
  } else {
    return $n * factorThis($n-1);
  }
}

$n=factorThis($f);
$n=number_format($n);

echo $n."\n";

?>

