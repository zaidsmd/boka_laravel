<form id="postRedirectForm" action="https://testpayment.cmi.co.ma/fim/est3Dgate" method="POST" style="display: none;">
    @foreach($data as $key => $value)
        <input type="hidden" name="{{$key}}" value="{{ $value }}">
    @endforeach
    <input type="hidden" name="HASH" value="{{ $hash }}">
    <script>
        // Directly submit form after it's built
        document.getElementById('postRedirectForm').submit();
    </script>
</form>


