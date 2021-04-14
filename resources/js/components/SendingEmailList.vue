<template>
  <div>
    <div class="row no-gutters">
      <div class="col">
        <SearchBox
          :type="'text'"
          :name="'帳戶號碼'"
          :store-name-spaced="'SendingEmailList'"
        ></SearchBox>
      </div>
      <div class="col">
        <SearchBox
          :type="'text'"
          :name="'客户姓名'"
          :store-name-spaced="'SendingEmailList'"
        ></SearchBox>
      </div>
      <div class="col">
        <SearchBox
          :type="'text'"
          :name="'證件號碼'"
          :store-name-spaced="'SendingEmailList'"
        ></SearchBox>
      </div>
      <div class="col">
        <SearchBox
          :type="'email'"
          :name="'電郵'"
          :store-name-spaced="'SendingEmailList'"
        ></SearchBox>
      </div>
    </div>
    <div class="row no-gutters">
      <div class="col">
        <SearchBox
          :type="'date'"
          :name="'投遞日期'"
          :store-name-spaced="'SendingEmailList'"
        ></SearchBox>
      </div>
      <div class="col">
        <SearchSelectOptions
          :name="'狀態'"
          :store-name-spaced="'SendingEmailList'"
        >
          <option value="">全部</option>
          <option value="未發送">未發送</option>
          <option value="已發送">已發送</option>
        </SearchSelectOptions>
      </div>
      <div class="col">
        <SearchBox
          :type="'text'"
          :name="'電郵發送者'"
          :store-name-spaced="'SendingEmailList'"
        ></SearchBox>
      </div>
      <div class="col"></div>
    </div>
    <button type="button" @click="sendEmails" class="btn btn-success btn-lg">
      <h5 class="m-0"><i class="far fa-envelope"></i> 一鍵發送</h5>
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
      <!-- <Column
        headerStyle="width: 8rem; text-align: center"
        bodyStyle="text-align: center; overflow: visible"
      >
        <template #body="slotProps">
          <form
            v-if="!slotProps.data.帳戶號碼"
            :action="generate_ayers_account_url"
            method="post"
          >
            <input
              type="hidden"
              name="redirect_route"
              value="SendingEmailList"
            />
            <input type="hidden" name="next_status" value="" />
            <Button
              name="uuid"
              :value="slotProps.data.uuid"
              type="submit"
              icon="pi pi-user-edit"
              label="生成Ayers帳戶"
              class="p-button-secondary"
            ></Button>
          </form>
        </template>
      </Column> -->
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
      User: null,
    };
  },
  mixins: [DecryptionMixin],
  props: {
    p_columns: {
      type: String,
      required: true,
    },
    p_filterMatchMode: {
      type: String,
      required: true,
    },
    generate_ayers_account_url: String,
    user: String,
  },
  components: {
    DataTable,
    Column,
    Button,
    SearchBox,
    SearchSelectOptions,
  },
  created() {
    this.columns = JSON.parse(this.p_columns);
    this.filterMatchMode = JSON.parse(this.p_filterMatchMode);
    this.User = JSON.parse(this.user);
    this.loading = true;
    this.loadData();
  },
  methods: {
    sendEmails() {
      let self = this;
      if (self.selectedClients && self.selectedClients.length > 0) {
        self.loading = true;
        axios
          .post("api/OpenAccountEmail/send", {
            clients: self.selectedClients,
            User: self.User,
          })
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
      axios.post("api/SendingEmailList/all_data").then(function (res) {
        let json = self.getDecryptedJsonObject(res.data);
        self.data = json.data;
        // self.$store.commit("IPOTable/ipos", json.data);
        self.loading = false;
      });
    },
  },
  computed: {
    ...mapState({
      filters: (state) => state.SendingEmailList.filters,
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