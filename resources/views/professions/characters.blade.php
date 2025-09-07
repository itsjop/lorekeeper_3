@extends('professions.layout')

@section('title')
  Professions
@endsection

@section('content')
  {!! breadcrumbs(['Professions' => 'professions', 'Category' => 'category']) !!}

  <div class="row">
    <div class="col-lg-7 col-12 text-lg-left text-center">
      <h1>{{ $category->name }} - Characters</h1>
    </div>
    <div class="col-lg-5 col-12 text-lg-right text-center">
      <a href="/professions/{{ $category->id }}">
        <div class="btn btn-primary">
          <i class="fas fa-search"></i> View professions
        </div>
      </a>
    </div>
  </div>

  @foreach ($category->professionsBySubcategory as $subcategoryId => $professions)
    @php $subcategory = \App\Models\Profession\ProfessionSubcategory::where('id', $subcategoryId)->first(); @endphp
    @isset($subcategory)
      <h3> {{ $subcategory->name }}</h3>
    @endisset
    @if ($professions->count() > 0)
      <div class="row">
        @foreach ($professions as $profession)
          <div class="col-12 w-100">
            @php $characters = isset($charactersByProfession[$profession->id]) ? $charactersByProfession[$profession->id] : collect()  @endphp
            <div class="card mb-2 w-100">
              <div class="card-header">
                <img
                  class="fr-fic fr-dii"
                  style="max-width:40px;"
                  src="{{ $profession->iconUrl }}"
                />
                {{ $profession->name }}
              </div>
              <div class="card-body p-0 w-100">
                <div class="row w-100 m-0">
                  @foreach ($characters as $character)
                    <div class="col-lg-3 col-md-4 col-12 mb-2">
                      <a href="{{ $character->url }}">
                        <img
                          src="{{ $character->image->thumbnailUrl }}"
                          class="img-thumbnail ml-thumbnail"
                          style="max-width:50px;"
                          alt="{{ $character->fullName }}"
                        />
                      </a>

                      {!! $character->displayName !!}
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  @endforeach
@endsection
