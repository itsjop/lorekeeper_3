<div id="sidebar-ul">
  <div class="sidebar-header">
    <a class="card-link">
      <a href="{{ url('prompts') }}">Prompts</a>
    </a>
  </div>
  <details class="sidebar-section" open>
    <summary class="sidebar-section-header">Prompts</summary>
    <ul>
      <li class="sidebar-item">
        <a href="{{ url('prompts/prompt-categories') }}" class="{{ set_active('prompts/prompt-categories*') }}">Prompt
          Categories</a>
      </li>
      <li class="sidebar-item">
        <a href="{{ url('prompts/prompts') }}" class="{{ set_active('prompts/prompts*') }}">All Prompts</a>
      </li>
    </ul>
  </details>
</div>
