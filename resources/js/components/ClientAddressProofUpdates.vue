<template>
  <b-container fluid class="p-0">
    <b-table
      hover
      bordered
      dark
      :items="data"
      :fields="Columns"
      :current-page="currentPage"
      :per-page="perPage"
      :filter="filters"
      :filter-function="filter"
      show-empty
      empty-filtered-text="沒有找到記錄"
      empty-text="沒有找到記錄"
      :busy="Loading"
      @filtered="onFiltered"
    >
      <template #cell(操作)="data">
        <b-form
          v-if="data.item.狀態 == 'pending'"
          :action="audit_request_url"
          method="post"
        >
          <input
            type="hidden"
            name="redirect_route"
            value="ClientAddressProofUpdates"
          />
          <b-button
            name="id"
            :value="data.item.id"
            variant="warning"
            type="submit"
            ><h5 class="mb-0"><i class="far fa-edit"></i> 審核</h5></b-button
          >
        </b-form>
        <b-form v-else :action="view_request_url" method="post">
          <input
            type="hidden"
            name="redirect_route"
            value="ClientAddressProofUpdates"
          />
          <b-button
            name="id"
            :value="data.item.id"
            variant="success"
            type="submit"
            ><h5 class="mb-0"><i class="far fa-eye"></i> 查看</h5></b-button
          >
        </b-form>
      </template>
      <template #empty="scope">
        {{ scope.emptyText }}
      </template>
      <template #emptyfiltered="scope">
        {{ scope.emptyFilteredText }}
      </template>
      <template #table-busy>
        <div class="text-center text-warning">
          <b-spinner class="align-middle"></b-spinner>
        </div>
      </template>
    </b-table>
    <b-pagination
      v-if="totalRows > 0"
      v-model="currentPage"
      :total-rows="totalRows"
      :per-page="perPage"
      align="center"
    >
    </b-pagination>
  </b-container>
</template>
<script>
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
      DownloadingExcel: false,
    };
  },
  mixins: [DecryptionMixin, CommonFunctionMixin],
  props: {
    columns: {
      type: String,
      required: true,
    },
    filter_type: {
      type: String,
      required: true,
    },
    audit_request_url: String,
    view_request_url: String,
  },
  components: {
    SearchSelectOptions,
  },
  created() {
    this.Columns = JSON.parse(this.columns);
    this.FilterType = JSON.parse(this.filter_type);
    this.Loading = true;
    this.loadData();
  },
  methods: {
    loadData() {
      const self = this;
      axios
        .post("api/ClientAddressProofUpdates/all_data")
        .then((res) => {
          console.log(res);
          self.data = res.data.data;
          self.FilteredRequests = self.data;
          self.totalRows = self.data.length;
          self.Loading = false;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    onFiltered(filteredItems) {
      this.SelectedRequests = [];
      this.FilteredRequests = filteredItems;
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    },
  },
  computed: {
    filters: {
      get() {
        return this.$store.state.ClientAddressProofUpdates.filters;
      },
      set(value) {
        this.$store.commit("ClientAddressProofUpdates/filters", value);
      },
    },
  },
};
</script>