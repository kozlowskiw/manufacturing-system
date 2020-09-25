var body = $('body');
body.on('keyup', '#product_search', function () {
    var searchRequest = $(this).val();

    $.ajax({
        method: 'POST',
        url: 'elementy/wyszukaj-produkt',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            searchRequest: searchRequest
        },

        success: function (response) {
            var record = '';
            var table_body = $('#product_table_body');

            table_body.html('');

            if (response.length !== 0) {
                $.each(response, function (index, value) {
                    record = '<tr>\n' +
                        '<td>' + value.id + '</td>\n' +
                        '<td>' + value.code + '</td>\n' +
                        '<td>' + value.name + '</td>\n' +
                        '</tr>';

                    $('#product_table_body').append(record);
                })
            } else {
                var empty_info = '<tr>\n' +
                    '<td>' + 'Wyszukiwany element nie istnieje' + '</td>' +
                    '</tr>';
                table_body.append(empty_info);
            }
        }
    })
});

body.on('keyup', '#operation_search', function () {
    var searchRequest = $(this).val();

    $.ajax({
        method: 'POST',
        url: 'elementy/wyszukaj-operacje',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            searchRequest: searchRequest
        },

        success: function (response) {
            var option = '';

            $('#operation_list').html('');

            $.each(response, function (index, value) {
                option = '<option value="'+value.name+'">'+value.name+'</option>';

                $('#operation_list').append(option);
            })
        }
    })
});
