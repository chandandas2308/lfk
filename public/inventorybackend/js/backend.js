jQuery(document).ready(function () {
    jQuery("#addProductForm").click(function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="_token"]').attr("content"),
            },
        });
        jQuery.ajax({
            url: "{{ route('SA-AddProduct') }}",
            data: jQuery("#addProductForm").serialize(),
            type: "post",
            success: function (result) {
                jQuery.each(result.error, function (key, value) {
                    jQuery(".alert-danger").show();
                    jQuery(".alert-danger>ul").append(
                        "<li>" + key + " : " + value + "</li>"
                    );
                });
                jQuery.each(result.success, function (key, value) {
                    jQuery("#addUserAlert").html(result.success);
                    jQuery("#addUserAlert").show();
                    jQuery("#addUserForm")["0"].reset();
                });
            },
        });
    });
});
