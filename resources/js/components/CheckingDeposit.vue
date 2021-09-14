<template>
  <b-container fluid>
    <h1 class="text-warning text-center">
      核對入款記錄
    </h1>
    <b-row class="mb-3">
      <b-col>
        <b-form-file
          ref="file"
          v-model="file"
          :state="Boolean(file)"
          placeholder="Choose a file or drop it here..."
          drop-placeholder="Drop file here..."
          accept=".xlsx, .xls"
        ></b-form-file>
      </b-col>
    </b-row>
    <b-row>
      <b-col class="text-right">
        <b-button
          variant="success"
          @click="upload"
          :disabled="!Boolean(file)"
        ><i class="fas fa-file-upload"></i> 上載</b-button>
      </b-col>
    </b-row>
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
    <b-row class="mt-3">
      <b-col>
        <b-input-group>
          <b-form-select
            v-model="selectedDate"
            :options="dates"
            @change="onChange"
          >
            <template #first>
              <b-form-select-option
                :value="null"
                disabled
              >請選擇上載日期</b-form-select-option>
            </template>
          </b-form-select>
          <b-button
            variant="success"
            :disabled="!Boolean(selectedDate)"
            @click="reload"
          ><i class="fas fa-sync"></i></b-button>
        </b-input-group>
      </b-col>
      <b-col>
        <b-pagination
          v-if="totalRows > 0"
          v-model="currentPage"
          :total-rows="totalRows"
          :per-page="perPage"
          align="center"
        >
        </b-pagination>
      </b-col>
      <b-col class="text-right">
        <b-button
          variant="success"
          :disabled="!Boolean(selectedDate) || downloading"
          @click="downloadUnknownDepositsExcel"
        ><i class="fas fa-file-download"></i> 下載Unknown Deposits</b-button>
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
      show-empty
      empty-filtered-text="沒有找到記錄"
      empty-text="沒有找到記錄"
    >
      <template #cell(status)="data">
        {{data.item.status}}
        <i
          v-if="data.item.status == 'matched'"
          class="fas fa-check text-success"
        ></i>
        <i
          v-else
          class="fas fa-times text-danger"
        ></i>
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
    <b-row class="mt-3">
      <b-col>
        {{totalRows}} Record(s)
      </b-col>
      <b-col>
        <b-pagination
          v-if="totalRows > 0"
          v-model="currentPage"
          :total-rows="totalRows"
          :per-page="perPage"
          align="center"
        >
        </b-pagination>
      </b-col>
      <b-col>
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import axios from "axios";
import { CommonFunctionMixin } from "../mixins/CommonFunctionMixin";
export default {
  data() {
    return {
      fields: [],
      data: [],
      busy: false,
      downloading: false,
      file: null,
      source: null,
      currentPage: 1,
      perPage: 20,
      totalRows: 0,
      progress: 0,
      selectedDate: null,
      dates: [],
    };
  },
  mixins: [CommonFunctionMixin],
  created() {
    this.source = axios.CancelToken.source();
    // this.busy = true;
    this.getDates();
    // this.load(1);
  },
  beforeDestroy() {
    this.source.cancel("Operation canceled by the user.");
  },
  methods: {
    downloadUnknownDepositsExcel(e) {
      const self = this;
      self.downloading = true;
      axios
        .post(
          "DownloadUnknownDepositsExcel",
          {
            uploaded_at: self.selectedDate,
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
          link.setAttribute(
            "download",
            `UnknownDeposits${self.selectedDate}.xlsx`
          );
          link.click();
          self.downloading = false;
        })
        .catch((error) => {
          console.log(error);
          self.downloading = false;
        });
    },
    getDates() {
      const self = this;
      axios
        .get("CheckingDepositDates", {
          cancelToken: self.source.token,
        })
        .then((res) => {
          console.log(res);
          self.dates = res.data;
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
    reload() {
      this.source.cancel("Operation canceled by the user.");
      this.source = axios.CancelToken.source();
      this.data = [];
      this.busy = true;
      this.progress = 0;
      this.totalRows = 0;
      this.load(1);
    },
    onChange() {
      this.reload();
    },
    load(pageNumber) {
      const self = this;
      axios
        .get("CheckingDeposit", {
          params: {
            perPage: self.perPage,
            pageNumber: pageNumber,
            uploaded_at: self.selectedDate,
          },
          cancelToken: self.source.token,
        })
        .then((res) => {
          console.log(res);
          const data = res.data.data.data;
          const total = res.data.data.total;
          self.fields = res.data.fields;
          self.FilterType = res.data.filter_type;
          self.data = self.data.concat(data);
          self.totalRows = self.data.length;
          if (total <= self.perPage) {
            self.progress = 100;
          } else {
            self.progress += (self.perPage / total) * 100;
          }
          if (data.length >= self.perPage) {
            self.load(pageNumber + 1);
          } else {
            self.busy = false;
          }
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
    upload() {
      let formData = new FormData();
      formData.append("file", this.file);
      const self = this;
      axios
        .post("CheckingDeposit", formData)
        .then((res) => {
          console.log(res);
          self.getDates();
          alert("上載及核對完成，請選擇上載日期並下載Unknown Deposits");
        })
        .catch((error) => {
          console.log(error);
          alert("上載失敗，請檢查文件格式及內容");
        });
      this.file = null;
    },
  },
  computed: {},
};
</script>