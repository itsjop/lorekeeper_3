<div id="sidebar-ul">
  <div class="sidebar-header">
    <a href="{{ url('world') }}" class="card-link">Encyclopedia</a>
  </div>
  <div class="details-sb" data-open>
    <summary class="sidebar-section-header"> World </summary>
    <div class="sb-item">
      <a href="{{ url('world/info') }}">World Expanded</a>
    </div>
  </div>
  <div class="details-sb" data-open>
    <summary class="sidebar-section-header"> Characters </summary>
    <div class="sb-item">
      <a href="{{ url('world/' . __('lorekeeper.specieses')) }}"
        class="{{ set_active('world/species*') }}">{{ ucfirst(__('lorekeeper.specieses')) }}</a>
    </div>
    <div class="sb-item">
      <a href="{{ url('world/' . __('lorekeeper.subtypes')) }}"
        class="{{ set_active('world/subtypes*') }}">{{ ucfirst(__('lorekeeper.subtypes')) }}</a>
    </div>
    <div class="sb-item">
      <a href="{{ url('world/rarities') }}" class="{{ set_active('world/rarities*') }}">Rarities</a>
    </div>
    <div class="sb-item">
      <a href="{{ url('world/trait-categories') }}" class="{{ set_active('world/trait-categories*') }}">Trait Categories</a>
    </div>
    <div class="sb-item">
      <a href="{{ url('world/traits') }}" class="{{ set_active('world/traits*') }}">All Traits</a>
    </div>
    @if (config('lorekeeper.extensions.visual_trait_index.enable_universal_index'))
      <div class="sb-item">
        <a href="{{ url('world/universaltraits') }}" class="{{ set_active('world/universaltraits*') }}">
          Universal Trait Index
        </a>
      </div>
    @endif
    <div class="sb-item">
      <a href="{{ url('world/character-categories') }}" class="{{ set_active('world/character-categories*') }}">
        Character Categories
      </a>
    </div>
    <div class="sb-item">
      <a href="{{ url('world/' . __('transformations.transformations')) }}"
        class="{{ set_active('world/' . __('transformations.transformations')) }}"
      >{{ ucfirst(__('transformations.transformations')) }}</a>
    </div>
    <div class="sb-item">
      <a href="{{ url('world/character-titles') }}" class="{{ set_active('world/character-titles*') }}">
        Character Titles
      </a>
    </div>
  </div>
  <div class="details-sb" data-open>
    <summary class="sidebar-section-header"> Items </summary>
    <div class="sb-item">
      <a href="{{ url('world/item-categories') }}" class="{{ set_active('world/item-categories*') }}">
        Item Categories
      </a>
    </div>
    <div class="sb-item">
      <a href="{{ url('world/items') }}" class="{{ set_active('world/items*') }}">
        All Items
      </a>
    </div>
    {{-- <div class="sb-item">
        <a href="{{ url('world/currency-categories') }}" class="{{ set_active('world/currency-categories*') }}">
          Currency Categories
        </a>
      </div>
        <div class="sb-item">
        <a href="{{ url('world/border-categories') }}" class="{{ set_active('world/border-categories*') }}">
          User Border Categories
        </a>
      </div>
        <div class="sb-item">
        <a href="{{ url('world/borders') }}" class="{{ set_active('world/borders*') }}">
          User Borders
        </a>
      </div> --}}
    <div class="sb-item">
      <a href="{{ url('world/currencies') }}" class="{{ set_active('world/currencies*') }}">
        All Currencies
      </a>
    </div>
    <div class="sb-item">
      <a href="{{ url('world/pet-categories') }}" class="{{ set_active('world/pet-categories*') }}">
        Pet Categories
      </a>
    </div>
    <div class="sb-item">
      <a href="{{ url('world/pets') }}" class="{{ set_active('world/pets*') }}">
        All Pets
      </a>
    </div>

    <div class="sb-item">
      <a href="{{ url('world/' . __('awards.awards')) }}" class="{{ set_active('world/' . __('awards.awards') . '*') }}">
        All {{ ucfirst(__('awards.awards')) }}
      </a>
    </div>
    <div class="sb-item">
      <a href="{{ url('world/recipes') }}" class="{{ set_active('world/recipes*') }}"> All Recipes </a>
    </div>
  </div>
  {{-- <div class="details-sb" data-open>
    <summary class="sidebar-section-header"> {{ ucfirst(__('awards.awards')) }} </summary>
      </div>
        <div class="sb-item">
        <a href="{{ url('world/' . __('awards.award') . '-categories') }}"
          class="{{ set_active('world/' . __('awards.award') . '-categories*') }}"
        >
          {{ ucfirst(__('awards.award')) }} Categories
        </a>
      </div>
       </div>
  <div class="details-sb" data-open>
    <summary class="sidebar-section-header"> Recipes
    </summary>
      </div>
       </div> --}}
</div>
