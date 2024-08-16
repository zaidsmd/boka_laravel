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
        <div class="div  gap-2 d-md-none d-flex">
            <div class="cart position-relative  text-primary border shadow-sm btn bg-white  p-2 rounded"
                 data-bs-toggle="offcanvas"
                 data-bs-target="#cart-canvas" aria-controls="cart-canvas">
                <i class=" fa-solid fa-cart-shopping mx-1"></i>
                <span class="mx-1 total d-md-inline d-none"> {{number_format(cart()->total,2,',',' ') }}</span>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                {{cart()->cart_lignes()->count()}}<span class="visually-hidden">مشتريات</span>
  </span>
                <span class="d-md-inline d-none">د.م</span>
            </div>
            <button class="navbar-toggler bg-white " type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown"
                    aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item ">
                    <a class="nav-link @if(\Illuminate\Support\Facades\Request::segment(1) == '') active @endif"
                       aria-current="page" href="{{url('/')}}"><span>
                            الصفحة الرئيسية</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle @if(\Illuminate\Support\Facades\Request::url() == route('shop')) active @endif"
                       aria-current="page" href="{{route('shop')}}"><span>
                            المتجر</span></a>
                    <ul class="dropdown-menu">
                        <a class=" dropdown-item text-end @if(\Illuminate\Support\Facades\Request::url() === route('shop.categories','ألعاب-تعليمية')) active @endif"
                           aria-current="page" href="{{route('shop.categories','ألعاب-تعليمية')}}"><span>
                            ألعاب تعليمية</span></a>
                        <a class=" dropdown-item text-end @if(\Illuminate\Support\Facades\Request::url() === route('shop.categories','هدايا-بوكادوبوكس')) active @endif"
                           aria-current="page" href="{{route('shop.categories','هدايا-بوكادوبوكس')}}"><span>
                            هدايا بوكادوبوكس</span></a>
                        <a class=" dropdown-item text-end @if(\Illuminate\Support\Facades\Request::url() === route('shop.categories','قصص-و-كتب')) active @endif"
                           aria-current="page" href="{{route('shop.categories','قصص-و-كتب')}}"><span>
                            قصص و كتب</span></a>
                    </ul>
                </li>
                <li class="nav-item ">
                    <a class="nav-link @if(\Illuminate\Support\Facades\Request::url() == route('shop.sort','date-desc')) active @endif"
                       aria-current="page" href="{{route('shop.sort','date-desc')}}"><span>
                            جديدنا</span></a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link @if(\Illuminate\Support\Facades\Request::segment(1) == 'best-seller') active @endif"
                       aria-current="page" href="{{route('best-seller')}}"><span>
                            الأكثر مبيعا</span></a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link @if(\Illuminate\Support\Facades\Request::url() == route('shop.sale',1)) active @endif"
                       aria-current="page" href="{{route('shop.sale',1)}}"><span>
                            التخفيضات</span></a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link @if(\Illuminate\Support\Facades\Request::url() == route('shop.categories','كتب-رمضان-والعيد')) active @endif"
                       aria-current="page" href="{{route('shop.categories','كتب-رمضان-والعيد')}}"><span>
                           كتب رمضان والعيد</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(\Illuminate\Support\Facades\Request::segment(1) === 'my-account') active @endif"
                       href="{{route('my-account')}}">لوحة حسابي</a>
                </li>
            </ul>
        </div>
        <div class="div  gap-2 d-md-flex d-none">
            <div class="cart  text-primary border shadow-sm btn bg-white  p-2 rounded" data-bs-toggle="offcanvas"
                 data-bs-target="#cart-canvas" aria-controls="cart-canvas">
                <i class=" fa-solid fa-cart-shopping mx-1"></i>
                <span class="mx-1 total d-md-inline d-none"> {{number_format(cart()->total,2,',',' ') }}</span>
                <span class="d-md-inline d-none">د.م</span>
            </div>
            <button class="navbar-toggler bg-white " type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown"
                    aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </div>
</nav>

<div class="offcanvas offcanvas-start" tabindex="-1" id="cart-canvas" aria-labelledby="cart-canvasLabel">
    <div class="offcanvas-header d-flex justify-content-between">
        <h5 class="offcanvas-title w-100" id="cart-canvasLabel">
            عربة التسوق</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">

    </div>
</div>
