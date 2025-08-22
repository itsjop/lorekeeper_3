@extends('user.layout', ['pageName' => 'user/inventory'])

@section('profile-title')
  {{ $user->name }}'s Inventory
@endsection

@section('profile-content')
  {!! breadcrumbs(['Users' => 'users', $user->name => $user->url, 'Inventory' => $user->url . '/inventory']) !!}

  <h1>Inventory </h1>
  {!! Form::open(['method' => 'GET', 'class' => '']) !!}
  <fieldset class="inventory-search-pane justify-content-end">
    <legend> Search </legend>
    <div class="sort btn-group">
      <button
        type="button"
        class="btn btn-secondary active def-view-button m-0"
        data-bs-toggle="tooltip"
        title="Default View"
        alt="Default View"
      >
        <i class="fas fa-th"></i></button>
      <button
        type="button"
        class="btn btn-secondary sum-view-button m-0 ml-2"
        data-bs-toggle="tooltip"
        title="Summarized View"
        alt="Summarized View"
      >
        <i class="fas fa-bars"></i></button>
    </div>

    <div class="name form-group m-0 w-100">
      {!! Form::text('name', Request::get('name'), ['class' => 'form-control w-100', 'placeholder' => 'Name']) !!}
    </div>
    <div class="category form-group m-0">
      {!! Form::select('item_category_id', $categories->pluck('name', 'id'), Request::get('item_category_id'), [
          'class' => 'form-control w-100',
          'placeholder' => 'Any Category'
      ]) !!}
    </div>
    @if (config('lorekeeper.extensions.item_entry_expansion.extra_fields'))
      <div class="rarity form-group m-0">
        {!! Form::select('rarity_id', $rarities, Request::get('rarity_id'), ['class' => 'form-control w-100']) !!}
      </div>
      <div class="artist form-group m-0">
        {!! Form::select('artist', $artists, Request::get('artist'), [
            'class' => 'form-control w-100',
            'placeholder' => 'Any Artist'
        ]) !!}
      </div>
    @endif
    <div class="search form-group m-0">
      {!! Form::submit('Search', ['class' => 'btn btn-primary m-0']) !!}
    </div>
  </fieldset>
  {!! Form::close() !!}

  <div id="defView" class="hide">
    @foreach ($items as $categoryId => $categoryItems)
      <div class="card mb-3 inventory-category">
        <h5 class="card-header inventory-header">
          {!! isset($categories[$categoryId])
              ? '<a href="' . $categories[$categoryId]->searchUrl . '">' . $categories[$categoryId]->name . '</a>'
              : 'Miscellaneous' !!}
          <a
            class="small inventory-collapse-toggle collapse-toggle"
            href="#categoryId_{!! isset($categories[$categoryId]) ? $categories[$categoryId]->id : 'miscellaneous' !!}"
            data-bs-toggle="collapse"
          >
            Show
          </a>
        </h5>
        <div class="card-body inventory-body collapse show grid-4-col grid" id="categoryId_{!! isset($categories[$categoryId]) ? $categories[$categoryId]->id : 'miscellaneous' !!}">
          @foreach ($categoryItems as $itemId => $stack)
            <div
              class="text-center inventory-item"
              data-id="{{ $stack->first()->pivot->id }}"
              data-name="{{ $user->name }}'s {{ $stack->first()->name }}"
            >
              @if ($stack->first()->has_image)
                <a href="#" class="inventory-stack">
                  <img src="{{ $stack->first()->imageUrl }}" alt="{{ $stack->first()->name }}" />
                </a>
              @endif
              <a href="#" class="inventory-stack inventory-stack-name">
                {{ $stack->first()->name }}
                <span class="badge badge-primary">
                  x{{ $stack->sum('pivot.count') }}
                </span>
              </a>
            </div>
          @endforeach
        </div>
      </div>
    @endforeach
  </div>

  <div id="sumView" class="hide">
    @foreach ($items as $categoryId => $categoryItems)
      <div class="card mb-2">
        <h5 class="card-header">
          {!! isset($categories[$categoryId])
              ? '<a href="' . $categories[$categoryId]->searchUrl . '">' . $categories[$categoryId]->name . '</a>'
              : 'Miscellaneous' !!}
          <a
            class="small inventory-collapse-toggle collapse-toggle"
            href="#categoryId_{!! isset($categories[$categoryId]) ? $categories[$categoryId]->id : 'miscellaneous' !!}"
            data-bs-toggle="collapse"
          >
            Show
          </a>
        </h5>
        <div class="card-body p-2 collapse show row" id="categoryId_{!! isset($categories[$categoryId]) ? $categories[$categoryId]->id : 'miscellaneous' !!}">
          @foreach ($categoryItems as $itemtype)
            <div class="col-lg-3 col-sm-4 col-12">
              @if ($itemtype->first()->has_image)
                <img
                  src="{{ $itemtype->first()->imageUrl }}"
                  style="height: 25px;"
                  alt="{{ $itemtype->first()->name }}"
                />
              @endif
              <a href="{{ $itemtype->first()->idUrl }}">
                {{ $itemtype->first()->name }}
              </a>
              <ul
                class="mb-0"
                data-id="{{ $itemtype->first()->pivot->id }}"
                data-name="{{ $user->name }}'s {{ $itemtype->first()->name }}"
              >
                @foreach ($itemtype as $item)
                  <li>
                    <a class="inventory-stack" href="#">
                      Stack of x{{ $item->pivot->count }}
                    </a>.
                  </li>
                @endforeach
              </ul>
            </div>
          @endforeach
        </div>
      </div>
    @endforeach
  </div>

  <h3>Latest Activity</h3>
  <div class="mb-4 logs-table">
    <div class="logs-table-header">
      <div class="row">
        <div class="col-6 col-md-2">
          <div class="logs-table-cell">Sender</div>
        </div>
        <div class="col-6 col-md-2">
          <div class="logs-table-cell">Recipient</div>
        </div>
        <div class="col-6 col-md-2">
          <div class="logs-table-cell">Item</div>
        </div>
        <div class="col-6 col-md-4">
          <div class="logs-table-cell">Log</div>
        </div>
        <div class="col-6 col-md-2">
          <div class="logs-table-cell">Date</div>
        </div>
      </div>
    </div>
    <div class="logs-table-body">
      @foreach ($logs as $log)
        <div class="logs-table-row">
          @include('user._item_log_row', ['log' => $log, 'owner' => $user])
        </div>
      @endforeach
    </div>
  </div>

  <div class="text-right">
    <a href="{{ url($user->url . '/item-logs') }}">View all...</a>
  </div>
@endsection

@section('scripts')
  @include('widgets._inventory_view_js')
  <script>
    $(document).ready(function() {
      $('.inventory-stack').on('click', function(e) {
        e.preventDefault();
        var $parent = $(this).parent();
        loadModal("{{ url('items') }}/" + $parent.data('id'), $parent.data('name'));
      });
    });
  </script>
@endsection
