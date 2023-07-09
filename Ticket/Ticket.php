<?php
include_once './CliApp.php';
include_once 'TicketType/TicketType.php';
include_once 'AgeCategory/AgeCategory.php';
include_once 'Quantity.php';

class Ticket extends CliApp
{
    private $type;

    private $category;

    private $quantity;

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

        $quantity = new Quantity();
        $quantity->listen();
        
        $ticket->add($ticketType, $ageCategory, $quantity);
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
        if ($result === 3) {
            // 最初から
            (new Casher)->Execute();
        }
    }

    public function add(
        TicketType $ticketType,
        AgeCategory $ageCategory,
        Quantity $quantity
    ) {
        $this->type = $ticketType->type;
        $this->category = $ageCategory->category;
        $this->quantity = $quantity->number;

        $this->detail[$this->type][$this->category] ??= 0;
        $this->detail[$this->type][$this->category] += $this->quantity;
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
                $typeName = TicketType::LIST[$type];
                $categoryName = AgeCategory::LIST[$category];
                $list[] = "{$typeName}チケット: {$categoryName} {$number}枚";
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
        $input = $this->ask('ほかにチケットを登録しますか？ はい「1」, いいえ「2」, 最初からやり直す「3」 : ');
        $this->line('');
        if (!is_numeric($input)) {
            return $this->inputError('半角数字で入力してください。');
        }
        $value = intval($input);
        if (!in_array($value, [1, 2, 3], true)) {
            return $this->inputError('指定外の数字は入力しないでください。');
        }
        return $this->inputSuccess($value);
    }
}