<td style="width: 20%" class="action-column">
    <div class="btn-container">
        <button onclick="window.location.href='{{ route('articles.afficher', $article->id) }}'" type="button" class="btn btn-sm btn-soft-primary" data-id-transform="{{ $article->id }}">
            <i class="fa fa-eye"></i>
        </button>


        <button type="button" class="btn btn-sm btn-soft-warning  edit-article" onclick="window.location.href='{{ route('articles.modifier', $article->id) }}';">
            <i class="fa fa-edit"></i>
        </button>



        <form class="delete-form" id="delete-form-{{$article->id}}" action="{{ route('articles.supprimer', $article->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button data-id="{{$article->id}}" type="button" class="btn btn-sm btn-soft-danger sa-warning delete-article">
                <i class="fa fa-trash-alt"></i>
            </button>
        </form>

    </div>
</td>
