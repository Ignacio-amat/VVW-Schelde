@extends('./layouts/layouts')

@section('pageCSS')
    <link rel="stylesheet" href="{{ asset('./css/createCategory.css') }} ">
    <link rel="stylesheet" href="{{ asset('./css/layout.css') }}">
@endsection

@section('title')
    <title>Create</title>
@endsection

@section('content')
    <section class="formSection">
        <h1 style="margin-top: 0; color: white">New Category</h1>

        <form method="POST" action="{{route('categories.create-two')}}" class="formScroll" style="border-radius: 0">
            @csrf
            <div>
                <label for="name"><strong>Name</strong></label>

                <div>
                    <input class="inputField" type="text" name="name" id="name" value="{{ old('name') }}">

                    @error('name')
                    <p>{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="description" ><strong>Description</strong></label>

                <div>
                    <input class="inputField" type="text" name="description" id="description" value="{{ old('description') }}"></input>

                    @error('description')
                    <p>{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="icon"><strong>Icon</strong></label>

                <div class="icon-grid" id="grid">
                    <div class="icon-item"><img src="{{ asset('/assets/icons/categories/restaurant.png') }}" alt="Restaurant image"></div>
                    <div class="icon-item"><img src="{{ asset('/assets/icons/categories/employee.png') }}" alt="Employee image"></div>
                    <div class="icon-item"><img src="{{ asset('/assets/icons/categories/repair.png') }}" alt="Repair image"></div>
                    <div class="icon-item"><img src="{{ asset('/assets/icons/categories/family.png') }}" alt="Kid Friendliness image"></div>
                    <div class="icon-item"><img src="{{ asset('/assets/icons/categories/marina.png') }}" alt="Marina image"></div>
                    <div class="icon-item"><img src="{{ asset('/assets/icons/categories/boat.png') }}" alt="Boat image"></div>
                    <div class="icon-item"><img src="{{ asset('/assets/icons/categories/price.png') }}" alt="Price image"></div>
                    <div class="icon-item"><img src="{{ asset('/assets/icons/categories/food.png') }}" alt="Food image"></div>
                </div>
            </div>
            @error('image')
            <p>{{ $message }}</p>
            @enderror

            <div>
                <input id="imageContainer" name="image" type="text" style="visibility: hidden">
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
