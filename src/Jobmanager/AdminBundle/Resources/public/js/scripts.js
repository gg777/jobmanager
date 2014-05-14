$(document).ready(function(){
    //console.log('start here');

    var data = 'toto';
    $('#create-company').on('click', function(){

        // remove company label, select and add button
        $('label[for=jobmanager_adminbundle_superjob_company], #jobmanager_adminbundle_superjob_company, button[type=submit], #create-company').remove();

        // ajax call create new company
        $.ajax({
            url: '/superjob-create-new-company-form',
            data: {data : data},
            method: 'post',
            dataType: 'json',
            success: function(data){
                console.log(data);

                // append company form
                $('#job-form-wrapper').append(data.form_data);

                // listener submit company
                $('#submit-company').on('click', function(){
                    console.log('click');

                    // create output
                    var Output = new Object();

                    // create new job
                    var Job = new Object();

                    // bind value job
                    Job.name = $('#jobmanager_adminbundle_superjob_name').val();
                    Job.urlJob = $('#jobmanager_adminbundle_superjob_urlJob').val();
                    Job.remixjobsId = $('#jobmanager_adminbundle_superjob_remixjobs_id').val();
                    Job.contractType = $('#jobmanager_adminbundle_superjob_contract_type').val();
                    Job.isSoldOut = $('#jobmanager_adminbundle_superjob_is_soldout').val();
                    Job.createDateDay = $('#jobmanager_adminbundle_superjob_createdDate_day').val();
                    Job.createDateMonth = $('#jobmanager_adminbundle_superjob_createdDate_month').val();
                    Job.createDateYear = $('#jobmanager_adminbundle_superjob_createdDate_year').val();

                    // create new company
                    var Company = new Object();

                    // bind valure company
                    Company.name = $('#jobmanager_adminbundle_company_name').val();
                    Company.address = $('#jobmanager_adminbundle_company_address').val();
                    Company.zip = $('#jobmanager_adminbundle_company_zip').val();
                    Company.city = $('#jobmanager_adminbundle_company_city').val();
                    Company.country = $('#jobmanager_adminbundle_company_country').val();
                    Company.lat = $('#jobmanager_adminbundle_company_lat').val();
                    Company.lng = $('#jobmanager_adminbundle_company_lng').val();
                    Company.isHeadHunter = $('#jobmanager_adminbundle_company_is_head_hunter').val();
                    Company.urlCompany = $('#jobmanager_adminbundle_company_urlCompany').val();
                    Company.recruiter = $('#jobmanager_adminbundle_company_recruiter').val();

                    // push job and company in output
                    Output.job = Job;
                    Output.company = Company;


                    // call ajax
                    $.ajax({
                        url: '/superjob-create-new-company',
                        data: { data_form: Output},
                        method: 'post',
                        dataType: 'json',
                        success: function(data){
                            console.log(data);
                        },
                        complete: function(){
                            console.log('complete');
                        },
                        error: function(error){
                            console.log(error);
                        }
                    });

                });

                // listener new recruiter
                $('#create-recruiter').on('click', function(){

                    // remove contact label, select  and add button
                    $('label[for=jobmanager_adminbundle_company_recruiter], #jobmanager_adminbundle_company_recruiter, #create-recruiter, #submit-company').remove();

                    // call ajax recruiter form
                    $.ajax({
                        url: '/superjob-create-new-recruiter-form',
                        data: {data : data},
                        method: 'post',
                        dataType: 'json',
                        success: function(data){
                            console.log(data);

                            // append company form
                            $('#job-form-wrapper').append(data.form_data);

                            // listener submit recruiter
                            $('#submit-recruiter').on('click', function(){

                                // create output
                                var Output = new Object();

                                // create new job
                                var Job = new Object();

                                // bind value job
                                Job.name = $('#jobmanager_adminbundle_superjob_name').val();
                                Job.urlJob = $('#jobmanager_adminbundle_superjob_urlJob').val();
                                Job.remixjobsId = $('#jobmanager_adminbundle_superjob_remixjobs_id').val();
                                Job.contractType = $('#jobmanager_adminbundle_superjob_contract_type').val();
                                Job.isSoldOut = $('#jobmanager_adminbundle_superjob_is_soldout').val();
                                Job.createDateDay = $('#jobmanager_adminbundle_superjob_createdDate_day').val();
                                Job.createDateMonth = $('#jobmanager_adminbundle_superjob_createdDate_month').val();
                                Job.createDateYear = $('#jobmanager_adminbundle_superjob_createdDate_year').val();

                                // create new company
                                var Company = new Object();

                                // bind value company
                                Company.name = $('#jobmanager_adminbundle_company_name').val();
                                Company.address = $('#jobmanager_adminbundle_company_address').val();
                                Company.zip = $('#jobmanager_adminbundle_company_zip').val();
                                Company.city = $('#jobmanager_adminbundle_company_city').val();
                                Company.country = $('#jobmanager_adminbundle_company_country').val();
                                Company.lat = $('#jobmanager_adminbundle_company_lat').val();
                                Company.lng = $('#jobmanager_adminbundle_company_lng').val();
                                Company.isHeadHunter = $('#jobmanager_adminbundle_company_is_head_hunter').val();
                                Company.urlCompany = $('#jobmanager_adminbundle_company_urlCompany').val();

                                // create new recruiter
                                var Recruiter = new Object();

                                // bind value recruiter
                                Recruiter.gender = $('#jobmanager_adminbundle_recruiter_gender').val();
                                Recruiter.firstName = $('#jobmanager_adminbundle_recruiter_firstName').val();
                                Recruiter.lastName = $('#jobmanager_adminbundle_recruiter_lastName').val();
                                Recruiter.tel = $('#jobmanager_adminbundle_recruiter_tel').val();
                                Recruiter.email = $('#jobmanager_adminbundle_recruiter_email').val();

                                // push job, company and recruiter in output
                                Output.job = Job;
                                Output.company = Company;
                                Output.recruiter = Recruiter;


                                // call ajax
                                $.ajax({
                                    url: '/superjob-create-new-recruiter',
                                    data: { data_form: Output},
                                    method: 'post',
                                    dataType: 'json',
                                    success: function(data){
                                        console.log(data);

                                        // todo display info message
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