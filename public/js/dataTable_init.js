const __dataTable_filter = function (data) {
    d = __datatable_ajax_callback(data);
};
var table = $(__dataTable_id).DataTable({
    dom: 'lrtip',
    lengthMenu: [[10, 25, 50,100, -1], [10, 25, 50,100, "Tous"]],
    processing: true,
    serverSide: true,
    responsive: true,
    "language": {
        "emptyTable": "{{ __('datatable.empty_table') }}",
        "loadingRecords": "{{ __('datatable.loading_records') }}",
        "processing": "{{ __('datatable.processing') }}",
        "select": {
            "rows": {
                "_": "{{ __('datatable.select.rows._') }}",
                "1": "{{ __('datatable.select.rows.1') }}"
            },
            "cells": {
                "1": "{{ __('datatable.select.cells.1') }}",
                "_": "{{ __('datatable.select.cells._') }}"
            },
            "columns": {
                "1": "{{ __('datatable.select.columns.1') }}",
                "_": "{{ __('datatable.select.columns._') }}"
            }
        },
        "autoFill": {
            "cancel": "{{ __('datatable.autofill.cancel') }}",
            "fill": "{{ __('datatable.autofill.fill') }}",
            "fillHorizontal": "{{ __('datatable.autofill.fill_horizontal') }}",
            "fillVertical": "{{ __('datatable.autofill.fill_vertical') }}"
        },
        "searchBuilder": {
            "conditions": {
                "date": {
                    "after": "{{ __('datatable.search_builder.conditions.date.after') }}",
                    "before": "{{ __('datatable.search_builder.conditions.date.before') }}",
                    "between": "{{ __('datatable.search_builder.conditions.date.between') }}",
                    "empty": "{{ __('datatable.search_builder.conditions.date.empty') }}",
                    "not": "{{ __('datatable.search_builder.conditions.date.not') }}",
                    "notBetween": "{{ __('datatable.search_builder.conditions.date.not_between') }}",
                    "notEmpty": "{{ __('datatable.search_builder.conditions.date.not_empty') }}",
                    "equals": "{{ __('datatable.search_builder.conditions.date.equals') }}"
                },
                "number": {
                    "between": "{{ __('datatable.search_builder.conditions.number.between') }}",
                    "empty": "{{ __('datatable.search_builder.conditions.number.empty') }}",
                    "gt": "{{ __('datatable.search_builder.conditions.number.gt') }}",
                    "gte": "{{ __('datatable.search_builder.conditions.number.gte') }}",
                    "lt": "{{ __('datatable.search_builder.conditions.number.lt') }}",
                    "lte": "{{ __('datatable.search_builder.conditions.number.lte') }}",
                    "not": "{{ __('datatable.search_builder.conditions.number.not') }}",
                    "notBetween": "{{ __('datatable.search_builder.conditions.number.not_between') }}",
                    "notEmpty": "{{ __('datatable.search_builder.conditions.number.not_empty') }}",
                    "equals": "{{ __('datatable.search_builder.conditions.number.equals') }}"
                },
                "string": {
                    "contains": "{{ __('datatable.search_builder.conditions.string.contains') }}",
                    "empty": "{{ __('datatable.search_builder.conditions.string.empty') }}",
                    "endsWith": "{{ __('datatable.search_builder.conditions.string.ends_with') }}",
                    "not": "{{ __('datatable.search_builder.conditions.string.not') }}",
                    "notEmpty": "{{ __('datatable.search_builder.conditions.string.not_empty') }}",
                    "startsWith": "{{ __('datatable.search_builder.conditions.string.starts_with') }}",
                    "equals": "{{ __('datatable.search_builder.conditions.string.equals') }}",
                    "notContains": "{{ __('datatable.search_builder.conditions.string.not_contains') }}",
                    "notEndsWith": "{{ __('datatable.search_builder.conditions.string.not_ends_with') }}",
                    "notStartsWith": "{{ __('datatable.search_builder.conditions.string.not_starts_with') }}"
                },
                "array": {
                    "empty": "{{ __('datatable.search_builder.conditions.array.empty') }}",
                    "contains": "{{ __('datatable.search_builder.conditions.array.contains') }}",
                    "not": "{{ __('datatable.search_builder.conditions.array.not') }}",
                    "notEmpty": "{{ __('datatable.search_builder.conditions.array.not_empty') }}",
                    "without": "{{ __('datatable.search_builder.conditions.array.without') }}",
                    "equals": "{{ __('datatable.search_builder.conditions.array.equals') }}"
                }
            },
            "add": "{{ __('datatable.search_builder.add') }}",
            "button": {
                "0": "{{ __('datatable.search_builder.button.0') }}",
                "_": "{{ __('datatable.search_builder.button._') }}"
            },
            "clearAll": "{{ __('datatable.search_builder.clear_all') }}",
            "condition": "{{ __('datatable.search_builder.condition') }}",
            "data": "{{ __('datatable.search_builder.data') }}",
            "deleteTitle": "{{ __('datatable.search_builder.delete_title') }}",
            "logicAnd": "{{ __('datatable.search_builder.logic_and') }}",
            "logicOr": "{{ __('datatable.search_builder.logic_or') }}",
            "title": {
                "0": "{{ __('datatable.search_builder.title.0') }}",
                "_": "{{ __('datatable.search_builder.title._') }}"
            },
            "value": "{{ __('datatable.search_builder.value') }}",
            "leftTitle": "{{ __('datatable.search_builder.left_title') }}",
            "rightTitle": "{{ __('datatable.search_builder.right_title') }}"
        },
        "searchPanes": {
            "clearMessage": "{{ __('datatable.search_panes.clear_message') }}",
            "count": "{{ __('datatable.search_panes.count') }}",
            "title": "{{ __('datatable.search_panes.title') }}",
            "collapse": {
                "0": "{{ __('datatable.search_panes.collapse.0') }}",
                "_": "{{ __('datatable.search_panes.collapse._') }}"
            },
            "countFiltered": "{{ __('datatable.search_panes.count_filtered') }}",
            "emptyPanes": "{{ __('datatable.search_panes.empty_panes') }}",
            "loadMessage": "{{ __('datatable.search_panes.load_message') }}",
            "collapseMessage": "{{ __('datatable.search_panes.collapse_message') }}",
            "showMessage": "{{ __('datatable.search_panes.show_message') }}"
        },
        "buttons": {
            "collection": "{{ __('datatable.buttons.collection') }}",
            "colvis": "{{ __('datatable.buttons.colvis') }}",
            "colvisRestore": "{{ __('datatable.buttons.colvis_restore') }}",
            "copy": "{{ __('datatable.buttons.copy') }}",
            "copySuccess": {
                "1": "{{ __('datatable.buttons.copy_success.1') }}",
                "_": "{{ __('datatable.buttons.copy_success._') }}"
            },
            "copyTitle": "{{ __('datatable.buttons.copy_title') }}",
            "csv": "{{ __('datatable.buttons.csv') }}",
            "excel": "{{ __('datatable.buttons.excel') }}",
            "pageLength": {
                "-1": "{{ __('datatable.buttons.page_length.-1') }}",
                "_": "{{ __('datatable.buttons.page_length._') }}",
                "1": "{{ __('datatable.buttons.page_length.1') }}"
            },
            "pdf": "{{ __('datatable.buttons.pdf') }}",
            "print": "{{ __('datatable.buttons.print') }}",
            "copyKeys": "{{ __('datatable.buttons.copy_keys') }}",
            "createState": "{{ __('datatable.buttons.create_state') }}",
            "removeAllStates": "{{ __('datatable.buttons.remove_all_states') }}",
            "removeState": "{{ __('datatable.buttons.remove_state') }}",
            "renameState": "{{ __('datatable.buttons.rename_state') }}",
            "savedStates": "{{ __('datatable.buttons.saved_states') }}",
            "stateRestore": "{{ __('datatable.buttons.state_restore') }}",
            "updateState": "{{ __('datatable.buttons.update_state') }}"
        },
        "decimal": "{{ __('datatable.decimal') }}",
        "datetime": {
            "previous": "{{ __('datatable.datetime.previous') }}",
            "next": "{{ __('datatable.datetime.next') }}",
            "hours": "{{ __('datatable.datetime.hours') }}",
            "minutes": "{{ __('datatable.datetime.minutes') }}",
            "seconds": "{{ __('datatable.datetime.seconds') }}",
            "unknown": "{{ __('datatable.datetime.unknown') }}",
            "amPm": ["{{ __('datatable.datetime.am_pm.0') }}", "{{ __('datatable.datetime.am_pm.1') }}"],
            "months": {
                "0": "{{ __('datatable.datetime.months.0') }}",
                "1": "{{ __('datatable.datetime.months.1') }}",
                "2": "{{ __('datatable.datetime.months.2') }}",
                "3": "{{ __('datatable.datetime.months.3') }}",
                "4": "{{ __('datatable.datetime.months.4') }}",
                "5": "{{ __('datatable.datetime.months.5') }}",
                "6": "{{ __('datatable.datetime.months.6') }}",
                "7": "{{ __('datatable.datetime.months.7') }}",
                "8": "{{ __('datatable.datetime.months.8') }}",
                "9": "{{ __('datatable.datetime.months.9') }}",
                "10": "{{ __('datatable.datetime.months.10') }}",
                "11": "{{ __('datatable.datetime.months.11') }}"
            },
            "weekdays": [
                "{{ __('datatable.datetime.weekdays.0') }}",
                "{{ __('datatable.datetime.weekdays.1') }}",
                "{{ __('datatable.datetime.weekdays.2') }}",
                "{{ __('datatable.datetime.weekdays.3') }}",
                "{{ __('datatable.datetime.weekdays.4') }}",
                "{{ __('datatable.datetime.weekdays.5') }}",
                "{{ __('datatable.datetime.weekdays.6') }}"
            ]
        },
        "editor": {
            "close": "{{ __('datatable.editor.close') }}",
            "create": {
                "title": "{{ __('datatable.editor.create.title') }}",
                "button": "{{ __('datatable.editor.create.button') }}",
                "submit": "{{ __('datatable.editor.create.submit') }}"
            },
            "edit": {
                "button": "{{ __('datatable.editor.edit.button') }}",
                "title": "{{ __('datatable.editor.edit.title') }}",
                "submit": "{{ __('datatable.editor.edit.submit') }}"
            },
            "remove": {
                "button": "{{ __('datatable.editor.remove.button') }}",
                "title": "{{ __('datatable.editor.remove.title') }}",
                "submit": "{{ __('datatable.editor.remove.submit') }}",
                "confirm": {
                    "_": "{{ __('datatable.editor.remove.confirm._') }}",
                    "1": "{{ __('datatable.editor.remove.confirm.1') }}"
                }
            },
            "multi": {
                "title": "{{ __('datatable.editor.multi.title') }}",
                "info": "{{ __('datatable.editor.multi.info') }}",
                "restore": "{{ __('datatable.editor.multi.restore') }}",
                "no_multi": "{{ __('datatable.editor.multi.no_multi') }}"
            },
            "error": {
                "system": "{{ __('datatable.editor.error.system') }}"
            }
        },
        "state_restore": {
            "remove_submit": "{{ __('datatable.state_restore.remove_submit') }}",
            "creation_modal": {
                "button": "{{ __('datatable.state_restore.creation_modal.button') }}",
                "order": "{{ __('datatable.state_restore.creation_modal.order') }}",
                "paging": "{{ __('datatable.state_restore.creation_modal.paging') }}",
                "scroller": "{{ __('datatable.state_restore.creation_modal.scroller') }}",
                "search": "{{ __('datatable.state_restore.creation_modal.search') }}",
                "select": "{{ __('datatable.state_restore.creation_modal.select') }}",
                "columns": {
                    "search": "{{ __('datatable.state_restore.creation_modal.columns.search') }}",
                    "visible": "{{ __('datatable.state_restore.creation_modal.columns.visible') }}"
                },
                "name": "{{ __('datatable.state_restore.creation_modal.name') }}",
                "search_builder": "{{ __('datatable.state_restore.creation_modal.search_builder') }}",
                "title": "{{ __('datatable.state_restore.creation_modal.title') }}",
                "toggle_label": "{{ __('datatable.state_restore.creation_modal.toggle_label') }}"
            },
            "rename_button": "{{ __('datatable.state_restore.rename_button') }}",
            "duplicate_error": "{{ __('datatable.state_restore.duplicate_error') }}",
            "empty_error": "{{ __('datatable.state_restore.empty_error') }}",
            "empty_states": "{{ __('datatable.state_restore.empty_states') }}",
            "remove_confirm": "{{ __('datatable.state_restore.remove_confirm') }}",
            "remove_error": "{{ __('datatable.state_restore.remove_error') }}",
            "remove_joiner": "{{ __('datatable.state_restore.remove_joiner') }}",
            "remove_title": "{{ __('datatable.state_restore.remove_title') }}",
            "rename_label": "{{ __('datatable.state_restore.rename_label') }}",
            "rename_title": "{{ __('datatable.state_restore.rename_title') }}"
        },
        "info": "{{ __('datatable.info') }}",
        "info_empty": "{{ __('datatable.info_empty') }}",
        "info_filtered": "{{ __('datatable.info_filtered') }}",
        "length_menu": "{{ __('datatable.length_menu') }}",
        "paginate": {
            "first": "{{ __('datatable.paginate.first') }}",
            "last": "{{ __('datatable.paginate.last') }}",
            "next": "{{ __('datatable.paginate.next') }}",
            "previous": "{{ __('datatable.paginate.previous') }}"
        },
        "zero_records": "{{ __('datatable.zero_records') }}",
        "aria": {
            "sort_ascending": "{{ __('datatable.aria.sort_ascending') }}",
            "sort_descending": "{{ __('datatable.aria.sort_descending') }}"
        },
        "info_thousands": "{{ __('datatable.info_thousands') }}",
        "search": "{{ __('datatable.search') }}",
        "thousands": "{{ __('datatable.thousands') }}"
    },

    // buttons: [
    //     {extend: 'copy', className: 'btn-soft-primary'},
    //     {extend: 'excel', className: 'btn-soft-primary'},
    //     {extend: 'pdf', className: 'btn-soft-primary'},
    //     {extend: 'colvis', className: 'btn-soft-primary'}
    // ],
    // columnDefs: [
    //     {
    //         orderable: false,
    //         className: 'select-checkbox',
    //         targets: 0
    //     },
    //     {
    //         orderable: false,
    //         className: 'last-col',
    //         targets: -1,
    //     }
    // ],
    ajax: {
        url: __dataTable_ajax_link,
        data: function (d){
            if (typeof __dataTable_filter_inputs_id === 'object'){
                for (const key in __dataTable_filter_inputs_id){
                    d[key]= $(__dataTable_filter_inputs_id[key]).val();
                }
            }
            d= __datatable_ajax_callback(d)
        }
    },
    columns:__dataTable_columns,
    orderCellsTop: true,
    order: [[1, 'desc']],
    pageLength: 50,
})
//
// $(document).on('click', '#select-all-row', function (e) {
//     if (this.checked) {
//         $('#datatable')
//             .find('tbody')
//             .find('input.row-select')
//             .each(function () {
//                 if (!this.checked) {
//                     $(this)
//                         .prop('checked', true)
//                         .change();
//                 }
//             });
//     } else {
//         $('#datatable')
//             .find('tbody')
//             .find('input.row-select')
//             .each(function () {
//                 if (this.checked) {
//                     $(this)
//                         .prop('checked', false)
//                         .change();
//                 }
//             });
//     }
// });
if(typeof __dataTable_filter_trigger_button_id !== 'undefined'){
    $(__dataTable_filter_trigger_button_id).click(e=> table.ajax.reload())
}
// $("#datatable_wrapper").prepend('<div class="row actions w-100"></div>')
// $("#datatable_wrapper>.dt-buttons").wrap('<div class="col-6 actions d-flex justify-content-end"></div>');
// $("#datatable_wrapper>.dataTables_length").wrap('<div class="col-6 actions"></div>');
// $("#datatable_wrapper>.col-6.actions").appendTo($('.row.actions'));
// function getSelectedRows() {
//     var selected_rows = [];
//     var i = 0;
//     $('.row-select:checked').each(function () {
//         selected_rows[i++] = $(this).val();
//     });
//     return selected_rows;
// }
$( document ).ajaxComplete(function() {
    // Required for Bootstrap tooltips in DataTables
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

});
