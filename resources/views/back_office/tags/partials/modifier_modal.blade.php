<div class="modal-header">
    <h5 class="modal-title align-self-center" id="edit-cat-modal-title">تعديل الوسم</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
</div>
<form method="post" action="{{route('tags.mettre_a_jour',$o_tag->id)}}" class="needs-validation" novalidate>
    @csrf
    @method('PUT')
    <div class="modal-body">
        <div class="row">
            <div class="col-12 mb-3">
                <label class="form-label required" for="name-input">الاسم</label>
                <input type="text" value="{{$o_tag->name}}" required class="form-control" id="name" name="name">
                <div class="invalid-feedback">يرجى إدخال الاسم أولاً</div>
            </div>
            <div class="col-12 mb-3">
                <label class="form-label required" for="name-input">النوع</label>
                <input type="text" value="{{$o_tag->type}}" required class="form-control" id="type" name="type">
                <div class="invalid-feedback">يرجى إدخال النوع أولاً</div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">إغلاق</button>
        <button class="btn btn-primary">حفظ</button>
    </div>
</form>
