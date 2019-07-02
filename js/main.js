/**
 * Hide slider on mobile
 */

if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
    $('.header-menu').css('display', 'none');
    $('.slider').css('display', 'none');
    $('.footer-top-container').css('display', 'none');

    $('.mobile-bar').css('display', 'block');
}

/**
 * Dynamic login screen.
 *
 * @type {jQuery|HTMLElement}
 */

var loginBtn    = $('a#login-toggle');
var loginForm   = $('.login-form');
var registrForm = $('.register-form');

var hasAccount = true;

loginBtn.click(() => {

    if (!hasAccount) {
        loginForm.css('display', 'none');
        registrForm.css('display', 'block');
        hasAccount = !hasAccount;
    } else {
        loginForm.css('display', 'block');
        registrForm.css('display', 'none');
        hasAccount = !hasAccount;
    }

});

// $('.form-message').css('display', 'none');

/**
 * Logout confirm
 */
$('.logout-btn').click(function () {
    var logout = confirm("Are you sure to logout?");

    if (logout) {
        location.href = "../event_planner/includes/logout.php";
    }
});

/**
 * Activity dynamic selection
 */

var url        = new URL(location.href);
var activityId = url.searchParams.get("activityId");

var activitySelect   = $('div.activity-select');
var activitySelected = activityId;
var initialActivity  = $('div.activity-select[data-activity-id=' + activityId + ']');

initialActivity.addClass('selected');

activitySelect.click(function () {
    activitySelect.each(function () {
        $(this).removeClass('selected');
    });

    activitySelected = $(this).attr('data-activity-id');

    $(this).addClass('selected');
});


/**
 * To do selections
 */

var todoId     = url.searchParams.get("todo_id");
var todoSelect = $('div.todo-select');

var initialTodo = $('div.todo-select[data-todo-id=' + todoId + ']');
initialTodo.addClass('selected');

todoSelect.click(function () {
    todoSelect.each(function () {
        $(this).removeClass('selected');
    });

    $(this).addClass('selected');
});

/**
 * to do status colors
 */

todoSelect.each(function() {

    var status = $(this).attr('data-status-id');

    switch(status) {
        case 'In wacht':
            $(this).css('background-color', '#f0f1f6');
            break;
        case 'Bezig':
            $(this).css('background-color', '#e6b300');
            break;
        case 'Klaar':
            $(this).css('background-color', '#a7dcb2');
            break;
        default:
        // code block
    }
});

/**
 * Activity actions
 */

function viewTodos() {
    window.location.href = "todos.php?activity_id=" + activitySelected;
}

function viewSingle() {
    window.location.href = "single_activity.php?activity_id=" + activitySelected;
}

/**
 * Mobile toggle
 */

$openBtn = $('.open-toggle');
$closeBtn = $('button.close-toggle');

$openBtn.click(function () {
    $('div.popup-menu').removeClass('close-menu');
});

$closeBtn.click(function () {
    $(this).parent().addClass('close-menu');
});

/**
 * Admin add product form
 */

var visible       = true;
var addPanel      = $('.admin-add');
var tablePanel    = $('.admin-table');
var addBtn        = $('.add-product');
var tableControls = $('.table-controls');

addBtn.click(function () {
    if (visible) {
        addPanel.css('display', 'block');
        tablePanel.css('display', 'none');
        addBtn.html('<i class="fas fa-times-circle" style="padding-right: 10px;"></i>Cancel').addClass('btn-danger');
        tableControls.css('display', 'none');
        visible = !visible;
    } else {
        addPanel.css('display', 'none');
        tablePanel.css('display', 'block');
        addBtn.html('<i class="fas fa-plus" style="padding-right: 10px;"></i>Add product').removeClass('btn-danger');
        tableControls.css('display', 'block');
        visible = !visible;
    }

});

/**
 * Displays err messages
 */

var url_string   = window.location.href; //window.location.href
var url          = new URL(url_string);
var errorMessage = url.searchParams.get("err");

if (errorMessage) {
    alert(errorMessage);
    console.log(errorMessage);
}

/**
 * Admin page description toggle
 */

$('.open-description').click(function () {
    $(this).next().css('display', 'block');
});

$('.close-description').click(function () {
    $(this).parent().parent().parent().css('display', 'none');
});

