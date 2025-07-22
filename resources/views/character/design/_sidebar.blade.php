<div id="sidebar-ul">
  <div class="sidebar-header">
    <a href="{{ url(__('cultivation.cultivation')) }}" class="card-link">Request</a>
  </div>
  @if (isset($request))
    <details class="sidebar-section" open>
      <summary class="sidebar-section-header">Current Request</summary>
      <ul>
        <li class="sidebar-item">
          <a href="{{ $request->url }}" class="{{ set_active('designs/' . $request->id) }}">View</a>
        </li>
        <li class="sidebar-item">
          <a href="{{ $request->url . '/comments' }}" class="{{ set_active('designs/' . $request->id . '/comments') }}">Comments</a>
        </li>
        <li class="sidebar-item">
          <a href="{{ $request->url . '/image' }}" class="{{ set_active('designs/' . $request->id . '/image') }}">Image</a>
        </li>
        <li class="sidebar-item">
          <a href="{{ $request->url . '/addons' }}" class="{{ set_active('designs/' . $request->id . '/addons') }}">Add-ons</a>
        </li>
        <li class="sidebar-item">
          <a href="{{ $request->url . '/traits' }}" class="{{ set_active('designs/' . $request->id . '/traits') }}">Traits</a>
        </li>
      </ul>
    </details>
  @endif
  <details class="sidebar-section" open>
    <summary class="sidebar-section-header">Design Approvals</summary>
    <ul>
      <li class="sidebar-item">
        <a href="{{ url('designs') }}" class="{{ set_active('designs') }}">Drafts</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('designs/pending') }}" class="{{ set_active('designs/*') }}">Submissions</a>
      </li>
    </ul>
  </details>
</div>
