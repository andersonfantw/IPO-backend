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
              <i class="fas fa-money-check-alt"></i> 銀行卡資料
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
            v-if="ClientBankCard"
            width="20%"
            class="text-warning"
          >
            {{ ClientBankCard.bank_name }}
          </td>
          <th
            width="20%"
            scope="row"
          >銀行碼</th>
          <td
            v-if="ClientBankCard"
            width="20%"
            class="text-warning"
          >
            {{ ClientBankCard.bank_code }}
          </td>
        </tr>
        <tr>
          <th
            width="25%"
            scope="row"
          >帳戶號碼</th>
          <td
            v-if="ClientBankCard"
            width="25%"
            class="text-warning"
          >
            {{ ClientBankCard.account_no }}
          </td>
          <th width="25%"></th>
          <td
            width="25%"
            class="text-warning"
          ></td>
        </tr>
        <tr>
          <th
            width="20%"
            scope="row"
          >銀行卡</th>
          <td colspan="3">
            <img
              style="width: 300px"
              :src="BankCard"
            />
          </td>
        </tr>
        <tr>
          <th
            width="20%"
            scope="row"
          >狀態</th>
          <td
            v-if="ClientBankCard"
            width="20%"
            :class="ClientBankCard.status"
          >
            {{ ClientBankCard.status }}
          </td>
          <th
            width="20%"
            scope="row"
          >經手人</th>
          <td
            v-if="ClientBankCard"
            width="20%"
            class="text-warning"
          >
            {{ ClientBankCard.issued_by }}
          </td>
        </tr>
        <tr>
          <th
            width="20%"
            scope="row"
          >申請發送時間</th>
          <td
            v-if="ClientBankCard"
            width="20%"
            class="text-warning"
          >
            {{ formateDateTime(ClientBankCard.created_at) }}
          </td>
          <th
            width="20%"
            scope="row"
          ></th>
          <td
            width="20%"
            class="text-warning"
          ></td>
        </tr>
        <tr>
          <th
            width="20%"
            scope="row"
          ></th>
          <td colspan="3"></td>
        </tr>
      </tbody>
    </table>
    <table
      v-if="ClientBankCard && ClientBankCard.status != 'approved'"
      class="table table-bordered text-light"
    >
      <thead>
        <tr v-if="ClientBankCard.status == 'pending'">
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
        <tr v-if="ClientBankCard">
          <td>
            <b-form-textarea
              v-if="駁回 || ClientBankCard.status == 'rejected'"
              name="駁回信息"
              size="lg"
              class="w100 bg-secondary text-white"
              placeholder="請寫駁回理由"
              rows="5"
              :disabled="ClientBankCard.status == 'rejected'"
              v-model="ClientBankCard.remark"
            ></b-form-textarea>
          </td>
        </tr>
      </tbody>
    </table>
    <template #modal-footer="">
      <b-button
        v-if="ClientBankCard && ClientBankCard.status == 'pending'"
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
      Client: null,
      ClientBankCard: null,
      ClientIDCard: null,
    };
  },
  mixins: [CommonFunctionMixin],
  components: {},
  props: {
    title: String,
  },
  methods: {
    submit() {
      const self = this;
      let data = {};
      data["駁回信息"] = self.ClientBankCard.remark;
      axios
        .put(`ClientBankCards/${self.id}`, data)
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
        .get(`ClientBankCards/${id}`)
        .then((res) => {
          console.log(res);
          self.Client = res.data.Client;
          self.ClientBankCard = res.data.ClientBankCard;
          self.ClientIDCard = res.data.IDCard;
          self.$refs.modal.show();
        })
        .catch((error) => {
          console.log(error);
          self.checkLogin(error);
          //   self.$refs.modal.show();
        });
    },
    reset() {
      this.id = null;
      this.Client = null;
      this.ClientBankCard = null;
      this.ClientIDCard = null;
    },
  },
  computed: {
    BankCard() {
      return this.id ? `LoadBankCard?id=${this.id}` : null;
    },
  },
};
</script>