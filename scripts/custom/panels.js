$(document).ready(function() {

    /* on load */
    $(".navLinkRecords").css({
        "border-bottom": "3px solid green",
    });
    /* on load */

    $("#navLinkRecords, .navLinkRecords").click(function() {
        $("#recordsPanel").prop("hidden", false);
        $("#accountPanel, #settingsPanel").prop("hidden", true);

        $(".navLinkRecords").css({
            "border-bottom": "3px solid green",
        });
        $(".navLinkAccount, .navLinkSettings").css({
            "border-bottom": "3px none green",
        });
    });

    $("#navLinkAccount, .navLinkAccount").click(function() {
        $("#accountPanel").prop("hidden", false);
        $("#recordsPanel, #settingsPanel").prop("hidden", true);

        $(".navLinkAccount").css({
            "border-bottom": "3px solid green",
        });
        $(".navLinkRecords, .navLinkSettings").css({
            "border-bottom": "3px none green",
        });
    });

    $("#navLinkSettings, .navLinkSettings").click(function() {
        $("#settingsPanel").prop("hidden", false);
        $("#accountPanel, #recordsPanel").prop("hidden", true);

        $(".navLinkSettings").css({
            "border-bottom": "3px solid green",
        });
        $(".navLinkRecords, .navLinkAccount").css({
            "border-bottom": "3px none green",
        });
    });

    $("#buttonClearEntries").click(function() {
        $("#textFieldTitle, #textFieldAccountOwner, #textFieldUsername, #textFieldEmailRecords, #textFieldPasswordRecords, #textFieldDescription").val("");
    });

});