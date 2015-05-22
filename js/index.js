$(document).ready(function () {
    //Set the carousel options
    $('#quote-carousel').carousel({
    pause: false,
    interval: false,
    });
    // Species list
    var species = [
        'Dogs',
        'Cats',
        'Birds',
        'Reptiles',
        'Fishes',
        'Other'
    ];

    $('.img-circle').on('click', function(e) {
        var spec = $(this).attr('value');
        window.location = 'search.php?sp=' + spec + '&br=none';
        e.preventDefault();
    });

    // Clicking events for each button
    for (var i in species) {
        $('#' + species[i] + '-search').on('click', function (e) {
            alert('asdf');
            var name = e.target.id.substr(0, e.target.id.indexOf("-"));
            window.location = 'search.php?sp=' + name + '&br=none';
            e.preventDefault();
        });
    }
});