@extends('admin_layouts.main')

@section('css')
    input[type="number"]::placeholder {
    text-align: right;
    }

    input[type="number"] {
    text-align: right;
    }

    .additional-charges {
    display: none;
    }
    .labels{
    display: none;

    }

    .mb-3 {
    margin-bottom: 15px; /* Espacement entre les éléments */
    }.close-icon {
    color: blue; /* couleur rouge pour la croix */
    transition: color 0.3s ease; /* transition de couleur douce */
    }

    .close-icon:hover {
    color: #c82333; /* couleur rouge plus foncée au survol */
    }

@endsection

@section('section')

    <h2>{{ __("lang.create_purchase.title") }}</h2>
    <form action="{{ route('categories.sauvegarder') }}" method="POST">
        @csrf

        <div class="mb-3 form-group row">
            <div class="col-md-3">
                <label for="name" class="form-label pt-0">Nom</label>
                <input required class="form-control" type="text" id="name" name="name">
            </div>
            <div class="col-md-3">
                <label for="slug" class="form-label">Slug</label>
                <input required class="form-control" type="text" id="slug" name="slug">
            </div>


        </div>


        <button type="submit" class="btn btn-success w-100">{{ __("lang.create_purchase.submit_button") }}</button>
    </form>

@endsection

@push('scripts')

@endpush
