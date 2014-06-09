$(document).ready(function(){
    console.log('start here');

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

    // init listener new company
    $('#superjob-create-company').on('click', function(){

        // remove job label, select and add button
        $(this).remove();
        $('#submit-job, label[for=jobmanager_adminbundle_superjob_company], #jobmanager_adminbundle_superjob_company').remove();


        // call ajax new company form
        $.ajax({
            url: '/admin/superjob-create-new-company-form',
            method: 'post',
            success: function(data){

                // append company form
                $('#superjob-form-wrapper').append(data.form_data);

                // listener submit company
                $('#submit-company').on('click', function(){

                    // retrieve form values
                    var dataForm = $('#super-job-form').serializeObject();

                    // call ajax send form value
                    $.ajax({
                        url: '/admin/superjob-create-new-company',
                        data: {data_form: dataForm},
                        method: 'post',
                        dataType: 'json',
                        success: function(data){
                            console.log(data);
                            window.location = ('/admin/');
                            console.log('success create company');
                        },
                        complete: function(){
                            console.log('complete');
                        },
                        error: function(error){
                            console.log('error create company');
                            console.log(error);
                        }
                    });
                });

                // listener new recruiter form
                $('#superjob-create-recruiter').on('click', function(){

                    // call ajax new recruiter form
                    $.ajax({
                        url: '/admin/superjob-create-new-recruiter-form',
                        method: 'post',
                        success: function(data){

                            // append recruiter form
                            $('#superjob-form-wrapper').append(data.form_data);

                            // remove recruiter create and submit button
                            $('#superjob-create-recruiter, #submit-company').remove();

                            // listener submit recruiter
                            $('#submit-recruiter').on('click', function(){

                                // retrieve form values
                                var dataForm = $('#super-job-form').serializeObject();

                                // call ajax send form value
                                $.ajax({
                                    url: '/admin/superjob-create-new-recruiter',
                                    data: {data_form: dataForm},
                                    method: 'post',
                                    dataType: 'json',
                                    success: function(data){
                                        console.log(data);
                                        window.location = ('/admin/');
                                        console.log('success create recruiter');
                                    },
                                    complete: function(){
                                        console.log('complete');
                                    },
                                    error: function(error){
                                        console.log('error create recruiter');
                                        console.log(error);
                                    }
                                });

                            });

                        },
                        complete: function(){},
                        error: function(error){}
                    });

                });


            },
            complete: function(data){
                console.log('complete');
            },
            error: function(error){
                console.log('error create recruiter form');
                console.log(error)
            }
        });

    });

});