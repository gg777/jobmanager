$(document).ready(function(){
    //console.log('start here');

    // SUPER RECALL FORM
    var data = 'toto';

    // listener new recruiter
    $('#superrecall-create-recruiter').on('click', function(){

        // remove recruiter label, select and add button
        $('label[for=jobmanager_adminbundle_recall_recruiter], #jobmanager_adminbundle_recall_recruiter, #superrecall-create-recruiter, #superrecall-create-recall').remove();

        // call ajax recruiter form
        $.ajax({
            url: '/superrecall-create-new-recruiter-form',
            data: {data : data},
            method: 'post',
            dataType: 'json',
            success: function(data){
                console.log(data);



                // append company form
                $('#recall-form-wrapper').append(data.form_data);

                $('#superrecall-create-company').on('click', function(){

                    // remove recruiter label, select and add button
                    $('label[for=jobmanager_adminbundle_recruiter_company], #jobmanager_adminbundle_recruiter_company, #superrecall-create-company, #submit-recruiter').remove();

                    // ajax call create new company
                    $.ajax({
                        url: '/superrecall-create-new-company-form',
                        data: {data : data},
                        method: 'post',
                        dataType: 'json',
                        success: function(data){
                            console.log(data);

                            // append company form
                            $('#recall-form-wrapper').append(data.form_data);

                            // listener submit company
                            $('#submit-company').on('click', function(){
                                console.log('click');

                                // create output
                                var Output = new Object();

                                // create new recruiter
                                var Recruiter = new Object();

                                // bind value recruiter
                                Recruiter.gender = $('#jobmanager_adminbundle_recruiter_gender').val();
                                Recruiter.firstName = $('#jobmanager_adminbundle_recruiter_firstName').val();
                                Recruiter.lastName = $('#jobmanager_adminbundle_recruiter_lastName').val();
                                Recruiter.tel = $('#jobmanager_adminbundle_recruiter_tel').val();
                                Recruiter.mobile = $('#jobmanager_adminbundle_recruiter_mobile').val();
                                Recruiter.email = $('#jobmanager_adminbundle_recruiter_email').val();

                                // create new recall
                                var Recall = new Object();

                                // bind value recall
                                Recall.createdDateDay = $('#jobmanager_adminbundle_recall_createdDate_date_day').val();
                                Recall.createdDateMonth = $('#jobmanager_adminbundle_recall_createdDate_date_month').val();
                                Recall.createdDateYear = $('#jobmanager_adminbundle_recall_createdDate_date_year').val();
                                Recall.createdDateTimeHour = $('#jobmanager_adminbundle_recall_createdDate_time_hour').val();
                                Recall.createdDateTimeMinute = $('#jobmanager_adminbundle_recall_createdDate_time_minute').val();
                                Recall.recallDateDay = $('#jobmanager_adminbundle_recall_recallDate_date_day').val();
                                Recall.recallDateMonth = $('#jobmanager_adminbundle_recall_recallDate_date_month').val();
                                Recall.recallDateDay = $('#jobmanager_adminbundle_recall_recallDate_date_year').val();
                                Recall.recallDateTimeHour = $('#jobmanager_adminbundle_recall_recallDate_time_hour').val();
                                Recall.recallDateTimeMinute = $('#jobmanager_adminbundle_recall_recallDate_time_minute').val();
                                Recall.isFirstContact = $('#jobmanager_adminbundle_recall_isFirstContact').val();
                                Recall.isRecalled = $('#jobmanager_adminbundle_recall_isRecalled').val();
                                Recall.isMail = $('#jobmanager_adminbundle_recall_isMail').val();
                                Recall.description = $('#jobmanager_adminbundle_recall_description').val();
                                Recall.jobSource = $('#jobmanager_adminbundle_recall_jobSource').val();

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

                                // push recall and company in output
                                Output.recall = Recall;
                                Output.company = Company;
                                Output.recruiter = Recruiter;


                                // call ajax
                                $.ajax({
                                    url: '/superrecall-create-new-company',
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

                    // create output
                    var Output = new Object();

                    // create new recall
                    var Recall = new Object();

                    // bind value recall
                    Recall.createdDateDay = $('#jobmanager_adminbundle_recall_createdDate_date_day').val();
                    Recall.createdDateMonth = $('#jobmanager_adminbundle_recall_createdDate_date_month').val();
                    Recall.createdDateYear = $('#jobmanager_adminbundle_recall_createdDate_date_year').val();
                    Recall.createdDateTimeHour = $('#jobmanager_adminbundle_recall_createdDate_time_hour').val();
                    Recall.createdDateTimeMinute = $('#jobmanager_adminbundle_recall_createdDate_time_minute').val();
                    Recall.recallDateDay = $('#jobmanager_adminbundle_recall_recallDate_date_day').val();
                    Recall.recallDateMonth = $('#jobmanager_adminbundle_recall_recallDate_date_month').val();
                    Recall.recallDateDay = $('#jobmanager_adminbundle_recall_recallDate_date_year').val();
                    Recall.recallDateTimeHour = $('#jobmanager_adminbundle_recall_recallDate_time_hour').val();
                    Recall.recallDateTimeMinute = $('#jobmanager_adminbundle_recall_recallDate_time_minute').val();
                    Recall.isFirstContact = $('#jobmanager_adminbundle_recall_isFirstContact').val();
                    Recall.isRecalled = $('#jobmanager_adminbundle_recall_isRecalled').val();
                    Recall.isMail = $('#jobmanager_adminbundle_recall_isMail').val();
                    Recall.description = $('#jobmanager_adminbundle_recall_description').val();
                    Recall.jobSource = $('#jobmanager_adminbundle_recall_jobSource').val();

                    // create new recruiter
                    var Recruiter = new Object();

                    // bind value recruiter
                    Recruiter.gender = $('#jobmanager_adminbundle_recruiter_gender').val();
                    Recruiter.firstName = $('#jobmanager_adminbundle_recruiter_firstName').val();
                    Recruiter.lastName = $('#jobmanager_adminbundle_recruiter_lastName').val();
                    Recruiter.tel = $('#jobmanager_adminbundle_recruiter_tel').val();
                    Recruiter.email = $('#jobmanager_adminbundle_recruiter_email').val();
                    Recruiter.companyId = $('#jobmanager_adminbundle_recruiter_company').val();

                    console.log(Recruiter.company);
//                    console.log($('#jobmanager_adminbundle_recruiter_company').val());
//

                    // push recall, company and recruiter in output
                    Output.recall = Recall;
//                    Output.company = Company;
                    Output.recruiter = Recruiter;


                    // call ajax
                    $.ajax({
                        url: '/superrecall-create-new-recruiter',
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