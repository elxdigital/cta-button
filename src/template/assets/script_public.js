$(document).ready(function () {
    $('.open-modal-button-cta').on('click', function(e) {
        e.preventDefault();
        var modalSelector = $(this).attr('href');

        $('#modalOverlay').fadeIn(200);
        $(modalSelector).fadeIn(200);
    });

    $('.fecharModal').on('click', function() {
        $('#modalOverlay').fadeOut(200);
        $(this).closest('.modal-button-cta').fadeOut(200);
    });

    $('#modalOverlay').on('click', function() {
        $('#modalOverlay').fadeOut(200);
        $('.modal-button-cta:visible').fadeOut(200);
    });

    $('.modal-button-cta').on('click', function(e) {
        e.stopPropagation();
    });
});
