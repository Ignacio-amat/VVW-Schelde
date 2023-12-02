@extends('./layouts/layouts')

@section('pageCSS')
    <link rel="stylesheet" href="{{ asset('./css/createCategory.css') }}">
    <link rel="stylesheet" href="{{ asset('./css/layout.css') }}">
@endsection
@section('content')
    <section class="formSection">
        <h1 style="margin-top: 0; color: white">Edit Category</h1>

        <form method="POST" action="{{route('categories.edit-two', $category)}}" class="formScroll" style="border-radius: 0">
            @csrf
            @method('PUT')
            <div>
                <label for="name"><strong>Name</strong></label>

                <div>
                    <input type="text"
                           name="name"
                           id="name"
                           value="{{ $category->name }}" placeholder="Name of Category...">
                    @error('name')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div>
                <label for="description"><strong>Description</strong></label>

                <div>
                    <input class = "inputField" type = "text" name="description"
                           id="description" value="{{ $category->description }}"
                           placeholder="Description of Category">

                    @error('description')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div>
                <label for="icon"><strong>Icon</strong></label>

                <div class="icon-grid" >
                    <div class="icon-item @if($category->image == "/assets/icons/categories/restaurant.png") selected @endif"><img src="{{asset('assets/icons/categories/restaurant.png')}}" alt="Restaurant image"></div>
                    <div class="icon-item @if($category->image == "/assets/icons/categories/employee.png") selected @endif"><img src="{{asset('assets/icons/categories/employee.png')}}" alt="Employee image"></div>
                    <div class="icon-item @if($category->image == "/assets/icons/categories/repair.png") selected @endif"><img src="{{asset('assets/icons/categories/repair.png')}}" alt="Repair image"></div>
                    <div class="icon-item @if($category->image == "/assets/icons/categories/family.png") selected @endif"><img src="{{asset('assets/icons/categories/family.png')}}" alt="Kid Friendliness image"></div>
                    <div class="icon-item @if($category->image == "/assets/icons/categories/marina.png") selected @endif"><img src="{{asset('assets/icons/categories/marina.png')}}" alt="Marina image"></div>
                    <div class="icon-item @if($category->image == "/assets/icons/categories/boat.png") selected @endif"><img src="{{asset('assets/icons/categories/boat.png')}}" alt="Boat image"></div>
                    <div class="icon-item @if($category->image == "/assets/icons/categories/price.png") selected @endif"><img src="{{asset('assets/icons/categories/price.png')}}" alt="Price image"></div>
                    <div class="icon-item @if($category->image == "/assets/icons/categories/food.png") selected @endif"><img src="{{asset('assets/icons/categories/food.png')}}" alt="Price image"></div>


                    @error('icon')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div>
                <input id="imageContainer" name="image" type="text" style="visibility: hidden" value="{{ $category->image }}">
            </div>
            <div style="margin-top: -10%">
                <button type="reset" class="nextButton">Reset</button>
                <button class="nextButton" type="submit">Next</button>
            </div>
            <div>
            </div>
        </form>
    </section>

    <script src="{{ asset('js/icons.js') }}"></script>
@endsection
