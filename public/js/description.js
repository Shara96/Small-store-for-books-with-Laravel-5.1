$(document).ready(function(){

    // Product page info tabs  ---------------------------------------------------------------------------------------
    $('#product-tabs a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    $("[data-toggle=tooltip]").tooltip();
}); //end doc ready



