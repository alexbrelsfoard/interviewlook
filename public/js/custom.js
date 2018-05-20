/**
 * Created by  Code and Silver on 4/22/2018.
 */
jQuery(document).ready(function($) {
    $( "#nav-toggle" ).click(function() {
        $( "#nav-right" ).toggle( "slow", function() {
            // Animation complete.
        });
    });

    $( "#nav-close" ).click(function() {
        $( "#nav-right" ).toggle( "slow", function() {
            // Animation complete.
        });
    });

    $( "#looks_tab_title" ).click(function() {
        $( "#video_recorder" ).hide();
        $( "#compile" ).show();
        $( "#list_of_videos" ).show();
        $(this).addClass( "active" );
        $("#questions_tab_title").removeClass( "active" );
        $("#intros_tab_title").removeClass( "active" );
        $( "#list_of_intros" ).addClass( "hidden" );
        $("#intro_input").hide();
        $("#question_input").show();
    });

    $( "#questions_tab_title" ).click(function() {
        $( "#video_recorder" ).show();
        $( "#list_of_videos" ).show();
        $( "#compile" ).hide();
        $(this).addClass( "active" );
        $("#looks_tab_title").removeClass( "active" );
        $("#intros_tab_title").removeClass( "active" );
        $( "#list_of_intros" ).addClass( "hidden" );
        $("#intro_input").hide();
        $("#question_input").show();
    });

    $( "#intros_tab_title" ).click(function() {
        $( "#video_recorder").show();
        $( "#compile" ).hide();
        $( "#list_of_videos" ).hide();
        $( "#list_of_intros" ).show().removeClass( "hidden" );
        $(this).addClass( "active" );
        $("#questions_tab_title").removeClass( "active" );
        $("#looks_tab_title").removeClass( "active" );
        $("#intro_input").show();
        $("#question_input").hide();
    });

    $( "#start_button" ).click(function() {

        if( !$("#question").val() ) {

            $( "#no-question" ).show( "slow", function() { });

        } else {

            $( "#no-question" ).hide( "slow", function() { });


                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                        $.ajax({
                            /* the route pointing to the post function */
                            url: '/start-video',
                            type: 'POST',
                            /* send the csrf-token and the input to the controller */
                            data: {_token: CSRF_TOKEN, video_id: $("#video_id").val(), question: $("#question").val()},
                            dataType: 'JSON',
                            /* remind that 'data' is the response of the AjaxController */
                            success: function (data) {

                                //$(".writeinfo").append(data.msg);
                                $( ".pipeRecordRTC" ).show( "slow", function() { });
                            }
                        });


                }


    });

});

