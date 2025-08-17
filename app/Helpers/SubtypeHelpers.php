<?php


function getCharacterSubtypeInfo($character, $info = 'all') {
  return getSubtypeInfo($character->subtype_id, $info);
}
function getImageSubtypeInfo($image, $info = 'all') {
  return getSubtypeInfo($image->subtype_id, $info);
}

/**
 * Returns Subtype name of passed Subtype Id.
 *
 * @param int $id
 * @param string $info - label
 *
 * @return string
 */
function getSubtypeInfo(int | null $id, string $info = 'label', $prop = null, $c = null): string | array {
  if ($id == null) $id = 0; // fallback
  // Read JSON file
  $file = __DIR__ . '/subtypeInfo.json';
  if (file_exists($file)) $subtypeContent = file_get_contents($file);
  $subtypeColors = json_decode($subtypeContent);
  // Label Matching
  $subtypeLabels =  [
    0 =>  'unset',
    1 =>  'energetic',
    2 =>  'sweet',
    3 =>  'mundane',
    4 =>  'dreadful',
    6 =>  'passionate',
    5 =>  'strange',
    7 =>  'playful',
    8 =>  'thrilling',
    9 =>  'surreal',
    10 => 'whimsical',
    11 => 'sensational',
    12 => 'bittersweet',
    13 => 'melodramatic',
    14 => 'charming',
    15 => 'fiery',
    16 => 'dazzling',
    17 => 'unknown',
    18 => 'bestial',
    19 => 'cranky',
    20 => 'grounst',
  ];

  $label = $subtypeLabels[$id];
  $subtypeInfo = $subtypeColors->$label;

  if ($info == 'info') return $subtypeInfo;
  if ($info == 'all') return [
    'label' => $label,
    'info' => $subtypeInfo,
  ];
  return $label;
}
