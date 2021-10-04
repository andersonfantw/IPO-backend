<template>
  <b-container fluid>
    <h1 class="text-warning text-center">
      一審資料未審核清單
    </h1>
    <b-row class="mb-3">
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
          />
        </b-input-group>
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <date-picker
          name="'提交時間'"
          v-model="filters['提交時間']"
          range
          placeholder="提交時間"
          @change="search"
        />
      </b-col>
      <b-col>
        <b-input-group prepend="AE">
          <b-form-select
            v-model="filters['AE']"
            :options="aes"
            @change="search"
          >
          </b-form-select>
        </b-input-group>
      </b-col>
      <b-col>
        <b-input-group prepend="已入金">
          <b-form-select
            v-model="filters['已入金']"
            :options="已入金"
            @change="search"
          >
          </b-form-select>
        </b-input-group>
      </b-col>
      <b-col> </b-col>
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
      <template #cell(操作)="data">
        <b-button
          variant="warning"
          type="button"
          @click="showClientDetails(data.item.uuid)"
        >
          <h5 class="mb-0"><i class="far fa-edit"></i> 審核</h5>
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
    <ClientDetails
      ref="ClientDetails"
      :title="'客戶信息'"
      @audited="reload"
    />
  </b-container>
</template>
<script>
import ClientDetails from "./ClientDetails";
import axios from "axios";
import { DecryptionMixin } from "../mixins/DecryptionMixin";
import { CommonFunctionMixin } from "../mixins/CommonFunctionMixin";
export default {
  data() {
    return {
      fields: [],
      filterMatchMode: {},
      busy: false,
      data: [],
      selectedClients: null,
      currentPage: 1,
      perPage: 20,
      FilterType: {},
      totalRows: 0,
      aes: [
        { value: null, text: "全部" },
        { value: "梧桐花開", text: "梧桐花開" },
        { value: "劉素惠", text: "劉素惠" },
      ],
      已入金: [
        { value: null, text: "全部" },
        { value: "是", text: "是" },
        { value: "否", text: "否" },
      ],
      next_status: "audited1",
      source: null,
      last_page: null,
    };
  },
  mixins: [DecryptionMixin, CommonFunctionMixin],
  props: {
    audit_client_url: String,
    base_url: String,
  },
  components: {
    ClientDetails,
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
    showClientDetails(uuid) {
      this.$refs.ClientDetails.showModal(uuid, this.next_status);
    },
    hideClientDetails() {
      this.$refs.ClientDetails.hideModal();
    },
    reload() {
      this.data = [];
      this.busy = true;
      this.load(1);
    },
    load(pageNumber) {
      const 客户姓名 = this.filters["客户姓名"];
      const 證件號碼 = this.filters["證件號碼"];
      const 手機號碼 = this.filters["手機號碼"];
      const 郵箱 = this.filters["郵箱"];
      const 提交時間 = this.filters["提交時間"];
      const AE = this.filters["AE"];
      const 已入金 = this.filters["已入金"];
      const self = this;
      axios
        .get("UnauditedList1", {
          params: {
            客户姓名: 客户姓名,
            證件號碼: 證件號碼,
            手機號碼: 手機號碼,
            郵箱: 郵箱,
            提交時間: 提交時間,
            AE: AE,
            已入金: 已入金,
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
          self.checkLogin(error);
        });
    },
    onFiltered(filteredItems) {
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    },
  },
  computed: {
    filters: {
      get() {
        return this.$store.state.UnauditedList1.filters;
      },
      set(value) {
        this.$store.commit("UnauditedList1/filters", value);
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