<template>
  <b-container fluid>
    <h1 class="text-warning text-center">
      添加銀行卡申請
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
        <b-input-group prepend="狀態">
          <b-form-select
            v-model="filters['狀態']"
            :options="狀態"
          >
          </b-form-select>
        </b-input-group>
      </b-col>
    </b-row>
    <b-row>
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
          v-if="data.item.狀態 == 'pending'"
          variant="warning"
          type="button"
          @click="showDetails(data.item.id)"
        >
          <h5 class="mb-0"><i class="far fa-edit"></i> 審核</h5>
        </b-button>
        <b-button
          v-else
          variant="success"
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
    <ClientBankCardDetails
      ref="ClientBankCardDetails"
      :title="'添加銀行卡申請'"
      @audited="reload"
    />
  </b-container>
</template>
<script>
import axios from "axios";
import { DecryptionMixin } from "../mixins/DecryptionMixin";
import { CommonFunctionMixin } from "../mixins/CommonFunctionMixin";
import ClientBankCardDetails from "./ClientBankCardDetails";
export default {
  data() {
    return {
      fields: [],
      FilterMatchMode: {},
      busy: false,
      data: [],
      SelectedBankCards: [],
      FilteredBankCards: [],
      currentPage: 1,
      perPage: 20,
      FilterType: {},
      totalRows: 0,
      progress: 0,
      狀態: [
        { value: null, text: "全部" },
        { value: "approved", text: "approved" },
        { value: "pending", text: "pending" },
        { value: "rejected", text: "rejected" },
      ],
      source: null,
      last_page: null,
    };
  },
  mixins: [DecryptionMixin, CommonFunctionMixin],
  props: {
    audit_request_url: String,
    view_request_url: String,
  },
  components: {
    ClientBankCardDetails,
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
      this.$refs.ClientBankCardDetails.showModal(id);
    },
    selectAll(e) {
      if (e) {
        this.SelectedBankCards = this.FilteredBankCards;
      } else {
        this.SelectedBankCards = [];
      }
    },
    reload() {
      this.data = [];
      this.busy = true;
      this.load(1);
    },
    load(pageNumber) {
      const self = this;
      axios
        .get("ClientBankCards", {
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
      this.SelectedBankCards = [];
      this.FilteredBankCards = filteredItems;
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    },
  },
  computed: {
    filters: {
      get() {
        return this.$store.state.ClientBankCards.filters;
      },
      set(value) {
        this.$store.commit("ClientBankCards/filters", value);
      },
    },
    checked: {
      get() {
        return this.SelectedBankCards.length == this.FilteredBankCards.length;
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