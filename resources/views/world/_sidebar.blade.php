<div id="sidebar-ul">
  <div class="sidebar-header">
    <a href="{{ url('world') }}" class="card-link">Encyclopedia</a>
  </div>
  <details class="sidebar-section" open>
    <summary class="sidebar-section-header"> World </summary>
    <ul>
      <li class="sidebar-item">
        <a href="{{ url('world/info') }}">World Expanded</a>
      </li>
    </ul>
  </details>
  <details class="sidebar-section" open>
    <summary class="sidebar-section-header"> Characters </summary>
    <ul>
      <li class="sidebar-item">
        <a href="{{ url('world/' . __('lorekeeper.specieses')) }}"
          class="{{ set_active('world/species*') }}">{{ ucfirst(__('lorekeeper.specieses')) }}</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('world/' . __('lorekeeper.subtypes')) }}"
          class="{{ set_active('world/subtypes*') }}">{{ ucfirst(__('lorekeeper.subtypes')) }}</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('world/rarities') }}" class="{{ set_active('world/rarities*') }}">Rarities</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('world/trait-categories') }}" class="{{ set_active('world/trait-categories*') }}">Trait Categories</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('world/traits') }}" class="{{ set_active('world/traits*') }}">All Traits</a>
      </li>
      @if (config('lorekeeper.extensions.visual_trait_index.enable_universal_index'))
        <li class="sidebar-item">
          <a href="{{ url('world/universaltraits') }}" class="{{ set_active('world/universaltraits*') }}">
            Universal Trait Index
          </a>
        </li>
      @endif
      <li class="sidebar-item">
        <a href="{{ url('world/character-categories') }}" class="{{ set_active('world/character-categories*') }}">
          Character Categories
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('world/' . __('transformations.transformations')) }}"
          class="{{ set_active('world/' . __('transformations.transformations')) }}"
        >{{ ucfirst(__('transformations.transformations')) }}</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('world/character-titles') }}" class="{{ set_active('world/character-titles*') }}">
          Character Titles
        </a>
      </li>
    </ul>
  </details>
  <details class="sidebar-section" open>
    <summary class="sidebar-section-header"> Items </summary>
    <ul>
      <li class="sidebar-item">
        <a href="{{ url('world/item-categories') }}" class="{{ set_active('world/item-categories*') }}">
          Item Categories
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('world/items') }}" class="{{ set_active('world/items*') }}">
          All Items
        </a>
      </li>
      {{-- <li class="sidebar-item">
        <a href="{{ url('world/currency-categories') }}" class="{{ set_active('world/currency-categories*') }}">
          Currency Categories
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('world/border-categories') }}" class="{{ set_active('world/border-categories*') }}">
          User Border Categories
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('world/borders') }}" class="{{ set_active('world/borders*') }}">
          User Borders
        </a>
      </li> --}}
      <li class="sidebar-item">
        <a href="{{ url('world/currencies') }}" class="{{ set_active('world/currencies*') }}">
          All Currencies
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('world/pet-categories') }}" class="{{ set_active('world/pet-categories*') }}">
          Pet Categories
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('world/pets') }}" class="{{ set_active('world/pets*') }}">
          All Pets
        </a>
      </li>

      <li class="sidebar-item">
        <a href="{{ url('world/' . __('awards.awards')) }}" class="{{ set_active('world/' . __('awards.awards') . '*') }}">
          All {{ ucfirst(__('awards.awards')) }}
        </a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('world/recipes') }}" class="{{ set_active('world/recipes*') }}"> All Recipes </a>
      </li>
    </ul>
  </details>
  {{-- <details class="sidebar-section" open>
    <summary class="sidebar-section-header"> {{ ucfirst(__('awards.awards')) }} </summary>
    <ul>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('world/' . __('awards.award') . '-categories') }}"
          class="{{ set_active('world/' . __('awards.award') . '-categories*') }}"
        >
          {{ ucfirst(__('awards.award')) }} Categories
        </a>
      </li>
    </ul>
  </details>
  <details class="sidebar-section" open>
    <summary class="sidebar-section-header"> Recipes
    </summary>
    <ul>
      </li>
    </ul>
  </details> --}}
</div>
