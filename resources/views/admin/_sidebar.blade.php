<div id="sidebar-ul" class="gridded">
  <div class="sidebar-header">
    <a href="{{ url('admin') }}" class="card-link">Admin Home</a>
  </div>

  @foreach (config('lorekeeper.admin_sidebar') as $key => $section)
    @if (Auth::user()->isAdmin || $section['power'] === 'mixed' || Auth::user()->hasPower($section['power']))
      <details class="{{ 'sidebar-section' . (array_key_exists('meta', $section) ? ' ' . $section['meta'] : '') }}">
        <summary class="sidebar-section-header">{{ str_replace(' ', '', $key) }} </summary>
        <ul>
          {{-- order by name --}}
          @php
            usort($section['links'], function ($a, $b) {
                return strcmp($a['name'], $b['name']);
            });
          @endphp
          @foreach ($section['links'] as $item)
            @if ($section['power'] !== 'mixed' || ($section['power'] === 'mixed' && array_key_exists('power', $item) && Auth::user()->hasPower($item['power'])))
              <li class="sidebar-item">
                <a href="{{ url($item['url']) }}" class="collapse-link {{ set_active($item['url'] . '*') }}">{{ $item['name'] }}
                </a>
              </li>
            @endif
          @endforeach
        </ul>
      </details>
    @endif
  @endforeach

</div>

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
