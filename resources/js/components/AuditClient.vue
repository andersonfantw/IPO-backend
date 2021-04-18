<template>
  <form :action="action" method="POST">
    <input type="hidden" name="uuid" v-model="Client.uuid" />
    <input type="hidden" name="redirect_route" v-model="redirect_route" />
    <input type="hidden" name="next_status" v-model="next_status" />
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col" colspan="6">
            <h5 class="mb-0">基礎信息</h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="17%" scope="row">
            <div class="mb-0">地區</div>
          </th>
          <td width="17%">
            <div class="mb-0">{{ 地區map[Client.nationality] }}</div>
          </td>
          <th width="17%">
            <div class="mb-0">開通賬戶</div>
          </th>
          <td width="17%">
            <div class="mb-0">證券（現金）賬戶</div>
          </td>
          <th width="17%">
            <div class="mb-0">介紹人</div>
          </th>
          <td width="17%">
            <div class="mb-0">
              {{ Introducer.name }} ({{ Introducer.type }})
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    <table v-if="ClientAddressProof" class="table table-bordered">
      <thead>
        <tr>
          <th scope="col" colspan="3">
            <h5 class="mb-0">住址證明</h5>
          </th>
          <th scope="col">
            <h5 class="mb-0">
              <label class="mb-0" for="駁回住址證明">駁回</label
              ><Checkbox
                id="駁回住址證明"
                class="ml-2"
                v-model="駁回.住址證明"
                :binary="true"
              />
            </h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="20%" scope="row">
            <div class="mb-0">地址</div>
          </th>
          <td width="20%">
            <div class="mb-0">{{ ClientAddressProof.address_text }}</div>
          </td>
          <td width="40%">
            <img style="width: 400px" :src="address_proof" />
          </td>
          <td width="20%" rowspan="6">
            <textarea
              v-if="駁回.住址證明"
              name="駁回住址證明"
              style="width: 100%"
              placeholder="請寫駁回理由"
              rows="7"
              v-model="ClientAddressProof.remark"
            ></textarea>
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col" colspan="4">
            <h5 class="mb-0">身份證信息</h5>
          </th>
          <th scope="col">
            <h5 class="mb-0">
              <label class="mb-0" for="駁回身份證信息">駁回</label
              ><Checkbox
                id="駁回身份證信息"
                class="ml-2"
                v-model="駁回.身份證信息"
                :binary="true"
              />
            </h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="20%" scope="row">
            <div class="mb-0">姓名</div>
          </th>
          <td width="20%">
            <div class="mb-0">{{ ClientIDCard.name_c }}</div>
          </td>
          <th width="20%">
            <div class="mb-0">英文名</div>
          </th>
          <td width="20%">
            <div class="mb-0">{{ ClientIDCard.name_en }}</div>
          </td>
          <td width="20%" rowspan="6">
            <textarea
              v-if="駁回.身份證信息"
              name="駁回身份證信息"
              style="width: 100%"
              placeholder="請寫駁回理由"
              v-model="ClientIDCard.remark"
              rows="10"
            ></textarea>
          </td>
        </tr>
        <tr>
          <th scope="row">
            <div class="mb-0">性別</div>
          </th>
          <td>
            <div class="mb-0">{{ ClientIDCard.gender }}</div>
          </td>
          <th>
            <div class="mb-0">手機號碼</div>
          </th>
          <td>
            <div class="mb-0">{{ Client.mobile }}</div>
          </td>
        </tr>
        <tr>
          <th scope="row">
            <div class="mb-0">出生日期</div>
          </th>
          <td>
            <div class="mb-0">{{ ClientIDCard.birthday }}</div>
          </td>
          <th>
            <div class="mb-0">證件類型</div>
          </th>
          <td>
            <div class="mb-0">{{ ClientIDCard.passport_type }}</div>
          </td>
        </tr>
        <tr>
          <th scope="row">
            <div class="mb-0">住址</div>
          </th>
          <td>
            <div class="mb-0">{{ ClientIDCard.address }}</div>
          </td>
          <th>
            <div class="mb-0">證件號碼</div>
          </th>
          <td>
            <div class="mb-0">{{ ClientIDCard.idcard_no }}</div>
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
      class="table table-bordered"
    >
      <thead>
        <tr>
          <th scope="col" colspan="4">
            <h5 v-if="銀行卡.lcid == 'zh-hk'" class="mb-0">香港銀行卡信息</h5>
            <h5 v-else-if="銀行卡.lcid == 'zh-cn'" class="mb-0">
              大陸銀行卡信息
            </h5>
            <h5 v-else-if="銀行卡.lcid == 'others'" class="mb-0">銀行卡信息</h5>
          </th>
          <th scope="col">
            <h5 class="mb-0">
              <label class="mb-0" :for="'駁回' + 銀行卡.lcid + '銀行卡信息'"
                >駁回</label
              >
              <Checkbox
                :id="'駁回' + 銀行卡.lcid + '銀行卡信息'"
                class="ml-2"
                v-model="駁回[銀行卡.lcid + '銀行卡信息']"
                :binary="true"
              />
            </h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="20%" scope="row">
            <div v-if="銀行卡.lcid == 'zh-hk'" class="mb-0">香港銀行名</div>
            <div v-else-if="銀行卡.lcid == 'zh-cn'" class="mb-0">
              大陸銀行名
            </div>
            <div v-else-if="銀行卡.lcid == 'others'" class="mb-0">銀行名</div>
          </th>
          <td width="20%">
            <div class="mb-0">
              {{ 銀行卡.bank_name }} ({{ 銀行卡.bank_code }})
            </div>
          </td>
          <th width="20%">
            <div v-if="銀行卡.lcid == 'zh-hk'" class="mb-0">香港銀行卡號</div>
            <div v-else-if="銀行卡.lcid == 'zh-cn'" class="mb-0">
              大陸銀行卡號
            </div>
            <div v-else-if="銀行卡.lcid == 'others'" class="mb-0">銀行卡號</div>
          </th>
          <td width="20%">
            <div class="mb-0">{{ 銀行卡.account_no }}</div>
          </td>
          <td width="20%" rowspan="2">
            <textarea
              v-if="駁回[銀行卡.lcid + '銀行卡信息']"
              :name="'駁回' + 銀行卡.lcid + '銀行卡信息'"
              style="width: 100%"
              placeholder="請寫駁回理由"
              rows="10"
              v-model="銀行卡.remark"
            ></textarea>
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
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col" colspan="4">
            <h5 class="mb-0">客戶補充資料</h5>
          </th>
          <th scope="col">
            <h5 class="mb-0">
              <label class="mb-0" for="駁回客戶補充資料">駁回</label
              ><Checkbox
                id="駁回客戶補充資料"
                class="ml-2"
                v-model="駁回.客戶補充資料"
                :binary="true"
              />
            </h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="20%" scope="row">
            <div class="mb-0">教育程度</div>
          </th>
          <td colspan="3">
            <div class="mb-0">{{ Client.education_level }}</div>
          </td>
          <td width="20%" rowspan="2">
            <textarea
              v-if="駁回.客戶補充資料"
              name="駁回客戶補充資料"
              style="width: 100%"
              placeholder="請寫駁回理由"
              rows="3"
              v-model="Client.remark"
            ></textarea>
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col" colspan="4">
            <h5 class="mb-0">工作狀態</h5>
          </th>
          <th scope="col">
            <h5 class="mb-0">
              <label class="mb-0" for="駁回工作狀態">駁回</label
              ><Checkbox
                id="駁回工作狀態"
                class="ml-2"
                v-model="駁回.工作狀態"
                :binary="true"
              />
            </h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="20%" scope="row">
            <div class="mb-0">工作狀態</div>
          </th>
          <td width="20%">
            <div class="mb-0">{{ ClientWorkingStatus.working_status }}</div>
          </td>
          <th width="20%" scope="row">
            <div class="mb-0">雇主名稱</div>
          </th>
          <td width="20%">
            <div class="mb-0">{{ ClientWorkingStatus.company_name }}</div>
          </td>
          <td width="20%" rowspan="4">
            <textarea
              v-if="駁回.工作狀態"
              name="駁回工作狀態"
              style="width: 100%"
              placeholder="請寫駁回理由"
              rows="10"
              v-model="ClientWorkingStatus.remark"
            ></textarea>
          </td>
        </tr>
        <tr>
          <th scope="row">
            <div class="mb-0">公司電話</div>
          </th>
          <td>
            <div class="mb-0">{{ ClientWorkingStatus.company_tel }}</div>
          </td>
          <th scope="row">
            <div class="mb-0">公司地址</div>
          </th>
          <td></td>
        </tr>
        <tr>
          <th scope="row">
            <div class="mb-0">業務性質</div>
          </th>
          <td>
            <div class="mb-0">{{ ClientWorkingStatus.industry }}</div>
          </td>
          <th scope="row">
            <div class="mb-0">職位</div>
          </th>
          <td>
            <div class="mb-0">{{ ClientWorkingStatus.position }}</div>
          </td>
        </tr>
        <tr>
          <th scope="row">
            <div class="mb-0">名片</div>
          </th>
          <td colspan="3">
            <img style="width: 300px" :src="name_card_face" />
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col" colspan="4">
            <h5 class="mb-0">財政狀況</h5>
          </th>
          <th scope="col">
            <h5 class="mb-0">
              <label class="mb-0" for="駁回財政狀況">駁回</label
              ><Checkbox
                id="駁回財政狀況"
                class="ml-2"
                v-model="駁回.財政狀況"
                :binary="true"
              />
            </h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="20%" scope="row">
            <div class="mb-0">資金來源</div>
          </th>
          <td width="20%">
            <div class="mb-0">{{ ClientFinancialStatus.fund_source }}</div>
          </td>
          <th width="20%" scope="row">
            <div class="mb-0">其他資金來源</div>
          </th>
          <td width="20%">
            <div class="mb-0">
              {{ ClientFinancialStatus.other_fund_source }}
            </div>
          </td>
          <td width="20%" rowspan="3">
            <textarea
              v-if="駁回.財政狀況"
              name="駁回財政狀況"
              style="width: 100%"
              placeholder="請寫駁回理由"
              rows="5"
              v-model="ClientFinancialStatus.remark"
            ></textarea>
          </td>
        </tr>
        <tr>
          <th scope="row">
            <div class="mb-0">每年收入(港元)</div>
          </th>
          <td>
            <div class="mb-0">{{ ClientFinancialStatus.annual_income }}</div>
          </td>
          <th scope="row">
            <div class="mb-0">資產項目</div>
          </th>
          <td></td>
        </tr>
        <tr>
          <th scope="row">
            <div class="mb-0">其他資產</div>
          </th>
          <td></td>
          <th scope="row">
            <div class="mb-0">資產淨值</div>
          </th>
          <td>
            <div class="mb-0">{{ ClientFinancialStatus.net_assets }}</div>
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col" colspan="4">
            <h5 class="mb-0">投資經驗及衍生產品認識</h5>
          </th>
          <th scope="col">
            <h5 class="mb-0">
              <label class="mb-0" for="駁回投資經驗及衍生產品認識">駁回</label
              ><Checkbox
                id="駁回投資經驗及衍生產品認識"
                class="ml-2"
                v-model="駁回.投資經驗及衍生產品認識"
                :binary="true"
              />
            </h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="20%" scope="row">
            <div class="mb-0">投資目標</div>
          </th>
          <td width="20%">
            <div class="mb-0">
              {{ ClientInvestmentExperience.investment_objective }}
            </div>
          </td>
          <th width="20%" scope="row">
            <div class="mb-0">股票</div>
          </th>
          <td width="20%">
            <div class="mb-0">{{ ClientInvestmentExperience.stock }}</div>
          </td>
          <td width="20%" rowspan="4">
            <textarea
              v-if="駁回.投資經驗及衍生產品認識"
              name="駁回投資經驗及衍生產品認識"
              style="width: 100%"
              placeholder="請寫駁回理由"
              rows="5"
              v-model="ClientInvestmentExperience.remark"
            ></textarea>
          </td>
        </tr>
        <tr>
          <th scope="row">
            <div class="mb-0">衍生認股證</div>
          </th>
          <td>
            <div class="mb-0">
              {{ ClientInvestmentExperience.derivative_warrants }}
            </div>
          </td>
          <th scope="row">
            <div class="mb-0">牛熊證</div>
          </th>
          <td>
            <div class="mb-0">{{ ClientInvestmentExperience.cbbc }}</div>
          </td>
        </tr>
        <tr>
          <th scope="row">
            <div class="mb-0">期貨及期權</div>
          </th>
          <td>
            <div class="mb-0">
              {{ ClientInvestmentExperience.futures_and_options }}
            </div>
          </td>
          <th scope="row">
            <div class="mb-0">債券/基金</div>
          </th>
          <td>
            <div class="mb-0">{{ ClientInvestmentExperience.bonds_funds }}</div>
          </td>
        </tr>
        <tr>
          <th scope="row">
            <div class="mb-0">其他投資經驗</div>
          </th>
          <td>
            <div class="mb-0">
              {{ ClientInvestmentExperience.other_investment_experience }}
            </div>
          </td>
          <th scope="row"></th>
          <td></td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th colspan="3" scope="col">
            <h5 class="mb-0">問題</h5>
          </th>
          <th colspan="3" scope="col">
            <h5 class="mb-0">答案</h5>
          </th>
          <th colspan="1" scope="col">
            <h5 class="mb-0">分數</h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="[key, value] of Object.entries(ClientScore)" :key="key">
          <th colspan="3" width="40%" scope="row">
            <div class="mb-0">{{ value.question_text }}?</div>
          </th>
          <td colspan="3" width="40%">
            <div class="mb-0">{{ value.answer }}</div>
          </td>
          <td colspan="3" width="20%">
            <div class="mb-0">{{ value.score }}</div>
          </td>
        </tr>
        <tr>
          <th scope="row">
            <h5 class="mb-0">評估結果</h5>
          </th>
          <td>
            <h5 class="mb-0">
              {{ 評估結果 }}
            </h5>
          </td>
          <th scope="row">
            <h5 class="mb-0">投資者特徵</h5>
          </th>
          <td>
            <h5 class="mb-0">{{ 投資者特徵 }}</h5>
          </td>
          <th scope="row">
            <h5 class="mb-0">風險承受程度</h5>
          </th>
          <td>
            <h5 class="mb-0">{{ 風險承受程度 }}</h5>
          </td>
          <td rowspan="2" width="20%">
            <h5 class="mb-0">
              <label class="mb-0" for="駁回問卷調查">駁回</label
              ><Checkbox
                id="駁回問卷調查"
                class="ml-2"
                v-model="駁回.問卷調查"
                :binary="true"
              />
            </h5>
            <textarea
              v-if="駁回.問卷調查"
              name="駁回問卷調查"
              style="width: 100%"
              placeholder="請寫駁回理由"
              rows="3"
              v-model="ClientEvaluationResults.remark"
            ></textarea>
          </td>
        </tr>
        <tr>
          <th scope="row">
            <h5 class="mb-0">用戶是否同意</h5>
          </th>
          <td>
            <h5 class="mb-0">{{ 用戶是否同意 }}</h5>
          </td>
          <th scope="row">
            <h5 class="mb-0">投資者同意的特徵</h5>
          </th>
          <td>
            <h5 class="mb-0">
              {{ ClientEvaluationResults.investor_characteristics }}
            </h5>
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th colspan="4" scope="col">
            <h5 class="mb-0">簽名</h5>
          </th>
          <th scope="col">
            <h5 class="mb-0">
              <label class="mb-0" for="駁回簽名">駁回</label
              ><Checkbox
                id="駁回簽名"
                class="ml-2"
                v-model="駁回.簽名"
                :binary="true"
              />
            </h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <td colspan="4">
          <img style="width: 300px" :src="ClientSignature.image" />
        </td>
        <td width="20%">
          <textarea
            v-if="駁回.簽名"
            name="駁回簽名"
            style="width: 100%"
            placeholder="請寫駁回理由"
            rows="10"
            v-model="ClientSignature.remark"
          ></textarea>
        </td>
      </tbody>
    </table>
    <table class="table table-bordered">
      <tbody>
        <th width="17%">
          <h5 class="mb-0">直接促銷</h5>
        </th>
        <td>
          <h5 class="mb-0">{{ ClientBusinessType.direct_promotion }}</h5>
        </td>
      </tbody>
    </table>
    <table v-if="ClientDepositProof" class="table table-bordered">
      <thead>
        <tr>
          <th colspan="4" scope="col">
            <h5 class="mb-0">存款證明</h5>
          </th>
          <th scope="col">
            <h5 class="mb-0">
              <label class="mb-0" for="駁回存款證明">駁回</label
              ><Checkbox
                id="駁回存款證明"
                class="ml-2"
                v-model="駁回.存款證明"
                :binary="true"
              />
            </h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">
            <div class="mb-0">入金帳戶</div>
          </th>
          <td>
            {{ ClientDepositProof.deposit_account }}
          </td>
          <th scope="row">
            <div class="mb-0">入金金額</div>
          </th>
          <td>HK${{ ClientDepositProof.deposit_amount }}</td>
          <td width="20%" rowspan="3">
            <textarea
              v-if="駁回.存款證明"
              name="駁回存款證明"
              style="width: 100%"
              placeholder="請寫駁回理由"
              rows="10"
              v-model="ClientDepositProof.remark"
            ></textarea>
          </td>
        </tr>
        <tr>
          <th scope="row">
            <div class="mb-0">入金銀行</div>
          </th>
          <td>
            {{ ClientDepositProof.deposit_bank }}
          </td>
          <th scope="row">
            <div class="mb-0">入金方法</div>
          </th>
          <td>
            <div v-if="ClientDepositProof.other_deposit_method" class="mb-0">
              {{ ClientDepositProof.other_deposit_method }}
            </div>
            <div v-else class="mb-0">
              {{ ClientDepositProof.deposit_method }}
            </div>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <img style="width: 400px" :src="deposit_proof" />
          </td>
          <th scope="row">
            <div class="mb-0">轉帳時間</div>
          </th>
          <td>
            {{ ClientDepositProof.transfer_time }}
          </td>
        </tr>
      </tbody>
    </table>
    <Button type="submit" label="提交審核" icon="pi pi-check" iconPos="right" />
  </form>
</template>
<script>
import Button from "primevue/button";
import InputSwitch from "primevue/inputswitch";
import Checkbox from "primevue/checkbox";
export default {
  data() {
    return {
      columns: [],
      filterMatchMode: {},
      loading: false,
      data: null,
      selectedClients: null,
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
      ClientScore: {},
      ClientEvaluationResults: null,
      ClientSignature: null,
      ClientBusinessType: null,
      ClientDepositProof: null,
      Introducer: null,
    };
  },
  components: { Button, InputSwitch, Checkbox },
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
    address_proof: String,
    deposit_proof: String,
    introducer: String,
    action: String,
    redirect_route: String,
    next_status: String,
  },
  created() {
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
    let self = this;
    this.client_score.forEach((score) => {
      let old_score = self.ClientScore[score.question_text];
      if (old_score) {
        if (score.score > old_score.score) {
          self.ClientScore[score.question_text] = score;
        }
      } else {
        self.ClientScore[score.question_text] = score;
      }
    });
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
      for (const [key, value] of Object.entries(this.ClientScore)) {
        result += value.score;
      }
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