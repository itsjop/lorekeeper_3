@extends('professions.layout')

@section('title')
  Professions
@endsection

@section('content')
  {!! breadcrumbs(['Professions' => 'professions', 'Category' => 'category']) !!}

  <div class="row">
    <div class="col-lg-7 col-12 text-lg-left text-center">
      <h1>{{ $category->name }}</h1>
    </div>
    <div class="col-lg-5 col-12 text-lg-right text-center">
      <a href="/professions/characters/{{ $category->id }}">
        <div class="btn btn-primary">
          <i class="fas fa-search"></i> View characters
        </div>
      </a>
    </div>
  </div>

  @if ($category->parsed_description)
    <div class="card text-justify w-75 p-3 ml-auto mr-auto site-page-content parsed-text">
      <div class="site-page-content parsed-text">
        {!! $category->parsed_description !!}
      </div>
    </div>
  @endif

  <!---- SUBCATEGORY NAV -->
  @if ($category->subcategories()->get()->count() > 0)
    <ul
      class="nav nav-tabs flex gap-_5 mt-3"
      id="professionTabs"
      role="tablist"
    >
      @foreach ($category->professionsBySubcategory as $subcategoryId => $professions)
        @php $subcategory = \App\Models\Profession\ProfessionSubcategory::where('id', $subcategoryId)->first(); @endphp
        @if ($professions->count() > 0)
          <li class="nav-item h4">
            <a
              class="nav-link h-100 {{ $loop->index == 0 ? 'active' : '' }}"
              id="tab-{{ $subcategory->id ?? 'general' }}"
              data-bs-toggle="tab"
              href="#subcat-{{ $subcategory->id ?? 'general' }}"
              role="tab"
              aria-controls="subcat-{{ $subcategory->id ?? 'general' }}"
              aria-selected="{{ $category->professions->where('subcategory_id', null)->count() <= 0 && $loop->index == 0 ? 'true' : 'false' }}"
            >{{ $subcategory->name ?? 'General' }}</a>
          </li>
        @endif
      @endforeach
    </ul>
  @endif

  <!---- TAB CONTENT / PROFESSIONS WITH SUBCATEGORY -->
  <div class="tab-content" id="professionContent">
    @foreach ($category->professionsBySubcategory as $subcategoryId => $professions)
      @php $subcategory = \App\Models\Profession\ProfessionSubcategory::where('id', $subcategoryId)->first(); @endphp
      <div
        class="tab-pane fade show {{ $loop->index == 0 ? ' active' : '' }}"
        id="subcat-{{ $subcategory->id ?? 'general' }}"
        role="tabpanel"
        aria-labelledby="tab-{{ $subcategory->id ?? 'general' }}"
      >
        @if (isset($subcategory->parsed_description))
          <div class="site-page-content parsed-text">
            <div class="text-justify mt-2 mr-auto ml-auto w-75 site-page-content parsed-text">
              <div class="site-page-content parsed-text">
                {!! $subcategory->parsed_description !!}
              </div>
            </div>
          </div>
        @endif

        <!---- PROFESSION NAVs -->
        <ul
          class="nav nav-tabs flex gap-_5 mt-3"
          id="professionTabs"
          role="tablist"
        >
          @foreach ($professions as $profession)
            <li class="nav-item h5">
              <a
                class="nav-link h-100 {{ $loop->index == 0 ? 'active' : '' }}"
                id="id-{{ $profession->id }}"
                data-bs-toggle="tab"
                href="#prof-{{ $profession->id }}"
                role="tab"
                aria-controls="prof-{{ $profession->id }}"
                aria-selected="{{ $loop->index == 0 ? 'true' : 'false' }}"
              >
                <img
                  class="fr-fic fr-dii"
                  style="max-width:40px;"
                  src="{{ $profession->iconUrl }}"
                >
                {{ $profession->name }}
              </a>
            </li>
          @endforeach
        </ul>

        <!---- Content -->

        <div class="tab-content" id="professionContent">
          @foreach ($professions as $profession)
            <!---- PROFESSION -->
            <div
              class="tab-pane fade show {{ $loop->index == 0 ? 'active' : '' }}"
              id="prof-{{ $profession->id }}"
              role="tabpanel"
              aria-labelledby="prof-{{ $profession->id }}"
            >
              <div class="row justify-content-center border"
                style="background-image:url('{{ $profession->subcategory->imageUrl ?? $profession->category->imageUrl }}')"
              >
                @if ($profession->imageUrl)
                  <div class="col-lg-7 text-center">
                    <img
                      src="{{ $profession->imageUrl }}"
                      class="fr-fic fr-dii"
                      style="max-height:800px;width:auto;max-width:100%;"
                    >
                  </div>
                @endif
                <div class="card col-lg m-5">
                  <h1 class="mt-3">
                    <img
                      class="fr-fic fr-dii"
                      src="{{ $profession->iconUrl }}"
                      style="max-width:50px;"
                    >{{ $profession->name }}
                  </h1>
                  <div class="row text-justify p-4 mt-2 site-page-content parsed-text">
                    <div class="site-page-content parsed-text">
                      {!! $profession->parsed_description !!}
                    </div>
                  </div>

                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endforeach
  </div>

@endsection
