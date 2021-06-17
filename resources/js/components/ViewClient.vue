<template>
  <form :action="action" method="POST">
    <input type="hidden" name="uuid" v-model="Client.uuid" />
    <input type="hidden" name="redirect_route" v-model="redirect_route" />
    <input type="hidden" name="next_status" v-model="next_status" />
    <table class="table table-bordered text-light">
      <thead>
        <tr>
          <th colspan="6">
            <h5 class="mb-0">基礎信息</h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="17%">地區</th>
          <td width="17%" class="text-warning">
            {{ 地區map[Client.nationality] }}
          </td>
          <th width="17%">開通賬戶</th>
          <td width="17%" class="text-warning">證券（現金）賬戶</td>
          <th width="17%">介紹人</th>
          <td width="17%" class="text-warning">
            {{ Introducer.name }} ({{ Introducer.type }})
          </td>
        </tr>
      </tbody>
    </table>
    <table v-if="ClientAddressProof" class="table table-bordered text-light">
      <thead>
        <tr>
          <th colspan="3">
            <h5 class="mb-0">住址證明</h5>
          </th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="20%">地址</th>
          <td width="20%" class="text-warning">
            {{ ClientAddressProof.address_text }}
          </td>
          <td width="40%">
            <img style="width: 500px" :src="address_proof" />
          </td>
          <td width="20%">
            <b-form-textarea
              class="bg-secondary text-white"
              v-if="ClientAddressProof.remark"
              name="駁回住址證明"
              style="width: 100%"
              placeholder="請寫駁回理由"
              rows="10"
              v-model="ClientAddressProof.remark"
              readonly
            ></b-form-textarea>
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered text-light">
      <thead>
        <tr>
          <th colspan="4">
            <h5 class="mb-0">身份證信息</h5>
          </th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="20%">姓名</th>
          <td width="20%" class="text-warning">
            {{ ClientIDCard.name_c }}
          </td>
          <th width="20%">英文名</th>
          <td width="20%" class="text-warning">
            {{ ClientIDCard.name_en }}
          </td>
          <td width="20%">
            <b-form-textarea
              class="bg-secondary text-white"
              v-if="ClientIDCard.remark"
              name="駁回身份證信息"
              style="width: 100%"
              placeholder="請寫駁回理由"
              rows="10"
              v-model="ClientIDCard.remark"
              readonly
            ></b-form-textarea>
          </td>
        </tr>
        <tr>
          <th>性別</th>
          <td class="text-warning">
            {{ ClientIDCard.gender }}
          </td>
          <th>手機號碼</th>
          <td class="text-warning">
            {{ Client.mobile }}
          </td>
        </tr>
        <tr>
          <th>出生日期</th>
          <td class="text-warning">
            {{ ClientIDCard.birthday }}
          </td>
          <th>證件類型</th>
          <td class="text-warning">
            {{ ClientIDCard.passport_type }}
          </td>
        </tr>
        <tr>
          <th>住址</th>
          <td class="text-warning">
            {{ ClientIDCard.address }}
          </td>
          <th>證件號碼</th>
          <td class="text-warning">
            {{ ClientIDCard.idcard_no }}
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <img style="width: 300px" :src="idcard_face" />
          </td>
          <td colspan="2">
            <img style="width: 300px" :src="idcard_back" />
          </td>
        </tr>
      </tbody>
    </table>
    <table
      v-for="銀行卡 in 銀行卡s"
      :key="銀行卡.id"
      class="table table-bordered text-light"
    >
      <thead>
        <tr>
          <th colspan="4">
            <h5 v-if="銀行卡.lcid == 'zh-hk'" class="mb-0">香港銀行卡信息</h5>
            <h5 v-else-if="銀行卡.lcid == 'zh-cn'" class="mb-0">
              大陸銀行卡信息
            </h5>
            <h5 v-else-if="銀行卡.lcid == 'others'" class="mb-0">銀行卡信息</h5>
          </th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="20%">
            <div v-if="銀行卡.lcid == 'zh-hk'" class="mb-0">香港銀行名</div>
            <div v-else-if="銀行卡.lcid == 'zh-cn'" class="mb-0">
              大陸銀行名
            </div>
            <div v-else-if="銀行卡.lcid == 'others'" class="mb-0">銀行名</div>
          </th>
          <td width="20%" class="text-warning">
            {{ 銀行卡.bank_name }} ({{ 銀行卡.bank_code }})
          </td>
          <th width="20%">
            <div v-if="銀行卡.lcid == 'zh-hk'" class="mb-0">香港銀行卡號</div>
            <div v-else-if="銀行卡.lcid == 'zh-cn'" class="mb-0">
              大陸銀行卡號
            </div>
            <div v-else-if="銀行卡.lcid == 'others'" class="mb-0">銀行卡號</div>
          </th>
          <td width="20%" class="text-warning">
            {{ 銀行卡.account_no }}
          </td>
          <td width="20%" rowspan="2">
            <b-form-textarea
              class="bg-secondary text-white"
              v-if="銀行卡.remark"
              :name="'駁回' + 銀行卡.lcid + '銀行卡信息'"
              style="width: 100%"
              placeholder="請寫駁回理由"
              rows="10"
              v-model="銀行卡.remark"
              readonly
            ></b-form-textarea>
          </td>
        </tr>
        <tr>
          <td colspan="4">
            <img
              v-if="銀行卡.lcid == 'zh-hk'"
              style="width: 300px"
              :src="hk_backcard_face"
            />
            <img
              v-else-if="銀行卡.lcid == 'zh-cn'"
              style="width: 300px"
              :src="cn_backcard_face"
            />
            <img
              v-else-if="銀行卡.lcid == 'others'"
              style="width: 300px"
              :src="other_backcard_face"
            />
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered text-light">
      <thead>
        <tr>
          <th colspan="4">
            <h5 class="mb-0">客戶補充資料</h5>
          </th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="20%">教育程度</th>
          <td colspan="3" class="text-warning">
            {{ Client.education_level }}
          </td>
          <td width="20%" rowspan="2">
            <b-form-textarea
              class="bg-secondary text-white"
              v-if="Client.remark"
              name="駁回客戶補充資料"
              style="width: 100%"
              placeholder="請寫駁回理由"
              rows="3"
              v-model="Client.remark"
              readonly
            ></b-form-textarea>
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered text-light">
      <thead>
        <tr>
          <th colspan="4">
            <h5 class="mb-0">工作狀態</h5>
          </th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="20%">工作狀態</th>
          <td width="20%" class="text-warning">
            {{ ClientWorkingStatus.working_status }}
          </td>
          <th width="20%">雇主名稱</th>
          <td width="20%" class="text-warning">
            {{ ClientWorkingStatus.company_name }}
          </td>
          <td width="20%" rowspan="4">
            <b-form-textarea
              class="bg-secondary text-white"
              v-if="ClientWorkingStatus.remark"
              name="駁回工作狀態"
              style="width: 100%"
              placeholder="請寫駁回理由"
              rows="10"
              v-model="ClientWorkingStatus.remark"
              readonly
            ></b-form-textarea>
          </td>
        </tr>
        <tr>
          <th>公司電話</th>
          <td class="text-warning">
            {{ ClientWorkingStatus.company_tel }}
          </td>
          <th>公司地址</th>
          <td></td>
        </tr>
        <tr>
          <th>業務性質</th>
          <td class="text-warning">
            {{ ClientWorkingStatus.industry }}
          </td>
          <th>職位</th>
          <td class="text-warning">
            {{ ClientWorkingStatus.position }}
          </td>
        </tr>
        <tr>
          <th>名片</th>
          <td colspan="3">
            <img style="width: 300px" :src="name_card_face" />
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered text-light">
      <thead>
        <tr>
          <th colspan="4">
            <h5 class="mb-0">財政狀況</h5>
          </th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="20%">資金來源</th>
          <td width="20%" class="text-warning">
            {{ ClientFinancialStatus.fund_source }}
          </td>
          <th width="20%">其他資金來源</th>
          <td width="20%" class="text-warning">
            {{ ClientFinancialStatus.other_fund_source }}
          </td>
          <td width="20%" rowspan="3">
            <b-form-textarea
              class="bg-secondary text-white"
              v-if="ClientFinancialStatus.remark"
              name="駁回財政狀況"
              style="width: 100%"
              placeholder="請寫駁回理由"
              rows="5"
              v-model="ClientFinancialStatus.remark"
              readonly
            ></b-form-textarea>
          </td>
        </tr>
        <tr>
          <th>每年收入(港元)</th>
          <td class="text-warning">
            {{ ClientFinancialStatus.annual_income }}
          </td>
          <th>資產項目</th>
          <td></td>
        </tr>
        <tr>
          <th>其他資產</th>
          <td></td>
          <th>資產淨值</th>
          <td class="text-warning">
            {{ ClientFinancialStatus.net_assets }}
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered text-light">
      <thead>
        <tr>
          <th colspan="4">
            <h5 class="mb-0">投資經驗及衍生產品認識</h5>
          </th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="20%">投資目標</th>
          <td width="20%" class="text-warning">
            {{ ClientInvestmentExperience.investment_objective }}
          </td>
          <th width="20%">股票</th>
          <td width="20%" class="text-warning">
            {{ ClientInvestmentExperience.stock }}
          </td>
          <td width="20%" rowspan="4">
            <b-form-textarea
              class="bg-secondary text-white"
              v-if="ClientInvestmentExperience.remark"
              name="駁回投資經驗及衍生產品認識"
              style="width: 100%"
              placeholder="請寫駁回理由"
              rows="5"
              v-model="ClientInvestmentExperience.remark"
              readonly
            ></b-form-textarea>
          </td>
        </tr>
        <tr>
          <th>衍生認股證</th>
          <td class="text-warning">
            {{ ClientInvestmentExperience.derivative_warrants }}
          </td>
          <th>牛熊證</th>
          <td class="text-warning">
            {{ ClientInvestmentExperience.cbbc }}
          </td>
        </tr>
        <tr>
          <th>期貨及期權</th>
          <td class="text-warning">
            {{ ClientInvestmentExperience.futures_and_options }}
          </td>
          <th>債券/基金</th>
          <td class="text-warning">
            {{ ClientInvestmentExperience.bonds_funds }}
          </td>
        </tr>
        <tr>
          <th>其他投資經驗</th>
          <td class="text-warning">
            {{ ClientInvestmentExperience.other_investment_experience }}
          </td>
          <th></th>
          <td></td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered text-light">
      <thead>
        <tr>
          <th colspan="3">
            <h5 class="mb-0">問題</h5>
          </th>
          <th colspan="3">
            <h5 class="mb-0">答案</h5>
          </th>
          <th colspan="3">
            <h5 class="mb-0">分數</h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(score, index) of client_score" :key="index">
          <th colspan="3" width="40%">{{ score.question_text }}?</th>
          <td colspan="3" width="40%" class="text-warning">
            {{ score.answer }}
          </td>
          <td colspan="3" width="20%" class="text-warning">
            {{ score.score }}
          </td>
        </tr>
        <tr>
          <th>
            <h5 class="mb-0">評估結果</h5>
          </th>
          <td>
            <h5 class="mb-0 text-warning">
              {{ 評估結果 }}
            </h5>
          </td>
          <th>
            <h5 class="mb-0">投資者特徵</h5>
          </th>
          <td>
            <h5 class="mb-0 text-warning">{{ 投資者特徵 }}</h5>
          </td>
          <th>
            <h5 class="mb-0">風險承受程度</h5>
          </th>
          <td>
            <h5 class="mb-0 text-warning">{{ 風險承受程度 }}</h5>
          </td>
          <td rowspan="2" width="20%">
            <b-form-textarea
              class="bg-secondary text-white"
              v-if="ClientEvaluationResults.remark"
              name="駁回問卷調查"
              style="width: 100%"
              placeholder="請寫駁回理由"
              rows="3"
              v-model="ClientEvaluationResults.remark"
              readonly
            ></b-form-textarea>
          </td>
        </tr>
        <tr>
          <th>
            <h5 class="mb-0">用戶是否同意</h5>
          </th>
          <td>
            <h5 class="mb-0 text-warning">{{ 用戶是否同意 }}</h5>
          </td>
          <th>
            <h5 class="mb-0">投資者同意的特徵</h5>
          </th>
          <td>
            <h5 class="mb-0 text-warning">
              {{ ClientEvaluationResults.investor_characteristics }}
            </h5>
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered text-light">
      <thead>
        <tr>
          <th colspan="4">
            <h5 class="mb-0">簽名</h5>
          </th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <td colspan="4">
          <img style="width: 300px" :src="ClientSignature.image" />
        </td>
        <td width="20%">
          <b-form-textarea
            class="bg-secondary text-white"
            v-if="ClientSignature.remark"
            name="駁回簽名"
            style="width: 100%"
            placeholder="請寫駁回理由"
            rows="10"
            v-model="ClientSignature.remark"
            readonly
          ></b-form-textarea>
        </td>
      </tbody>
    </table>
    <table class="table table-bordered text-light">
      <tbody>
        <th width="17%">
          <h5 class="mb-0">直接促銷</h5>
        </th>
        <td>
          <h5 class="mb-0 text-warning">
            {{ ClientBusinessType.direct_promotion }}
          </h5>
        </td>
      </tbody>
    </table>
    <table class="table table-bordered text-light">
      <thead>
        <tr>
          <th colspan="4">
            <h5 class="mb-0">存款證明</h5>
          </th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>入金帳戶</th>
          <td class="text-warning">
            {{ ClientDepositProof.deposit_account }}
          </td>
          <th>入金金額</th>
          <td class="text-warning">
            HK${{ ClientDepositProof.deposit_amount }}
          </td>
          <td width="20%" rowspan="3">
            <b-form-textarea
              class="bg-secondary text-white"
              v-if="ClientDepositProof.remark"
              name="駁回存款證明"
              style="width: 100%"
              placeholder="請寫駁回理由"
              rows="10"
              v-model="ClientDepositProof.remark"
              readonly
            ></b-form-textarea>
          </td>
        </tr>
        <tr>
          <th>入金銀行</th>
          <td class="text-warning">
            {{ ClientDepositProof.deposit_bank }}
          </td>
          <th>入金方法</th>
          <td>
            <div
              v-if="ClientDepositProof.other_deposit_method"
              class="mb-0 text-warning"
            >
              {{ ClientDepositProof.other_deposit_method }}
            </div>
            <div v-else class="mb-0 text-warning">
              {{ ClientDepositProof.deposit_method }}
            </div>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <img style="width: 500px" :src="deposit_proof" />
          </td>
          <th>轉帳時間</th>
          <td class="text-warning">
            {{ ClientDepositProof.transfer_time }}
          </td>
        </tr>
      </tbody>
    </table>
  </form>
</template>
<script>
export default {
  data() {
    return {
      地區map: {},
      駁回: {
        身份證信息: false,
        "zh-hk銀行卡信息": false,
        "zh-cn銀行卡信息": false,
        others銀行卡信息: false,
        客戶補充資料: false,
        工作狀態: false,
        財政狀況: false,
        投資經驗及衍生產品認識: false,
        問卷調查: false,
        簽名: false,
        住址證明: false,
        存款證明: false,
      },
      Client: null,
      ClientIDCard: null,
      ClientAddressProof: null,
      ClientWorkingStatus: null,
      ClientFinancialStatus: null,
      ClientInvestmentExperience: null,
      ClientEvaluationResults: null,
      ClientSignature: null,
      ClientBusinessType: null,
      ClientDepositProof: null,
      Introducer: null,
    };
  },
  components: {},
  props: {
    client: String,
    client_id_card: String,
    client_address_proof: String,
    idcard_face: String,
    idcard_back: String,
    銀行卡s: Array,
    hk_backcard_face: String,
    cn_backcard_face: String,
    other_backcard_face: String,
    client_working_status: String,
    name_card_face: String,
    client_financial_status: String,
    client_investment_experience: String,
    client_score: Array,
    client_evaluation_results: String,
    client_signature: String,
    client_business_type: String,
    client_deposit_proof: String,
    deposit_proof: String,
    address_proof: String,
    introducer: String,
    action: String,
    redirect_route: String,
    next_status: String,
  },
  created() {
    debugger;
    this.Client = JSON.parse(this.client);
    this.ClientIDCard = JSON.parse(this.client_id_card);
    try {
      this.ClientAddressProof = JSON.parse(this.client_address_proof);
      this.駁回.住址證明 = this.ClientAddressProof.remark ? true : false;
    } catch (e) {}
    this.ClientWorkingStatus = JSON.parse(this.client_working_status);
    this.ClientFinancialStatus = JSON.parse(this.client_financial_status);
    this.ClientInvestmentExperience = JSON.parse(
      this.client_investment_experience
    );
    this.ClientEvaluationResults = JSON.parse(this.client_evaluation_results);
    this.ClientSignature = JSON.parse(this.client_signature);
    this.ClientBusinessType = JSON.parse(this.client_business_type);
    try {
      this.ClientDepositProof = JSON.parse(this.client_deposit_proof);
      this.駁回.存款證明 = this.ClientDepositProof.remark ? true : false;
    } catch (e) {}
    this.Introducer = JSON.parse(this.introducer);
    this.地區map["zh-hk"] = "香港";
    this.地區map["zh-cn"] = "中國";
    this.地區map["others"] = "台灣";
    this.駁回.身份證信息 = this.ClientIDCard.remark ? true : false;
    this.銀行卡s.forEach((銀行卡) => {
      this.駁回[銀行卡.lcid + "銀行卡信息"] = 銀行卡.remark ? true : false;
    });
    this.駁回.客戶補充資料 = this.Client.remark ? true : false;
    this.駁回.工作狀態 = this.ClientWorkingStatus.remark ? true : false;
    this.駁回.財政狀況 = this.ClientFinancialStatus.remark ? true : false;
    this.駁回.投資經驗及衍生產品認識 = this.ClientInvestmentExperience.remark
      ? true
      : false;
    this.駁回.問卷調查 = this.ClientEvaluationResults.remark ? true : false;
    this.駁回.簽名 = this.ClientSignature.remark ? true : false;
  },
  computed: {
    評估結果() {
      let result = 0;
      this.client_score.forEach((score) => {
        result += score.score;
      });
      return result;
    },
    投資者特徵() {
      if (this.評估結果 <= 19) {
        return "保守型";
      } else if (this.評估結果 >= 20 && this.評估結果 <= 29) {
        return "穩健型";
      } else if (this.評估結果 >= 30 && this.評估結果 <= 39) {
        return "平衡型";
      } else if (this.評估結果 >= 40 && this.評估結果 <= 49) {
        return "增長型";
      } else if (this.評估結果 >= 50) {
        return "進取型";
      }
    },
    風險承受程度() {
      if (this.評估結果 <= 19) {
        return "低";
      } else if (this.評估結果 >= 20 && this.評估結果 <= 29) {
        return "低至中";
      } else if (this.評估結果 >= 30 && this.評估結果 <= 39) {
        return "中";
      } else if (this.評估結果 >= 40 && this.評估結果 <= 49) {
        return "中至高";
      } else if (this.評估結果 >= 50) {
        return "高";
      }
    },
    用戶是否同意() {
      return this.ClientEvaluationResults.agree ? "是" : "否";
    },
  },
  methods: {},
};
</script>