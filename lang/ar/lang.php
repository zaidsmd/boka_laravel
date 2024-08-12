<?php

return [
    'create_fruit' => [
        'title' => 'إنشاء فاكهة جديدة',
        'label_name' => 'الاسم',
        'label_description' => 'الوصف',
        'placeholder_name' => 'أدخل اسم الفاكهة',
        'placeholder_description' => 'أدخل وصف الفاكهة',
        'submit_button' => 'إنشاء'
    ],

    'create_sale' => [
        'title' => 'إنشاء بيع من أجل  ',
        'label_purchase' => 'الشراء',
        'label_sold_cases' => 'عدد الصناديق المباعة',
        'placeholder_availables_cases' => 'الصناديق المتوفرة',
        'placeholder_sold_cases' => 'عدد الصناديق المباعة',
        'label_unit_price' => 'سعر الصندوق',
        'placeholder_unit_price' => 'سعر الصندوق (درهم)',
        'submit_button' => 'إنشاء البيع',
        'error' => 'لا يمكن أن يتجاوز عدد الصناديق المباعة الصناديق المتوفرة.',
        'label_caisses_vides' => 'الصناديق الفارغة',
        'placeholder_caisses_vides' => 'عدد الصناديق الفارغة',
    ],
    'update_fruit.title' => 'تحديث الفاكهة',
    'update_fruit.label_name' => 'الاسم',
    'update_fruit.label_description' => 'الوصف',
    'update_fruit.placeholder_name' => 'أدخل الاسم',
    'update_fruit.placeholder_description' => 'أدخل الوصف',
    'update_fruit.submit_button' => 'تحديث',


    'update_purchase' => [
        'title' => 'تعديل الشراء',
        'label_quantity' => 'الكمية',
        'label_price' => 'السعر',
        'label_fournisseur' => 'المورد',
        'label_fruit' => 'الفاكهة',
        'submit_button' => 'تعديل',
    ],

    'fruit_list_title' => 'قائمة الفواكه',
    'table_headers' => [
        'name' => 'الاسم',
        'description' => 'الوصف',
        'actions' => 'الإجراءات',
        'email' => 'البريد الإلكتروني',
        'role' => 'الدور',
    ],
    'new_purchase' => 'إضافة شراء جديد',
    'add_new_fruit' => 'إضافة فاكهة جديدة',

    'buttons' => [
        'transform' => 'تحويل',
        'transform2' => ' إضافة تحويل',
        'add_new_client' => 'إضافة زبون جديد',
        'edit' => 'تعديل',
        'delete' => 'حذف',
        'new_purchase' => 'شراء جديد',
        'details' => 'تفاصيل',
        'sell' => 'بيع',
        'paye' => 'دفع',



    ],

    'fr'=> 'الفرنسية',
    'ar' => 'العربية',
    'create_purchase' => [
        'title' => 'إنشاء شراء جديد',
        'label_quantity' => ' الكمية',
        'label_price' => 'سعر الوحدة',
        'label_fournisseur' => 'المورّد',
        'label_fruit' => 'الفاكهة',
        'numero_achat' => 'الفاكهة',
        'placeholder_quantity' => 'أدخل الكمية',
        'placeholder_price' => 'أدخل السعر',
        'submit_button' => 'إنشاء الشراء',
        'add_additional_charges_button' => 'إضافة رسوم إضافية',
        'label_additional_charge_description' => 'أدخل الرسوم الإضافية',
        'placeholder_additional_charge_description' => 'أدخل وصف الرسوم الإضافية',
        'label_additional_charge_price' => 'سعر الرسوم الإضافية',
        'placeholder_additional_charge_price' => 'أدخل سعر الرسوم الإضافية',
        'percentage_discount '=> 'نسبة الخصم (%)',
        'prix_total_achat '=> 'السعر الإجمالي للشراء',
        'apres_charge'=> 'السعر الإجمالي للشراء بعد الرسوم الإضافية',


    ],

    'purchase_list_title' => 'قائمة الشراءات',
    'purchase_table_headers' => [
        'id' => 'رقم الشراء ',
        'date' => 'التاريخ ',
        'quantity' => 'الكمية',
        'price' => 'السعر الإجمالي للشراء',
        'available_cases' => 'الصناديق المتاحة',
        'sold_cases' => 'الصناديق المباعة',
        'total_cases' => 'إجمالي الصناديق',
        'estimated_case' => 'السعر المقدر للصندوق',
        'actions' => 'الإجراءات',
        'product' => 'الفاكهة',
        'supplier' => 'المورد',

    ],

    'fruit_created_success' => 'تم إنشاء الفاكهة بنجاح.',
    'fruit_updated_success' => 'تم تحديث الفاكهة بنجاح.',
    'fruit_deleted_success' => 'تم حذف الفاكهة بنجاح.',


    'fournisseur_created_success' => 'تم إنشاء المورد بنجاح.',
    'fournisseur_updated_success' => 'تم تحديث المورد بنجاح.',
    'fournisseur_deleted_success' => 'تم حذف المورد بنجاح.',

    'client_created_success' => 'تم إنشاء الزبون بنجاح.',
    'client_updated_success' => 'تم تحديث الزبون بنجاح.',
    'client_deleted_success' => 'تم حذف الزبون بنجاح.',

    'purchase_created_success' => 'تم إنشاء الشراء بنجاح.',
    'purchase_updated_success' => 'تم تحديث الشراء بنجاح.',
    'purchase_deleted_success' => 'تم حذف الشراء بنجاح.',
    'purchase_transform_success' => 'تم التحويل بنجاح.',



    'product_created_success' => 'تم إنشاء المنتج بنجاح.',
    'product_updated_success' => 'تم تحديث المنتج بنجاح.',
    'product_deleted_success' => 'تم حذف المنتج بنجاح.',

    'purchase_transform_success' => 'تم التحويل بنجاح.',


    'paiement_created_success' => 'تم إنشاء الدفعة بنجاح.',
    'paiement_updated_success' => 'تم تحديث الدفعة بنجاح.',
    'paiement_deleted_success' => 'تم حذف الدفعة بنجاح.',

    'sale_created_success' => 'تم إنشاء البيع بنجاح.',
    'sale_updated_success' => 'تم تحديث البيع بنجاح.',
    'sale_deleted_success' => 'تم حذف البيع بنجاح.',

    'vente_title' => 'تفاصيل البيع',


    'succes' => 'نجاح',

    'confirm_delete_title' => 'هل أنت متأكد؟',
    'confirm_delete_text' => 'بمجرد الحذف، لن تتمكن من استعادة هذا العنصر!',
    'confirm_delete_icon' => 'warning',
    'confirm_delete_button' => 'نعم، احذف!',
    'cancel_button' => 'إلغاء',

    'estim' => 'السعر المقدر للصندوق',


    'datatable_processing' => 'جاري المعالجة...',
    'datatable_length_menu' => 'عرض _MENU_ عناصر',
    'datatable_zero_records' => 'لم يتم العثور على نتائج مطابقة',
    'datatable_empty_table' => 'لا تتوفر بيانات في الجدول',
    'datatable_info' => 'عرض العناصر من _START_ إلى _END_ من مجموع _TOTAL_ عنصر',
    'datatable_info_empty' => 'عرض العناصر من 0 إلى 0 من مجموع 0 عنصر',
    'datatable_info_filtered' => '(منتقاة من مجموع _MAX_ عنصر)',
    'datatable_info_postfix' => '',
    'datatable_search' => 'بحث:',
    'datatable_url' => '',
    'datatable_info_thousands' => ',',
    'datatable_loading_records' => 'جاري التحميل...',
    'datatable_first' => 'الأول',
    'datatable_last' => 'الأخير',
    'datatable_next' => 'التالي',
    'datatable_previous' => 'السابق',
    'datatable_sort_ascending' => ': فعل لفرز العمود تصاعديًا',
    'datatable_sort_descending' => ': فعل لفرز العمود تنازليًا',


    'client_list_title' => 'قائمة الزبائن',

    'table_headers' => [
        'name' => 'الاسم',
        'phone_number' => 'رقم الهاتف',
        'actions' => 'الإجراءات',
        'description' => 'الوصف',
        'email' => 'البريد الإلكتروني',
        'role' => 'الدور',
    ],

    'labels' => [
        'modal_title' => 'تحويل الشراء',
        'modal_title2' => ' إضافة تحويل جديد',
        'cases_count_label' => 'عدد الصناديق المحصلة',
        'cases_count_label2' => 'عدد الصناديق المحصلة الإضافية',
        'cases_count_placeholder' => 'أدخل عدد الصناديق'
    ],

    'update_client' => [
        'title' => 'تحديث الزبون',
        'label_name' => 'الاسم',
        'label_phone_number' => 'رقم الهاتف',
        'submit_button' => 'تحديث',
    ],

    'create_client' => [
        'title' => 'إنشاء زبون جديد',
        'label_name' => 'الاسم',
        'label_phone_number' => 'رقم الهاتف',
        'submit_button' => 'إنشاء',
        'placeholder_name' => 'أدخل اسم الزبون',
        'placeholder_phone_number' => 'أدخل رقم هاتف الزبون',
    ],
    'confirm_delete_title' => 'هل أنت متأكد؟',
    'confirm_delete_text' => "بمجرد الحذف، لن تتمكن من استعادة هذا العنصر!",
    'confirm_delete_icon' => 'warning',
    'confirm_delete_button' => 'نعم، حذف!',
    'cancel_button' => 'إلغاء',
    'succes' => 'تم بنجاح!',
    'datatable_processing' => 'جاري المعالجة...',



    'create_fournisseur' => [
        'title' => 'إنشاء مورد جديد',
        'label_name' => 'الاسم',
        'label_phone_number' => 'رقم الهاتف',
        'placeholder_name' => 'أدخل اسم المورد',
        'placeholder_phone_number' => 'أدخل رقم هاتف المورد',
        'submit_button' => 'إنشاء',
    ],

    "fournisseur_list_title" => "قائمة الموردين",
        "add_new_fournisseur" => "إضافة مورد جديد",


    'update_fournisseur' => [
        'title' => 'تحديث المورد',
        'label_name' => 'الاسم',
        'label_phone_number' => 'رقم الهاتف',
        'submit_button' => 'تحديث',
    ],

    'search_placeholder' => 'أدخل اسم الزبون',
    'price_to_paye' => 'المبلغ المتبقي للدفع:',
    'payed_price' => 'إجمالي المبيعات الغير مكملة ',
    'dh'=> 'درهم',
    'old_sells'=> 'مبيعات سابقة',
    'clients'=>'الزبائن',
    'client'=>'الزبون',
    'remaining_price' => 'المبلغ المتبقي للدفع : ',
    'enter_price' => 'أدخل  المبلغ ',
    'enter_new_price' => 'أدخل  المبلغ الجديد',
    'historique' => 'مبيعات سابقة ل : ',
    'return_empty_cases'=>'إعادة الصناديق ',
    'client_cases' => ' الصناديق  عند الزبون :',
    'old_payments' => 'مدفوعات سابقة',
    'paiement_client' => 'دفعات الزبون',
    'empty_cases' => 'صناديق عند الزبون ',
    'payments_title' => 'مدفوعات يومية',
    'ventes_title' => 'مبيعات يومية',
    'users' => 'المستخدمون',
    'user' => 'المستخدم',
    'list_users' => ' قائمة المستخدمين',
    'add_new_user' => 'إضافة مستخدم جديد',
    'update_user' => 'تحديث مستخدم ',
    'paiement'=> 'دفعة ',
    'liste_vente_achat'=>'قائمة المبيعات للشراء رقم' ,
    'table_headers_vente' => [
        'date' => 'التاريخ',
        'time' => 'الساعة',
        'sold_cases' => 'عدد الصناديق المباعة',
        'unit_price' => 'سعر الوحدة ',
        'total_sale_price' => 'السعر الإجمالي للبيع ',
        'empty_cases' => 'عدد الصناديق  ',
        'paid_price' => 'السعر المدفوع',
        'remaining_price' => 'السعر المتبقي',
        'status' => 'الحالة',
        'email' => 'البريد الإلكتروني',
        'role' => 'الدور',

    ],


    'create'=> 'إنشاء',

    'vente_status' => [
        'payed_in_full' => 'مدفوع بالكامل',
        'partially_paid' => 'مدفوع جزئيا',
        'not_payed' => 'غير مدفوع',
    ],

    'edit_sale' => [
        'title' => 'تحديث البيع لـ ',
        'label_sold_cases' => 'عدد الصناديق المباعة',
        'label_unit_price' => 'سعر الوحدة',
        'submit_button' => 'حفظ التعديلات',
        'label_not_enough_cases' => 'عدد الصناديق غير متوفر',
        'label_available_cases' => 'عدد الصناديق المتاحة',

    ],
    'sign_in_continue' => 'قم بتسجيل الدخول للمتابعة.',
    'email' => 'البريد الإلكتروني',
    'username' => 'اسم المستخدم',
    'enter_username' => ' أدخل اسم المستخدم',
    'enter_email' => 'أدخل البريد الإلكتروني',
    'password' => 'كلمة المرور',
    'enter_password' => 'أدخل كلمة المرور',
    'remember_me' => 'تذكرني',
    'forgot_password' => 'هل نسيت كلمة المرور؟',
    'log_in' => 'تسجيل الدخول',
    'purchase_details' => [
        'title' => 'تفاصيل الشراء',
        'initial_purchase_price' => 'سعر الشراء الأولي',
        'additional_charges' => 'الرسوم الإضافية',
        'total_purchase_price' => 'السعر الإجمالي للشراء',
        'paid_sales_price' => 'سعر  المدفوعات',
        'sales_price' => 'سعر المبيعات',
        'remaining' => 'الربح',
        'view_sales' => 'عرض المبيعات',
        'charge' => 'الرسوم',

    ],

    'admin' => 'مدير',
    'seller' => 'بائع',
    'total_price' => 'إجمالي المدفوعات',
    'fix_discount'=>'الخصم الثابت',
    'price_after_charge' => 'السعر الإجمالي للشراء + مصاريف عامة  ',

    'edit_charge'=> 'تحديث مصاريف عامة ',
    'edit_charge_description' => 'أدخل مصاريف عامة',

    'app_title'=> 'برنامج إدارة الفواكه',

    'charges_additionelles'=> 'مصاريف عامة',

    'Email or password invalid' => 'اسم المستخدم أو كلمة المرور غير صالحة',
    'charges_additionelles_list'=> 'مصاريف عامة',
    'add_new_charge'=> 'إنشاء مصاريف عامة' ,
    'logout' => 'تسجيل الخروج',

    'enter_email' => 'أدخل البريد الإلكتروني',
    'enter_password' => 'أدخل كلمة المرور',

    "Label de charge additionnelle créé avec succès" => "تم إنشاء تسمية الرسوم الإضافية بنجاح",
    "Label de charge additionnelle mis à jour avec succès" => "تم تحديث تسمية الرسوم الإضافية بنجاح",
    "Label de charge additionnelle supprimé avec succès" => "تم حذف تسمية الرسوم الإضافية بنجاح",



    'user_created_successfully' => 'تم إنشاء المستخدم بنجاح',
    'user_updated_successfully' => 'تم تحديث المستخدم بنجاح',
    'user_deleted_successfully' => 'تم حذف المستخدم بنجاح',




    'error_update_cases' => 'عدد الصناديق لا يفوق الصناديق المباعة ',

    'name.required' => 'حقل الاسم مطلوب',
    'client_exists' => 'العميل موجود بالفعل.',
    'email.required' => 'حقل البريد الإلكتروني مطلوب',
    'email.email' => 'البريد الإلكتروني يجب أن يكون عنوان بريد إلكتروني صالح',
    'email.unique' => 'البريد الإلكتروني تم استخدامه بالفعل',
    'name.unique' => 'الإسم تم استخدامه بالفعل',
    'numero_achat.unique' => 'رقم الشراء تم استخدامه بالفعل',
    'password.required' => 'حقل كلمة المرور مطلوب',
    'role.required' => 'حقل الدور مطلوب',
];
