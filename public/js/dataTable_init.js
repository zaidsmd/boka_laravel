const __dataTable_filter = function (data) {
    d = __datatable_ajax_callback(data);
};
function __datatable_ajax_callback(data){
    for (var i = 0, len = data.columns.length; i < len; i++) {
        if (! data.columns[i].search.value) delete data.columns[i].search;
        if (data.columns[i].searchable === true) delete data.columns[i].searchable;
        if (data.columns[i].orderable === true) delete data.columns[i].orderable;
        if (data.columns[i].data === data.columns[i].name) delete data.columns[i].name;
    }
    delete data.search.regex;

    return data;
}
if (typeof  __sort_column != "undefined") {
    var sortby = __sort_column;
} else {
    var sortby = 1;
}
var table = $(__dataTable_id).DataTable({
    dom: 'lBrtip',
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Tous"]],
    processing: true,
    serverSide: true,
    responsive: true,
    language: {
        "emptyTable": "لا توجد بيانات متاحة في الجدول",
        "loadingRecords": "جاري التحميل...",
        "processing": "جاري المعالجة...",
        "select": {
            "rows": {
                "_": "%d صفوف محددة",
                "1": "صف واحد محدد"
            },
            "cells": {
                "1": "خلية واحدة محددة",
                "_": "%d خلايا محددة"
            },
            "columns": {
                "1": "عمود واحد محدد",
                "_": "%d أعمدة محددة"
            }
        },
        "autoFill": {
            "cancel": "إلغاء",
            "fill": "املأ جميع الخلايا بـ <i>%d<\/i>",
            "fillHorizontal": "املأ الخلايا أفقيًا",
            "fillVertical": "املأ الخلايا عموديًا"
        },
        "searchBuilder": {
            "conditions": {
                "date": {
                    "after": "بعد",
                    "before": "قبل",
                    "between": "بين",
                    "empty": "فارغ",
                    "not": "ليس",
                    "notBetween": "ليس بين",
                    "notEmpty": "غير فارغ",
                    "equals": "يساوي"
                },
                "number": {
                    "between": "بين",
                    "empty": "فارغ",
                    "gt": "أكبر من",
                    "gte": "أكبر أو يساوي",
                    "lt": "أقل من",
                    "lte": "أقل أو يساوي",
                    "not": "ليس",
                    "notBetween": "ليس بين",
                    "notEmpty": "غير فارغ",
                    "equals": "يساوي"
                },
                "string": {
                    "contains": "يحتوي",
                    "empty": "فارغ",
                    "endsWith": "ينتهي بـ",
                    "not": "ليس",
                    "notEmpty": "غير فارغ",
                    "startsWith": "يبدأ بـ",
                    "equals": "يساوي",
                    "notContains": "لا يحتوي",
                    "notEndsWith": "لا ينتهي بـ",
                    "notStartsWith": "لا يبدأ بـ"
                },
                "array": {
                    "empty": "فارغ",
                    "contains": "يحتوي",
                    "not": "ليس",
                    "notEmpty": "غير فارغ",
                    "without": "بدون",
                    "equals": "يساوي"
                }
            },
            "add": "إضافة شرط",
            "button": {
                "0": "بحث متقدم",
                "_": "بحث متقدم (%d)"
            },
            "clearAll": "مسح الكل",
            "condition": "شرط",
            "data": "بيانات",
            "deleteTitle": "حذف قاعدة التصفية",
            "logicAnd": "و",
            "logicOr": "أو",
            "title": {
                "0": "بحث متقدم",
                "_": "بحث متقدم (%d)"
            },
            "value": "قيمة",
            "leftTitle": "إلغاء الفقرة",
            "rightTitle": "إضافة الفقرة"
        },
        "searchPanes": {
            "clearMessage": "مسح الكل",
            "count": "{total}",
            "title": "فلاتر نشطة - %d",
            "collapse": {
                "0": "لوحة البحث",
                "_": "لوحة البحث (%d)"
            },
            "countFiltered": "{shown} ({total})",
            "emptyPanes": "لا توجد لوحات بحث",
            "loadMessage": "جاري تحميل لوحة البحث...",
            "collapseMessage": "طي الكل",
            "showMessage": "إظهار الكل"
        },
        "buttons": {
            "collection": "مجموعة",
            "colvis": "ظهور الأعمدة",
            "colvisRestore": "استعادة الظهور",
            "copy": "نسخ",
            "copySuccess": {
                "1": "تم نسخ صف واحد إلى الحافظة",
                "_": "تم نسخ %d صفوف إلى الحافظة"
            },
            "copyTitle": "نسخ إلى الحافظة",
            "csv": "CSV",
            "excel": "Excel",
            "pageLength": {
                "-1": "عرض جميع الصفوف",
                "_": "عرض %d صفوف",
                "1": "عرض صف واحد"
            },
            "pdf": "PDF",
            "print": "طباعة",
            "copyKeys": "اضغط على Ctrl أو ⌘ + C لنسخ بيانات الجدول إلى الحافظة.",
            "createState": "إنشاء حالة",
            "removeAllStates": "إزالة جميع الحالات",
            "removeState": "إزالة",
            "renameState": "إعادة تسمية",
            "savedStates": "الحالات المحفوظة",
            "stateRestore": "استعادة الحالة %d",
            "updateState": "تحديث"
        },
        "decimal": ",",
        "datetime": {
            "previous": "السابق",
            "next": "التالي",
            "hours": "الساعات",
            "minutes": "الدقائق",
            "seconds": "الثواني",
            "unknown": "-",
            "amPm": [
                "ص",
                "م"
            ],
            "months": {
                "0": "يناير",
                "2": "مارس",
                "3": "أبريل",
                "4": "مايو",
                "5": "يونيو",
                "6": "يوليو",
                "8": "سبتمبر",
                "9": "أكتوبر",
                "10": "نوفمبر",
                "1": "فبراير",
                "11": "ديسمبر",
                "7": "أغسطس"
            },
            "weekdays": [
                "أحد",
                "إثنين",
                "ثلاثاء",
                "أربعاء",
                "خميس",
                "جمعة",
                "سبت"
            ]
        },
        "editor": {
            "close": "إغلاق",
            "create": {
                "title": "إنشاء إدخال جديد",
                "button": "جديد",
                "submit": "إنشاء"
            },
            "edit": {
                "button": "تحرير",
                "title": "تحرير الإدخال",
                "submit": "تحديث"
            },
            "remove": {
                "button": "حذف",
                "title": "حذف",
                "submit": "حذف",
                "confirm": {
                    "_": "هل أنت متأكد أنك تريد حذف %d صفوف؟",
                    "1": "هل أنت متأكد أنك تريد حذف صف واحد؟"
                }
            },
            "multi": {
                "title": "قيم متعددة",
                "info": "العناصر المحددة تحتوي على قيم مختلفة لهذا الإدخال. لتعديل وتحديد جميع العناصر بنفس القيمة لهذا الإدخال، انقر هنا أو اضغط على هنا، وإلا فستحتفظ بقيمها الفردية.",
                "restore": "إلغاء التغييرات",
                "noMulti": "يمكن تعديل هذا الحقل بشكل فردي، لكنه ليس جزءًا من مجموعة."
            },
            "error": {
                "system": "حدث خطأ في النظام (<a target=\"\\\" rel=\"nofollow\" href=\"\\\">مزيد من المعلومات<\/a>)."
            }
        },
        "stateRestore": {
            "removeSubmit": "حذف",
            "creationModal": {
                "button": "إنشاء",
                "order": "ترتيب",
                "paging": "ترقيم الصفحات",
                "scroller": "موقع التمرير",
                "search": "بحث",
                "select": "تحديد",
                "columns": {
                    "search": "بحث حسب العمود",
                    "visible": "ظهور الأعمدة"
                },
                "name": "اسم:",
                "searchBuilder": "بحث متقدم",
                "title": "إنشاء حالة جديدة",
                "toggleLabel": "تضمين:"
            },
            "renameButton": "إعادة تسمية",
            "duplicateError": "يوجد بالفعل حالة بنفس الاسم.",
            "emptyError": "لا يمكن أن يكون الاسم فارغًا.",
            "emptyStates": "لا توجد حالات محفوظة",
            "removeConfirm": "هل تريد حقًا حذف %s؟",
            "removeError": "فشل في حذف الحالة.",
            "removeJoiner": "و",
            "removeTitle": "حذف الحالة",
            "renameLabel": "اسم جديد لـ %s:",
            "renameTitle": "إعادة تسمية الحالة"
        },
        "info": "عرض _START_ إلى _END_ من _TOTAL_ إدخالات",
        "infoEmpty": "عرض 0 إلى 0 من 0 إدخالات",
        "infoFiltered": "(مفلترة من إجمالي _MAX_ إدخالات)",
        "lengthMenu": "عرض _MENU_ إدخالات",
        "paginate": {
            "first": "الأولى",
            "last": "الأخيرة",
            "next": "التالي",
            "previous": "السابق"
        },
        "zeroRecords": "لم يتم العثور على سجلات مطابقة",
        "aria": {
            "sortAscending": ": تفعيل لفرز العمود تصاعديًا",
            "sortDescending": ": تفعيل لفرز العمود تنازليًا"
        },
        "infoThousands": " ",
        "search": "بحث:",
        "thousands": " "
    },
    buttons: [
        {extend: 'copy', className: 'btn-soft-primary'},
        {extend: 'excel', className: 'btn-soft-primary'},
        {extend: 'pdf', className: 'btn-soft-primary'},
        {extend: 'colvis', className: 'btn-soft-primary'}
    ],
    columnDefs: [
        {
            orderable: false,
            className: 'select-checkbox',
            targets: 0
        },
        {
            className: 'last-col',
            targets: -1,
        }
    ],
    ajax: {
        url: __dataTable_ajax_link,
        data: function (d) {
            if (typeof __dataTable_filter_inputs_id === 'object') {
                for (const key in __dataTable_filter_inputs_id) {
                    d[key] = $(__dataTable_filter_inputs_id[key]).val();
                }
            }
            d = __datatable_ajax_callback(d)
        }
    },
    columns: __dataTable_columns,
    orderCellsTop: true,
    order: [[sortby, 'desc']],
    pageLength: 10,
})

$(document).on('click', '#select-all-row', function (e) {
    if (this.checked) {
        $('#datatable')
            .find('tbody')
            .find('input.row-select')
            .each(function () {
                if (!this.checked) {
                    $(this)
                        .prop('checked', true)
                        .change();
                }
            });
    } else {
        $('#datatable')
            .find('tbody')
            .find('input.row-select')
            .each(function () {
                if (this.checked) {
                    $(this)
                        .prop('checked', false)
                        .change();
                }
            });
    }
});
if (typeof __dataTable_filter_trigger_button_id !== 'undefined') {
    $(__dataTable_filter_trigger_button_id).click(e => table.ajax.reload())
}
$("#datatable_wrapper").prepend('<div class="row actions w-100"></div>')
$("#datatable_wrapper>.dt-buttons").wrap('<div class="col-6 actions d-flex justify-content-end"></div>');
$("#datatable_wrapper>.dataTables_length").wrap('<div class="col-6 actions"></div>');
$("#datatable_wrapper>.col-6.actions").appendTo($('.row.actions'));

function getSelectedRows() {
    var selected_rows = [];
    var i = 0;
    $('.row-select:checked').each(function () {
        selected_rows[i++] = $(this).val();
    });
    return selected_rows;
}

$(document).ajaxComplete(function () {
    // Required for Bootstrap tooltips in DataTables
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

});
