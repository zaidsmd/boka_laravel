<div class="modal-header">
    <h5 class="modal-title align-self-center" id="edit-cat-modal-title">تعديل المدينة</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
</div>
<form method="post" action="{{route('villes.mettre_a_jour',$ville->id)}}" class="needs-validation" novalidate>
    @csrf
    @method('PUT')
    <div class="modal-body">
        <div class="row">
            <div class="col-12 mb-3">
                <label class="form-label required" for="nom">الاسم</label>
                <input type="text" value="{{$ville->nom}}" required class="form-control" id="nom" name="nom">
                <div class="invalid-feedback">يرجى إدخال الاسم أولاً</div>
            </div>
            <div class="col-12 mb-3">
                <label class="form-label required" for="price">الثمن</label>
                <input type="text" value="{{$ville->price}}" required class="form-control" id="price" name="price">
                <div class="invalid-feedback">يرجى إدخال النوع أولاً</div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">إغلاق</button>
        <button class="btn btn-primary">حفظ</button>
    </div>
</form>
