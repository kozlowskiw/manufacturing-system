var $products_table = $('#products_table');
var $operations_table = $('#operations_table');

$products_table.bootstrapTable({
    formatSearch: function () {
        return 'Wyszukaj produkt'
    },
    formatNoMatches: function () {
        return 'Nie znaleziono rekordów'
    }
});

$operations_table.bootstrapTable({
    formatSearch: function () {
        return 'Wyszukaj operację';
    },
    formatNoMatches: function () {
        return 'Wybierz element'
    }
});

$products_table.on('check.bs.table', function (e, row) {
    var row_id = row.id;

    $.ajax({
        method: 'POST',
        url: 'pobierz-operacje',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            product_id: row_id
        },

        success: function (response) {
            if (response.length !== 0 && Array.isArray(response)) {

                var response_rows = [];
                $.each(response, function (index, value) {
                    response_rows.push(value[0]);
                });

                $operations_table.bootstrapTable('load', response_rows);
            } else {
                $operations_table.bootstrapTable({
                    formatNoMatches: function () {
                        return 'Wybrany element nie posiada przypisanych operacji'
                    }
                })
            }
        },
        error: function (response) {
            $operations_table.bootstrapTable('removeAll');
            $operations_table.bootstrapTable('refreshOptions', {
                formatNoMatches: function () {
                    return 'Wybrany element nie posiada przypisanych operacji'
                }
            });
        }
    })
});

$products_table.on('uncheck.bs.table', function () {
    $operations_table.bootstrapTable('removeAll');
    $operations_table.bootstrapTable('refreshOptions', {
        formatNoMatches: function () {
            return 'Wybierz element'
        }
    });
});
