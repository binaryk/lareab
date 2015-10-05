jQuery(document).ready(function ($) {

    $('.action-buttons .fa-trash-o').on('submit', function () {
        $.ajax({
            type: "POST",
            url : "organization/delete",
            data : {
                "_token": $(this).find('input[name=_token]').val(),
                "id": $(this).closest('tr').data('id')
            },
            success : function(data){
                alert(data);
            }
        });
        return false;
    });

});