<div class="ml-badge">
  <div class="flag">
    <div class="bg">
    </div>
    <div class="label">
      {{ ucfirst(getSubtypeInfo($character->image->subtype_id)) }} Palate
    </div>
  </div>
  <img src="{{ asset('images/subtypes/badges/' . getSubtypeInfo($character->image->subtype_id) . '.png') }}"
    alt="{{ 'Subtype badge for ' . $character->url . '.' }}"
  >
</div>
