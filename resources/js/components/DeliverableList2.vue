<template>
  <div>
    <div class="row no-gutters">
      <div class="col">
        <SearchBox
          :type="'text'"
          :name="'帳戶號碼'"
          :store-name-spaced="'DeliverableList2'"
        ></SearchBox>
      </div>
      <div class="col">
        <SearchSelectOptions
          :name="'開通賬戶類型'"
          :store-name-spaced="'DeliverableList2'"
        >
          <option value="">全部</option>
          <option value="現金賬戶">現金賬戶</option>
          <option value="全權委託賬戶">全權委託賬戶</option>
        </SearchSelectOptions>
      </div>
      <div class="col">
        <SearchBox
          :type="'text'"
          :name="'客户姓名'"
          :store-name-spaced="'DeliverableList2'"
        ></SearchBox>
      </div>
      <div class="col">
        <SearchBox
          :type="'text'"
          :name="'證件號碼'"
          :store-name-spaced="'DeliverableList2'"
        ></SearchBox>
      </div>
    </div>
    <div class="row no-gutters">
      <div class="col">
        <SearchBox
          :type="'text'"
          :name="'手機號碼'"
          :store-name-spaced="'DeliverableList2'"
        ></SearchBox>
      </div>
      <div class="col">
        <SearchBox
          :type="'email'"
          :name="'郵箱'"
          :store-name-spaced="'DeliverableList2'"
        ></SearchBox>
      </div>
      <div class="col"></div>
      <div class="col"></div>
    </div>
    <button type="button" class="btn btn-success btn-lg">
      <h5 class="m-0"><i class="fas fa-download"></i> 協議及開戶資料下載</h5>
    </button>
    <button
      type="button"
      @click="generateAccounts"
      class="btn btn-primary btn-lg"
    >
      <h5 class="m-0"><i class="far fa-user"></i> 產生Ayers帳號</h5>
    </button>
    <DataTable
      :value="data"
      :filters="filters"
      :selection.sync="selectedClients"
      :paginator="true"
      :rows="10"
      :loading="loading"
      :resizableColumns="true"
      columnResizeMode="fit"
      class="p-datatable-gridlines"
    >
      <Column selectionMode="multiple" headerStyle="width: 3.5em"></Column>
      <Column
        v-for="col of columns"
        :field="col.field"
        :header="col.header"
        :key="col.field"
        :sortable="true"
        :filterMatchMode="filterMatchMode[col.field]"
      >
        <template #body="slotProps">
          <p class="text-break">
            {{ slotProps.data[slotProps.column.field] }}
          </p>
        </template>
      </Column>
      <Column
        headerStyle="width: 8rem; text-align: center"
        bodyStyle="text-align: center; overflow: visible"
      >
        <template #body="slotProps">
          <form :action="view_client_url" method="post">
            <input
              type="hidden"
              name="redirect_route"
              value="DeliverableList2"
            />
            <Button
              name="uuid"
              :value="slotProps.data.uuid"
              type="submit"
              icon="pi pi-user-edit"
              label="查看"
              class="p-button-secondary"
            ></Button>
          </form>
        </template>
      </Column>
      <template #empty>沒有找到記錄</template>
    </DataTable>
  </div>
</template>
<script>
import SearchBox from "./SearchBox";
import SearchSelectOptions from "./SearchSelectOptions";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Button from "primevue/button";
import Checkbox from "primevue/checkbox";
import axios from "axios";
import { DecryptionMixin } from "../mixins/DecryptionMixin";
import { mapState } from "vuex";
export default {
  data() {
    return {
      columns: [],
      filterMatchMode: {},
      loading: false,
      data: null,
      selectedClients: null,
    };
  },
  mixins: [DecryptionMixin],
  props: {
    view_client_url: {
      type: String,
      required: true,
    },
    p_columns: {
      type: String,
      required: true,
    },
    p_filterMatchMode: {
      type: String,
      required: true,
    },
    generate_ayers_account_url: String,
  },
  components: {
    SearchBox,
    DataTable,
    Column,
    Button,
    Checkbox,
    SearchSelectOptions,
  },
  created() {
    this.columns = JSON.parse(this.p_columns);
    this.filterMatchMode = JSON.parse(this.p_filterMatchMode);
    this.loading = true;
    this.loadData();
  },
  methods: {
    generateAccounts() {
      let self = this;
      if (self.selectedClients && self.selectedClients.length > 0) {
        self.loading = true;
        axios
          .post("api/AyersAccount/generate", { clients: self.selectedClients })
          .then(function (response) {
            console.log(response);
            self.loadData();
          })
          .catch(function (error) {
            console.log(error);
          });
      } else {
        alert("請先選中客戶！");
      }
    },
    loadData() {
      let self = this;
      axios.post("api/DeliverableList2/all_data").then(function (res) {
        let json = self.getDecryptedJsonObject(res.data);
        self.data = json.data;
        // self.$store.commit("IPOTable/ipos", json.data);
        self.loading = false;
      });
    },
  },
  computed: {
    ...mapState({
      filters: (state) => state.DeliverableList2.filters,
    }),
  },
  watch: {},
};
</script>
<style>
.p-datatable-resizable .p-datatable-thead > tr > th,
.p-datatable-resizable .p-datatable-tfoot > tr > td,
.p-datatable-resizable .p-datatable-tbody > tr > td {
  white-space: normal;
}
</style>