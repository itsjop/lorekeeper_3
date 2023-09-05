@extends('professions.layout')

@section('title') Professions @endsection

@section('content')
{!! breadcrumbs(['Professions' => 'professions', 'Category' => 'category']) !!}

<h1>{{ $category->name }}</h1>

@if($category->parsed_description)
<div class="card text-justify w-75 p-3 ml-auto mr-auto site-page-content parsed-text">
    <div class="site-page-content parsed-text">
        {!! $category->parsed_description !!}
    </div>
</div>
@endif

<!---- SUBCATEGORY NAV -->
@if($category->subcategoriesWithProfessions->count() > 0)
<ul class="nav nav-tabs mt-3" id="professionTabs" role="tablist">
    @foreach($category->subcategoriesWithProfessions as $subcategory)
    @if($subcategory->professions->count() > 0)
    <li class="nav-item h4">
        <a class="nav-link {{ ($loop->index == 0) ? 'active' : '' }}" id="tab-{{$subcategory->id}}" data-toggle="tab"
            href="#subcat-{{$subcategory->id}}" role="tab" aria-controls="subcat-{{$subcategory->id}}" aria-selected="{{($category->professions->where('subcategory_id', null)->count() <= 0 && $loop->index == 0) ? 'true' : 'false'}}">{{$subcategory->name}}</a>
    </li>
    @endif
    @endforeach
</ul>
@else

        <!---- PROFESSION NAVs -->
        <ul class="nav nav-tabs" id="professionTabs" role="tablist">
            @foreach($category->professions as $profession)
            <li class="nav-item h5">
                <a class="nav-link {{($loop->index == 0) ? 'active' : ''}}" id="id-{{$profession->id}}" data-toggle="tab" href="#prof-{{$profession->id}}" role="tab"
                    aria-controls="prof-{{$profession->id}}" aria-selected="{{($loop->index == 0) ? 'true' : 'false'}}">
                    <img class="fr-fic fr-dii" style="max-width:50px;"
                        src="{{$profession->iconUrl}}">
                        {{$profession->name}}
                </a>
            </li>
            @endforeach

        </ul>

        <!---- Content -->

        <div class="tab-content" id="professionContent">
            @foreach($category->professions as $profession)

            <!---- PROFESSION -->
            <div class="tab-pane fade show {{($loop->index == 0) ? 'active' : ''}}" id="prof-{{$profession->id}}" role="tabpanel" aria-labelledby="prof-{{$profession->id}}">
                <div class="row justify-content-center border" style="background-image:url('{{ $profession->subcategory->imageUrl ?? $profession->category->imageUrl}}')">
                    <div class="col-lg-7 text-center"><img
                            src="{{$profession->imageUrl}}"
                            class="fr-fic fr-dii" style="max-height:1000px;max-width:100%;"></div>
                    <div class="col-lg-4 bg-white mt-5">
                        <h1 class="mt-3"><img class="fr-fic fr-dii"
                                src="{{$profession->iconUrl}}"
                                style="max-width:50px;">{{$profession->name}}</h1>
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
@endif

<!---- TAB CONTENT / PROFESSIONS WITH SUBCATEGORY -->
<div class="tab-content" id="professionContent">
    @foreach($category->subcategoriesWithProfessions as $subcategory)

    <div class="tab-pane fade show {{($loop->index == 0) ? ' active' : ''}}" id="subcat-{{$subcategory->id ?? 'general' }}" role="tabpanel" aria-labelledby="tab-{{$subcategory->id ?? 'general' }}">
        @if(isset($subcategory->parsed_description))
        <div class="site-page-content parsed-text">
            <div class="text-justify mt-2 mr-auto ml-auto w-75 site-page-content parsed-text">
                <div class="site-page-content parsed-text">
                    {!! $subcategory->parsed_description !!}
                </div>
            </div>
        </div>
        @endif

        <!---- PROFESSION NAVs -->
        <ul class="nav nav-tabs" id="professionTabs" role="tablist">
        @foreach($subcategory->professions as $profession)
            <li class="nav-item h5">
                <a class="nav-link {{($loop->index == 0) ? 'active' : ''}}" id="id-{{$profession->id}}" data-toggle="tab" href="#prof-{{$profession->id}}" role="tab"
                    aria-controls="prof-{{$profession->id}}" aria-selected="{{($loop->index == 0) ? 'true' : 'false'}}">
                    <img class="fr-fic fr-dii" style="max-width:50px;"
                        src="{{$profession->iconUrl}}">
                        {{$profession->name}}
                </a>
            </li>
        @endforeach
        </ul>


        <!---- Content -->

        <div class="tab-content" id="professionContent">
        @foreach($subcategory->professions as $profession)
            <!---- PROFESSION -->
            <div class="tab-pane fade show {{($loop->index == 0) ? 'active' : ''}}" id="prof-{{$profession->id}}" role="tabpanel" aria-labelledby="prof-{{$profession->id}}">
                <div class="row justify-content-center border" style="background-image:url('{{ $profession->subcategory->imageUrl ?? $profession->category->imageUrl}}')">
                    <div class="col-lg-7"><img
                            src="{{$profession->imageUrl}}"
                            class="fr-fic fr-dii w-100 h-auto" style="max-width:1000px;"></div>
                    <div class="col-lg-4 bg-white mt-5">
                        <h1 class="mt-3"><img class="fr-fic fr-dii"
                                src="{{$profession->iconUrl}}"
                                style="max-width:50px;">{{$profession->name}}</h1>
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