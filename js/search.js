$(function () {
    function on_click_dropdown() {
        var menu_host = $(event.target).parent().parent().parent();
        var button = menu_host.find("button");
        var value = $(event.target).text();

        if (button.attr("id") === "species_filter") {
            $("#species_filter").text(value + " ");
            $("#species_filter").append('<span class=\"caret\"></span>');

            //reset breeds every time you select species
            $("#breeds_filter").text("Breeds ");
            $("#breeds_filter").append('<span class=\"caret\"></span>');

            $("#breeds_filter_ul").empty();
            for (var i in pet_types[value]) {
                $("#breeds_filter_ul").append(
                    '<li role="presentation"><a role="filteritem" tabindex="1">'
                    + pet_types[value][i] + '</a></li>');
            }
            $('div.btn-group ul.dropdown-menu li a').click(on_click_dropdown);

        } else if (button.attr("id") === "breeds_filter") {
            $("#breeds_filter").text(value + " ");
            $("#breeds_filter").append('<span class=\"caret\"></span>');
        } else if (button.attr("id") === "state_filter") {
            $("#state_filter").text(value + " ");
            $("#state_filter").append('<span class=\"caret\"></span>');
        } else if (button.attr("id") === "sex_filter") {
            $("#sex_filter").text(value + " ");
            $("#sex_filter").append('<span class=\"caret\"></span>');
        } else if (button.attr("id") === "age_filter") {
            $("#age_filter").text(value + " ");
            $("#age_filter").append('<span class=\"caret\"></span>');
        }
        return true;
    }

    function init_filter() {
        var value = getQueryVariable('sp');
        var state_list = ['AL', 'AK', 'AZ', 'AR', 'CA', 'CO', 'CT', 'DE', 'FL', 'GA', 'HI',
        'ID', 'IL', 'IN', 'IA', 'KS', 'KY', 'LA', 'ME', 'MD', 'MA', 'MI',
        'MN', 'MS', 'MO', 'MT', 'NE', 'NV', 'NH', 'NJ', 'NM', 'NY', 'NC',
        'ND', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX', 'UT',
        'VT', 'VA', 'WA', 'WV', 'WI', 'WY'];

        for (var types in pet_types) {
            $('#species_filter_ul').append(
                '<li role="presentation"><a role="filteritem" tabindex="1">'
                + types + '</a></li>');
        }
        for (var i in pet_types[value]) {
            $("#breeds_filter_ul").append(
                '<li role="presentation"><a role="filteritem" tabindex="1">'
                + pet_types[value][i] + '</a></li>');
        }
        for (var i = 0; i < state_list.length; i++) {
            $("#state_filter_ul").append(
                '<li role="presentation"><a role="filteritem" tabindex="1">'
                + state_list[i] + '</a></li>');
        }
        $('div.btn-group ul.dropdown-menu li a').click(on_click_dropdown);
    }

    $('#btn-search').on('click', function (e) {
        var sp = $("#species_filter").text().trim();
        var br = $("#breeds_filter").text().trim();
        var state = $("#state_filter").text().trim();
        var sex = $("#sex_filter").text().trim();
        var age = $("#age_filter").text().trim();

        if (sp === 'Species') {
            sp = 'none';
        }
        if (br === 'Breeds') {
            br = 'none';
        }
        if (state === 'States') {
            state = 'none';
        }
        if (sex === 'Sex') {
            sex = 'none';
        }
        if (age === 'Age') {
            age = 'none';
        }

        window.location = 'search.php?sp=' + sp + '&br=' + br + '&state=' + state + '&sex=' + sex + '&age=' + age;
        e.preventDefault();
    });

    $('#btn-reset').on('click', function (e){
        $("#species_filter").text("Species ");
        $("#species_filter").append('<span class=\"caret\"></span>');
        $("#breeds_filter").text("Breeds ");
        $("#breeds_filter").append('<span class=\"caret\"></span>');
        $("#breeds_filter_ul").empty();
        $("#state_filter").text("States ");
        $("#state_filter").append('<span class=\"caret\"></span>');
        $("#sex_filter").text("Sex ");
        $("#sex_filter").append('<span class=\"caret\"></span>');
        $("#age_filter").text("Age ");
        $("#age_filter").append('<span class=\"caret\"></span>');
    });

    function getQueryVariable(variable) {
        var query = window.location.search.substring(1);
        var vars = query.split("&");
        for (var i = 0; i < vars.length; i++) {
            var pair = vars[i].split("=");
            if (pair[0] == variable) {
                return pair[1];
            }
        }
        return (false);
    }

    init_filter();
});