$(document).ready(function() {

    /* on load */
    $(".navLinkRecords").css({
        "border-bottom": "3px solid green",
    });
    /* on load */

    $("#navLinkRecords, .navLinkRecords").click(function() {
        $("#recordsPanel").prop("hidden", false);
        $("#accountPanel").prop("hidden", true);

        $(".navLinkRecords").css({
            "border-bottom": "3px solid green",
        });
        $(".navLinkAccount").css({
            "border-bottom": "3px none green",
        });
    });

    $("#navLinkAccount, .navLinkAccount").click(function() {
        $("#accountPanel").prop("hidden", false);
        $("#recordsPanel").prop("hidden", true);

        $(".navLinkAccount").css({
            "border-bottom": "3px solid green",
        });
        $(".navLinkRecords").css({
            "border-bottom": "3px none green",
        });
    });

    $("#buttonClearEntries").click(function() {
        $("#textFieldTitle, #textFieldAccountOwner, #textFieldUsername, #textFieldEmailRecords, #textFieldPasswordRecords, #textFieldDescription").val("");
    });

});