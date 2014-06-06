$(document).ready(function(){

    /**
     * Serialize to Object
     * @returns {{}}
     */
    $.fn.serializeObject = function()
    {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function() {
            if (o[this.name]) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };

    console.log('All start here...');

    // listener new job
    $('#submit-super-job-front').on('click', function(){

        // retrieve form values
        var dataForm = $('#super-job-front-form').serializeObject();

        console.log(dataForm);

        // call ajax push form value
        $.ajax({
            url: '/submit-job-form',
            data: {data : dataForm},
            method: 'post',
            dataType: 'json',
            success: function(data){
                $('.message').remove();
                $('.title-job-contact-4').after('<p class="message" style="color: green; padding-bottom: 20px;">'+data+'</p>');
            },
            complete: function(){},
            error: function(error){}
        });

    })

});