<ul id="sidebar-ul" class="gridded">
  <li class="sidebar-header">
    <a href="{{ url('admin') }}" class="card-link">Admin Home</a>
  </li>

  @foreach (config('lorekeeper.admin_sidebar') as $key => $section)
    @if (Auth::user()->isAdmin || $section['power'] === 'mixed' || Auth::user()->hasPower($section['power']))
      <li class="{{ 'sidebar-section' . (array_key_exists('meta', $section) ? ' ' . $section['meta'] : '') }}">
        <div
          class="sidebar-section-header"
          data-toggle="collapse"
          href="#collapse-{!! $key !!}"
          role="button"
          aria-expanded="false"
          aria-controls="collapse-{!! $key !!}"
        >{{ str_replace(' ', '', $key) }} </div>

        <div
          class="{{ config('lorekeeper.extensions.collapsible_admin_sidebar') ? 'collapse' : '' }} collapse-{!! $key !!}"
          id="collapse-{!! $key !!}"
        >
          {{-- order by name --}}
          @php
            usort($section['links'], function ($a, $b) {
                return strcmp($a['name'], $b['name']);
            });
          @endphp
          @foreach ($section['links'] as $item)
            @if (
                $section['power'] !== 'mixed' ||
                    ($section['power'] === 'mixed' && array_key_exists('power', $item) && Auth::user()->hasPower($item['power']))
            )
              <div class="sidebar-item">
                <a href="{{ url($item['url']) }}"
                  class="collapse-link {{ set_active($item['url'] . '*') }}">{{ $item['name'] }}</a>
              </div>
            @endif
          @endforeach
        </div>
      </li>
    @endif
  @endforeach

</ul>

@if (config('lorekeeper.extensions.collapsible_admin_sidebar'))
  @section('scripts')
    <script>
      $(document).ready(function() {
        let currentCollapse = $(".sidebar-section").find('.collapse');
        [...currentCollapse].forEach(element => {
          let links = $(element).find('.collapse-link');
          [...links].forEach(link => {
            isActive = link.classList.contains('active');
            if (isActive) {
              let active = $(link).closest('.collapse');
              $(active).addClass('show');
            }
          })
        })
      })
    </script>
  @endsection
@endif
