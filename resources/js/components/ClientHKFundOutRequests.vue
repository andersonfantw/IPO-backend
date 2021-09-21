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
            @keypress.enter="search"
          ></b-form-input>
        </b-input-group>
      </b-col>
      <b-col>
        <b-input-group prepend="客户姓名">
          <b-form-input
            type="search"
            v-model="filters['客户姓名']"
            @keypress.enter="search"
          ></b-form-input>
        </b-input-group>
      </b-col>
      <b-col>
        <b-input-group prepend="手機號碼">
          <b-form-input
            type="search"
            v-model="filters['手機號碼']"
            @keypress.enter="search"
          ></b-form-input>
        </b-input-group>
      </b-col>
      <b-col>
        <SearchSelectOptions
          :name="'狀態'"
          :store-name-spaced="'ClientHKFundOutRequests'"
          @change="search"
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
          @change="search"
        />
      </b-col>
      <b-col>
        <date-picker
          name="'審批時間'"
          v-model="filters['審批時間']"
          range
          placeholder="審批時間"
          @change="search"
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
      </b-col>
    </b-row>
    <b-table
      hover
      bordered
      dark
      :items="data"
      :fields="fields"
      show-empty
      empty-filtered-text="沒有找到記錄"
      empty-text="沒有找到記錄"
      @filtered="onFiltered"
    >
      <template #cell(操作)="data">
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
    search(e) {
      this.data = [];
      this.busy = true;
      this.load(1);
    },
    linkGen(pageNum) {
      return null;
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
      const 帳戶號碼 = this.filters["帳戶號碼"];
      const 客户姓名 = this.filters["客户姓名"];
      const 手機號碼 = this.filters["手機號碼"];
      const 狀態 = this.filters["狀態"];
      const 發送時間 = this.filters["發送時間"];
      const 審批時間 = this.filters["審批時間"];
      const self = this;
      axios
        .get("ClientHKFundOutRequests", {
          params: {
            帳戶號碼: 帳戶號碼,
            客户姓名: 客户姓名,
            手機號碼: 手機號碼,
            狀態: 狀態,
            發送時間: 發送時間,
            審批時間: 審批時間,
            perPage: self.perPage,
            pageNumber: pageNumber,
          },
          cancelToken: self.source.token,
        })
        .then((res) => {
          console.log(res);
          const data = res.data.data;
          self.fields = res.data.fields;
          self.FilterType = res.data.filter_type;
          self.data = self.data.concat(data);
          self.totalRows = self.data.length;
          self.last_page = res.data.last_page;
          self.busy = false;
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