<?php
$num = 1;
$den = 1;
$temp = 1;

function hcd ($n,$d) {
  while ($d !=0) {
  $temp = $n % $d;
  $n = $d;
  $d = $temp;
  }

return $n;

}

echo "Type numerator,denominator (conmma separated): ";
$line = fgets(STDIN);
$parts = explode (",", $line);
$num = $parts[0];
$den = $parts[1];

$n = hcd($num,$den);

$num /= $n;
$den /= $n;

echo "Highest Common Divisor: ".$n."\n";
echo "Reduced Fraction: ".$num."/".$den."\n";

?>
