<?php

require 'Validator.php';
require 'Storage.php';

$storage = new Storage();
$validator = new SimpleValidator();

$data = $storage->getAll();
$errors = [];

// СОРТИРОВКА
$sort = $_GET['sort'] ?? 'title';

usort($data, function ($a, $b) use ($sort) {
    return strcmp($a[$sort], $b[$sort]);
});

// ОБРАБОТКА
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $task = [
        'title' => trim($_POST['title'] ?? ''),
        'description' => trim($_POST['description'] ?? ''),
        'subject' => trim($_POST['subject'] ?? ''),
        'deadline' => $_POST['deadline'] ?? '',
        'priority' => $_POST['priority'] ?? '',
        'status' => $_POST['status'] ?? ''
    ];

    $errors = $validator->validate($task);

    if (empty($errors)) {

        $task['created_at'] = date("Y-m-d");

        $data[] = $task;

        $storage->save($data);

        header("Location: index.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Менеджер задач</title>

<link rel="stylesheet" href="css/style.css">

</head>
<body>

<div class="container">

<h2>Добавить задачу</h2>

<form method="POST">

<input name="title" placeholder="Название" required>

<textarea name="description" placeholder="Описание" required></textarea>

<input name="subject" placeholder="Предмет" required>

<input type="date" name="deadline" required>

<select name="priority">
    <option value="low">Низкий</option>
    <option value="medium">Средний</option>
    <option value="high">Высокий</option>
</select>

<select name="status">
    <option value="not_done">Не выполнено</option>
    <option value="done">Выполнено</option>
</select>

<button>Добавить</button>

</form>

<?php if (!empty($errors)): ?>
    <div style="color:red;">
        <?php foreach ($errors as $e) echo "<div>$e</div>"; ?>
    </div>
<?php endif; ?>

<h2>Список задач</h2>

<table>

<tr>
    <th>Название</th>
    <th>Описание</th>
    <th>Предмет</th>
    <th>Дедлайн</th>
    <th>Приоритет</th>
    <th>Статус</th>
</tr>

<?php foreach ($data as $task): ?>
<tr>
    <td><?= htmlspecialchars($task['title']) ?></td>
    <td><?= htmlspecialchars($task['description']) ?></td>
    <td><?= htmlspecialchars($task['subject']) ?></td>
    <td><?= htmlspecialchars($task['deadline']) ?></td>
    <td><?= htmlspecialchars($task['priority']) ?></td>
    <td><?= htmlspecialchars($task['status']) ?></td>
</tr>
<?php endforeach; ?>

</table>

</div>

</body>
</html>