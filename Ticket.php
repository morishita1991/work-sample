<?php
include_once './CliApp.php';
include_once './TicketType.php';
include_once './AgeCategory.php';
include_once './NumberOfTickets.php';

/**
 * アプリケーション本体
 *
 * Appクラスを「継承」して、アプリケーションに必要なロジックをここに記述します。
 */
class Ticket extends CliApp
{
    private $type;

    private $category;

    private $number;

    private array $detail;

    /**
     * チケットの登録：必要な情報を入力してもらう
     * @param Ticket $ticket
     * @return void
     */
    public function register(Ticket $ticket)
    {
        $ticketType = new TicketType();
        $ticketType->listen();
        
        $ageCategory = new AgeCategory();
        $ageCategory->listen();
        
        $numberOfTickets = new NumberOfTickets();
        $numberOfTickets->listen();
        
        $ticket->add($ticketType, $ageCategory, $numberOfTickets);
        $ticket->confirm();
        $this->line('');
        $ticket->listen();
    }

    public function listen()
    {
        [
            'result' => $result,
            'error' => $error
        ] = $this->validate();

        if ($result === false) {
            $this->line($error);
            $this->listen();
        }
        if ($result === 1) {
            $this->register($this);
        }
        if ($result === 2) {
            return;
        }
    }

    public function add(
        TicketType $ticketType,
        AgeCategory $ageCategory,
        NumberOfTickets $numberOfTickets
    ) {
        $this->type = $ticketType->type;
        $this->category = $ageCategory->category;
        $this->number = $numberOfTickets->number;

        $this->detail[$this->type][$this->category] ??= 0;
        $this->detail[$this->type][$this->category] += $this->number;
    }

    public function confirm()
    {
        $list = $this->confirmMessageList();
        array_map(fn($m) => $this->line($m), $list);
    }

    private function confirmMessageList(): array
    {
        $list = [];
        if (empty($this->detail)) {
            $list[] = '現在、登録されているチケットはありません。';
            $list[] = '';
            return $list;
        }
        $list[] = '';
        $list[] = '現在、以下の内容が登録されています。';
        $list[] = '';
        foreach($this->detail as $type => $arr) {
            foreach ($arr as $category => $number) {
                $list[] = "{$type}チケット: {$category} {$number}枚";
            }
        }
        return $list;
    }

    /**
     * チケットの枚数
     * 不正な値の場合は、エラーメッセージを返します。
     * @return array{result:false|int,error:string}
     */
    private function validate()
    {
        $input = $this->ask('ほかにチケットを登録しますか？ はい「1」, いいえ「2」 : ');
        if (!is_numeric($input)) {
            return $this->inputError('半角数字で入力してください。');
        }
        $value = intval($input);
        if (!in_array($value, [1, 2], true)) {
            return $this->inputError('指定外の数字は入力しないでください。');
        }
        return $this->inputSuccess($value);
    }
}