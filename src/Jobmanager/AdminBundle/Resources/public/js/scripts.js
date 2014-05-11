$(document).ready(function(){
    //console.log('start here');

    var data = 'toto';
    $('#create-company').on('click', function(){

        // remove company label and select
        $('label[for=jobmanager_adminbundle_job_company], #jobmanager_adminbundle_job_company').remove();

        // ajax call
        $.ajax({
            url: '/superjob-create-new-company',
            data: {data : data},
            method: 'post',
            dataType: 'json',
            cache: false,
            success: function(data){
                console.log(data);

                //$('.box-body').html(data.form_data);
                $('button[type=submit]').before(data.form_data);
            },
            complete: function(){
                console.log('complete')
            },
            error: function(error){
                console.log(error);
            }
        });
    });

});