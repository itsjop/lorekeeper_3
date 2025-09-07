<div id="sidebar-ul">
  <div class="sidebar-header">
    <a href="{{ url(__('cultivation.cultivation')) }}" class="card-link"> Request </a>
  </div>
  @if (isset($request))
    <div class="details-sb" data-open>
      <summary class="sidebar-section-header"> Current Request </summary>
      <div class="sb-item">
        <a href="{{ $request->url }}" class="{{ set_active('designs/' . $request->id) }}"> View </a>
      </div>
      <div class="sb-item">
        <a href="{{ $request->url . '/comments' }}" class="{{ set_active('designs/' . $request->id . '/comments') }}"> Comments </a>
      </div>
      <div class="sb-item">
        <a href="{{ $request->url . '/image' }}" class="{{ set_active('designs/' . $request->id . '/image') }}"> Image </a>
      </div>
      <div class="sb-item">
        <a href="{{ $request->url . '/addons' }}" class="{{ set_active('designs/' . $request->id . '/addons') }}"> Add-ons </a>
      </div>
      <div class="sb-item">
        <a href="{{ $request->url . '/traits' }}" class="{{ set_active('designs/' . $request->id . '/traits') }}"> Traits </a>
      </div>
    </div>
  @endif
  <div class="details-sb" data-open>
    <summary class="sidebar-section-header"> Design Approvals </summary>
    <div class="sb-item">
      <a href="{{ url('designs') }}" class="{{ set_active('designs') }}"> Drafts </a>
    </div>
    <div class="sb-item">
      <a href="{{ url('designs/pending') }}" class="{{ set_active('designs/*') }}"> Submissions </a>
    </div>
  </div>
</div>
