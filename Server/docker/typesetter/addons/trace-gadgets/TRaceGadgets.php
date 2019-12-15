<?php defined('is_running') or die('Not an entry point...');

function add_head_tags($js_files) {
    global $page;
    $page->head_js[] = "/public/lib/jquery/js/jquery.popupoverlay.min.js";
    $page->head_js[] = "/public/lib/chart/js/chart.min.js";
    $page->head_js[] = "/public/js/common/constants.js";
    $page->head_js[] = "/public/js/common/utilities.js";
    $page->head_js[] = "/public/js/common/cookies.js";
    $page->head_js[] = "/public/js/common/templates.js";
    $page->head_js[] = "/public/js/common/shared-data.js";
    $page->head_js[] = "/public/js/common/api.js";
    $page->css_admin[] = "/public/css/main.css";
}

function print_page_template($name) {
    global $page;
    echo '<link rel="stylesheet" type="text/css" href="/public/css/' . $name . '.css">' .
        '<div id="' . $name . '-container"></div>';

    // this is a rather hacky way to load JS with jQuery support from a file, but it works for now
    $page->jQueryCode .= '});</script><script type="text/javascript" src="/public/js/trace/' . $name . '.js"></script><script>({';
}

function TRaceGadget_Vouchers()           { print_page_template('vouchers'); }
function TRaceGadget_PlayerRegistration() { print_page_template('player-registration'); }
function TRaceGadget_PlayerLogin()        { print_page_template('player-login'); }
function TRaceGadget_PlayerStatus()       { print_page_template('player-status'); }
function TRaceGadget_PlayerResult()       { print_page_template('player-result'); }
function TRaceGadget_Webshop()       	  { print_page_template('webshop'); }
function TRaceGadget_Kasino()       	  { print_page_template('kasino'); }
