<template>
  <form :action="action" method="POST">
    <input type="hidden" name="id" v-model="ClientCreditCard.id" />
    <input type="hidden" name="redirect_route" v-model="redirect_route" />
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
              <i class="fas fa-money-check-alt"></i> 信用卡資料
            </h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="20%" scope="row">發卡機構</th>
          <td width="20%" class="text-warning">
            {{ ClientCreditCard.card_issuer }}
          </td>
          <th width="20%" scope="row">信用卡號碼</th>
          <td width="20%" class="text-warning">
            {{ ClientCreditCard.card_no }}
          </td>
        </tr>
        <tr>
          <th width="25%">信用卡持有人</th>
          <td width="25%" class="text-warning">
            {{ ClientCreditCard.owner_name }}
          </td>
          <th width="25%">信用卡有效日期</th>
          <td width="25%" class="text-warning">
            {{ ClientCreditCard.expiry_date }}
          </td>
        </tr>
        <tr>
          <th width="20%">信用卡</th>
          <td colspan="3">
            <img style="width: 300px" :src="credit_card_image" />
          </td>
        </tr>
        <tr>
          <th width="20%" scope="row">狀態</th>
          <td width="20%" :class="ClientCreditCard.status">
            {{ ClientCreditCard.status }}
          </td>
          <th width="20%" scope="row">經手人</th>
          <td width="20%" class="text-warning">
            {{ ClientCreditCard.issued_by }}
          </td>
        </tr>
        <tr>
          <th width="20%" scope="row">申請發送時間</th>
          <td width="20%" class="text-warning">
            {{ formateDateTime(ClientCreditCard.created_at) }}
          </td>
          <th width="20%" scope="row"></th>
          <td width="20%" class="text-warning"></td>
        </tr>
        <tr>
          <th width="20%" scope="row"></th>
          <td colspan="3"></td>
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
              v-model="ClientCreditCard.remark"
            ></b-form-textarea>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="text-center mb-5">
      <button type="submit" class="btn btn-success">
        <h5 class="mb-0"><i class="far fa-paper-plane"></i> 提交審核</h5>
      </button>
    </div>
  </form>
</template>
<script>
import { CommonFunctionMixin } from "../mixins/CommonFunctionMixin";
export default {
  data() {
    return {
      駁回: false,
      Client: null,
      ClientCreditCard: null,
      ClientIDCard: null,
    };
  },
  mixins: [CommonFunctionMixin],
  components: {},
  props: {
    client: String,
    client_id_card: String,
    client_credit_card: String,
    redirect_route: String,
    action: String,
    credit_card_image: String,
  },
  created() {
    this.Client = JSON.parse(this.client);
    this.ClientIDCard = JSON.parse(this.client_id_card);
    this.ClientCreditCard = JSON.parse(this.client_credit_card);
  },
  methods: {},
};
</script>