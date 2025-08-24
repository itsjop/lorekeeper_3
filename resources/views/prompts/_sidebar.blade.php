<div id="sidebar-ul">
  <div class="sidebar-header">
    <a class="card-link">
      <a href="{{ url('prompts') }}">Prompts</a>
    </a>
  </div>
  <div class="details-sb" data-open>
    <summary class="sidebar-section-header">Prompts</summary>
    <div class="sb-item">
      <a href="{{ url('prompts/prompt-categories') }}" class="{{ set_active('prompts/prompt-categories*') }}">Prompt
        Categories</a>
    </div>
    <div class="sb-item">
      <a href="{{ url('prompts/prompts') }}" class="{{ set_active('prompts/prompts*') }}">All Prompts</a>
    </div>
  </div>
</div>
