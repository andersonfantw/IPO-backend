<template>
  <b-modal
    ref="modal"
    size="xl"
    :title="title"
    body-bg-variant="dark"
    body-text-variant="light"
  >
    <table class="table table-bordered text-light">
      <thead>
        <tr>
          <th
            scope="col"
            colspan="6"
          >
            <h5 class="mb-0"><i class="far fa-user"></i> 客戶資料</h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th
            width="25%"
            scope="row"
          >客戶姓名</th>
          <td
            v-if="ClientIDCard"
            width="25%"
            class="text-warning"
          >
            {{ ClientIDCard.name_c }}
          </td>
          <th
            width="25%"
            scope="row"
          >手機號碼</th>
          <td
            v-if="Client"
            width="25%"
            class="text-warning"
          >
            {{ Client.mobile }}
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered text-light">
      <thead>
        <tr>
          <th
            scope="col"
            colspan="6"
          >
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
          <th
            width="25%"
            scope="row"
          >帳戶號碼</th>
          <td
            width="25%"
            class="text-warning"
          >
            {{ AyersAccount.account_no }}
          </td>
          <th
            width="25%"
            scope="row"
          >帳戶類型</th>
          <td
            width="25%"
            class="text-warning"
          >
            {{ AyersAccount.type }}
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered text-light">
      <thead>
        <tr>
          <th
            scope="col"
            colspan="6"
          >
            <h5 class="mb-0">
              <i class="fas fa-money-check-alt"></i> 入金申請資料
            </h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th
            width="20%"
            scope="row"
          >銀行</th>
          <td
            v-if="Request"
            width="20%"
            class="text-warning"
          >
            {{ Request.bank }}
          </td>
          <th
            width="20%"
            scope="row"
          >入金方法</th>
          <td
            v-if="Request"
            width="20%"
            class="text-warning"
          >
            {{ Request.method }}
          </td>
        </tr>
        <tr>
          <th
            width="20%"
            scope="row"
          >銀行卡</th>
          <td colspan="3">
            <img
              style="width: 300px"
              :src="bank_card"
            />
          </td>
        </tr>
        <tr>
          <th
            width="20%"
            scope="row"
          >狀態</th>
          <td
            v-if="Request"
            width="20%"
            :class="Request.status"
          >
            {{ Request.status }}
          </td>
          <th
            width="20%"
            scope="row"
          >經手人</th>
          <td
            width="20%"
            class="text-warning"
          >
            {{ Request.issued_by }}
          </td>
        </tr>
        <tr>
          <th
            width="20%"
            scope="row"
          >轉帳時間</th>
          <td
            width="20%"
            class="text-warning"
          >
            {{ formateDateTime(Request.transfer_time) }}
          </td>
          <th
            width="20%"
            scope="row"
          >申請發送時間</th>
          <td
            width="20%"
            class="text-warning"
          >
            {{ formateDateTime(Request.created_at) }}
          </td>
        </tr>
        <tr>
          <th
            width="20%"
            scope="row"
          >入金證明</th>
          <td colspan="3">
            <img
              style="width: 500px"
              :src="receipt"
            />
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered text-light">
      <thead>
        <tr>
          <th scope="col">
            <h5 class="mb-0">
              <b-form-checkbox
                id="駁回"
                v-model="駁回"
                :value="true"
                :unchecked-value="false"
              >駁回
              </b-form-checkbox>
            </h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <b-form-textarea
              v-if="駁回"
              name="駁回信息"
              size="lg"
              class="w100 bg-secondary text-white"
              placeholder="請寫駁回理由"
              rows="7"
              v-model="Request.remark"
            ></b-form-textarea>
          </td>
        </tr>
      </tbody>
    </table>
  </b-modal>
</template>
<script>
export default {};
</script>