<div class="modal-header">
    <h5 class="modal-title align-self-center" id="edit-cat-modal-title">تحديث الحالة</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form method="post" class="needs-validation" enctype="multipart/form-data" action="{{ route('commandes.modifier_status',  $o_order->id) }}" novalidate>
    @csrf
    <div class="modal-body">
        <h3> {{$o_order->number}}</h3>
        <select class="form-control form-select" name="status">
            @php
                $currentStatus = $o_order->status;
            @endphp
            @foreach($statuses as $status)
                @if($status !== $currentStatus)
                    <option value="{{ $status }}">{{ $status }}</option>
                @endif
            @endforeach
        </select>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">إغلاق</button>
        <button class="btn btn-primary">تحديث</button>

    </div>
</form>
