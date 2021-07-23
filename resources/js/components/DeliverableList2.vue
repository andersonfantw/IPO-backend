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
        <b-input-group prepend="開通賬戶類型">
          <b-form-select v-model="filters['開通賬戶類型']" :options="options">
          </b-form-select>
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
        <b-input-group prepend="證件號碼">
          <b-form-input
            type="search"
            v-model="filters['證件號碼']"
          ></b-form-input>
        </b-input-group>
      </b-col>
    </b-row>
    <b-row no-gutters>
      <b-col>
        <b-input-group prepend="手機號碼">
          <b-form-input
            type="search"
            v-model="filters['手機號碼']"
          ></b-form-input>
        </b-input-group>
      </b-col>
      <b-col>
        <b-input-group prepend="郵箱">
          <b-form-input type="search" v-model="filters['郵箱']"></b-form-input>
        </b-input-group>
      </b-col>
      <b-col cols="6">
        <DateRange :name="'開戶時間'" v-model="filters['開戶時間']" />
      </b-col>
    </b-row>
    <b-row no-gutters>
      <b-col cols="6">
        <DateRange :name="'帳戶生成時間'" v-model="filters['帳戶生成時間']" />
      </b-col>
      <b-col></b-col>
      <b-col></b-col>
    </b-row>
    <b-row no-gutters>
      <b-col>
        <b-button variant="primary" @click="generateAccounts"
          ><i class="far fa-user"></i> 產生Ayers帳號</b-button
        >
        <b-button variant="success" @click="downloadExcel">
          <i class="fas fa-download"></i> 開戶Excel下載<b-spinner
            v-if="DownloadingExcel"
            label="Spinning"
            small
          />
        </b-button>
        <b-button variant="warning" @click="downloadFilesForOpeningAccount">
          <i class="fas fa-download"></i> 協議及開戶資料下載
        </b-button>
      </b-col>
    </b-row>
    <b-row v-if="loading">
      <b-col class="text-center">
        <b-spinner variant="warning"></b-spinner>
      </b-col>
    </b-row>
    <b-table
      hover
      bordered
      dark
      :items="data"
      :fields="columns"
      :current-page="currentPage"
      :per-page="perPage"
      :filter="filters"
      :filter-function="filter"
      show-empty
      empty-filtered-text="沒有找到記錄"
      empty-text="沒有找到記錄"
      @filtered="onFiltered"
    >
      <template #head(操作)>
        <b-form-checkbox v-model="checked" @change="selectAll" />
      </template>
      <template #cell(操作)="data">
        <b-form-checkbox v-model="selectedClients" :value="data.item" />
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
import axios from "axios";
import { DecryptionMixin } from "../mixins/DecryptionMixin";
import { CommonFunctionMixin } from "../mixins/CommonFunctionMixin";
export default {
  data() {
    return {
      columns: [],
      loading: false,
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
    };
  },
  mixins: [DecryptionMixin, CommonFunctionMixin],
  props: {
    view_client_url: {
      type: String,
      required: true,
    },
    p_columns: {
      type: String,
      required: true,
    },
    filter_type: {
      type: String,
      required: true,
    },
    generate_ayers_account_url: String,
  },
  components: {
    DateRange,
  },
  created() {
    this.columns = JSON.parse(this.p_columns);
    this.FilterType = JSON.parse(this.filter_type);
    this.loading = true;
    this.loadData(1);
  },
  methods: {
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
        self.loading = true;
        axios
          .post("api/AyersAccount/generate", { clients: self.selectedClients })
          .then((response) => {
            console.log(response);
            self.data = [];
            self.loadData(1);
          })
          .catch((error) => {
            console.log(error);
          });
      } else {
        alert("請先選中客戶！");
      }
    },
    loadData(pageNumber) {
      const self = this;
      axios
        .post("api/DeliverableList2/all_data", {
          perPage: self.perPage,
          pageNumber: pageNumber,
        })
        .then((res) => {
          console.log(res);
          const data = res.data.data;
          self.data = self.data.concat(data);
          self.filteredClients = self.data;
          self.totalRows = self.data.length;
          if (data.length >= self.perPage) {
            self.loadData(pageNumber + 1);
          } else {
            self.loading = false;
          }
        })
        .catch((error) => {
          console.log(error);
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
  },
  watch: {},
};
</script>
<style>
</style>