<template>
  <div>
    <div class="row no-gutters">
      <div class="col">
        <SearchBox
          :type="'text'"
          :name="'客户姓名'"
          :store-name-spaced="'UnauditedList1'"
        ></SearchBox>
      </div>
      <div class="col">
        <SearchBox
          :type="'text'"
          :name="'證件號碼'"
          :store-name-spaced="'UnauditedList1'"
        ></SearchBox>
      </div>
      <div class="col">
        <SearchBox
          :type="'text'"
          :name="'手機號碼'"
          :store-name-spaced="'UnauditedList1'"
        ></SearchBox>
      </div>
      <div class="col">
        <SearchBox
          :type="'text'"
          :name="'郵箱'"
          :store-name-spaced="'UnauditedList1'"
        ></SearchBox>
      </div>
    </div>
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
          <form :action="audit_client_url" method="post">
            <input type="hidden" name="redirect_route" value="UnauditedList1" />
            <input type="hidden" name="next_status" value="audited1" />
            <Button
              name="uuid"
              :value="slotProps.data.uuid"
              type="submit"
              icon="pi pi-user-edit"
              label="審核"
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
    p_columns: {
      type: String,
      required: true,
    },
    p_filterMatchMode: {
      type: String,
      required: true,
    },
    audit_client_url: String,
  },
  components: {
    SearchBox,
    DataTable,
    Column,
    Button,
    Checkbox,
  },
  created() {
    this.columns = JSON.parse(this.p_columns);
    this.filterMatchMode = JSON.parse(this.p_filterMatchMode);
    this.loading = true;
    this.loadData();
  },
  methods: {
    loadData() {
      let self = this;
      axios.post("api/UnauditedList1/all_data").then((res) => {
        let json = self.getDecryptedJsonObject(res.data);
        self.data = json.data;
        // self.$store.commit("IPOTable/ipos", json.data);
        self.loading = false;
      });
    },
  },
  computed: {
    ...mapState({
      filters: (state) => state.UnauditedList1.filters,
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