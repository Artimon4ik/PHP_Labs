<?php
declare(strict_types=1);

// Класс Transaction — описывает одну транзакцию
class Transaction {
    private int $id;
    private string $date;
    private float $amount;
    private string $description;
    private string $merchant;

    public function __construct(
        int $id,
        string $date,
        float $amount,
        string $description,
        string $merchant
    ) {
        $this->id = $id;
        $this->date = $date;
        $this->amount = $amount;
        $this->description = $description;
        $this->merchant = $merchant;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getDate(): string {
        return $this->date;
    }

    public function getAmount(): float {
        return $this->amount;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getMerchant(): string {
        return $this->merchant;
    }

    public function getDaysSinceTransaction(): int {
        $transactionDate = new DateTime($this->date);
        $today = new DateTime();
        return $today->diff($transactionDate)->days;
    }
}

//Интерфейс хранилища
 
interface TransactionStorageInterface {
    public function addTransaction(Transaction $transaction): void;
    public function removeTransactionById(int $id): void;
    public function getAllTransactions(): array;
    public function findById(int $id): ?Transaction;
}


//Репозиторий транзакций
class TransactionRepository implements TransactionStorageInterface {
    private array $transactions = [];

    public function addTransaction(Transaction $transaction): void {
        $this->transactions[] = $transaction;
    }

    public function removeTransactionById(int $id): void {
        foreach ($this->transactions as $key => $transaction) {
            if ($transaction->getId() === $id) {
                unset($this->transactions[$key]);
            }
        }
    }

    public function getAllTransactions(): array {
        return $this->transactions;
    }

    public function findById(int $id): ?Transaction {
        foreach ($this->transactions as $transaction) {
            if ($transaction->getId() === $id) {
                return $transaction;
            }
        }
        return null;
    }
}


//Менеджер бизнес-логики

class TransactionManager {
    public function __construct(
        private TransactionStorageInterface $repository
    ) {}

    public function calculateTotalAmount(): float {
        $total = 0;
        foreach ($this->repository->getAllTransactions() as $t) {
            $total += $t->getAmount();
        }
        return $total;
    }

    public function calculateTotalAmountByDateRange(string $start, string $end): float {
        $total = 0;
        foreach ($this->repository->getAllTransactions() as $t) {
            if ($t->getDate() >= $start && $t->getDate() <= $end) {
                $total += $t->getAmount();
            }
        }
        return $total;
    }

    public function countTransactionsByMerchant(string $merchant): int {
        $count = 0;
        foreach ($this->repository->getAllTransactions() as $t) {
            if ($t->getMerchant() === $merchant) {
                $count++;
            }
        }
        return $count;
    }

    public function sortTransactionsByDate(): array {
        $transactions = $this->repository->getAllTransactions();
        usort($transactions, fn($a, $b) => strtotime($a->getDate()) <=> strtotime($b->getDate()));
        return $transactions;
    }

    public function sortTransactionsByAmountDesc(): array {
        $transactions = $this->repository->getAllTransactions();
        usort($transactions, fn($a, $b) => $b->getAmount() <=> $a->getAmount());
        return $transactions;
    }
}


//Класс для вывода таблицы

final class TransactionTableRenderer {
    public function render(array $transactions): string {
        $html = "<table border='1'>";
        $html .= "<tr>
            <th>ID</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Description</th>
            <th>Merchant</th>
            <th>Days</th>
        </tr>";

        foreach ($transactions as $t) {
            $html .= "<tr>";
            $html .= "<td>{$t->getId()}</td>";
            $html .= "<td>{$t->getDate()}</td>";
            $html .= "<td>{$t->getAmount()}</td>";
            $html .= "<td>{$t->getDescription()}</td>";
            $html .= "<td>{$t->getMerchant()}</td>";
            $html .= "<td>{$t->getDaysSinceTransaction()}</td>";
            $html .= "</tr>";
        }

        $html .= "</table>";
        return $html;
    }
}

//Инициализация данных
$repo = new TransactionRepository();

$repo->addTransaction(new Transaction(1, "2023-01-01", 100, "Groceries", "Linella"));
$repo->addTransaction(new Transaction(2, "2023-02-01", 200, "Dinner", "KFC"));
$repo->addTransaction(new Transaction(3, "2023-03-01", 150, "Fuel", "Rompetrol"));
$repo->addTransaction(new Transaction(4, "2023-04-01", 300, "Clothes", "Puma"));
$repo->addTransaction(new Transaction(5, "2023-05-01", 120, "Books", "Carturesti"));
$repo->addTransaction(new Transaction(6, "2023-06-01", 80, "Coffee", "Bonjour Café"));
$repo->addTransaction(new Transaction(7, "2023-07-01", 500, "Electronics", "Altex"));
$repo->addTransaction(new Transaction(8, "2023-08-01", 60, "Taxi", "Bolt"));
$repo->addTransaction(new Transaction(9, "2023-09-01", 90, "Cinema", "Cineplex"));
$repo->addTransaction(new Transaction(10, "2023-10-01", 250, "Hotel", "Booking"));

$manager = new TransactionManager($repo);
$renderer = new TransactionTableRenderer();

$transactions = $manager->sortTransactionsByAmountDesc();

echo $renderer->render($transactions);

echo "<p>Total: " . $manager->calculateTotalAmount() . "</p>";