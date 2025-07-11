<?php


/**
 * Returns Subtype name of passed Subtype Id.
 *
 * @param int $id
 * @param string $info - label
 *
 * @return string
 */
function getSubtypeInfo(int $id, string $info = 'label', $prop = null) {
  // Read JSON file
  $file = __DIR__ . '/subtypeInfo.json';
  if (file_exists($file)) $subtypeContent = file_get_contents($file);
  $subtypeColors = json_decode($subtypeContent);
  // Label Matching
  $subtypeLabels =  [
    1 => "sweet",
    2 => "energetic",
    3 => "dreadful",
    4 => "mundane",
    5 => "strange",
    6 => "passionate",
    7 => "playful",
    8 => "dazzling",
    9 => "whimsical",
    10 => "thrilling",
    11 => "surreal",
    12 => "charming",
    13 => "melodramatic",
    14 => "bittersweet",
    15 => "sensational",
    16 => "fiery",
    17 => "cirrus",
    18 => "???",
    19 => "???",
    20 => "???",
  ];

  $label = $subtypeLabels[$id];
  if ($info == 'color' && isset($prop)) return implode(', ', $subtypeColors->$label->$prop);
  if ($info == 'colors') return $subtypeColors->$label;
  return $label;
}
