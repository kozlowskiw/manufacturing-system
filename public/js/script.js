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


var checkedRows = [];

$operations_table.bootstrapTable({
    formatSearch: function () {
        return 'Wyszukaj operację';
    }
});


// $('form').submit(function () {
//    //event.preventDefault();
//
//    var selections = $operations_table.bootstrapTable('getSelections');
//
//    //var tableData = selections.serialize();
//
//     // var $op_ids = JSON.stringify($operations_table.bootstrapTable('getSelections'));
// //console.log(tableData);
//     $.ajax({
//         type: 'GET',
//         url: 'elementy-operacje/dodaj',
//         dataType: 'json',
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         data: {'selections' : JSON.stringify(selections)},
//         success: function(result){
//             alert(result);
//         }
//
//         // success: function (response) {
//         //     var record = '';
//         //     var table_body = $('#product_table_body');
//         //
//         //     table_body.html('');
//         //
//         //     if (response.length !== 0) {
//         //         $.each(response, function (index, value) {
//         //             record = '<tr>\n' +
//         //                 '<td>' + value.id + '</td>\n' +
//         //                 '<td>' + value.code + '</td>\n' +
//         //                 '<td>' + value.name + '</td>\n' +
//         //                 '</tr>';
//         //
//         //             $('#product_table_body').append(record);
//         //         })
//         //     } else {
//         //         var empty_info = '<tr>\n' +
//         //             '<td>' + 'Wyszukiwany element nie istnieje' + '</td>' +
//         //             '</tr>';
//         //         table_body.append(empty_info);
//         //     }
//         // }
//     })
//
// });
