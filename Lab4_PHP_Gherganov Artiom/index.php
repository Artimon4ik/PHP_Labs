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

// Сортировка по дате (от самой ранней к самой поздней)
usort($transactions, function($a, $b) {
    return strtotime($a['date']) <=> strtotime($b['date']);
});


// Сортировка по сумме по убыванию (от самой большой к самой маленькой)
usort($transactions, function($a, $b) {
    return $b['amount'] <=> $a['amount'];
});


?>

<table border="1" >
    <thead>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Description</th>
            <th>Merchant</th>
            <th>Days Since Transaction</th>
        </tr>
    </thead>

    <tbody>

<?php 
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
?>
    </tbody>
    <tfoot>
<?php
echo "<tr>";
    echo "<td colspan='6'><strong>Total: " . number_format(calculateTotalAmount($transactions), 2) . "</strong></td>";
echo "</tr>";
?>
    </tfoot>
</table>
</table>


<?php 
//Создайте функцию calculateTotalAmount(array $transactions): float, которая вычисляет общую сумму всех транзакций.
function calculateTotalAmount(array $transactions): float {
    $total = 0;
    foreach ($transactions as $transaction) {
        $total += $transaction['amount'];
    }
    return $total;
}
?>


<?php
//Создайте функцию findTransactionByDescription(string $descriptionPart), которая ищет транзакцию по части описания.
function findTransactionByDescription(array $transactions, string $descriptionPart): array {
    $found = [];

    foreach ($transactions as $transaction) {
        if (str_contains($transaction['description'], $descriptionPart)) {
            $found[] = $transaction;
        }
    }

    return $found;
   
}
?>

<?php
//Создайте функцию findTransactionById(int $id), которая ищет транзакцию по идентификатору

//forEach

function findTransactionById(array $transactions, int $id): array {
    foreach ($transactions as $transaction) {
        if ($transaction['id'] === $id) {
            return $transaction; 
        }
    }
    return []; // если не нашли, возвращаем пустой массив
}


?>


<?php
function daysSinceTransaction(string $date): int {
    $transactionDate = new DateTime($date);
    $today = new DateTime();
    $diff = $today->diff($transactionDate);
    return $diff->days;
}
?>

<?php
//Создайте функцию addTransaction(int $id, string $date, float $amount, string $description, string $merchant): void для добавления новой транзакции.


function addTransaction(int $id, string $date, float $amount, string $description, string $merchant): void {
    global $transactions; 
    $newTransaction = [
        "id" => $id,
        "date" => $date,
        "amount" => $amount,
        "description" => $description,
        "merchant" => $merchant,
    ];

    $transactions[] = $newTransaction; // добавляем в конец массива
}

?>











