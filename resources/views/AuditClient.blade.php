@extends('layouts.app')

@section('content')
    <audit-client :uuid="'{{ $uuid }}'" :地區="'{{ $地區 }}'" :介紹人="'{{ $介紹人 }}'"
        :姓名="'{{ $姓名 }}'" :英文名="'{{ $英文名 }}'" :性別="'{{ $性別 }}'" :手機號碼="'{{ $手機號碼 }}'"
        :出生日期="'{{ $出生日期 }}'" :住址="'{{ $住址 }}'" :證件號碼="'{{ $證件號碼 }}'"
        :idcard_face="'{{ $idcard_face }}'" :idcard_back="'{{ $idcard_back }}'" :銀行="'{{ $銀行 }}'"
        :銀行卡號="'{{ $銀行卡號 }}'" :backcard_face="'{{ $backcard_face }}'" :教育程度="'{{ $教育程度 }}'"
        :工作狀態="'{{ $工作狀態 }}'" :雇主名稱="'{{ $雇主名稱 }}'" :公司電話="'{{ $公司電話 }}'"
        :公司地址="'{{ $公司地址 }}'" :業務性質="'{{ $業務性質 }}'" :服務年資="'{{ $服務年資 }}'"
        :職位="'{{ $職位 }}'" :name_card_face="'{{ $name_card_face }}'" :資金來源="'{{ $資金來源 }}'"
        :其他資金來源="'{{ $其他資金來源 }}'" :每年收入="'{{ $每年收入 }}'" :資產項目="'{{ $資產項目 }}'"
        :其他資產="'{{ $其他資產 }}'" :資產淨值="'{{ $資產淨值 }}'" :投資目標="'{{ $投資目標 }}'"
        :股票="'{{ $股票 }}'" :衍生認股證="'{{ $衍生認股證 }}'" :牛熊證="'{{ $牛熊證 }}'"
        :期貨及期權="'{{ $期貨及期權 }}'" :債券基金="'{{ $債券基金 }}'" :其他投資經驗="'{{ $其他投資經驗 }}'"
        :是否有意進行衍生產品投資="'{{ $是否有意進行衍生產品投資 }}'" :問卷調查="{{ $問卷調查 }}" :用戶是否同意="{{ $用戶是否同意 }}"
        :簽名="'{{ $簽名 }}'" :直接促銷="'{{ $直接促銷 }}'" :action="'{{ route('audit1') }}'"
        :redirect_route="'{{ $redirect_route }}'" :next_status="'{{ $next_status }}'">
    </audit-client>
@endsection
