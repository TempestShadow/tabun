<?php

return [
    'comment' => [
        'as_date' => 1489132800,    // strtotime('2017-03-10')
        'oa_required_level' => 1,
        'na_required_level' => 6,     // Allow all allowed users to listen New Age
        'na_required_rating' => 10.0,
        'date_sort' => SORT_ASC,
        'hide_voters_from_owner' => true,
    ],
    'topic' => [
        'as_date' => 1489132800,    // strtotime('2017-03-10')
        'oa_required_level' => 1,
        'na_required_level' => 6,     // Allow all allowed users to listen New Age
        'na_required_rating' => false,
        'date_sort' => SORT_ASC,
        'hide_voters_from_owner' => false,
    ],
    'blog' => [
        'as_date' => 0,
        'oa_required_level' => 6,
        'na_required_level' => 6,     // Allow all allowed users to listen New Age
        'na_required_rating' => false,
        'date_sort' => SORT_DESC,
        'hide_voters_from_owner' => false,
    ],
    'user' => [
        'as_date' => 1357027200,    // strtotime('2013-01-01')
        'oa_required_level' => 1,
        'na_required_level' => 6,     // Allow all users to listen New Age
        'na_required_rating' => 10.0,
        'date_sort' => SORT_DESC,
        'hide_voters_from_owner' => true,
    ],
];
// as_date — точка завершения "старого" периода, unix timestamp
// oa_required_level — кому разрешено видеть юзеров оценок за "старый" период
// na_required_level — кому разрешено видеть юзеров оценок за "новый" период и запрашивать список оценок в целом
//	0 — никто
//	1 — администраторы сайта
// * Значения от 2 до 7 включительно имеют разный эффект для комментариев, топиков и блогов, но не для пользователей.
//	2 — (не используется)
//	3 — администраторы сайта, администраторы блогов
//	4 — администраторы сайта, администраторы блогов, модераторы блогов
//	5 — администраторы сайта, администраторы блогов, модераторы блогов, автор объекта (если он может видеть объект)
//	6 — все пользователи, которые имеют доступ к объекту на чтение
//	7 — все пользователи
//	8 — все
//		^ не работает для комментариев
// см. также ModuleACL::CheckSimpleAccessLevel
