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
});