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
            <h5 class="mb-0">出入金申請資料</h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="17%" scope="row">
            <div class="mb-0">出金帳戶</div>
          </th>
          <td width="17%" scope="row">
            <div class="mb-0">{{ Request.account_out }}</div>
          </td>
          <th width="17%" scope="row">
            <div class="mb-0">金額</div>
          </th>
          <td width="17%" scope="row">
            <div class="mb-0">{{ Request.amount }}</div>
          </td>
          <th width="17%" scope="row"></th>
          <td width="17%" scope="row"></td>
        </tr>
        <tr>
          <th width="17%" scope="row">
            <div class="mb-0">入金帳戶</div>
          </th>
          <td width="17%" scope="row">
            <div class="mb-0">{{ Request.account_in }}</div>
          </td>
          <th width="17%" scope="row">
            <div class="mb-0">入金銀行</div>
          </th>
          <td width="17%" scope="row">
            <div class="mb-0">{{ Request.bank }}</div>
          </td>
          <th width="17%" scope="row">
            <div class="mb-0">SWIFT代碼</div>
          </th>
          <td width="17%" scope="row">
            <div class="mb-0">{{ Request.swift_code }}</div>
          </td>
        </tr>

        <tr>
          <th width="17%" scope="row">
            <div class="mb-0">銀行地址</div>
          </th>
          <td width="17%" scope="row">
            <div class="mb-0">{{ Request.bank_address_text }}</div>
          </td>
          <th width="17%" scope="row"></th>
          <td width="17%" scope="row"></td>
          <th width="17%" scope="row"></th>
          <td width="17%" scope="row"></td>
        </tr>

        <tr>
          <th width="17%" scope="row">
            <div class="mb-0">狀態</div>
          </th>
          <td width="17%" scope="row">
            <div class="mb-0">{{ Request.status }}</div>
          </td>
          <th width="17%" scope="row">
            <div class="mb-0">備註</div>
          </th>
          <td width="17%" scope="row">
            <div class="mb-0">{{ Request.remark }}</div>
          </td>
          <th width="17%" scope="row">
            <div class="mb-0">經手人</div>
          </th>
          <td width="17%" scope="row">
            <div class="mb-0">{{ Request.issued_by }}</div>
          </td>
        </tr>
        <tr>
          <th width="17%" scope="row">
            <div class="mb-0">轉帳時間</div>
          </th>
          <td width="17%" scope="row">
            <div class="mb-0">{{ Request.transfer_time }}</div>
          </td>
          <th width="17%" scope="row">
            <div class="mb-0">申請發送時間</div>
          </th>
          <td width="17%" scope="row">
            <div class="mb-0">{{ Request.created_at }}</div>
          </td>
          <th width="17%" scope="row"></th>
          <td width="17%" scope="row"></td>
        </tr>
      </tbody>
    </table>
  </form>
</template>
<script>
export default {
  data() {
    return {
      Request: null,
      Client: null,
      AyersAccounts: null,
      ClientIDCard: null,
    };
  },
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