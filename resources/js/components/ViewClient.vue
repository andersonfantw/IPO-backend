<template>
  <form :action="action" method="POST">
    <input type="hidden" name="uuid" v-model="uuid" />
    <input type="hidden" name="redirect_route" v-model="redirect_route" />
    <input type="hidden" name="next_status" v-model="next_status" />
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col" colspan="6">
            <h4 class="mb-0">基礎信息</h4>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="17%" scope="row">
            <h5 class="mb-0">地區</h5>
          </th>
          <td width="17%">
            <h5 class="mb-0">{{ 地區map.get(地區) }}</h5>
          </td>
          <th width="17%">
            <h5 class="mb-0">開通賬戶</h5>
          </th>
          <td width="17%">
            <h5 class="mb-0">證券（現金）賬戶</h5>
          </td>
          <th width="17%">
            <h5 class="mb-0">介紹人</h5>
          </th>
          <td width="17%">
            <h5 class="mb-0">{{ 介紹人 }}</h5>
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col" colspan="4">
            <h4 class="mb-0">身份證信息</h4>
          </th>
          <th scope="col">
            <!-- <h4 class="mb-0">
              <label class="mb-0" for="駁回身份證信息">駁回</label
              ><Checkbox
                id="駁回身份證信息"
                class="ml-2"
                v-model="駁回.身份證信息"
                :binary="true"
              />
            </h4> -->
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="20%" scope="row">
            <h5 class="mb-0">姓名</h5>
          </th>
          <td width="20%">
            <h5 class="mb-0">{{ 姓名 }}</h5>
          </td>
          <th width="20%">
            <h5 class="mb-0">英文名</h5>
          </th>
          <td width="20%">
            <h5 class="mb-0">{{ 英文名 }}</h5>
          </td>
          <td width="20%" rowspan="6">
            <textarea
              name="駁回身份證信息"
              style="width: 100%"
              placeholder="請寫駁回理由"
              rows="10"
              v-model="idcard_remark"
              readonly
            ></textarea>
          </td>
        </tr>
        <tr>
          <th scope="row">
            <h5 class="mb-0">性別</h5>
          </th>
          <td>
            <h5 class="mb-0">{{ 性別 }}</h5>
          </td>
          <th>
            <h5 class="mb-0">手機號碼</h5>
          </th>
          <td>
            <h5 class="mb-0">{{ 手機號碼 }}</h5>
          </td>
        </tr>
        <tr>
          <th scope="row">
            <h5 class="mb-0">出生日期</h5>
          </th>
          <td>
            <h5 class="mb-0">{{ 出生日期 }}</h5>
          </td>
          <th>
            <h5 class="mb-0">證件類型</h5>
          </th>
          <td>
            <h5 class="mb-0">身份證</h5>
          </td>
        </tr>
        <tr>
          <th scope="row">
            <h5 class="mb-0">住址</h5>
          </th>
          <td>
            <h5 class="mb-0">{{ 住址 }}</h5>
          </td>
          <th>
            <h5 class="mb-0">證件號碼</h5>
          </th>
          <td>
            <h5 class="mb-0">{{ 證件號碼 }}</h5>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <img style="width: 400px" :src="idcard_face" />
          </td>
          <td colspan="2">
            <img style="width: 400px" :src="idcard_back" />
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col" colspan="4">
            <h4 class="mb-0">銀行卡信息</h4>
          </th>
          <th scope="col">
            <!-- <h4 class="mb-0">
              <label class="mb-0" for="駁回銀行卡信息">駁回</label>
              <Checkbox
                id="駁回銀行卡信息"
                class="ml-2"
                v-model="駁回.銀行卡信息"
                :binary="true"
              />
            </h4> -->
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="20%" scope="row">
            <h5 class="mb-0">銀行</h5>
          </th>
          <td width="20%">
            <h5 class="mb-0">{{ 銀行 }}</h5>
          </td>
          <th width="20%">
            <h5 class="mb-0">銀行卡號</h5>
          </th>
          <td width="20%">
            <h5 class="mb-0">{{ 銀行卡號 }}</h5>
          </td>
          <td width="20%" rowspan="2">
            <textarea
              name="駁回銀行卡信息"
              style="width: 100%"
              placeholder="請寫駁回理由"
              rows="10"
              v-model="bankcard_remark"
              readonly
            ></textarea>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <img style="width: 400px" :src="backcard_face" />
          </td>
          <td colspan="2"></td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col" colspan="4">
            <h4 class="mb-0">客戶補充資料</h4>
          </th>
          <th scope="col">
            <!-- <h4 class="mb-0">
              <label class="mb-0" for="駁回客戶補充資料">駁回</label
              ><Checkbox
                id="駁回客戶補充資料"
                class="ml-2"
                v-model="駁回.客戶補充資料"
                :binary="true"
              />
            </h4> -->
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="20%" scope="row">
            <h5 class="mb-0">教育程度</h5>
          </th>
          <td colspan="3">
            <h5 class="mb-0">{{ 教育程度 }}</h5>
          </td>
          <td width="20%" rowspan="2">
            <textarea
              name="駁回客戶補充資料"
              style="width: 100%"
              placeholder="請寫駁回理由"
              rows="3"
              v-model="Client_remark"
              readonly
            ></textarea>
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col" colspan="4">
            <h4 class="mb-0">工作狀態</h4>
          </th>
          <th scope="col">
            <!-- <h4 class="mb-0">
              <label class="mb-0" for="駁回工作狀態">駁回</label
              ><Checkbox
                id="駁回工作狀態"
                class="ml-2"
                v-model="駁回.工作狀態"
                :binary="true"
              />
            </h4> -->
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="20%" scope="row">
            <h5 class="mb-0">工作狀態</h5>
          </th>
          <td width="20%">
            <h5 class="mb-0">{{ 工作狀態 }}</h5>
          </td>
          <th width="20%" scope="row">
            <h5 class="mb-0">雇主名稱</h5>
          </th>
          <td width="20%">
            <h5 class="mb-0">{{ 雇主名稱 }}</h5>
          </td>
          <td width="20%" rowspan="4">
            <textarea
              name="駁回工作狀態"
              style="width: 100%"
              placeholder="請寫駁回理由"
              rows="10"
              v-model="working_status_remark"
              readonly
            ></textarea>
          </td>
        </tr>
        <tr>
          <th scope="row">
            <h5 class="mb-0">公司電話</h5>
          </th>
          <td>
            <h5 class="mb-0">{{ 公司電話 }}</h5>
          </td>
          <th scope="row">
            <h5 class="mb-0">公司地址</h5>
          </th>
          <td>
            <h5 class="mb-0">{{ 公司地址 }}</h5>
          </td>
        </tr>
        <tr>
          <th scope="row">
            <h5 class="mb-0">業務性質</h5>
          </th>
          <td>
            <h5 class="mb-0">{{ 業務性質 }}</h5>
          </td>
          <th scope="row">
            <h5 class="mb-0">職位</h5>
          </th>
          <td>
            <h5 class="mb-0">{{ 職位 }}</h5>
          </td>
        </tr>
        <tr>
          <th scope="row">
            <h5 class="mb-0">名片</h5>
          </th>
          <td colspan="3">
            <img style="width: 400px" :src="name_card_face" />
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col" colspan="4">
            <h4 class="mb-0">財政狀況</h4>
          </th>
          <th scope="col">
            <!-- <h4 class="mb-0">
              <label class="mb-0" for="駁回財政狀況">駁回</label
              ><Checkbox
                id="駁回財政狀況"
                class="ml-2"
                v-model="駁回.財政狀況"
                :binary="true"
              />
            </h4> -->
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="20%" scope="row">
            <h5 class="mb-0">資金來源</h5>
          </th>
          <td width="20%">
            <h5 class="mb-0">{{ 資金來源 }}</h5>
          </td>
          <th width="20%" scope="row">
            <h5 class="mb-0">其他資金來源</h5>
          </th>
          <td width="20%">
            <h5 class="mb-0">{{ 其他資金來源 }}</h5>
          </td>
          <td width="20%" rowspan="3">
            <textarea
              name="駁回財政狀況"
              style="width: 100%"
              placeholder="請寫駁回理由"
              rows="5"
              v-model="financial_status_remark"
              readonly
            ></textarea>
          </td>
        </tr>
        <tr>
          <th scope="row">
            <h5 class="mb-0">每年收入(港元)</h5>
          </th>
          <td>
            <h5 class="mb-0">{{ 每年收入 }}</h5>
          </td>
          <th scope="row">
            <h5 class="mb-0">資產項目</h5>
          </th>
          <td>
            <h5 class="mb-0">{{ 資產項目 }}</h5>
          </td>
        </tr>
        <tr>
          <th scope="row">
            <h5 class="mb-0">其他資產</h5>
          </th>
          <td>
            <h5 class="mb-0">{{ 其他資產 }}</h5>
          </td>
          <th scope="row">
            <h5 class="mb-0">資產淨值</h5>
          </th>
          <td>
            <h5 class="mb-0">{{ 資產淨值 }}</h5>
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col" colspan="4">
            <h4 class="mb-0">投資經驗及衍生產品認識</h4>
          </th>
          <th scope="col">
            <!-- <h4 class="mb-0">
              <label class="mb-0" for="駁回投資經驗及衍生產品認識">駁回</label
              ><Checkbox
                id="駁回投資經驗及衍生產品認識"
                class="ml-2"
                v-model="駁回.投資經驗及衍生產品認識"
                :binary="true"
              />
            </h4> -->
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="20%" scope="row">
            <h5 class="mb-0">投資目標</h5>
          </th>
          <td width="20%">
            <h5 class="mb-0">{{ 投資目標 }}</h5>
          </td>
          <th width="20%" scope="row">
            <h5 class="mb-0">股票</h5>
          </th>
          <td width="20%">
            <h5 class="mb-0">{{ 股票 }}</h5>
          </td>
          <td width="20%" rowspan="4">
            <textarea
              name="駁回投資經驗及衍生產品認識"
              style="width: 100%"
              placeholder="請寫駁回理由"
              rows="5"
              v-model="investment_experience_remark"
              readonly
            ></textarea>
          </td>
        </tr>
        <tr>
          <th scope="row">
            <h5 class="mb-0">衍生認股證</h5>
          </th>
          <td>
            <h5 class="mb-0">{{ 衍生認股證 }}</h5>
          </td>
          <th scope="row">
            <h5 class="mb-0">牛熊證</h5>
          </th>
          <td>
            <h5 class="mb-0">{{ 牛熊證 }}</h5>
          </td>
        </tr>
        <tr>
          <th scope="row">
            <h5 class="mb-0">期貨及期權</h5>
          </th>
          <td>
            <h5 class="mb-0">{{ 期貨及期權 }}</h5>
          </td>
          <th scope="row">
            <h5 class="mb-0">債券/基金</h5>
          </th>
          <td>
            <h5 class="mb-0">{{ 債券基金 }}</h5>
          </td>
        </tr>
        <tr>
          <th scope="row">
            <h5 class="mb-0">其他投資經驗</h5>
          </th>
          <td>
            <h5 class="mb-0">{{ 其他投資經驗 }}</h5>
          </td>
          <th scope="row">
            <h5 class="mb-0">是否有意進行衍生產品投資?</h5>
          </th>
          <td>
            <h5 class="mb-0">{{ 是否有意進行衍生產品投資 }}</h5>
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th colspan="2" scope="col">
            <h4 class="mb-0">問題</h4>
          </th>
          <th colspan="2" scope="col">
            <h4 class="mb-0">答案</h4>
          </th>
          <th colspan="2" scope="col">
            <h4 class="mb-0">分數</h4>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th colspan="2" width="33%" scope="row">
            <h5 class="mb-0">你現時的歲數是?</h5>
          </th>
          <td colspan="2" width="33%">
            <h5 class="mb-0">{{ age }}</h5>
          </td>
          <td colspan="2" width="33%">
            <h5 class="mb-0">{{ ageToScore(age) }}</h5>
          </td>
        </tr>
        <tr>
          <th colspan="2" width="33%" scope="row">
            <h5 class="mb-0">你的教育程度是?</h5>
          </th>
          <td colspan="2" width="33%">
            <h5 class="mb-0">{{ 教育程度 }}</h5>
          </td>
          <td colspan="2" width="33%">
            <h5 class="mb-0">{{ score(教育程度) }}</h5>
          </td>
        </tr>
        <tr>
          <th colspan="2" width="33%" scope="row">
            <h5 class="mb-0">
              你有多少年投資經驗(不包括儲蓄、定期儲蓄及外幣儲蓄)?
            </h5>
          </th>
          <td colspan="2" width="33%">
            <h5 class="mb-0">{{ 你有多少年投資經驗 }}</h5>
          </td>
          <td colspan="2" width="33%">
            <h5 class="mb-0">{{ score(你有多少年投資經驗) }}</h5>
          </td>
        </tr>
        <tr v-for="問卷 in 問卷調查" :key="問卷.id">
          <th colspan="2" width="33%" scope="row">
            <h5 class="mb-0">{{ 問卷.question_text }}?</h5>
          </th>
          <td colspan="2" width="33%">
            <h5 class="mb-0">{{ 問卷.answer }}</h5>
          </td>
          <td colspan="2" width="33%">
            <h5
              v-if="問卷.question_text != '沒有任何衍生産品知識及經驗'"
              class="mb-0"
            >
              {{ answerToScore(問卷.answer) }}
            </h5>
          </td>
        </tr>
        <tr>
          <th width="17%" scope="row">
            <h4 class="mb-0">評估結果</h4>
          </th>
          <td width="17%">
            <h4 class="mb-0">
              {{ 評估結果 }}
            </h4>
          </td>
          <th width="17%" scope="row">
            <h4 class="mb-0">投資者特徵</h4>
          </th>
          <td width="17%">
            <h4 class="mb-0">{{ 投資者特徵 }}</h4>
          </td>
          <td rowspan="2" width="17%">
            <!-- <h4 class="mb-0">
              <label class="mb-0" for="駁回問卷調查">駁回</label
              ><Checkbox
                id="駁回問卷調查"
                class="ml-2"
                v-model="駁回.問卷調查"
                :binary="true"
              />
            </h4> -->
            <textarea
              name="駁回問卷調查"
              style="width: 100%"
              placeholder="請寫駁回理由"
              rows="3"
              v-model="evaluation_results_remark"
              readonly
            ></textarea>
          </td>
        </tr>
        <tr>
          <th width="17%" scope="row">
            <h4 class="mb-0">風險承受程度</h4>
          </th>
          <td width="17%">
            <h4 class="mb-0">{{ 風險承受程度 }}</h4>
          </td>
          <th width="17%" scope="row">
            <h4 class="mb-0">用戶是否同意</h4>
          </th>
          <td width="17%">
            <h4 class="mb-0">{{ computed用戶是否同意 }}</h4>
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th colspan="4" scope="col">
            <h4 class="mb-0">簽名</h4>
          </th>
          <th scope="col">
            <!-- <h4 class="mb-0">
              <label class="mb-0" for="駁回簽名">駁回</label
              ><Checkbox
                id="駁回簽名"
                class="ml-2"
                v-model="駁回.簽名"
                :binary="true"
              />
            </h4> -->
          </th>
        </tr>
      </thead>
      <tbody>
        <td colspan="4">
          <img style="width: 400px" :src="簽名" />
        </td>
        <td width="20%">
          <textarea
            name="駁回簽名"
            style="width: 100%"
            placeholder="請寫駁回理由"
            rows="10"
            v-model="signature_remark"
            readonly
          ></textarea>
        </td>
      </tbody>
    </table>
    <table class="table table-bordered">
      <tbody>
        <th width="17%">
          <h4 class="mb-0">直接促銷</h4>
        </th>
        <td>
          <h4 class="mb-0">{{ 直接促銷 }}</h4>
        </td>
      </tbody>
    </table>
    <!-- <Button type="submit" label="提交審核" icon="pi pi-check" iconPos="right" /> -->
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
      地區map: new Map(),
      評估結果: 0,
      駁回: {
        身份證信息: false,
        銀行卡信息: false,
        客戶補充資料: false,
        工作狀態: false,
        財政狀況: false,
        投資經驗及衍生產品認識: false,
        問卷調查: false,
        簽名: false,
      },
    };
  },
  components: { Button, InputSwitch, Checkbox },
  props: {
    uuid: String,
    地區: String,
    介紹人: String,
    姓名: String,
    英文名: String,
    性別: String,
    手機號碼: String,
    出生日期: String,
    住址: String,
    證件號碼: String,
    idcard_face: String,
    idcard_back: String,
    銀行: String,
    銀行卡號: String,
    backcard_face: String,
    教育程度: String,
    工作狀態: String,
    雇主名稱: String,
    公司電話: String,
    公司地址: String,
    業務性質: String,
    服務年資: String,
    職位: String,
    name_card_face: String,
    資金來源: String,
    其他資金來源: String,
    每年收入: String,
    資產項目: String,
    其他資產: String,
    資產淨值: String,
    投資目標: String,
    股票: String,
    衍生認股證: String,
    牛熊證: String,
    期貨及期權: String,
    債券基金: String,
    其他投資經驗: String,
    是否有意進行衍生產品投資: String,
    問卷調查: Array,
    用戶是否同意: Number,
    簽名: String,
    直接促銷: String,
    action: String,
    redirect_route: String,
    next_status: String,
    Client_remark: String,
    idcard_remark: String,
    bankcard_remark: String,
    working_status_remark: String,
    financial_status_remark: String,
    investment_experience_remark: String,
    evaluation_results_remark: String,
    signature_remark: String,
  },
  created() {
    this.地區map.set("zh-hk", "香港");
    this.地區map.set("zh-cn", "中國");
    this.問卷調查.forEach((問卷) => {
      if (問卷.question_text != "沒有任何衍生産品知識及經驗") {
        this.評估結果 += this.answerToScore(問卷.answer);
      }
    });
    this.評估結果 +=
      this.score(this.你有多少年投資經驗) + this.score(this.教育程度);
    this.駁回.身份證信息 = this.idcard_remark ? true : false;
    this.駁回.銀行卡信息 = this.bankcard_remark ? true : false;
    this.駁回.客戶補充資料 = this.Client_remark ? true : false;
    this.駁回.工作狀態 = this.working_status_remark ? true : false;
    this.駁回.財政狀況 = this.financial_status_remark ? true : false;
    this.駁回.投資經驗及衍生產品認識 = this.investment_experience_remark
      ? true
      : false;
    this.駁回.問卷調查 = this.evaluation_results_remark ? true : false;
    this.駁回.簽名 = this.signature_remark ? true : false;
  },
  computed: {
    age() {
      let date1 = new Date(this.出生日期);
      let date2 = new Date();
      let Difference_In_Time = date2.getTime() - date1.getTime();
      let Difference_In_Years = Difference_In_Time / (1000 * 3600 * 24) / 365;
      return Math.floor(Difference_In_Years);
    },
    你有多少年投資經驗() {
      let score = 0;
      let result = null;
      if (this.score(this.股票) > score) {
        score = this.score(this.股票);
        result = this.股票;
      } else if (this.score(this.衍生認股證) > score) {
        score = this.score(this.衍生認股證);
        result = this.衍生認股證;
      } else if (this.score(this.牛熊證) > score) {
        score = this.score(this.牛熊證);
        result = this.牛熊證;
      } else if (this.score(this.期貨及期權) > score) {
        score = this.score(this.期貨及期權);
        result = this.期貨及期權;
      } else if (this.score(this.債券基金) > score) {
        score = this.score(this.債券基金);
        result = this.債券基金;
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
    computed用戶是否同意() {
      return this.用戶是否同意 ? "是" : "否";
    },
  },
  methods: {
    score(answer) {
      let A = /^A/i;
      let B = /^B/i;
      let C = /^C/i;
      let D = /^D/i;
      let E = /^E/i;
      let 是 = /是/i;
      let 否 = /否/i;
      if (A.test(answer)) {
        return 5;
      } else if (B.test(answer)) {
        return 4;
      } else if (C.test(answer)) {
        return 3;
      } else if (D.test(answer)) {
        return 2;
      } else if (E.test(answer)) {
        return 1;
      } else if (是.test(answer)) {
        return 1;
      } else if (否.test(answer)) {
        return 0;
      }
    },
    ageToScore(age) {
      if (age >= 18 && age <= 25) {
        return 5;
      } else if (age >= 26 && age <= 35) {
        return 4;
      } else if (age >= 36 && age <= 50) {
        return 3;
      } else if (age >= 51 && age <= 65) {
        return 2;
      } else if (age > 65) {
        return 1;
      }
    },
    answerToScore(answer) {
      if (this.isJson(answer)) {
        let E = /^E/i;
        answer = JSON.parse(answer);
        let score = 0;
        answer.forEach((element) => {
          if (!E.test(element)) {
            score += 2;
          }
        });
        return score;
      } else {
        let score = this.score(answer);
        return score;
      }
    },
    isJson(str) {
      try {
        JSON.parse(str);
      } catch (e) {
        return false;
      }
      return true;
    },
  },
};
</script>