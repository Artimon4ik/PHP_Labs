<?php

interface Validator {
    public function validate($data);
}

class SimpleValidator implements Validator {

    public function validate($data) {

        $errors = [];

        if ($data['title'] == '') $errors[] = "Нет названия";
        if ($data['description'] == '') $errors[] = "Нет описания";
        if ($data['subject'] == '') $errors[] = "Нет предмета";
        if ($data['deadline'] == '') $errors[] = "Нет даты";

        if (!in_array($data['priority'], ['low','medium','high'])) {
            $errors[] = "Ошибка приоритета";
        }

        if (!in_array($data['status'], ['not_done','done'])) {
            $errors[] = "Ошибка статуса";
        }

        return $errors;
    }
}