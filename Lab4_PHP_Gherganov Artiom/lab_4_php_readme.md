# Лабораторная работа №4  
## Массивы и функции в PHP

---

# Цель работы

Освоить работу с **массивами в PHP**, применяя основные операции:

- создание массивов  
- добавление элементов  
- удаление элементов  
- сортировка  
- поиск  

Также закрепить навыки работы с **функциями**, включая:

- передачу аргументов  
- возвращаемые значения  
- использование анонимных функций

---

# Задание 1. Работа с массивами

Необходимо разработать **систему управления банковскими транзакциями**, которая позволяет:

- хранить список транзакций  
- сортировать транзакции  
- искать транзакции  
- вычислять общую сумму операций  
- добавлять новые транзакции  
- определять сколько дней прошло с момента операции

---

# 1. Создание массива транзакций

Создаем массив `$transactions`, где каждая транзакция представлена **ассоциативным массивом**.

### Код

```php
<?php
declare(strict_types=1);

$transactions = [
    [
        "id" => 1,
        "date" => "2019-01-27",
        "amount" => 3000.50,
        "description" => "Payment for Birthday",
        "merchant" => "Supermarket-№1",
    ],
    [
        "id" => 2,
        "date" => "2020-06-20",
        "amount" => 400.00,
        "description" => "Dinner with friends",
        "merchant" => "Local Cafe",
    ],
    [
        "id" => 3,
        "date"=> "2021-07-22",
        "amount"=> 120.60,
        "description"=> "Payment for groceries",
        "merchant"=> "Linella",
    ]
];
```

![alt text](<Снимок экрана 2026-03-08 215858.png>)

> **Объяснение:**  
> - `$transactions` — массив транзакций  
> - Каждая транзакция — ассоциативный массив  
> - Ключи (`id`, `date`, `amount`, `description`, `merchant`) используются для доступа к данным

---

# 2. Сортировка транзакций

Для сортировки используется функция `usort()`, которая принимает:

- массив  
- функцию сравнения

### Сортировка по дате

```php
usort($transactions, function($a, $b) {
    return strtotime($a['date']) <=> strtotime($b['date']);
});
```

> **Объяснение:**  
> - `strtotime()` преобразует дату в timestamp  
> - `<=>` — оператор сравнения  
> - Сортировка от ранней даты к поздней

### Сортировка по сумме

```php
usort($transactions, function($a, $b) {
    return $b['amount'] <=> $a['amount'];
});
```

> **Объяснение:**  
> - Сравниваются суммы транзакций  
> - `$b['amount'] <=> $a['amount']` — сортировка по убыванию

---

# 3. Вывод транзакций в таблице

Для вывода используется цикл `foreach`.

### Код

```php
foreach ($transactions as $transaction) {
    echo "<tr>";
        echo "<td>" . $transaction["id"] . "</td>";
        echo "<td>" . $transaction["date"] . "</td>";
        echo "<td>" . $transaction["amount"]. "</td>";
        echo "<td>" . $transaction["description"] . "</td>";
        echo "<td>" . $transaction["merchant"] . "</td>";
        echo "<td>" . daysSinceTransaction($transaction['date']) . "</td>";
    echo "</tr>";
}
```

> **Объяснение:**  
> - `foreach` проходит по каждому элементу массива `$transactions`  
> - Для каждой транзакции создается строка `<tr>`  
> - Выводятся значения в ячейки `<td>`

---

# 4. Функция подсчёта общей суммы транзакций

### Код

```php
function calculateTotalAmount(array $transactions): float {
    $total = 0;
    foreach ($transactions as $transaction) {
        $total += $transaction['amount'];
    }
    return $total;
}
```

> **Объяснение:**  
> - Функция принимает массив транзакций  
> - Проходит по каждой транзакции  
> - Суммирует поле `amount`  
> - Возвращает итоговую сумму

---

# 5. Поиск транзакции по описанию

### Код

```php
function findTransactionByDescription(array $transactions, string $descriptionPart): array {
    $found = [];

    foreach ($transactions as $transaction) {
        if (str_contains($transaction['description'], $descriptionPart)) {
            $found[] = $transaction;
        }
    }

    return $found;
}
```

> **Объяснение:**  
> - Функция ищет транзакции, содержащие часть текста  
> - Используется `str_contains()`  
> - Найденные транзакции добавляются в массив `$found`

---

# 6. Поиск транзакции по ID

### Код

```php
function findTransactionById(array $transactions, int $id): array {
    foreach ($transactions as $transaction) {
        if ($transaction['id'] === $id) {
            return $transaction;
        }
    }
    return [];
}
```

> **Объяснение:**  
> - Функция проходит по массиву  
> - Проверяет совпадение `id`  
> - Возвращает найденную транзакцию  
> - Если не найдено — возвращает пустой массив

---

# 7. Количество дней с момента транзакции

### Код

```php
function daysSinceTransaction(string $date): int {
    $transactionDate = new DateTime($date);
    $today = new DateTime();
    $diff = $today->diff($transactionDate);
    return $diff->days;
}
```

> **Объяснение:**  
> - Используется класс `DateTime`  
> - Создаются объекты даты транзакции и текущей даты  
> - Метод `diff()` вычисляет разницу  
> - Возвращается количество дней

---

# 8. Добавление новой транзакции

### Код

```php
function addTransaction(int $id, string $date, float $amount, string $description, string $merchant): void {
    global $transactions;

    $newTransaction = [
        "id" => $id,
        "date" => $date,
        "amount" => $amount,
        "description" => $description,
        "merchant" => $merchant,
    ];

    $transactions[] = $newTransaction;
}
```

> **Объяснение:**  
> - Используется `global $transactions`  
> - Создаётся новый массив транзакции  
> - Добавляется в общий массив

---

# Задание 2. Галерея изображений

### Сканирование директории

```php
$dir = 'image/';
$files = scandir($dir);

if ($files === false) {
    echo "Папка с изображениями не найдена!";
    return;
}
```

> **Объяснение:**  
> - `scandir()` считывает файлы из директории  
> - Возвращает массив файлов

### Вывод изображений

```php
foreach ($files as $file) {
    if ($file != "." && $file != "..") {
        $path = $dir . $file;
        echo '<img src="' . $path . '" alt="image">';
    }
}
```

> **Объяснение:**  
> - "` .`" — текущая директория  
> - "`..`" — родительская директория  
> - Каждый файл выводится как HTML изображение

### CSS галереи

```css
.gallery {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 12px;
    max-width: 1200px;
    margin: 0 auto;
}

.gallery img {
    width: 100%;
    height: 120px;
    object-fit: cover;
}
```

> **Объяснение:**  
> - Используется CSS Grid  
> - Автоматическое выравнивание изображений  
> - Создаётся аккуратная сетка

---

# Контрольные вопросы

### 1. Что такое массивы в PHP?

> - Структура данных, хранящая несколько значений в одной переменной  
> - Типы массивов: индексированные, ассоциативные, многомерные

### 2. Как создать массив в PHP?

> - `$array = [];`  
> - `$array = array();`  
> - Можно сразу задать значения

### 3. Для чего используется `foreach`?

> - Для перебора элементов массива  
> - Выполняет код для каждого элемента

---

# Вывод

> В ходе работы изучены:  
> - работа с массивами  
> - функции с аргументами и возвращаемыми значениями  
> - сортировка и поиск  
> - работа с датами и файловой системой  

> Также реализованы:  
> - система обработки банковских транзакций  
> - галерея изображений  

> Полученные знания позволяют создавать динамические веб-приложения на PHP.
```

