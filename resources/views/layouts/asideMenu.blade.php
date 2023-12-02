<link rel="stylesheet" href="{{ asset('./css/layout.css') }}"/>


<section class="asideMenuSection">
    <aside class="aside">
        <div class="homeButton">
            <div class="imageAndLink">
                <img src="{{ asset('assets/icons/general/home.png') }}" alt="Home Icon"class="categoryIcon homeIcon"/>
                <a class="asideMenuLink homeText" href="{{route('index')}}">HOME</a>
            </div>
        </div>
        <ul class="asideMenuList" id="parentList">

        </ul>

        <div class="asideMenuButtons beLast">
            <a class="crudActions" href="{{route('survey.edit')}}">EDIT SURVEY</a>
            <a class="crudActions" href="{{route('questions.index')}}">QUESTIONS</a>
            <a class="crudActions" href="{{route('categories.create')}}">ADD CATEGORY</a>
            <a class="crudActions" href="{{route('categories.index')}}">SHOW CATEGORIES</a>
            <a class="crudActions" href="{{route('quick-access-selection.index')}}">EDIT QUICK ACCESS</a>
        </div>

    </aside>
</section>

<script src="{{asset('js/loadingCategories.js')}}"></script>

