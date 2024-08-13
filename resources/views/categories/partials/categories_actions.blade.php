<td class="action-column">
    <div class="btn-container d-flex align-items-center">
        <form class="delete-form me-1" id="delete-form-{{$categorie->id}}" action="{{ route('categories.supprimer', $categorie->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button data-id="{{$categorie->id}}" type="button" class="btn btn-sm btn-soft-danger sa-warning delete-categorie">
                <i class="fa fa-trash-alt"></i>
            </button>
        </form>

        @if (isset($edit_modal))
            <button type="button" class="btn btn-sm btn-soft-warning edit-charge" onclick="openEditModal({{ $categorie->id }}, '{{ $categorie->name }}')">
                <i class="fa fa-edit"></i>
            </button>
        @endif
    </div>
</td>

