<?php
namespace App\Imports;

use App\ClientAyersAccount;
use App\Traits\SMS;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ChunkReadListOfCustomersWhoFailedToPay implements ToCollection, WithChunkReading
{
    use SMS;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            dump($row);
            $ac = $row[0];
            $ClientAyersAccount = ClientAyersAccount::where('account_no', $ac)->first();
            if (is_object($ClientAyersAccount)) {
                $Client = $ClientAyersAccount->Client;
                $contents = [
                    '[中国银盛国际证券]',
                    "尊敬的客户，由于您开户时填写的民生银行信息没有填写「分行号码」，因此出款时被银行驳回提款，后台人员已帮您手动添加「分行号码」，请重新提交提款申请，后台人员会再次帮您处理出金，抱歉对您造成的不便。",
                ];
                $content = implode("\n", $contents);
                $response = $this->sendSMS($Client, $content);
                dump($response);
            }
            sleep(1);
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
