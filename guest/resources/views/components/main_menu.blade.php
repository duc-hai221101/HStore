<div class="mainmenu pull-left">
    <ul class="nav navbar-nav collapse navbar-collapse">
        <li><a href="{{ route('home') }}" class="active">Home</a></li>
       @foreach($categoriesLimit as $categoryParent)
        <li class="dropdown"><a href="#">{{ $categoryParent->name }}<i class="fa fa-angle-down"></i></a>
            @if ($categoryParent->showCa->count())

            <ul role="menu" class="sub-menu">
                @foreach($categoryParent->showCa as $categoryChi)
                <li>
                    <a href="{{ route('category.product',['slug'=>$categoryChi->slug,'id'=>$categoryChi->id]) }}">{{ $categoryChi->name }}</a>
                    @if($categoryChi->showCa->count())
                        @include('components.main_menu',['categoryParent'=>$categoryChi])
                    @endif
                </li>
                @endforeach
            </ul>
            @endif
        </li> 
       @endforeach
        <li><a href="404.html">404</a></li>
        <li><a href="contact-us.html">Contact</a></li>
    </ul>
</div>