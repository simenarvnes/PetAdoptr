var main = function() {
    if (g_signed) {
            $('#signup-modal').modal('show');
    } else{
            $('#login-modal').modal('show');
    }

    init_buttons();
    $('div.btn-group ul.dropdown-menu li a').click(on_click_dropdown);

    $('#target').submit(function (event) {
        if (g_signed) {
            if (check_validation() === true) {
                if (file_validation() === false) {
                    event.preventDefault();
                } else {
                    if ($("#agree").get(0).checked === false) {
                        alert("Please agree to the terms and conditions");
                        event.preventDefault();
                    } else {
                    $("#species").val($("#species_menu").text().trim());
                    $("#breeds").val($("#breeds_menu").text().trim());
                    $("#size").val($("#size_menu").text().trim());
                    $("#state").val($("#state_menu").text().trim());
                    }
                }
            }
            else {
                alert('Please fill in the required fields');
                event.preventDefault();
            }
        } else {
            $('#login-modal').modal('show');
            event.preventDefault();
        }
    });
};

var on_click_dropdown = function(event) {
    var menu_host = $(event.target).parent().parent().parent();
    var button = menu_host.find("button");
    var value = $(event.target).text();

    if (button.attr("id") === "species_menu") {
        $("#species_menu").text(value + " ");
        $("#species_menu").append('<span class=\"caret\"></span>');

        $("#breeds_menu_ul").empty();
        $("#breeds_menu").text("Select Breeds ");
        $("#breeds_menu").append('<span class=\"caret\"></span>');

        for (var i in pet_types[value]) {
            $("#breeds_menu_ul").append(
                '<li role="presentation"><a role="menuitem" tabindex="1">'
                + pet_types[value][i] + '</a></li>');
        }
        $('div.btn-group ul.dropdown-menu').click(on_click_dropdown);

    } else if (button.attr("id") === "breeds_menu") {
        $("#breeds_menu").text(value + " ");
        $("#breeds_menu").append('<span class=\"caret\"></span>');
    } else if (button.attr("id") === "size_menu") {
        $("#size_menu").text(value + " ");
        $("#size_menu").append('<span class=\"caret\"></span>');
    } else if (button.attr("id") === "state_menu") {

         $("#state_menu").text(value + " ");
        $("#state_menu").append('<span class=\"caret\"></span>');
    }

    return true;
};

var init_buttons = function() {
    for (var types in pet_types) {
        $('#species_menu_ul').append(
            '<li role="presentation"><a role="menuitem" tabindex="1">'
            + types + '</a></li>');
    }

    var states = ['AL', 'AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'FL', 'GA', 'HI',
        'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI',
        'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC',
        'ND', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT',
        'VT', 'VA', 'WA', 'WV', 'WI', 'WY'];

    for (var i in states) {
        $("#state_menu_ul").append(
            '<li role="presentation"><a role="menuitem" tabindex="1">'
            + states[i] + '</a></li>');
    }
    $('div.btn-group ul.dropdown-menu li a').click(on_click_dropdown);
};

var check_validation = function() {
    if ($("#name").val().length === 0
        || $("#species_menu").text().trim() === "Select Species"
        || $("#breeds_menu").text().trim() === "Select Breeds"
        || $("#age").val().length === 0
        || $("#city").val().length === 0
        || $("#zipCode").val().length === 0
        || $("#state_menu").text().trim() === "State") return false;
    else
        return true;
};

var file_validation = function() {
    var file = $("#image").get(0).files;

    if (window.File && window.FileReader && window.FileList && window.Blob)
    {
        if (file.length >= 0 && file.length <= 3) {
            for (var i = 0; i < file.length; i++) {
                var fsize = file[i].size;
                var ftype = file[i].type;
                var fname = file[i].name;

                switch(ftype) {
                    case 'image/png':
                    case 'image/gif':
                    case 'image/jpeg':
                    case 'image/pjpeg':
                        break;
                    default:
                        alert("Unsupported File!");
                        return false;
                }
        
                if(fsize>3145728) //do something if file size more than 1 mb (1048576)
                {
                    alert(fsize +" bytes\nToo big!");
                    return false;
                }
            }
            return true;
        }
        else {
            alert("You can upload file up to 3!");
        }

    } else{
        alert("Please upgrade your browser, because your current browser lacks some new features we need!");
    }
};

$(document).ready(main);