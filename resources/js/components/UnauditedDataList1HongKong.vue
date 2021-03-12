<template>
  <div>
    <SearchBar :store-name-spaced="'UnauditedDataList1HongKong'"></SearchBar>
    <button type="button" class="btn btn-success">协议及开户资料下载</button>
    <DataTable
      :value="data"
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
    let self = this;
    axios.post("api/UnauditedDataList1HongKong/all_data").then(function (res) {
      let json = self.getDecryptedJsonObject(res.data);
      self.data = json.data;
      // self.$store.commit("IPOTable/ipos", json.data);
      self.loading = false;
    });
  },
  computed: {
    clientInfo: {
      get() {
        return this.$store.state.UnauditedDataList1HongKong.clientInfo;
      },
      set(value) {
        this.$store.commit("UnauditedDataList1HongKong/clientInfo", value);
      },
    },
  },
};
</script>
<style>
.p-datatable-resizable .p-datatable-thead > tr > th,
.p-datatable-resizable .p-datatable-tfoot > tr > td,
.p-datatable-resizable .p-datatable-tbody > tr > td {
  white-space: normal;
}
</style>