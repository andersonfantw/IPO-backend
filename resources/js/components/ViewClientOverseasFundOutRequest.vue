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
              <i class="far fa-user-circle"></i> 客戶帳戶資料
            </h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="AyersAccount in AyersAccounts"
          :key="AyersAccount.account_no"
        >
          <th width="25%" scope="row">帳戶號碼</th>
          <td width="25%" class="text-warning">
            {{ AyersAccount.account_no }}
          </td>
          <th width="25%" scope="row">帳戶類型</th>
          <td width="25%" class="text-warning">
            {{ AyersAccount.type }}
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered text-light">
      <thead>
        <tr>
          <th scope="col" colspan="6">
            <h5 class="mb-0">
              <i class="fas fa-money-check-alt"></i> 出入金申請資料
            </h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="25%" scope="row">出金帳戶</th>
          <td width="25%" class="text-warning">
            {{ Request.account_out }}
          </td>
          <th width="25%" scope="row">金額</th>
          <td width="25%" class="text-warning">
            {{ Request.amount }}
          </td>
        </tr>
        <tr>
          <th width="25%" scope="row">入金帳戶</th>
          <td width="25%" class="text-warning">
            {{ Request.account_in }}
          </td>
          <th width="25%" scope="row">入金銀行</th>
          <td width="25%" class="text-warning">
            {{ Request.bank }}
          </td>
        </tr>
        <tr>
          <th width="25%" scope="row">銀行地址</th>
          <td width="25%" class="text-warning">
            {{ Request.bank_address_text }}
          </td>
          <th width="25%" scope="row">SWIFT代碼</th>
          <td width="25%" class="text-warning">
            {{ Request.swift_code }}
          </td>
        </tr>
        <tr>
          <th width="25%" scope="row">狀態</th>
          <td width="25%" class="text-warning">
            {{ Request.status }}
          </td>
          <th width="25%" scope="row">經手人</th>
          <td width="25%" class="text-warning">
            {{ Request.issued_by }}
          </td>
        </tr>
        <tr>
          <th width="25%" scope="row">申請發送時間</th>
          <td width="25%" class="text-warning">
            {{ formateDateTime(Request.created_at) }}
          </td>
          <th width="25%"></th>
          <td width="25%"></td>
        </tr>
      </tbody>
    </table>
    <table v-if="Request.remark" class="table table-bordered text-light">
      <thead>
        <tr>
          <th scope="col">
            <h5 class="mb-0">
              <label class="mb-0" for="駁回">駁回</label>
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
              v-model="Request.remark"
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
      Request: null,
      Client: null,
      AyersAccounts: null,
      ClientIDCard: null,
    };
  },
  mixins: [CommonFunctionMixin],
  components: {},
  props: {
    request: String,
    client: String,
    client_id_card: String,
    ayers_accounts: Array,
    redirect_route: String,
  },
  created() {
    this.Client = JSON.parse(this.client);
    this.ClientIDCard = JSON.parse(this.client_id_card);
    this.Request = JSON.parse(this.request);
    this.AyersAccounts = this.ayers_accounts;
  },
};
</script>