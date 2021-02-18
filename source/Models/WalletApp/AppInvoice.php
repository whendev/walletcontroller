<?php


namespace Source\Models\WalletApp;


use Exception;
use Source\Core\Model;
use Source\Models\User;

/**
 * Class AppInvoice
 * @package Source\Models\WalletApp
 */
class AppInvoice extends Model
{
    /**
     * AppInvoice constructor.
     */
    public function __construct()
    {
        parent::__construct("app_invoices", ["user_id", "wallet_id", "category_id", "description", "type", "value", "due_at", "repeat_when"], ["id"]);
    }

    public function balanceMonth(User $user): \stdClass
    {
        $dateChart = [];
        for ($month = -4; $month <= 0; $month++){
            $dateChart[] = date("m/Y", strtotime("{$month}month"));
        }

        $chartData = new \stdClass();
        $chartData->categories = "'". implode("','", $dateChart). "'";
        $chartData->expense = "0,0,0,0,0";
        $chartData->income = "0,0,0,0,0";

        $chart = (new AppInvoice())->find(
            "user_id = :user AND status = :status AND due_at >= DATE(now() - INTERVAL 4 MONTH) ORDER BY year(due_at) ASC, month(due_at) ASC",
            "user={$user->id}&status=paid",
            "year(due_at) AS due_year,
                    month(due_at) AS due_month,
                    DATE_FORMAT(due_at, '%m-%Y') AS due_date,
                     (SELECT sum(value) FROM app_invoices WHERE user_id = :user AND year(due_at) = due_year AND month(due_at) = due_month AND status = :status AND type = 'income') AS income,   
                     (SELECT sum(value) FROM app_invoices WHERE user_id = :user AND year(due_at) = due_year AND month(due_at) = due_month AND status = :status AND type = 'expense') AS expense
                    "
        )->limit(5)->fetch(true);

        if ($chart){
            $chartCategories = [];
            $chartIncome = [];
            $chartExpense = [];
            foreach ($chart as $chartItem){
                $chartCategories[] = $chartItem->due_date;
                $chartExpense[] = ($chartItem->expense ?? "0");
                $chartIncome[] = ($chartItem->income ?? "0");
            }

            $chartData->categories = "'". implode("','", $chartCategories). "'";
            $chartData->income = "'". implode("','", $chartIncome). "'";
            $chartData->expense= "'". implode("','", $chartExpense). "'";
        }
        return $chartData;
    }

    public function balanceWallet(User $user): ?AppInvoice
    {
        $wallet = (new AppInvoice())->find("user_id = :user AND status = :status",
            "user={$user->id}&status=paid",
            "
            (SELECT SUM(value) FROM app_invoices WHERE user_id = :user  AND status = :status AND type = 'income') AS income,
            (SELECT SUM(value) FROM app_invoices WHERE user_id = :user AND status = :status AND type = 'expense') AS expense
        ")->fetch();

        if ($wallet){
            $wallet->wallet = $wallet->income - $wallet->expense;
        }

        return $wallet;
    }

    /**
     * @param User $user
     * @param int $afterMonth
     * @throws Exception
     */
    public function fixed(User $user, int $afterMonth = 1)
    {

        $fixed = $this->find("user_id = :user AND status = 'paid' AND type IN('fixed_income', 'fixed_expense')", "user={$user->id}")->fetch(true);

        if (!$fixed){
            return;
        }

        foreach ($fixed as $fixedItem){
            $invoice = $fixedItem->id;
            $start = new \DateTime($fixedItem->due_at);
            $end = new \DateTime("+{$afterMonth}month");
            $interval = null;
            if ($fixedItem->period == "month"){
                $interval = new \DateInterval("P1M");
            }

            if ($fixedItem->period == "year"){
                $interval = new \DateInterval("P1Y");
            }

            $period = new \DatePeriod($start, $interval, $end);
            foreach ($period as $item){
                $getFixed = $this->find("user_id = :user AND invoice_of = :of AND year(due_at) = :y AND month(due_at) = :m",
                    "user={$user->id}&of={$fixedItem->id}&y={$item->format("Y")}&m={$item->format("m")}")->fetch();

                if (!$getFixed){
                    $newItem = $fixedItem;
                    $newItem->id = null;
                    $newItem->invoice_of = $invoice;
                    $newItem->type = str_replace("fixed_", "" ,$newItem->type);
                    $newItem->due_at = $item->format("Y-m-d");
                    $newItem->status = ($item->format("Y-m-d") <= date("Y-m-d") ? "paid" : "unpaid");
                    $newItem->save();
                }
            }
        }
    }

    /**
     * @param User $user
     * @param string $type
     * @param array|null $filter
     * @param int|null $limit
     * @return array|null
     */
    public function filter_invoices(User $user, string $type, ?array $filter, ?int $limit = null): ?array
    {
        $status = (!empty($filter["status"]) && $filter["status"] == "paid" ? "AND status = 'paid'" : (!empty($filter["status"]) && $filter["status"] == "unpaid" ? "AND status = 'unpaid'" : null));
        $category = (!empty($filter["category"]) && $filter["category"] != "all" ? "AND category_id = '{$filter['category']}'" : null);

        $due_year = (!empty($filter["date"]) ? explode("-", $filter["date"])[1] : date("Y"));
        $due_month = (!empty($filter["date"]) ? explode("-", $filter["date"])[0] : date("m"));
        $due_at = "AND (year(due_at)) = '{$due_year}' AND month(due_at) = '{$due_month}'";

        $due = $this->find("user_id = :user AND type = :type {$status} {$category} {$due_at}", "user={$user->id}&type={$type}")->order("day(due_at) ASC");

        if ($limit){
            $due->limit($limit);
        }

        return $due->fetch(true);
    }

    /**
     * @return AppCategory
     */
    public function category(): AppCategory
    {
        return (new AppCategory())->findById($this->category_id);
    }

}