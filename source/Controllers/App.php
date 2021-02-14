<?php


namespace Source\Controllers;


use Source\Core\Controller;
use Source\Core\Session;
use Source\Core\View;
use Source\Models\Auth;
use Source\Models\User;
use Source\Models\WalletApp\AppCategory;
use Source\Models\WalletApp\AppInvoice;
use Source\Models\WalletApp\AppWallet;
use Source\Support\Email;
use Source\Support\Message;

class App extends Controller
{
    private ?User $user;

    public function __construct()
    {
        parent::__construct(__DIR__."/../../themes/".CONF_VIEW_APP."/");

        if (!Auth::user()){
            (new Message())->warning("Você precisa efetuar o login primeiro")->flash();
            redirect("/entrar");
        }

        $this->user = Auth::user();
    }

    public function home()
    {
        // CHART
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
            "user={$this->user->id}&status=paid",
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

        $income = (new AppInvoice())->find("user_id = :user AND status = :status AND type = 'income' AND due_at <= DATE(now() + INTERVAL 1 MONTH)", "user={$this->user->id}&status=unpaid")->order("due_at")->fetch(true);
        $expense = (new AppInvoice())->find("user_id = :user AND status = :status AND type = 'expense' AND due_at <= DATE(now() + INTERVAL 1 MONTH)", "user={$this->user->id}&status=unpaid")->order("due_at")->fetch(true);

        $wallets = (new AppWallet())->find("user_id = :user", "user={$this->user->id}", "id, wallet")->fetch(true);

        $wallet = (new AppInvoice())->find("user_id = :user AND status = :status",
            "user={$this->user->id}&status=paid",
            "
            (SELECT SUM(value) FROM app_invoices WHERE user_id = :user  AND status = :status AND type = 'income') AS income,
            (SELECT SUM(value) FROM app_invoices WHERE user_id = :user AND status = :status AND type = 'expense') AS expense
        ")->fetch();

        if ($wallet){
            $wallet->wallet = $wallet->income - $wallet->expense;
        }

        echo $this->view->render("home", [
            'chartData' => $chartData,
            'localPage' => "Controle",
            'income' => $income,
            'expense' => $expense,
            'wallet' => $wallet,
            'wallets' => $wallets
        ]);
    }

    public function launch(array $data)
    {
        if (request_limit("applaunch", 50, 60*5)){
            $json['message'] = $this->message->warning("Você fez mais de 50 requisições, tente novamente em 5 minutos")->render();
            echo json_encode($json);
            return;
        }

        if (!empty($data['enrollments']) && ($data['enrollments'] < 1 || $data['enrollments'] > 420)){
            $json['message'] = $this->message->warning("O numero de parcelas vai de 2 a 420")->render();
            echo json_encode($json);
            return;
        }

        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $status = (date($data['due_at']) <= date("Y-m-d") ? "paid" : "unpaid");

        $invoice = (new AppInvoice());
        $invoice->user_id = $this->user->id;
        $invoice->wallet_id = $data["wallet_id"];
        $invoice->category_id = $data["category_id"];
        $invoice->invoice_of = null;
        $invoice->description = $data["description"];
        $invoice->type = ($data["repeat_when"] == "fixed" ? "fixed_{$data['type']}" : $data['type']);
        $invoice->value = str_replace([".", ","], ["","."], $data["value"]);
        $invoice->currency = $data["currency"];
        $invoice->due_at = $data["due_at"];
        $invoice->repeat_when = $data["repeat_when"];
        $invoice->period = $data["period"];
        $invoice->enrollments =  $data['enrollments'];
        $invoice->enrollment_of = 1;
        $invoice->status = ($data["repeat_when"] == "fixed" ? "paid" : $status);

        if (!$invoice->save()){
            $json['message'] = $invoice->message()->render();
            echo json_encode($json);
            return;
        }

        if ($invoice->repeat_when  == "enrollment"){
            $invoiceOf = $invoice->id;
            for ($enrollment = 1; $enrollment < $invoice->enrollments; $enrollment++){
                $invoice->id = null;
                $invoice->invoice_of = $invoiceOf;
                $invoice->due_at = date("Y-m-d", strtotime($data["due_at"] . "+ {$enrollment}month"));
                $invoice->status = (date($invoice->due_at) <= date("Y-m-d") ? "paid" : "unpaid");
                $invoice->enrollment_of = $enrollment + 1;
                $invoice->save();
            }
        }

        if ($invoice->type == "income"){
            (new Message())->success("Receita cadastrada com successo!")->flash();
        } else {
            (new Message())->success("Despesa cadastrada com successo!")->flash();
        }


        $json["invoice"] = $invoice->data();
        $json["redirect"] = url("/app");
        echo json_encode($json);
    }

    public function filter(array $data)
    {
        if (!empty($data)){
            $data = filter_var_array($data , FILTER_SANITIZE_STRIPPED);
            $status = (empty($data["status"]) ? "all" : $data["status"]);
            $category = (empty($data["category"]) ? "all" : $data["category"]);
            $date = (!empty($data["date"]) ? $data["date"] : date("m/Y"));
            list($m, $y) = explode("/", $date);
            $m = ($m >= 1 && $m <= 12 ? $m : date("m"));
            $y = ($y <= date("Y", strtotime("+10year")) ? $y : date("Y", strtotime("+10year")));
            $redirectFor = ($data["filter"] == "income" ? "receber" : "pagar");

            $start = new \DateTime(date("Y-m-t"));
            $end = new \DateTime(date("Y-m-t", strtotime("{$y}-{$m}+1month")));
            $diff = $start->diff($end);

            if (!$diff->invert){
                $afterMonths = (floor($diff->days / 30));
                (new AppInvoice())->fixed($this->user, $afterMonths);
            }

            $json["redirect"] = url("/app/{$redirectFor}/{$status}/{$category}/{$m}-{$y}");
            echo json_encode($json);
            return;
        }
        $json["message"] = $data;
        echo json_encode($json);
    }

    public function onpaid(array $data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        $invoice = (new AppInvoice())->find("user_id = :user AND id = :id", "user={$data['user_id']}&id={$data['id']}")->fetch();
        $status = ($data["status"] == "unpaid" ? "paid" : "unpaid");
        if ($status){
            $invoice->status = $status;
            $invoice->save();
            $json["user"] = $invoice->user_id;
            $json["id"] = $invoice->id;
            $json["status"] = $invoice->status;
            echo json_encode($json);
        } else {
            $json["redirect"] = url("/app");
            echo json_encode($json);
        }
    }

    public function income(?array $data)
    {
        $categories = (new AppCategory())
            ->find("type = :t", "t=income", "id, name")
            ->order("order_by, name")
            ->fetch(true);

        echo $this->view->render("invoices", [
            "categories" => $categories,
            "type" => "income",
            "invoices" => (new AppInvoice())->filter_invoices($this->user, "income", ($data ?? null)),
            "filter" => (object)[
                "status" => ($data["status"] ?? null),
                "category" => ($data["category"] ?? null),
                "date" => (!empty($data["date"]) ? str_replace("-", "/", $data["date"]) : null)
            ]
        ]);
    }

    public function expense(?array $data)
    {
        $categories = (new AppCategory())
            ->find("type = :t", "t=expense", "id, name")
            ->order("order_by, name")
            ->fetch(true);

        echo $this->view->render("invoices", [
            "categories" => $categories,
            "type" => "expense",
            "invoices" => (new AppInvoice())->filter_invoices($this->user, "expense", ($data ?? null)),
            "filter" => (object)[
                "status" => ($data["status"] ?? null),
                "category" => ($data["category"] ?? null),
                "date" => (!empty($data["date"]) ? str_replace("-", "/", $data["date"]) : null)
            ]
        ]);
    }

    public function support(?array $data)
    {
        if (!empty($data)){

            if (empty($data["message"] || empty($data["subject"]))){
                $json["message"] = $this->message->warning("Por favor, preencha todos os campos para continuar!")->render();
                echo json_encode($json);
                return;
            }

            if (request_limit("appsupport", 3, 60 * 5)){
                $json["message"] = $this->message->warning("Por favor, aguarde mais 5 minutos para enviar outro pedido de suporte")->render();
                echo json_encode($json);
                return;
            }

            if (request_repeat("message", $data["message"])){
                $json["message"] = $this->message->warning("ja recebemos sua mensagem, agradecemos pelo contato e responderemos em breve.")->render();
                echo json_encode($json);
                return;
            }

            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
            $subject = date_fmt() . " - {$data["subject"]}";
            $message = $data["message"];
            $view = new View(__DIR__."/../../shared/views/email");

            $body = $view->render("support", [
                "subject" => $subject,
                "message" => str_textarea($message),
                "userEmail" => $this->user->email
            ]);

            (new Email())->bootstrap($subject,
                $body,
                CONF_MAIL_SUPPORT,
                "{$this->user->first_name} {$this->user->last_name}"
            )->send(CONF_MAIL_SENDER["address"], "Suporte ". CONF_MAIL_SENDER["name"]);

            $json["message"] = $this->message->success("Mensagem enviada com sucesso! Agradecemos o seu contato e iremos responder em breve.")->render();
            echo json_encode($json);
            return;
        }

        echo $this->view->render('support', [

        ]);
    }

    public function invoice(array $data)
    {

        if ($data["remove"]){
            $invoice = (new AppInvoice())->find("user_id = :user AND id = :id", "user={$this->user->id}&id={$data["remove"]}")->fetch();
            $urlRedirect = (($invoice->type == "income" ? "receber" : "pagar") ?? "");
            if ($invoice->destroy()){
                (new Message())->success("Fatura deletada com sucesso!")->flash();
                redirect(url("/app/{$urlRedirect}"));
            } else {
                (new Message())->error("Não foi possivel deletar a fatura, verifique os dados ou entre em contato com o suporte!")->flash();
                redirect(url("/app/{$urlRedirect}"));
            }
            return;
        }

        $invoice = (new AppInvoice())->find("user_id = :user AND id = :id",
            "user={$this->user->id}&id={$data["invoice"]}")->fetch();

        $categories = (new AppCategory())->find("type = :t", "t={$invoice->type}", "id, name")->fetch(true);

        $wallets = (new AppWallet())->find("user_id = :id", "id={$this->user->id}", "id, wallet")->fetch(true);

        echo $this->view->render('invoice', [
            "invoice" => $invoice,
            "categories" => $categories,
            "wallets" => $wallets
        ]);
    }


    public function logout()
    {
        $this->message->info("Até logo {$this->user->first_name}! Você saiu com sucesso.")->flash();
        (new Session())->unset("authUser");
        redirect(url("/entrar"));
    }

}