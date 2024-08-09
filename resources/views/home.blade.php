@extends('layouts.main')
@section('page')
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{asset('images/Carousel-1.jpg')}}" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="{{asset('images/Carousel-2.jpg')}}" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <section class="pt-4" >
        <div class="section-divider">
            <span class="text-primary fw-bold" >اختر الكتب حسب العمر</span>
        </div>
        <div class="row py-4">
           @for($i=0;$i<4;$i++)
                <div class="col-xl-3 col-lg-4 col-sm-6 py-2">
                    <div class="card border-0 shadow-sm overflow-hidden product-card" data-price="80">
                        <div class="card-img w-100 position-relative">
                            <div class="add-to-cart-card">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </div>
                            <img src="https://picsum.photos/id/{{$i+100}}/300/300" class="img-fluid w-100" alt="">
                        </div>
                        <div class="card-body text-center">
                            <a href="" class="d-block fs-6 text-decoration-none text-muted">12-15 سنوات</a>
                            <a href="" class="fw-medium text-decoration-none text-muted">يوميات دلتا: كيف</a>
                            <p class="fs-5 fw-bold text-primary" ><span class="mx-2 text-decoration-line-through text-orange-400 fw-normal" > د.م 120,00 </span> د.م 80,00</p>
                        </div>
                    </div>
                </div>
           @endfor
        </div>
    </section>
@endsection
