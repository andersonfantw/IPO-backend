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
              <i class="fas fa-money-check-alt"></i> 出金申請資料
            </h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th
            width="17%"
            scope="row"
          >出金帳戶</th>
          <td
            v-if="Request"
            width="17%"
            class="text-warning"
          >
            {{ Request.account_out }}
          </td>
          <th
            width="17%"
            scope="row"
          >金額</th>
          <td
            v-if="Request"
            width="17%"
            class="text-warning"
          >
            {{ Request.amount }}
          </td>
          <th
            width="17%"
            scope="row"
          ></th>
          <td
            width="17%"
            scope="row"
          ></td>
        </tr>
        <tr>
          <th
            width="17%"
            scope="row"
          >入金帳戶</th>
          <td
            v-if="Request"
            width="17%"
            class="text-warning"
          >
            {{ Request.account_in }}
          </td>
          <th
            width="17%"
            scope="row"
          >入金銀行</th>
          <td
            v-if="Request"
            width="17%"
            class="text-warning"
          >
            {{ Request.bank }}
          </td>
          <th
            width="17%"
            scope="row"
          >入金方法</th>
          <td
            v-if="Request"
            width="17%"
            class="text-warning"
          >
            {{ Request.method }}
          </td>
        </tr>
        <tr>
          <th
            width="17%"
            scope="row"
          >狀態</th>
          <td
            v-if="Request"
            width="17%"
            :class="Request.status"
          >
            {{ Request.status }}
          </td>
          <th
            width="17%"
            scope="row"
          >經手人</th>
          <td
            v-if="Request"
            width="17%"
            class="text-warning"
          >
            {{ Request.issued_by }}
          </td>
          <th
            width="17%"
            scope="row"
          >申請發送時間</th>
          <td
            v-if="Request"
            width="17%"
            class="text-warning"
          >
            {{ formateDateTime(Request.created_at) }}
          </td>
        </tr>
      </tbody>
    </table>
    <table
      v-if="Request && Request.status != 'approved'"
      class="table table-bordered text-light"
    >
      <thead>
        <tr v-if="Request.status == 'pending'">
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
        <tr v-if="Request">
          <td>
            <b-form-textarea
              v-if="駁回 || Request.status == 'rejected'"
              name="駁回信息"
              size="lg"
              class="w100 bg-secondary text-white"
              placeholder="請寫駁回理由"
              rows="5"
              :disabled="Request.status == 'rejected'"
              v-model="Request.remark"
            ></b-form-textarea>
          </td>
        </tr>
      </tbody>
    </table>
    <template #modal-footer="">
      <b-button
        v-if="Request && Request.status=='pending'"
        variant="success"
        @click="submit"
      >
        提交審核
      </b-button>
    </template>
  </b-modal>
</template>
<script>
import { CommonFunctionMixin } from "../mixins/CommonFunctionMixin";
export default {
  data() {
    return {
      id: null,
      駁回: false,
      Request: null,
      Client: null,
      AyersAccounts: null,
      ClientIDCard: null,
    };
  },
  mixins: [CommonFunctionMixin],
  props: {
    title: String,
  },
  methods: {
    submit() {
      const self = this;
      let data = {};
      data["駁回信息"] = self.Request.remark;
      axios
        .put(`ClientHKFundOutRequests/${self.id}`, data)
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
    showModal(id) {
      const self = this;
      self.id = id;
      axios
        .get(`ClientHKFundOutRequests/${id}`)
        .then((res) => {
          console.log(res);
          self.Request = res.data.Request;
          self.Client = res.data.Client;
          self.AyersAccounts = res.data.AyersAccounts;
          self.ClientIDCard = res.data.IDCard;
          self.$refs.modal.show();
        })
        .catch((error) => {
          console.log(error);
          self.checkLogin(error);
          // self.$refs.modal.show();
        });
    },
    reset() {
      this.id = null;
      this.Request = null;
      this.Client = null;
      this.AyersAccounts = null;
      this.ClientIDCard = null;
    },
  },
};
</script>