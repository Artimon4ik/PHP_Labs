<?php
/*
$a = 0;
$b = 0;

for ($i = 0; $i <= 5; $i++) {
   $a += 10;
   $b += 5;
   echo "Шаг $i: a = $a, b= $b \n";  
   
}
echo "End of the loop: a = $a, b = $b";
*/

/*-----------------------------------------------*/

/*
$a = 0; 
$b = 0; 
$i = 0; 

while ($i <= 5) {
    $a += 10; 
    $b += 5;  
    echo "Шаг $i: a = $a, b = $b\n"; 
    $i++; 
}

echo "End of the loop: a = $a, b = $b";
*/

/*-----------------------------------------------*/

/*
do{
 $a += 10; 
    $b += 5;  
    echo "Шаг $i: a = $a, b = $b\n"; 
    $i++; 
}while($i <= 5);
echo "End of the loop: a = $a, b = $b";
*/

/*-----------------------------------------------*/





$day = date("N");


if ($day == 1 || $day == 3 || $day == 5) {
    $johnSchedule = "8:00-12:00";
} else {
    $johnSchedule = "Нерабочий день";
}


if ($day == 2 || $day == 4 || $day == 6) {
    $janeSchedule = "12:00-16:00";
} else {
    $janeSchedule = "Нерабочий день";
}
?>










<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Расписание</title>
</head>
<body>

<h2>Расписание на сегодня (<?php echo date("d.m.Y"); ?>)</h2>
<p>Сегодня день недели № <?php echo $day; ?></p>

<table border="1" cellpadding="8">
    <tr>
        <th>№</th>
        <th>Фамилия Имя</th>
        <th>График работы</th>
    </tr>
    <tr>
        <td>1</td>
        <td>John Styles</td>
        <td><?php echo $johnSchedule; ?></td>
    </tr>
    <tr>
        <td>2</td>
        <td>Jane Doe</td>
        <td><?php echo $janeSchedule; ?></td>
    </tr>
</table>

</body>
</html>
