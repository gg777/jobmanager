$(document).ready(function(){

    //console.log('start here');

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

    // listener new recruiter form
    $('#superrecall-create-recruiter').on('click', function(){

        // remove recruiter label, select and add button
        $('label[for=jobmanager_adminbundle_recall_recruiter], #jobmanager_adminbundle_recall_recruiter, #superrecall-create-recruiter, #superrecall-create-recall').remove();

        // call ajax new recruiter form
        $.ajax({
            url: '/admin/superrecall-create-new-recruiter-form',
            method: 'post',
            success: function(data){

                // append company form
                $('#recall-form-wrapper').append(data.form_data);

                // listener create new company form
                $('#superrecall-create-company').on('click', function(){

                    // remove recruiter label, select and add button
                    $('label[for=jobmanager_adminbundle_recruiter_company], #jobmanager_adminbundle_recruiter_company, #superrecall-create-company, #submit-recruiter').remove();

                    // ajax call create new company
                    $.ajax({
                        url: '/admin/superrecall-create-new-company-form',
                        method: 'post',
                        success: function(data){

                            // append company form
                            $('#recall-form-wrapper').append(data.form_data);

                            // listener submit company
                            $('#submit-company').on('click', function(){

                                // retrieve form values
                                var dataForm = $('#super-recall-form').serializeObject();

                                // call ajax
                                $.ajax({
                                    url: '/admin/superrecall-create-new-company',
                                    data: {data_form : dataForm},
                                    method: 'post',
                                    dataType: 'json',
                                    success: function(data){
                                        window.location = ('/admin');
                                    },
                                    complete: function(){
                                        console.log('complete');
                                    },
                                    error: function(error){
                                        console.log(error);
                                    }
                                });

                            });

                        },
                        complete: function(){
                            console.log('complete')
                        },
                        error: function(error){
                            console.log(error);
                        }
                    });
                });

                // listener submit recruiter
                $('#submit-recruiter').on('click', function(){

                    // retrieve form values
                    var dataForm = $('#super-recall-form').serializeObject();

                    // call ajax
                    $.ajax({
                        url: '/admin/superrecall-create-new-recruiter',
                        data: {data_form: dataForm},
                        method: 'post',
                        dataType: 'json',
                        success: function(data){
                            window.location = ('/admin/');
                        },
                        complete: function(){
                            console.log('complete');
                        },
                        error: function(error){
                            console.log(error);
                        }
                    });

                });
            },
            complete: function(data){
                console.log('complete');
            },
            error: function(error){
                console.log(error)
            }
        });
    });

});