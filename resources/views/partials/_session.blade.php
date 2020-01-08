@if( session()->has('success') )

<script>
    new Noty({
        type: "success",
        text: "{{ session('success') }}",
        layout: "topRight",
        timeout: 2000,
        killer: true
    }).show();
</script>

@endif
