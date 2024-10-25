<?php

function string_processing($s) { // функция обработки строк
    $s = strip_tags($s); // удаляем HTML, PHP, XML теги    
    $s = trim($s); // убираем лишние пробелы в начале или конце строки
    $s = mb_convert_case(substr($s, 0, 2), MB_CASE_TITLE, "UTF-8") . substr($s, 2); // приводим первые символы к верхнему регистру
    $s = htmlspecialchars($s); // преобразуем специальные символы в HTML сущности
    return $s;
}

$file = file('test.xml'); // читаем файл

$section = 0; // счетчик вопросов
// $subsection = 0; // счетчик подвопросов
$first_question = true; // первый вопрос

echo '<style> p {margin-left:40px; margin-top: 0px; margin-bottom: 0px;} </style>'; // стиль для отступов

foreach ($file as $str) { // обходим все строки
    
    if (preg_match('/<question.*>/', $str)) { // если найдена строка с вопросом 
        if ($first_question) 
            $first_question = false; 
        else 
            echo '<br>'; // перенос
    }
    
    if (preg_match('/<name>/', $str)) { // если найдена строка с именем
        $section++; // увеличиваем счетчик вопросов
        $str = string_processing($str); // обрабатываем строку

        echo $section, '. ', $str; // выводим номер вопроса и его текст
        $subsection = 0; // сбрасываем счетчик подвопросов
    }
    
    if (preg_match('/<answer.*?.">/', $str)) { // если найдена строка с ответом
        $subsection++; // увеличиваем счетчик подвопросов
        $str = string_processing($str); // обрабатываем строку
        echo '<p>', $section, '.', $subsection, ' ', $str, '</p>'; // выводим номер вопроса и подвопроса и текст ответа
    }
}

