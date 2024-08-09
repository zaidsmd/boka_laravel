<div class="w-100 bg-orange-300 py-2 text-center text-white fw-bold">
    <i class="fa fa-solid fa-star"></i>
    أضخم متجر الكتروني لكتب الأطفال والناشئة بالمغرب
    <i class="fa fa-solid fa-star"></i>
</div>
<nav class="navbar navbar-expand-lg shadow-sm position-sticky z-3 top-0">
    <div class="container">
        <a class="navbar-brand" href="{{url('/')}}" style="max-width: 70px">
            <img src="{{asset('images/logo.png')}}" class="img-fluid" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav">
                <li class="nav-item ">
                    <a class="nav-link " aria-current="page" href="#"><span>
                            الصفحة الرئيسية</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pricing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(\Illuminate\Support\Facades\Request::segment(1) === 'my-account') active @endif" href="{{route('my-account')}}">لوحة حسابي</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                       aria-expanded="false">
                        Dropdown link
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
            </ul>

        </div>
        <div class="cart  text-primary border shadow-sm btn bg-white  p-2 rounded">
            <span class="mx-1 total" >د.م 00,00</span>
            <i class=" fa-solid fa-cart-shopping mx-1"></i>
        </div>
    </div>
</nav>
