<template>
  <b-container fluid class="p-0">
    <b-row no-gutters>
      <b-col>
        <b-input-group prepend="帳戶號碼">
          <b-form-input
            type="search"
            v-model="filters['帳戶號碼']"
          ></b-form-input>
        </b-input-group>
      </b-col>
      <b-col>
        <b-input-group prepend="客户姓名">
          <b-form-input
            type="search"
            v-model="filters['客户姓名']"
          ></b-form-input>
        </b-input-group>
      </b-col>
      <b-col>
        <b-input-group prepend="手機號碼">
          <b-form-input
            type="search"
            v-model="filters['手機號碼']"
          ></b-form-input>
        </b-input-group>
      </b-col>
      <div class="col">
        <SearchSelectOptions
          :name="'狀態'"
          :store-name-spaced="'ClientFundInRequests'"
        >
          <option value="">全部</option>
          <option value="approved">approved</option>
          <option value="rejected">rejected</option>
        </SearchSelectOptions>
      </div>
    </b-row>
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
              value="ClientFundInRequests"
            />
            <button
              name="id"
              :value="slotProps.data.id"
              type="submit"
              class="btn btn-warning"
            >
              <h5 class="mb-0"><i class="far fa-edit"></i> 審核</h5>
            </button>
          </form>
          <form v-else :action="view_request_url" method="post">
            <input
              type="hidden"
              name="redirect_route"
              value="ClientFundInRequests"
            />
            <button
              name="id"
              :value="slotProps.data.id"
              type="submit"
              class="btn btn-success"
            >
              <h5 class="mb-0"><i class="far fa-eye"></i> 查看</h5>
            </button>
          </form>
        </template>
      </Column>
      <template #empty>沒有找到記錄</template>
    </DataTable>
  </b-container>
</template>
<script>
import SearchBox from "./SearchBox";
import SearchSelectOptions from "./SearchSelectOptions";
import axios from "axios";
import { DecryptionMixin } from "../mixins/DecryptionMixin";
import { CommonFunctionMixin } from "../mixins/CommonFunctionMixin";
export default {
  data() {
    return {
      Columns: [],
      FilterMatchMode: {},
      Loading: false,
      data: null,
      SelectedRequests: [],
      FilteredRequests: [],
      currentPage: 1,
      perPage: 10,
      FilterType: {},
      totalRows: 0,
    };
  },
  mixins: [DecryptionMixin, CommonFunctionMixin],
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
    SearchSelectOptions,
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
      axios.post("api/ClientFundInRequests/all_data").then((res) => {
        const json = self.getDecryptedJsonObject(res.data);
        self.data = json.data;
        self.Loading = false;
      });
    },
  },
  computed: {
    ...mapState({
      filters: (state) => state.ClientFundInRequests.filters,
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