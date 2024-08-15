<td class="action-column">
    <div class="btn-container d-flex align-items-center">
        <button data-url="{{ route('tags' . '.' . 'supprimer', $o_tag->id) }}"
                class="btn btn-sm btn-soft-danger sa-warning me-1" data-bs-custom-class="danger-tooltip"
                data-bs-template='<div class="tooltip mb-1 rounded " role="tooltip"><div class="tooltip-inner bg-danger font-size-10"></div></div>'
                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Supprimer">
            <i class="fa fa-trash-alt"></i>
        </button>
        @if (isset($edit_modal))
            <a data-url="{{ $edit_modal['url'] }}" data-target="{{ $edit_modal['modal_id'] }} "
               class="btn btn-sm btn-soft-warning __datatable-edit-modal">
                <i class="fa fa-edit"></i>
            </a>
        @endif
    </div>
</td>

