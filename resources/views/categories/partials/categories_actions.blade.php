<td style="width: 20%" class="action-column">
    <div class="btn-container">
        <form class="delete-form" id="delete-form-{{$categorie->id}}" action="{{ route('categories.supprimer', $categorie->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button data-id="{{$categorie->id}}" type="button" class="btn btn-sm btn-soft-danger sa-warning delete-categorie">
                <i class="fa fa-trash-alt"></i>
            </button>
        </form>



    </div>
    @if (isset($edit_modal))
{{--        <a id="edit-categorie-{{$categorie->id}}" data-url="{{ $edit_modal['url'] }}" data-target="{{ $edit_modal['modal_id'] }} "--}}
{{--           class="btn btn-sm btn-soft-warning __datatable-edit-modal">--}}
{{--            <i class="fa fa-edit"></i>--}}
{{--        </a>--}}
        <button type="button" class="btn btn-sm btn-soft-warning edit-charge" onclick="openEditModal({{ $categorie->id }}, '{{ $categorie->name }}')">
                        <i class="fa fa-edit"></i>
        </button>
    @endif
</td>
