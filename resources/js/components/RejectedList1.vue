<template>
  <div>
    <SearchBar :store-name-spaced="'RejectedList1'"></SearchBar>
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
      <template #empty>No records found.</template>
    </DataTable>
  </div>
</template>
<script>
import SearchBar from "./SearchBar";
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
  components: { SearchBar, DataTable, Column, Button, Checkbox },
  created() {
    this.columns = JSON.parse(this.p_columns);
    this.filterMatchMode = JSON.parse(this.p_filterMatchMode);
    this.loading = true;
    this.loadData();
  },
  methods: {
    loadData() {
      let self = this;
      axios
        .post("api/RejectedList1/all_data", {
          clientName: self.clientName,
          IDCardNumber: self.IDCardNumber,
          mobileNo: self.mobileNo,
        })
        .then(function (res) {
          let json = self.getDecryptedJsonObject(res.data);
          self.data = json.data;
          // self.$store.commit("IPOTable/ipos", json.data);
          self.loading = false;
        });
    },
  },
  computed: {
    ...mapState({
      filters: (state) => state.RejectedList1.filters,
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