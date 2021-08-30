<template>
  <b-modal
    ref="modal"
    size="xl"
    :title="title"
    body-bg-variant="dark"
    body-text-variant="light"
    @hidden="reset"
    @ok="reset"
  >
    <table class="table table-bordered text-light">
      <thead>
        <tr>
          <th
            scope="col"
            colspan="6"
          >
            <h5 class="mb-0"><i class="fas fa-info"></i> 基礎信息</h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="17%">地區</th>
          <td
            v-if="Client"
            width="17%"
            class=""
          >
            {{ 地區map[Client.nationality] }}
          </td>
          <th width="17%">開通賬戶</th>
          <td
            v-if="ClientBusinessType"
            width="17%"
            class=""
          >{{ClientBusinessType.business_type}}</td>
          <th width="17%">介紹人</th>
          <td
            v-if="Introducer"
            width="17%"
            class=""
          >
            {{ Introducer.name }} ({{ Introducer.type }})
          </td>
        </tr>
      </tbody>
    </table>
    <table
      v-if="ClientAddressProof"
      class="table table-bordered text-light"
    >
      <thead>
        <tr>
          <th
            scope="col"
            colspan="3"
          >
            <h5 class="mb-0"><i class="fas fa-map-marked-alt"></i> 住址證明</h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>地址</th>
          <td class="">
            {{ ClientAddressProof.address_text }}
          </td>
          <td class="text-center">
            <img
              style="width: 500px"
              :src="AddressProof"
            />
          </td>
        </tr>
        <tr>
          <th
            scope="col"
            colspan="3"
          >
            <h5 class="mb-0">
              <b-form-checkbox
                id="駁回住址證明"
                v-model="駁回.住址證明"
                :value="true"
                :unchecked-value="false"
                :disabled="next_status == null"
              >駁回
              </b-form-checkbox>
            </h5>
          </th>
        </tr>
        <tr v-if="駁回.住址證明">
          <td colspan="3">
            <b-form-textarea
              class="text-light bg-dark"
              name="駁回住址證明"
              style="width: 100%"
              placeholder="請寫駁回理由"
              rows="5"
              v-model="ClientAddressProof.remark"
              :disabled="!駁回.住址證明 || next_status == null"
            ></b-form-textarea>
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered text-light">
      <thead>
        <tr>
          <th
            scope="col"
            colspan="4"
          >
            <h5 class="mb-0"><i class="far fa-id-card"></i> 身份證信息</h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>姓名</th>
          <td
            v-if="ClientIDCard"
            class=""
          >
            {{ ClientIDCard.name_c }}
          </td>
          <th>英文名</th>
          <td
            v-if="ClientIDCard"
            class=""
          >
            {{ ClientIDCard.name_en }}
          </td>
        </tr>
        <tr>
          <th>性別</th>
          <td
            v-if="ClientIDCard"
            class=""
          >
            {{ ClientIDCard.gender }}
          </td>
          <th>手機號碼</th>
          <td
            v-if="Client"
            class=""
          >
            {{ Client.mobile }}
          </td>
        </tr>
        <tr>
          <th>出生日期</th>
          <td
            v-if="ClientIDCard"
            class=""
          >
            {{ ClientIDCard.birthday }}
          </td>
          <th>證件類型</th>
          <td
            v-if="ClientIDCard"
            class=""
          >
            {{ ClientIDCard.passport_type }}
          </td>
        </tr>
        <tr>
          <th>住址</th>
          <td
            v-if="ClientIDCard"
            class=""
          >
            {{ ClientIDCard.address }}
          </td>
          <th>證件號碼</th>
          <td
            v-if="ClientIDCard"
            class=""
          >
            {{ ClientIDCard.idcard_no }}
          </td>
        </tr>
        <tr>
          <td
            colspan="2"
            class="text-center"
          >
            <img
              style="width: 300px"
              :src="IDCardFace"
            />
          </td>
          <td
            colspan="2"
            class="text-center"
          >
            <img
              style="width: 300px"
              :src="IDCardBack"
            />
          </td>
        </tr>
        <tr>
          <th
            scope="col"
            colspan="4"
          >
            <h5 class="mb-0">
              <b-form-checkbox
                id="駁回身份證信息"
                v-model="駁回.身份證信息"
                :value="true"
                :unchecked-value="false"
                class="text-warning"
                :disabled="next_status == null"
              >駁回
              </b-form-checkbox>
            </h5>
          </th>
        </tr>
        <tr v-if="駁回.身份證信息">
          <td
            v-if="ClientIDCard"
            colspan="4"
          >
            <b-form-textarea
              class="text-light bg-dark"
              name="駁回身份證信息"
              style="width: 100%"
              placeholder="請寫駁回理由"
              v-model="ClientIDCard.remark"
              rows="5"
              :disabled="!駁回.身份證信息 || next_status == null"
            ></b-form-textarea>
          </td>
        </tr>
      </tbody>
    </table>
    <table
      v-if="ClientDepositProof"
      class="table table-bordered text-light"
    >
      <thead>
        <tr>
          <th
            colspan="4"
            scope="col"
          >
            <h5 class="mb-0"><i class="fas fa-dollar-sign"></i> 存款證明</h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>入金帳戶</th>
          <td class="">
            {{ ClientDepositProof.deposit_account }}
          </td>
          <th>入金金額</th>
          <td class="">HK${{ ClientDepositProof.deposit_amount }}</td>
        </tr>
        <tr>
          <th>入金銀行</th>
          <td class="">
            {{ ClientDepositProof.deposit_bank }}
          </td>
          <th>入金方法</th>
          <td class="">
            <div
              v-if="ClientDepositProof.other_deposit_method"
              class="mb-0"
            >
              {{ ClientDepositProof.other_deposit_method }}
            </div>
            <div
              v-else
              class="mb-0"
            >
              {{ ClientDepositProof.deposit_method }}
            </div>
          </td>
        </tr>
        <tr>
          <td
            colspan="2"
            class="text-center"
          >
            <img
              style="width: 500px"
              :src="DepositProof"
            />
          </td>
          <th>轉帳時間</th>
          <td class="">
            {{ ClientDepositProof.transfer_time }}
          </td>
        </tr>
        <tr>
          <th
            scope="col"
            colspan="4"
          >
            <h5 class="mb-0">
              <b-form-checkbox
                id="駁回存款證明"
                v-model="駁回.存款證明"
                :value="true"
                :unchecked-value="false"
                :disabled="next_status == null"
              >駁回
              </b-form-checkbox>
            </h5>
          </th>
        </tr>
        <tr v-if="駁回.存款證明">
          <td colspan="4">
            <b-form-textarea
              class="text-light bg-dark"
              name="駁回存款證明"
              style="width: 100%"
              placeholder="請寫駁回理由"
              rows="5"
              v-model="ClientDepositProof.remark"
              :disabled="!駁回.存款證明 || next_status == null"
            ></b-form-textarea>
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
          <th
            scope="col"
            colspan="3"
          >
            <h5
              v-if="銀行卡.lcid == 'zh-hk'"
              class="mb-0"
            >
              <i class="fas fa-money-check-alt"></i> 香港銀行卡信息
            </h5>
            <h5
              v-else-if="銀行卡.lcid == 'zh-cn'"
              class="mb-0"
            >
              <i class="fas fa-money-check-alt"></i> 大陸銀行卡信息
            </h5>
            <h5
              v-else-if="銀行卡.lcid == 'others'"
              class="mb-0"
            >
              <i class="fas fa-money-check-alt"></i> 銀行卡信息
            </h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td
            rowspan="2"
            class="text-center"
          >
            <img
              v-if="銀行卡.lcid == 'zh-hk'"
              style="width: 300px"
              :src="HKBankcardFace"
            />
            <img
              v-else-if="銀行卡.lcid == 'zh-cn'"
              style="width: 300px"
              :src="CNBankcardFace"
            />
            <img
              v-else-if="銀行卡.lcid == 'others'"
              style="width: 300px"
              :src="OtherBankcardFace"
            />
          </td>
          <th>
            <div
              v-if="銀行卡.lcid == 'zh-hk'"
              class="mb-0"
            >香港銀行名</div>
            <div
              v-else-if="銀行卡.lcid == 'zh-cn'"
              class="mb-0"
            >
              大陸銀行名
            </div>
            <div
              v-else-if="銀行卡.lcid == 'others'"
              class="mb-0"
            >銀行名</div>
          </th>
          <td>{{ 銀行卡.bank_name }} ({{ 銀行卡.bank_code }})</td>
        </tr>
        <tr>
          <th>
            <div
              v-if="銀行卡.lcid == 'zh-hk'"
              class="mb-0"
            >香港銀行卡號</div>
            <div
              v-else-if="銀行卡.lcid == 'zh-cn'"
              class="mb-0"
            >
              大陸銀行卡號
            </div>
            <div
              v-else-if="銀行卡.lcid == 'others'"
              class="mb-0"
            >銀行卡號</div>
          </th>
          <td>
            {{ 銀行卡.account_no }}
          </td>
        </tr>
        <tr>
          <th
            scope="col"
            colspan="3"
          >
            <h5 class="mb-0">
              <b-form-checkbox
                :id="'駁回' + 銀行卡.lcid + '銀行卡信息'"
                v-model="駁回[銀行卡.lcid + '銀行卡信息']"
                :value="true"
                :unchecked-value="false"
                :disabled="next_status == null"
              >駁回
              </b-form-checkbox>
            </h5>
          </th>
        </tr>
        <tr v-if="駁回[銀行卡.lcid + '銀行卡信息']">
          <td colspan="3">
            <b-form-textarea
              class="text-light bg-dark"
              :name="'駁回' + 銀行卡.lcid + '銀行卡信息'"
              style="width: 100%"
              placeholder="請寫駁回理由"
              rows="5"
              v-model="銀行卡.remark"
              :disabled="!駁回[銀行卡.lcid + '銀行卡信息'] || next_status == null"
            ></b-form-textarea>
          </td>
        </tr>
      </tbody>
    </table>
    <table
      v-if="Client"
      class="table table-bordered text-light"
    >
      <thead>
        <tr>
          <th
            scope="col"
            colspan="2"
          >
            <h5 class="mb-0"><i class="fas fa-user-plus"></i> 客戶補充資料</h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>教育程度</th>
          <td>
            {{ Client.education_level }}
          </td>
        </tr>
        <tr>
          <th
            scope="col"
            colspan="2"
          >
            <h5 class="mb-0">
              <b-form-checkbox
                id="駁回客戶補充資料"
                v-model="駁回.客戶補充資料"
                :value="true"
                :unchecked-value="false"
                :disabled="next_status == null"
              >駁回
              </b-form-checkbox>
            </h5>
          </th>
        </tr>
        <tr v-if="駁回.客戶補充資料">
          <td colspan="2">
            <b-form-textarea
              class="text-light bg-dark"
              name="駁回客戶補充資料"
              style="width: 100%"
              placeholder="請寫駁回理由"
              rows="5"
              v-model="Client.remark"
              :disabled="!駁回.客戶補充資料 || next_status == null"
            ></b-form-textarea>
          </td>
        </tr>
      </tbody>
    </table>
    <table
      v-if="ClientWorkingStatus"
      class="table table-bordered text-light"
    >
      <thead>
        <tr>
          <th
            scope="col"
            colspan="4"
          >
            <h5 class="mb-0"><i class="fas fa-briefcase"></i> 工作狀態</h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="20%">工作狀態</th>
          <td
            width="20%"
            class=""
          >
            {{ ClientWorkingStatus.working_status }}
          </td>
          <th width="20%">雇主名稱</th>
          <td
            width="20%"
            class=""
          >
            {{ ClientWorkingStatus.company_name }}
          </td>
        </tr>
        <tr>
          <th>業務性質</th>
          <td class="">
            {{ ClientWorkingStatus.industry }}
          </td>
          <th>職位</th>
          <td class="">
            {{ ClientWorkingStatus.position }}
          </td>
        </tr>
        <tr>
          <th>電郵地址</th>
          <td class="">
            {{ Client.email }}
          </td>
        </tr>
        <tr>
          <th>名片</th>
          <td
            colspan="3"
            class="text-center"
          >
            <img
              style="width: 300px"
              :src="NameCardFace"
            />
          </td>
        </tr>
        <tr>
          <th
            scope="col"
            colspan="4"
          >
            <h5 class="mb-0">
              <b-form-checkbox
                id="駁回工作狀態"
                v-model="駁回.工作狀態"
                :value="true"
                :unchecked-value="false"
                :disabled="next_status == null"
              >駁回
              </b-form-checkbox>
            </h5>
          </th>
        </tr>
        <tr v-if="駁回.工作狀態">
          <td colspan="4">
            <b-form-textarea
              class="text-light bg-dark"
              name="駁回工作狀態"
              style="width: 100%"
              placeholder="請寫駁回理由"
              rows="5"
              v-model="ClientWorkingStatus.remark"
              :disabled="!駁回.工作狀態 || next_status == null"
            ></b-form-textarea>
          </td>
        </tr>
      </tbody>
    </table>
    <table
      v-if="ClientFinancialStatus"
      class="table table-bordered text-light"
    >
      <thead>
        <tr>
          <th
            scope="col"
            colspan="4"
          >
            <h5 class="mb-0">
              <i class="fas fa-hand-holding-usd"></i> 財政狀況
            </h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>資金來源</th>
          <td class="">
            {{ ClientFinancialStatus.fund_source }}
          </td>
          <th>其他資金來源</th>
          <td class="">
            {{ ClientFinancialStatus.other_fund_source }}
          </td>
        </tr>
        <tr>
          <th>每年收入(港元)</th>
          <td class="">
            {{ ClientFinancialStatus.annual_income }}
          </td>
          <th>資產項目</th>
          <td></td>
        </tr>
        <tr>
          <th>其他資產</th>
          <td></td>
          <th>資產淨值</th>
          <td class="">
            {{ ClientFinancialStatus.net_assets }}
          </td>
        </tr>
        <tr>
          <th
            scope="col"
            colspan="4"
          >
            <h5 class="mb-0">
              <b-form-checkbox
                id="駁回財政狀況"
                v-model="駁回.財政狀況"
                :value="true"
                :unchecked-value="false"
                :disabled="next_status == null"
              >駁回
              </b-form-checkbox>
            </h5>
          </th>
        </tr>
        <tr v-if="駁回.財政狀況">
          <td colspan="4">
            <b-form-textarea
              class="text-light bg-dark"
              name="駁回財政狀況"
              style="width: 100%"
              placeholder="請寫駁回理由"
              rows="5"
              v-model="ClientFinancialStatus.remark"
              :disabled="!駁回.財政狀況 || next_status == null"
            ></b-form-textarea>
          </td>
        </tr>
      </tbody>
    </table>
    <table
      v-if="ClientInvestmentExperience"
      class="table table-bordered text-light"
    >
      <thead>
        <tr>
          <th
            scope="col"
            colspan="4"
          >
            <h5 class="mb-0">
              <i class="fas fa-chart-line"></i> 投資經驗及衍生產品認識
            </h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>投資目標</th>
          <td class="">
            {{ ClientInvestmentExperience.investment_objective }}
          </td>
          <th>股票</th>
          <td class="">
            {{ ClientInvestmentExperience.stock }}
          </td>
        </tr>
        <tr>
          <th>衍生認股證</th>
          <td class="">
            {{ ClientInvestmentExperience.derivative_warrants }}
          </td>
          <th>牛熊證</th>
          <td class="">
            {{ ClientInvestmentExperience.cbbc }}
          </td>
        </tr>
        <tr>
          <th>期貨及期權</th>
          <td class="">
            {{ ClientInvestmentExperience.futures_and_options }}
          </td>
          <th>債券/基金</th>
          <td class="">
            {{ ClientInvestmentExperience.bonds_funds }}
          </td>
        </tr>
        <tr>
          <th>其他投資經驗</th>
          <td class="">
            {{ ClientInvestmentExperience.other_investment_experience }}
          </td>
          <th></th>
          <td></td>
        </tr>
        <tr>
          <th
            scope="col"
            colspan="4"
          >
            <h5 class="mb-0">
              <b-form-checkbox
                id="駁回投資經驗及衍生產品認識"
                v-model="駁回.投資經驗及衍生產品認識"
                :value="true"
                :unchecked-value="false"
                :disabled="next_status == null"
              >駁回
              </b-form-checkbox>
            </h5>
          </th>
        </tr>
        <tr v-if="駁回.投資經驗及衍生產品認識">
          <td colspan="4">
            <b-form-textarea
              class="text-light bg-dark"
              name="駁回投資經驗及衍生產品認識"
              style="width: 100%"
              placeholder="請寫駁回理由"
              rows="5"
              v-model="ClientInvestmentExperience.remark"
              :disabled="!駁回.投資經驗及衍生產品認識 || next_status == null"
            ></b-form-textarea>
          </td>
        </tr>
      </tbody>
    </table>
    <table
      v-if="ClientEvaluationResults"
      class="table table-bordered text-light"
    >
      <thead>
        <tr>
          <th
            colspan="3"
            scope="col"
          >
            <h5 class="mb-0"><i class="fas fa-question"></i> 問題</h5>
          </th>
          <th
            colspan="3"
            scope="col"
          >
            <h5 class="mb-0"><i class="far fa-lightbulb"></i> 答案</h5>
          </th>
          <th
            colspan="1"
            scope="col"
          >
            <h5 class="mb-0"><i class="fas fa-poll"></i> 分數</h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(score, index) of ClientScore"
          :key="index"
        >
          <th colspan="3">{{ score.question_text }}?</th>
          <td
            colspan="3"
            class=""
          >
            {{ score.answer }}
          </td>
          <td
            colspan="1"
            class=""
          >
            {{ score.score }}
          </td>
        </tr>
        <tr>
          <th>
            <h5 class="mb-0">評估結果</h5>
          </th>
          <td>
            <h5 class="mb-0">
              {{ 評估結果 }}
            </h5>
          </td>
          <th>
            <h5 class="mb-0">投資者特徵</h5>
          </th>
          <td>
            <h5 class="mb-0">{{ 投資者特徵 }}</h5>
          </td>
          <th>
            <h5 class="mb-0">風險承受程度</h5>
          </th>
          <td>
            <h5 class="mb-0">{{ 風險承受程度 }}</h5>
          </td>
        </tr>
        <tr>
          <th>
            <h5 class="mb-0">用戶是否同意</h5>
          </th>
          <td>
            <h5 class="mb-0">{{ 用戶是否同意 }}</h5>
          </td>
          <th>
            <h5 class="mb-0">投資者同意的特徵</h5>
          </th>
          <td>
            <h5 class="mb-0">
              {{ ClientEvaluationResults.investor_characteristics }}
            </h5>
          </td>
        </tr>
        <tr>
          <td colspan="7">
            <h5 class="mb-0">
              <b-form-checkbox
                id="駁回問卷調查"
                v-model="駁回.問卷調查"
                :value="true"
                :unchecked-value="false"
                :disabled="next_status == null"
              >駁回
              </b-form-checkbox>
            </h5>
          </td>
        </tr>
        <tr v-if="駁回.問卷調查">
          <td colspan="7">
            <b-form-textarea
              class="text-light bg-dark"
              name="駁回問卷調查"
              style="width: 100%"
              placeholder="請寫駁回理由"
              rows="5"
              v-model="ClientEvaluationResults.remark"
              :disabled="!駁回.問卷調查 || next_status == null"
            ></b-form-textarea>
          </td>
        </tr>
      </tbody>
    </table>
    <table
      v-if="ClientSignature"
      class="table table-bordered text-light"
    >
      <thead>
        <tr>
          <th scope="col">
            <h5 class="mb-0"><i class="fas fa-signature"></i> 簽名</h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="bg-light text-center">
            <img
              style="width: 300px"
              :src="ClientSignature.image"
            />
          </td>
        </tr>
        <tr>
          <th scope="col">
            <h5 class="mb-0">
              <b-form-checkbox
                id="駁回簽名"
                v-model="駁回.簽名"
                :value="true"
                :unchecked-value="false"
                :disabled="next_status == null"
              >駁回
              </b-form-checkbox>
            </h5>
          </th>
        </tr>
        <tr v-if="駁回.簽名">
          <td>
            <b-form-textarea
              class="text-light bg-dark"
              name="駁回簽名"
              style="width: 100%"
              placeholder="請寫駁回理由"
              rows="5"
              v-model="ClientSignature.remark"
              :disabled="!駁回.簽名 || next_status == null"
            ></b-form-textarea>
          </td>
        </tr>
      </tbody>
    </table>
    <!-- <table v-if="ClientBusinessType" class="table table-bordered">
      <tbody>
        <th width="17%">
          <h5 class="mb-0"><i class="fas fa-mail-bulk"></i> 直接促銷</h5>
        </th>
        <td>
          <h5 class="mb-0">
            {{ ClientBusinessType.direct_promotion }}
          </h5>
        </td>
      </tbody>
    </table> -->
    <template
      v-if="next_status"
      #modal-footer=""
    >
      <b-button
        variant="success"
        @click="submit"
      > 提交審核 </b-button>
    </template>
  </b-modal>
</template>
<script>
import axios from "axios";
import { CommonFunctionMixin } from "../mixins/CommonFunctionMixin";
export default {
  data() {
    return {
      id: null,
      uuid: null,
      next_status: null,
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
      地區map: {},
      Client: null,
      ClientIDCard: null,
      ClientAddressProof: null,
      銀行卡s: [],
      ClientWorkingStatus: null,
      ClientFinancialStatus: null,
      ClientInvestmentExperience: null,
      ClientEvaluationResults: null,
      ClientSignature: null,
      ClientBusinessType: null,
      ClientDepositProof: null,
      Introducer: null,
      ClientScore: [],
    };
  },
  mixins: [CommonFunctionMixin],
  created() {
    this.地區map["zh-hk"] = "香港";
    this.地區map["zh-cn"] = "中國";
    this.地區map["others"] = "台灣";
  },
  mounted() {},
  props: {
    title: String,
  },
  methods: {
    submit() {
      const self = this;
      let data = {};
      data["uuid"] = self.uuid;
      data["next_status"] = self.next_status;
      if (self.駁回.身份證信息 && self.ClientIDCard) {
        data["駁回身份證信息"] = self.ClientIDCard.remark;
      }
      if (self.駁回.住址證明 && self.ClientAddressProof) {
        data["駁回住址證明"] = self.ClientAddressProof.remark;
      }
      self.銀行卡s.forEach(function (bankcard) {
        if (self.駁回[`${bankcard.lcid}銀行卡信息`]) {
          data[`駁回${bankcard.lcid}銀行卡信息`] = bankcard.remark;
        }
      });
      if (self.駁回.客戶補充資料 && self.Client) {
        data["駁回客戶補充資料"] = self.Client.remark;
      }
      if (self.駁回.工作狀態 && self.ClientWorkingStatus) {
        data["駁回工作狀態"] = self.ClientWorkingStatus.remark;
      }
      if (self.駁回.財政狀況 && self.ClientFinancialStatus) {
        data["駁回財政狀況"] = self.ClientFinancialStatus.remark;
      }
      if (self.駁回.投資經驗及衍生產品認識 && self.ClientInvestmentExperience) {
        data["駁回投資經驗及衍生產品認識"] =
          self.ClientInvestmentExperience.remark;
      }
      if (self.駁回.問卷調查 && self.ClientEvaluationResults) {
        data["駁回問卷調查"] = self.ClientEvaluationResults.remark;
      }
      if (self.駁回.簽名 && self.ClientSignature) {
        data["駁回簽名"] = self.ClientSignature.remark;
      }
      if (self.駁回.存款證明 && self.ClientDepositProof) {
        data["駁回存款證明"] = self.ClientDepositProof.remark;
      }
      axios
        .put(`AuditClient/${self.uuid}`, data)
        .then((res) => {
          console.log(res);
          self.$emit("audited");
          self.reset();
          self.$refs.modal.hide();
        })
        .catch((error) => {
          console.log(error);
          self.reset();
          self.checkLogin(error);
        });
    },
    showModal(uuid, next_status) {
      const self = this;
      self.uuid = uuid;
      self.next_status = next_status;
      axios
        .get(`Client/${uuid}`)
        .then((res) => {
          // const json = self.getDecryptedJsonObject(res.data);
          console.log(res);
          self.Client = res.data.Client;
          if (self.Client && self.Client.remark && self.Client.remark != "") {
            self.駁回.客戶補充資料 = true;
          }
          self.ClientIDCard = res.data.ClientIDCard;
          if (
            self.ClientIDCard &&
            self.ClientIDCard.remark &&
            self.ClientIDCard.remark != ""
          ) {
            self.駁回.身份證信息 = true;
          }
          self.ClientAddressProof = res.data.ClientAddressProof;
          if (
            self.ClientAddressProof &&
            self.ClientAddressProof.remark &&
            self.ClientAddressProof.remark != ""
          ) {
            self.駁回.住址證明 = true;
          }
          self.銀行卡s = res.data.ClientBankCards;
          self.銀行卡s.forEach(function (bankcard) {
            if (bankcard.remark && bankcard.remark != "") {
              self.駁回[`${bankcard.lcid}銀行卡信息`] = true;
            }
          });
          self.ClientWorkingStatus = res.data.ClientWorkingStatus;
          if (
            self.ClientWorkingStatus &&
            self.ClientWorkingStatus.remark &&
            self.ClientWorkingStatus.remark != ""
          ) {
            self.駁回.工作狀態 = true;
          }
          self.ClientFinancialStatus = res.data.ClientFinancialStatus;
          if (
            self.ClientFinancialStatus &&
            self.ClientFinancialStatus.remark &&
            self.ClientFinancialStatus.remark != ""
          ) {
            self.駁回.財政狀況 = true;
          }
          self.ClientInvestmentExperience = res.data.ClientInvestmentExperience;
          if (
            self.ClientInvestmentExperience &&
            self.ClientInvestmentExperience.remark &&
            self.ClientInvestmentExperience.remark != ""
          ) {
            self.駁回.投資經驗及衍生產品認識 = true;
          }
          self.ClientEvaluationResults = res.data.ClientEvaluationResults;
          if (
            self.ClientEvaluationResults &&
            self.ClientEvaluationResults.remark &&
            self.ClientEvaluationResults.remark != ""
          ) {
            self.駁回.問卷調查 = true;
          }
          self.ClientScore = res.data.ClientScore;
          self.ClientSignature = res.data.ClientSignature;
          if (
            self.ClientSignature &&
            self.ClientSignature.remark &&
            self.ClientSignature.remark != ""
          ) {
            self.駁回.簽名 = true;
          }
          self.ClientBusinessType = res.data.ClientBusinessType;
          self.ClientDepositProof = res.data.ClientDepositProof;
          if (
            self.ClientDepositProof &&
            self.ClientDepositProof.remark &&
            self.ClientDepositProof.remark != ""
          ) {
            self.駁回.存款證明 = true;
          }
          self.Introducer = res.data.Introducer;
          self.$refs.modal.show();
        })
        .catch((error) => {
          console.log(error);
          self.checkLogin(error);
          // self.$refs.modal.show();
        });
    },
    reset() {
      this.uuid = null;
      this.next_status = null;
      this.Client = null;
      this.ClientIDCard = null;
      this.ClientAddressProof = null;
      this.銀行卡s = [];
      this.ClientWorkingStatus = null;
      this.ClientFinancialStatus = null;
      this.ClientInvestmentExperience = null;
      this.ClientEvaluationResults = null;
      this.ClientScore = null;
      this.ClientSignature = null;
      this.ClientBusinessType = null;
      this.ClientDepositProof = null;
      this.Introducer = null;
      for (const property in this.駁回) {
        this.駁回[property] = false;
      }
    },
  },
  computed: {
    評估結果() {
      let result = 0;
      this.ClientScore.forEach((score) => {
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
    AddressProof() {
      return this.uuid ? `LoadAddressProof?uuid=${this.uuid}` : null;
    },
    IDCardFace() {
      return this.uuid ? `LoadIDCardFace?uuid=${this.uuid}` : null;
    },
    IDCardBack() {
      return this.uuid ? `LoadIDCardBack?uuid=${this.uuid}` : null;
    },
    HKBankcardFace() {
      return this.uuid ? `LoadHKBankCard?uuid=${this.uuid}` : null;
    },
    CNBankcardFace() {
      return this.uuid ? `LoadCNBankCard?uuid=${this.uuid}` : null;
    },
    OtherBankcardFace() {
      return this.uuid ? `LoadOtherBankCard?uuid=${this.uuid}` : null;
    },
    NameCardFace() {
      return this.uuid ? `LoadNameCard?uuid=${this.uuid}` : null;
    },
    DepositProof() {
      return this.uuid ? `LoadDepositProof?uuid=${this.uuid}` : null;
    },
  },
};
</script>