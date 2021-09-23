<template>
  <b-container fluid>
    <h1 class="text-warning text-center">開戶信發送清單</h1>
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
        <b-input-group prepend="證件號碼">
          <b-form-input
            type="search"
            v-model="filters['證件號碼']"
            @keypress.enter="search"
          ></b-form-input>
        </b-input-group>
      </b-col>
      <b-col>
        <b-input-group prepend="電郵">
          <b-form-input
            type="search"
            v-model="filters['電郵']"
            @keypress.enter="search"
          ></b-form-input>
        </b-input-group>
      </b-col>
    </b-row>
    <b-row class="mb-3">
      <b-col>
        <date-picker
          name="'投遞日期'"
          v-model="filters['投遞日期']"
          range
          placeholder="投遞日期"
          @change="search"
        />
      </b-col>
      <b-col>
        <b-input-group prepend="狀態">
          <b-form-select
            v-model="filters['狀態']"
            :options="options"
            @change="search"
          >
          </b-form-select>
        </b-input-group>
      </b-col>
      <b-col>
        <b-input-group prepend="電郵發送者">
          <b-form-input
            type="search"
            v-model="filters['電郵發送者']"
            @keypress.enter="search"
          ></b-form-input>
        </b-input-group>
      </b-col>
      <b-col>
        <date-picker
          name="'電郵發送時間'"
          v-model="filters['電郵發送時間']"
          range
          placeholder="電郵發送時間"
          @change="search"
        />
      </b-col>
    </b-row>
    <b-button
      variant="success"
      @click="sendEmails"
    ><i class="far fa-envelope"></i> 一鍵發送</b-button>
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
// import DateRange from "./DateRange";
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
      User: null,
      currentPage: 1,
      perPage: 50,
      FilterType: {},
      totalRows: 0,
      options: [
        { value: null, text: "全部" },
        { value: "未發送", text: "未發送" },
        { value: "已發送", text: "已發送" },
      ],
      progress: 0,
      last_page: null,
    };
  },
  mixins: [DecryptionMixin, CommonFunctionMixin],
  props: {
    generate_ayers_account_url: String,
    user: String,
  },
  components: {
    // DateRange,
  },
  created() {
    // this.User = JSON.parse(this.user);
    this.busy = true;
    this.getCounts(axios);
    this.load(1);
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
    sendEmails() {
      const self = this;
      if (self.selectedClients && self.selectedClients.length > 0) {
        self.busy = true;
        axios
          .post("SendOpenAccountEmail", {
            clients: self.selectedClients,
            User: self.User,
          })
          .then((res) => {
            console.log(res);
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
      const 客户姓名 = this.filters["客户姓名"];
      const 證件號碼 = this.filters["證件號碼"];
      const 電郵 = this.filters["電郵"];
      const 投遞日期 = this.filters["投遞日期"];
      const 狀態 = this.filters["狀態"];
      const 電郵發送者 = this.filters["電郵發送者"];
      const 電郵發送時間 = this.filters["電郵發送時間"];
      const self = this;
      axios
        .get("SendingEmailList", {
          params: {
            帳戶號碼: 帳戶號碼,
            客户姓名: 客户姓名,
            證件號碼: 證件號碼,
            電郵: 電郵,
            投遞日期: 投遞日期,
            狀態: 狀態,
            電郵發送者: 電郵發送者,
            電郵發送時間: 電郵發送時間,
            perPage: self.perPage,
            pageNumber: pageNumber,
          },
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
        return this.$store.state.SendingEmailList.filters;
      },
      set(value) {
        this.$store.commit("SendingEmailList/filters", value);
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