<template>
  <b-container fluid>
    <h1 class="text-warning text-center">
      客戶海外出款申請
      <b-spinner
        v-if="busy"
        variant="warning"
      ></b-spinner>
    </h1>
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
      <b-col>
        <SearchSelectOptions
          :name="'狀態'"
          :store-name-spaced="'ClientOverseasFundOutRequests'"
        >
          <option value="">全部</option>
          <option value="pending">pending</option>
          <option value="approved">approved</option>
          <option value="rejected">rejected</option>
          <option value="canceled">canceled</option>
        </SearchSelectOptions>
      </b-col>
    </b-row>
    <b-row no-gutters>
      <b-col>
        <DateRange
          :name="'發送時間'"
          v-model="filters['發送時間']"
        />
      </b-col>
      <b-col>
        <DateRange
          :name="'審批時間'"
          v-model="filters['審批時間']"
        />
      </b-col>
    </b-row>
    <b-button
      variant="success"
      @click="downloadExcel"
    ><i class="fas fa-download"></i> 入金Excel下載
      <b-spinner
        v-if="DownloadingExcel"
        label="Spinning"
        small
      />
    </b-button>
    <b-row
      no-gutters
      class="mt-3"
    >
      <b-col class="text-center">
        <b-pagination
          v-if="totalRows > 0"
          v-model="currentPage"
          :total-rows="totalRows"
          :per-page="perPage"
          align="center"
        >
        </b-pagination>
      </b-col>
    </b-row>
    <b-table
      hover
      bordered
      dark
      :items="data"
      :fields="fields"
      :current-page="currentPage"
      :per-page="perPage"
      :filter="filters"
      :filter-function="filter"
      show-empty
      empty-filtered-text="沒有找到記錄"
      empty-text="沒有找到記錄"
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
            value="ClientOverseasFundOutRequests"
          />
          <b-button
            name="id"
            :value="data.item.id"
            variant="warning"
            type="submit"
          >
            <h5 class="mb-0"><i class="far fa-edit"></i> 審核</h5>
          </b-button>
        </b-form>
        <b-form
          v-else
          :action="view_request_url"
          method="post"
        >
          <input
            type="hidden"
            name="redirect_route"
            value="ClientOverseasFundOutRequests"
          />
          <b-button
            name="id"
            :value="data.item.id"
            variant="success"
            type="submit"
          >
            <h5 class="mb-0"><i class="far fa-eye"></i> 查看</h5>
          </b-button>
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
import DateRange from "./DateRange";
import SearchSelectOptions from "./SearchSelectOptions";
import axios from "axios";
import { DecryptionMixin } from "../mixins/DecryptionMixin";
import { CommonFunctionMixin } from "../mixins/CommonFunctionMixin";
export default {
  data() {
    return {
      fields: [],
      FilterMatchMode: {},
      busy: false,
      data: [],
      SelectedRequests: [],
      FilteredRequests: [],
      currentPage: 1,
      perPage: 30,
      FilterType: {},
      totalRows: 0,
      DownloadingExcel: false,
    };
  },
  mixins: [DecryptionMixin, CommonFunctionMixin],
  props: {
    audit_request_url: String,
    view_request_url: String,
  },
  components: {
    SearchSelectOptions,
    DateRange,
  },
  created() {
    this.busy = true;
    this.loadData(1);
  },
  methods: {
    loadData(pageNumber) {
      const self = this;
      axios
        .get("ClientOverseasFundOutRequests", {
          params: {
            perPage: self.perPage,
            pageNumber: pageNumber,
          },
        })
        .then((res) => {
          console.log(res);
          const data = res.data.data;
          self.fields = res.data.fields;
          self.FilterType = res.data.filter_type;
          self.data = self.data.concat(data);
          self.totalRows = self.data.length;
          if (data.length >= self.perPage) {
            self.loadData(pageNumber + 1);
          } else {
            self.busy = false;
          }
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
    downloadExcel(e) {
      const self = this;
      self.DownloadingExcel = true;
      axios
        .post(
          "api/ClientOverseasFundOutRequests/DownloadAyersImportData",
          {},
          {
            responseType: "arraybuffer",
          }
        )
        .then((response) => {
          console.log(response);
          const url = window.URL.createObjectURL(new Blob([response.data]));
          const link = document.createElement("a");
          link.href = url;
          link.setAttribute("download", "OverseasFundOutRequests.xlsx");
          link.click();
          self.DownloadingExcel = false;
        })
        .catch((error) => {
          console.log(error);
          self.DownloadingExcel = false;
        });
    },
  },
  computed: {
    filters: {
      get() {
        return this.$store.state.ClientOverseasFundOutRequests.filters;
      },
      set(value) {
        this.$store.commit("ClientOverseasFundOutRequests/filters", value);
      },
    },
  },
  watch: {},
};
</script>
<style>
</style>