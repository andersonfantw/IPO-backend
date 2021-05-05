<template>
  <form :action="action" method="POST">
    <input type="hidden" name="id" v-model="Request.id" />
    <input type="hidden" name="redirect_route" v-model="redirect_route" />
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col" colspan="6">
            <h5 class="mb-0">客戶資料</h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="25%" scope="row">
            <div class="mb-0">客戶姓名</div>
          </th>
          <td width="25%">
            <div class="mb-0">{{ ClientIDCard.name_c }}</div>
          </td>
          <th width="25%" scope="row">
            <div class="mb-0">手機號碼</div>
          </th>
          <td width="25%">
            <div class="mb-0">{{ Client.mobile }}</div>
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col" colspan="6">
            <h5 class="mb-0">客戶帳戶資料</h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="AyersAccount in AyersAccounts"
          :key="AyersAccount.account_no"
        >
          <th width="25%" scope="row">
            <div class="mb-0">帳戶號碼</div>
          </th>
          <td width="25%">
            <div class="mb-0">{{ AyersAccount.account_no }}</div>
          </td>
          <th width="25%" scope="row">
            <div class="mb-0">帳戶類型</div>
          </th>
          <td width="25%">
            <div class="mb-0">{{ AyersAccount.type }}</div>
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col" colspan="6">
            <h5 class="mb-0">入金申請資料</h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="20%" scope="row">
            <div class="mb-0">銀行</div>
          </th>
          <td width="20%" scope="row">
            <div class="mb-0">{{ Request.bank }}</div>
          </td>
          <th width="20%" scope="row">
            <div class="mb-0">入金方法</div>
          </th>
          <td width="20%" scope="row">
            <div class="mb-0">{{ Request.method }}</div>
          </td>
        </tr>
        <tr>
          <th width="20%" scope="row">
            <div class="mb-0">狀態</div>
          </th>
          <td width="20%" scope="row">
            <div class="mb-0">{{ Request.status }}</div>
          </td>
          <th width="20%" scope="row">
            <div class="mb-0">經手人</div>
          </th>
          <td width="20%" scope="row">
            <div class="mb-0">{{ Request.issued_by }}</div>
          </td>
        </tr>
        <tr>
          <th width="20%" scope="row">
            <div class="mb-0">轉帳時間</div>
          </th>
          <td width="20%" scope="row">
            <div class="mb-0">{{ formateDateTime(Request.transfer_time) }}</div>
          </td>
          <th width="20%" scope="row">
            <div class="mb-0">申請發送時間</div>
          </th>
          <td width="20%" scope="row">
            <div class="mb-0">{{ formateDateTime(Request.created_at) }}</div>
          </td>
        </tr>
        <tr>
          <th width="20%" scope="row">
            <div class="mb-0">入金證明</div>
          </th>
          <td colspan="3">
            <img :src="Request.receipt" />
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th scope="col">
            <h5 class="mb-0">
              <label class="mb-0" for="駁回">駁回</label
              ><Checkbox id="駁回" class="ml-2" v-model="駁回" :binary="true" />
            </h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <textarea
              v-if="駁回"
              name="駁回信息"
              style="width: 100%"
              placeholder="請寫駁回理由"
              rows="7"
              v-model="Request.remark"
            ></textarea>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="text-center mb-5">
      <Button
        type="submit"
        label="提交審核"
        icon="pi pi-check"
        iconPos="right"
      />
    </div>
  </form>
</template>
<script>
import Button from "primevue/button";
import Checkbox from "primevue/checkbox";
import { CommonFunctionMixin } from "../mixins/CommonFunctionMixin";
export default {
  data() {
    return {
      駁回: false,
      Request: null,
      Client: null,
      AyersAccounts: null,
      ClientIDCard: null,
    };
  },
  mixins: [CommonFunctionMixin],
  components: {
    Button,
    Checkbox,
  },
  props: {
    request: String,
    client: String,
    client_id_card: String,
    ayers_accounts: Array,
    redirect_route: String,
    action: String,
  },
  created() {
    this.Client = JSON.parse(this.client);
    this.ClientIDCard = JSON.parse(this.client_id_card);
    this.Request = JSON.parse(this.request);
    this.AyersAccounts = this.ayers_accounts;
  },
  methods: {},
};
</script>