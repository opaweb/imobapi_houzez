jQuery(document).ready(function( $ ) {
    $(".property-form form").submit(function(e){
        e.preventDefault();
        var full_name = $('input[name="name"]').val();
        var email = $('input[name="email"]').val();
        var phone = $('input[name="mobile"]').val();
        var message = $('textarea[name="message"]').val();
        //var tags = $('input[name="tags"]').val();
        var tags = $('select[name="user_type"]').val();
        //var source = $('input[name="source"]').val();
        var source = 'site';
        //var subject = $('input[name="subject"]').val();        
        var property_code = $('.detail-wrap ul li:first-child span').text();
        var property_contract = $('.detail-wrap ul strong:contains("Status")').next().text();
        var subject = 'Interesse em Imóvel';

        var url = 'https://' + document.location.hostname + '/wp-content/plugins/imobapi_houzez/leads.php';

        $.ajax({
            type: "POST",
            url: url,
            data: {'full_name': full_name, 'email': email, 'phone': phone, 'message': message, 'tags': tags, 'source': source, 'subject': subject, 'property_code': property_code, 'property_contract': property_contract},
            success: function(ret){
                console.log('Enviado com sucesso');
                console.log(ret);
            },
        });
    });
});