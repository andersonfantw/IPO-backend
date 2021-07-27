<template>
  <form :action="action" method="POST">
    <input type="hidden" name="id" v-model="ClientAddressProofUpdate.id" />
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
          <th scope="col" colspan="4">
            <h5 class="mb-0">
              <i class="fas fa-money-check-alt"></i> (修改前)住址證明
            </h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="20%" scope="row">詳細住址</th>
          <td width="80%" class="text-warning">
            {{ ClientAddressProof.address_text }}
          </td>
        </tr>
        <tr>
          <th width="20%" scope="row">住址證明</th>
          <td width="80%" class="text-warning">
            <img style="width: 300px" :src="old_address_proof_image" />
          </td>
        </tr>
      </tbody>
    </table>
    <table class="table table-bordered text-light">
      <thead>
        <tr>
          <th scope="col" colspan="4">
            <h5 class="mb-0">
              <i class="fas fa-money-check-alt"></i> (修改後)住址證明
            </h5>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th width="20%" scope="row">詳細住址</th>
          <td width="80%" class="text-warning">
            {{ ClientAddressProofUpdate.address_text }}
          </td>
        </tr>
        <tr>
          <th width="20%" scope="row">住址證明</th>
          <td width="80%" class="text-warning">
            <img style="width: 300px" :src="new_address_proof_image" />
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
              v-model="ClientAddressProofUpdate.remark"
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
export default {
  data() {
    return {
      駁回: false,
      Client: null,
      ClientIDCard: null,
      ClientAddressProof: null,
      ClientAddressProofUpdate: null,
    };
  },
  components: {},
  props: {
    client: String,
    client_id_card: String,
    client_address_proof: String,
    client_address_proof_update: String,
    redirect_route: String,
    action: String,
    old_address_proof_image: String,
    new_address_proof_image: String,
  },
  created() {
    this.Client = JSON.parse(this.client);
    this.ClientIDCard = JSON.parse(this.client_id_card);
    this.ClientAddressProof = JSON.parse(this.client_address_proof);
    this.ClientAddressProofUpdate = JSON.parse(
      this.client_address_proof_update
    );
  },
  methods: {},
};
</script>