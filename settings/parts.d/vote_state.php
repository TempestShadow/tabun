<?php

return [
    'comment' => [
        'as_date' => 1489132800,    // strtotime('2017-03-10')
        'oa_required_level' => 1,
        'na_required_level' => 6,   // Allow all allowed users to listen New Age
        'na_required_rating' => 10.0,
        'hide_voters_from_owner' => true,
        'date_sort' => SORT_ASC,
    ],
    'topic' => [
        'as_date' => 1489132800,    // strtotime('2017-03-10')
        'oa_required_level' => 1,
        'na_required_level' => 6,   // Allow all allowed users to listen New Age
        'na_required_rating' => false,
        'hide_voters_from_owner' => false,
        'date_sort' => SORT_ASC,
    ],
    'blog' => [
        'as_date' => 0,
        'oa_required_level' => 6,
        'na_required_level' => 6,   // Allow all allowed users to listen New Age
        'na_required_rating' => false,
        'hide_voters_from_owner' => false,
        'date_sort' => SORT_DESC,
    ],
    'user' => [
        'as_date' => 1357027200,    // strtotime('2013-01-01')
        'oa_required_level' => 1,
        'na_required_level' => 6,   // Allow all users to listen New Age
        'na_required_rating' => 10.0,
        'hide_voters_from_owner' => true,
        'date_sort' => SORT_DESC,
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
// na_required_rating — рейтинг, начиная с которого разрешено видеть список оценок (false или null для отключения ограничений)
// hide_voters_from_owner — скрыть голосующих от владельца объекта
// date_sort — режим сортировки голосов по дате: по возрастанию (SORT_ASC) или по убыванию (SORT_DESC)
