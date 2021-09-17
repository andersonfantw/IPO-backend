<template>
  <b-container fluid>
    <h1 class="text-warning text-center">
      客戶香港出款申請
    </h1>
    <b-row class="mb-3">
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
          :store-name-spaced="'ClientHKFundOutRequests'"
        >
          <option value="">全部</option>
          <option value="pending">pending</option>
          <option value="approved">approved</option>
          <option value="rejected">rejected</option>
          <option value="canceled">canceled</option>
        </SearchSelectOptions>
      </b-col>
    </b-row>
    <b-row class="mb-3">
      <b-col>
        <date-picker
          name="'發送時間'"
          v-model="filters['發送時間']"
          range
          placeholder="發送時間"
        />
      </b-col>
      <b-col>
        <date-picker
          name="'審批時間'"
          v-model="filters['審批時間']"
          range
          placeholder="審批時間"
        />
      </b-col>
      <b-col>
      </b-col>
      <b-col>
      </b-col>
    </b-row>
    <b-button
      variant="success"
      @click="downloadFundOutExcel"
    ><i class="fas fa-download"></i> 出金Excel下載
      <b-spinner
        v-if="DownloadingExcel"
        label="Spinning"
        small
      />
    </b-button>
    <b-row
      v-if="busy"
      class="mt-3"
    >
      <b-col>
        <b-progress
          :max="100"
          show-progress
          animated
          variant="success"
        >
          <b-progress-bar
            :value="progress"
            :label="`${progress.toFixed(2)}%`"
          ></b-progress-bar>
        </b-progress>
      </b-col>
    </b-row>
    <b-row
      no-gutters
      class="mt-3"
    >
      <b-col class="text-center">
        <b-pagination-nav
          v-if="last_page"
          v-model="currentPage"
          :link-gen="linkGen"
          :number-of-pages="last_page"
          @change="onPageChange"
          align="center"
        ></b-pagination-nav>
        <!-- <b-pagination
          v-if="totalRows > 0"
          v-model="currentPage"
          :total-rows="totalRows"
          :per-page="perPage"
          align="center"
        >
        </b-pagination> -->
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
        <!-- <b-form
          v-if="data.item.狀態 == 'pending'"
          :action="audit_request_url"
          method="post"
        >
          <input
            type="hidden"
            name="redirect_route"
            value="ClientHKFundOutRequests"
          />
          <b-button
            name="id"
            :value="data.item.id"
            variant="warning"
            type="submit"
            ><h5 class="mb-0"><i class="far fa-edit"></i> 審核</h5></b-button
          >
        </b-form> -->
        <b-button
          :disabled="Auditing"
          v-if="data.item.狀態 == 'pending'"
          type="button"
          variant="success"
          @click="approve(data.item.id)"
        >
          <h5 class="mb-0"><i class="fas fa-check"></i> 通過</h5>
        </b-button>
        <b-button
          :disabled="Auditing"
          v-if="data.item.狀態 == 'pending'"
          type="button"
          variant="danger"
          @click="reject(data.item.id)"
        >
          <h5 class="mb-0"><i class="fas fa-times"></i> 駁回</h5>
        </b-button>
        <b-button
          :disabled="Auditing"
          variant="warning"
          type="button"
          @click="showDetails(data.item.id)"
        >
          <h5 class="mb-0"><i class="far fa-eye"></i> 查看</h5>
        </b-button>
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
    <b-pagination-nav
      v-if="last_page"
      v-model="currentPage"
      :link-gen="linkGen"
      :number-of-pages="last_page"
      @change="onPageChange"
      align="center"
    ></b-pagination-nav>
    <!-- <b-pagination
      v-if="totalRows > 0"
      v-model="currentPage"
      :total-rows="totalRows"
      :per-page="perPage"
      align="center"
    >
    </b-pagination> -->
    <ClientHKFundOutDetails
      ref="ClientHKFundOutDetails"
      :title="'客戶香港出款申請'"
      @audited="reload"
    />
  </b-container>
</template>
<script>
import DateRange from "./DateRange";
import SearchSelectOptions from "./SearchSelectOptions";
import axios from "axios";
import { DecryptionMixin } from "../mixins/DecryptionMixin";
import { CommonFunctionMixin } from "../mixins/CommonFunctionMixin";
import ClientHKFundOutDetails from "./ClientHKFundOutDetails";
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
      Auditing: false,
      source: null,
      progress: 0,
      last_page: null,
    };
  },
  mixins: [DecryptionMixin, CommonFunctionMixin],
  props: {
    audit_request_url: String,
    view_request_url: String,
    issued_by: String,
  },
  components: {
    SearchSelectOptions,
    DateRange,
    ClientHKFundOutDetails,
  },
  created() {
    this.source = axios.CancelToken.source();
    this.busy = true;
    this.getCounts(axios);
    this.load(1);
  },
  beforeDestroy() {
    this.source.cancel("Operation canceled by the user.");
  },
  methods: {
    linkGen(pageNum) {
      return {
        path: "/ClientHKFundOutRequests/",
        query: { page: pageNum },
      };
    },
    onPageChange(pageNo) {
      this.data = [];
      this.busy = true;
      this.load(pageNo);
    },
    showDetails(id) {
      this.$refs.ClientHKFundOutDetails.showModal(id);
    },
    approve(id) {
      const self = this;
      self.Auditing = true;
      axios
        .put(`AuditClientHKFundOutRequest/${id}`, {
          id: id,
          status: "approved",
        })
        .then((res) => {
          console.log(res);
          self.Auditing = false;
          self.reload();
        })
        .catch((error) => {
          self.Auditing = false;
          alert(error);
          console.log(error);
        });
    },
    reject(id) {
      const self = this;
      self.Auditing = true;
      axios
        .put(`AuditClientHKFundOutRequest/${id}`, {
          id: id,
          status: "rejected",
        })
        .then((res) => {
          console.log(res);
          self.Auditing = false;
          self.reload();
        })
        .catch((error) => {
          self.Auditing = false;
          alert(error);
          console.log(error);
        });
    },
    reload() {
      this.data = [];
      this.busy = true;
      this.load(1);
    },
    load(pageNumber) {
      const self = this;
      axios
        .get("ClientHKFundOutRequests", {
          params: {
            perPage: self.perPage,
            pageNumber: pageNumber,
          },
          cancelToken: self.source.token,
        })
        .then((res) => {
          console.log(res);
          const data = res.data.data;
          const total = res.data.total;
          self.fields = res.data.fields;
          self.FilterType = res.data.filter_type;
          self.data = self.data.concat(data);
          self.totalRows = self.data.length;
          self.last_page = res.data.last_page;
          self.busy = false;
          // if (total <= self.perPage) {
          //   self.progress = 100;
          // } else {
          //   self.progress += (self.perPage / total) * 100;
          // }
          // if (data.length >= self.perPage) {
          //   self.load(pageNumber + 1);
          // } else {
          //   self.busy = false;
          // }
        })
        .catch((error) => {
          if (axios.isCancel(error)) {
            console.log("Request canceled", error.message);
          } else {
            console.log(error);
          }
        });
    },
    onFiltered(filteredItems) {
      this.SelectedRequests = [];
      this.FilteredRequests = filteredItems;
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    },
    downloadFundOutExcel2(e) {
      const self = this;
      self.DownloadingExcel = true;
      axios
        .post(
          "api/ClientHKFundOutRequests/DownloadAyersImportData2",
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
          link.setAttribute("download", "HKFundOutRequests2.xls");
          link.click();
          self.DownloadingExcel = false;
        })
        .catch((error) => {
          console.log(error);
          self.DownloadingExcel = false;
        });
    },
    downloadFundOutExcel(e) {
      const self = this;
      self.DownloadingExcel = true;
      axios
        .post(
          "api/ClientHKFundOutRequests/DownloadAyersImportData",
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
          link.setAttribute("download", "HKFundOutRequests.xls");
          link.click();
          self.DownloadingExcel = false;
        })
        .catch((error) => {
          console.log(error);
          self.DownloadingExcel = false;
        });
      self.downloadFundOutExcel2(e);
    },
  },
  computed: {
    filters: {
      get() {
        return this.$store.state.ClientHKFundOutRequests.filters;
      },
      set(value) {
        this.$store.commit("ClientHKFundOutRequests/filters", value);
      },
    },
    counts: {
      get() {
        return this.$store.state.Menu.counts;
      },
      set(value) {
        this.$store.commit("Menu/counts", value);
      },
    },
  },
  watch: {},
};
</script>
<style>
</style>