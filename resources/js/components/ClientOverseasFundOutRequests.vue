<template>
  <div>
    <DataTable
      :value="data"
      :filters="filters"
      :selection.sync="SelectedRequests"
      :paginator="true"
      :rows="10"
      :loading="Loading"
      :resizableColumns="true"
      columnResizeMode="fit"
      class="p-datatable-gridlines"
    >
      <Column selectionMode="multiple" headerStyle="width: 3.5em"></Column>
      <Column
        v-for="col of Columns"
        :field="col.field"
        :header="col.header"
        :key="col.field"
        :sortable="true"
        :filterMatchMode="FilterMatchMode[col.field]"
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
          <form
            v-if="slotProps.data.狀態 == 'pending'"
            :action="audit_request_url"
            method="post"
          >
            <input
              type="hidden"
              name="redirect_route"
              value="ClientOverseasFundOutRequests"
            />
            <Button
              name="id"
              :value="slotProps.data.id"
              type="submit"
              icon="pi pi-user-edit"
              label="審核"
              class="p-button-secondary"
            ></Button>
          </form>
          <form v-else :action="view_request_url" method="post">
            <input
              type="hidden"
              name="redirect_route"
              value="ClientOverseasFundOutRequests"
            />
            <Button
              name="id"
              :value="slotProps.data.id"
              type="submit"
              icon="pi pi-user-edit"
              label="查閱"
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
      Columns: [],
      FilterMatchMode: {},
      Loading: false,
      data: null,
      SelectedRequests: null,
    };
  },
  mixins: [DecryptionMixin],
  props: {
    columns: {
      type: String,
      required: true,
    },
    filter_match_mode: {
      type: String,
      required: true,
    },
    audit_request_url: String,
    view_request_url: String,
  },
  components: {
    SearchBox,
    DataTable,
    Column,
    Button,
    Checkbox,
  },
  created() {
    this.Columns = JSON.parse(this.columns);
    this.FilterMatchMode = JSON.parse(this.filter_match_mode);
    this.Loading = true;
    this.loadData();
  },
  methods: {
    loadData() {
      const self = this;
      axios.post("api/ClientOverseasFundOutRequests/all_data").then((res) => {
        const json = self.getDecryptedJsonObject(res.data);
        self.data = json.data;
        self.Loading = false;
      });
    },
  },
  computed: {
    ...mapState({
      filters: (state) => state.ClientOverseasFundOutRequests.filters,
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