<template>
  <b-container fluid>
    <h1 class="text-warning text-center">二審資料可投遞清單</h1>
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
        <b-input-group prepend="開通賬戶類型">
          <b-form-select
            v-model="filters['開通賬戶類型']"
            :options="options"
            @change="search"
          >
          </b-form-select>
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
        <b-input-group prepend="證件號碼">
          <b-form-input
            type="search"
            v-model="filters['證件號碼']"
            @keypress.enter="search"
          ></b-form-input>
        </b-input-group>
      </b-col>
    </b-row>
    <b-row class="mb-3">
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
        <b-input-group prepend="郵箱">
          <b-form-input
            type="search"
            v-model="filters['郵箱']"
            @keypress.enter="search"
          ></b-form-input>
        </b-input-group>
      </b-col>
      <b-col>
        <date-picker
          name="'開戶時間'"
          v-model="filters['開戶時間']"
          range
          placeholder="開戶時間"
          @change="search"
        />
      </b-col>
      <b-col>
        <date-picker
          name="'帳戶生成時間'"
          v-model="filters['帳戶生成時間']"
          range
          placeholder="帳戶生成時間"
          @change="search"
        />
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <b-button
          variant="primary"
          @click="generateAccounts"
        ><i class="far fa-user"></i> 產生Ayers帳號</b-button>
        <b-button
          variant="success"
          @click="downloadExcel"
        >
          <i class="fas fa-download"></i> 開戶Excel下載
          <b-spinner
            v-if="DownloadingExcel"
            label="Spinning"
            small
          />
        </b-button>
        <b-button
          variant="warning"
          @click="downloadFilesForOpeningAccount"
        >
          <i class="fas fa-download"></i> 協議及開戶資料下載
        </b-button>
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
      <template #head(操作)>
        <b-form-checkbox
          v-model="checked"
          @change="selectAll"
        />
      </template>
      <template #cell(操作)="data">
        <b-form-checkbox
          v-model="selectedClients"
          :value="data.item"
        />
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
  </b-container>
</template>
<script>
import axios from "axios";
import { DecryptionMixin } from "../mixins/DecryptionMixin";
import { CommonFunctionMixin } from "../mixins/CommonFunctionMixin";
export default {
  data() {
    return {
      fields: [],
      busy: false,
      data: [],
      selectedClients: [],
      filteredClients: [],
      DownloadingExcel: false,
      DownloadFilesForOpeningAccount: false,
      currentPage: 1,
      perPage: 50,
      FilterType: {},
      totalRows: 0,
      options: [
        { value: null, text: "全部" },
        { value: "現金賬戶", text: "現金賬戶" },
        { value: "全權委託賬戶", text: "全權委託賬戶" },
      ],
      progress: 0,
      source: null,
      last_page: null,
    };
  },
  mixins: [DecryptionMixin, CommonFunctionMixin],
  props: {
    generate_ayers_account_url: String,
  },
  components: {},
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
    selectAll(e) {
      if (e) {
        this.selectedClients = this.filteredClients;
      } else {
        this.selectedClients = [];
      }
    },
    downloadFilesForOpeningAccount() {
      const self = this;
      if (self.selectedClients && self.selectedClients.length > 0) {
        self.DownloadFilesForOpeningAccount = true;
        axios
          .post(
            "api/DeliverableList2/DownloadFilesForOpeningAccount",
            {
              clients: self.selectedClients,
            },
            {
              responseType: "arraybuffer",
            }
          )
          .then((response) => {
            console.log(response);
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement("a");
            link.href = url;
            link.setAttribute("download", "協議及開戶資料.zip");
            link.click();
            self.DownloadFilesForOpeningAccount = false;
          })
          .catch((error) => {
            console.log(error);
            self.DownloadFilesForOpeningAccount = false;
          });
      } else {
        alert("請先選中客戶！");
      }
    },
    downloadExcel() {
      const self = this;
      if (self.selectedClients && self.selectedClients.length > 0) {
        self.DownloadingExcel = true;
        axios
          .post(
            "api/DeliverableList2/DownloadAyersImportData",
            {
              clients: self.selectedClients,
            },
            {
              responseType: "arraybuffer",
            }
          )
          .then((response) => {
            console.log(response);
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement("a");
            link.href = url;
            link.setAttribute("download", "AyersImportData.xlsx");
            link.click();
            self.DownloadingExcel = false;
          })
          .catch((error) => {
            console.log(error);
            self.DownloadingExcel = false;
          });
      } else {
        alert("請先選中客戶！");
      }
    },
    generateAccounts() {
      const self = this;
      if (self.selectedClients && self.selectedClients.length > 0) {
        self.busy = true;
        axios
          .post("api/AyersAccount/generate", { clients: self.selectedClients })
          .then((response) => {
            console.log(response);
            self.data = [];
            self.progress = 0;
            self.load(1);
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        alert("請先選中客戶！");
      }
    },
    load(pageNumber) {
      const 帳戶號碼 = this.filters["帳戶號碼"];
      const 開通賬戶類型 = this.filters["開通賬戶類型"];
      const 客户姓名 = this.filters["客户姓名"];
      const 證件號碼 = this.filters["證件號碼"];
      const 手機號碼 = this.filters["手機號碼"];
      const 郵箱 = this.filters["郵箱"];
      const 開戶時間 = this.filters["開戶時間"];
      const 帳戶生成時間 = this.filters["帳戶生成時間"];
      const self = this;
      axios
        .get("DeliverableList2", {
          params: {
            帳戶號碼: 帳戶號碼,
            開通賬戶類型: 開通賬戶類型,
            客户姓名: 客户姓名,
            證件號碼: 證件號碼,
            手機號碼: 手機號碼,
            郵箱: 郵箱,
            開戶時間: 開戶時間,
            帳戶生成時間: 帳戶生成時間,
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
          self.filteredClients = self.data;
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
          self.checkLogin(error);
        });
    },
    onFiltered(filteredItems) {
      this.selectedClients = [];
      this.filteredClients = filteredItems;
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    },
  },
  computed: {
    filters: {
      get() {
        return this.$store.state.DeliverableList2.filters;
      },
      set(value) {
        this.$store.commit("DeliverableList2/filters", value);
      },
    },
    checked: {
      get() {
        return this.selectedClients.length == this.filteredClients.length;
      },
      set(value) {},
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