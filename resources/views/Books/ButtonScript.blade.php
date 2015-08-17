@section('footer')
<hr>

<script>
    $('#authors_list').select2({
    placeholder:'Choose a category',
    tags:true
    });
</script>

<script>
    $('#authors_list2').select2({
    placeholder:'Choose a tag',
    tags:true
    });
</script>