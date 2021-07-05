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
                    "尊敬的客户，您开户时填写的银行账户名称为“花旗银行”，与您实际的银行账户名称不同，请您登陆账户总览，然后选择“添加银行卡”，提交您实际的银行卡账户信息，等候后台人员审批后，便可再次尝试提交出款申请。",
                    "账户总览链接：https://pysao.chinayss.hk/",
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
