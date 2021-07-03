<template>
  <div>
    <table class="table table-bordered text-light">
      <thead>
        <tr>
          <th scope="col" colspan="6">
            <h5 class="mb-0"><i class="far fa-user"></i> 客戶資料</h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="25%" scope="row">客戶姓名</th>
          <td width="25%" class="text-warning">
            {{ ClientIDCard.name_c }}
          </td>
          <th width="25%" scope="row">手機號碼</th>
          <td width="25%" class="text-warning">
            {{ Client.mobile }}
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered text-light">
      <thead>
        <tr>
          <th scope="col" colspan="6">
            <h5 class="mb-0">
              <i class="fas fa-money-check-alt"></i> 銀行卡資料
            </h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="25%" scope="row">銀行</th>
          <td width="25%" class="text-warning">
            {{ ClientBankCard.bank_name }}
          </td>
          <th width="25%" scope="row">銀行碼</th>
          <td width="25%" class="text-warning">
            {{ ClientBankCard.bank_code }}
          </td>
        </tr>
        <tr>
          <th width="25%" scope="row">帳戶號碼</th>
          <td width="25%" class="text-warning">
            {{ ClientBankCard.account_no }}
          </td>
          <th width="25%"></th>
          <td width="25%" class="text-warning"></td>
        </tr>
        <tr>
          <th width="20%" scope="row">銀行卡</th>
          <td colspan="3">
            <img style="width: 300px" :src="bank_card" />
          </td>
        </tr>
        <tr>
          <th width="25%" scope="row">狀態</th>
          <td width="25%" :class="ClientBankCard.status">
            {{ ClientBankCard.status }}
          </td>
          <th width="25%" scope="row">經手人</th>
          <td width="25%" class="text-warning">
            {{ ClientBankCard.issued_by }}
          </td>
        </tr>
        <tr>
          <th width="25%" scope="row">申請發送時間</th>
          <td width="25%" class="text-warning">
            {{ formateDateTime(ClientBankCard.created_at) }}
          </td>
          <th width="25%" scope="row"></th>
          <td width="25%" class="text-warning"></td>
        </tr>
        <tr>
          <th width="25%" scope="row"></th>
          <td colspan="5"></td>
        </tr>
      </tbody>
    </table>
    <table v-if="ClientBankCard.remark" class="table table-bordered text-light">
      <thead>
        <tr>
          <th scope="col">
            <h5 class="mb-0">
              <label class="mb-0">駁回理由</label>
            </h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <b-form-textarea
              name="駁回信息"
              size="lg"
              class="w100 bg-secondary text-white"
              placeholder="請寫駁回理由"
              rows="7"
              v-model="ClientBankCard.remark"
              :readonly="true"
            ></b-form-textarea>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
<script>
import { CommonFunctionMixin } from "../mixins/CommonFunctionMixin";
export default {
  data() {
    return {
      Client: null,
      ClientBankCard: null,
      ClientIDCard: null,
    };
  },
  mixins: [CommonFunctionMixin],
  components: {},
  props: {
    client: String,
    client_id_card: String,
    client_bank_card: String,
    bank_card_image: String,
    redirect_route: String,
  },
  created() {
    this.Client = JSON.parse(this.client);
    this.ClientIDCard = JSON.parse(this.client_id_card);
    this.ClientBankCard = JSON.parse(this.client_bank_card);
  },
  methods: {},
};
</script>