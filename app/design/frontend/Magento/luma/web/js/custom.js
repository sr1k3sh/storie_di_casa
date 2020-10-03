require([
    "jquery",
    "jquery/ui"
],
function($) {
    "use strict";
    $(document).ready(function(){

    // auto selects the first input with radio class
    $('.options-list input.radio:first').attr('checked','checked');
    });
});