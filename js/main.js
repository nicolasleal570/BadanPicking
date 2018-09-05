function newPopUp(p1) {
    var get;
    var value;

    p1 = p1.toString();
    get = p1.split('');

    if (get[1] == 0) {
        value = 'CD01';
    } else if (get[1] == 1) {
        value = 'S601';
    } else if (get[1] == 2) {
        value = 'S603';
    } else if (get[1] == 3) {
        value = 'S604';
    } else if (get[1] == 4) {
        value = 'S605';
    } else if (get[1] == 5) {
        value = 'S606';
    } else if (get[1] == 6) {
        value = 'S607';
    } else if (get[1] == 7) {
        value = 'S609';
    } else if (get[1] == 8) {
        value = 'S610';
    } else if (get[1] == 9) {
        value = 'S611';
    } else if (get[1] == 10) {
        value = 'S612';
    }

    $.post(
        'LookUp.php',
        {
            id_cen: value,
            cod_mat: document.getElementById(get[0]).value
        },

        function(data, status) {
            $('#dialog').html(data);

            $(function() {
                $('#dialog').dialog({
                    autoOpen: false,
                    modal: true,
                    width: 600,
                    height: 200,
                    title: 'Informacion Adicional',
                    show: {
                        effect: 'blind',
                        duration: 1000
                    },
                    hide: {
                        effect: 'blind',
                        duration: 1000
                    }
                });

                $('#dialog').dialog('open');
            });
        }
    );
}

function Results() {
    $('#ShContainer').html('');
    $('.loader').html(
        "<img src='CCSSelba/loading.gif' width='180' height='120'>"
    );

    $.post(
        'resultado.php',
        {
            nm_prd: document.getElementById('name_product').value
        },
        function(data, status) {
            $('.loader').html('');
            $('#ShContainer').html(data);
        }
    );
}

function LettersWithSpaceOnly(evt) {
    evt = evt ? evt : event;
    var charCode = evt.charCode
        ? evt.charCode
        : evt.keyCode
            ? evt.keyCode
            : evt.which
                ? evt.which
                : 0;

    if (charCode == 13) {
        $('#ShContainer').html('');
        $('.loader').html(
            "<img src='CCSSelba/loading.gif' width='180' height='120'>"
        );
        $.post(
            'resultado.php',
            {
                nm_prd: document.getElementById('name_product').value
            },
            function(data, status) {
                $('.loader').html('');
                $('#ShContainer').html(data);
            }
        );
    }
}
