<template>
  <b-container fluid>
    <h1 class="text-center">查看開戶進度</h1>
    <b-row class="mb-3">
      <b-col>
        <b-input-group prepend="客户姓名">
          <b-form-input
            type="search"
            v-model="filters['客户姓名']"
            @keyup.enter="query"
          ></b-form-input>
        </b-input-group>
      </b-col>
      <b-col>
        <b-input-group prepend="證件號碼">
          <b-form-input
            type="search"
            v-model="filters['證件號碼']"
            @keyup.enter="query"
          ></b-form-input>
        </b-input-group>
      </b-col>
      <b-col>
        <b-input-group prepend="手機號碼">
          <b-form-input
            type="search"
            v-model="filters['手機號碼']"
            @keyup.enter="query"
          ></b-form-input>
        </b-input-group>
      </b-col>
      <b-col>
        <b-input-group prepend="郵箱">
          <b-form-input
            type="search"
            v-model="filters['郵箱']"
            @keyup.enter="query"
          />
        </b-input-group>
      </b-col>
    </b-row>
    <b-row class="mb-3">
      <b-col>
        <!-- <DateRange :name="'更新時間'" v-model="filters['更新時間']" /> -->
        <date-picker
          name="'更新時間'"
          v-model="filters['更新時間']"
          range
          placeholder="更新時間"
        />
      </b-col>
      <b-col>
        <b-input-group prepend="AE">
          <b-form-select v-model="filters['AE']" :options="aes">
          </b-form-select>
        </b-input-group>
      </b-col>
      <b-col>
        <b-button @click="query" variant="success">查詢</b-button>
      </b-col>
      <b-col> </b-col>
    </b-row>
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
      @filtered="onFiltered"
      :busy="busy"
    >
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
      <template #cell(操作)="data">
        <b-button
          v-if="
            data.item.帳戶號碼 != '' &&
            (!data.item['08銷戶時間'] || !data.item['13銷戶時間']) &&
            !data.item.can_close
          "
          type="button"
          variant="danger"
          @click="setCanCloseAC(data.item.uuid)"
          ><h5 class="mb-0">
            <i class="far fa-window-close"></i> 可銷戶
          </h5></b-button
        >
        <b-button
          v-if="
            data.item.帳戶號碼 != '' &&
            (!data.item['08銷戶時間'] || !data.item['13銷戶時間']) &&
            data.item.can_close
          "
          type="button"
          variant="success"
          @click="cancelCanCloseAC(data.item.uuid)"
          ><h5 class="mb-0">
            <i class="far fa-window-close"></i> 取消銷戶
          </h5></b-button
        >
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
// import DateRange from "./DateRange";
import axios from "axios";
import { DecryptionMixin } from "../mixins/DecryptionMixin";
import { CommonFunctionMixin } from "../mixins/CommonFunctionMixin";
export default {
  data() {
    return {
      Columns: [],
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
    };
  },
  mixins: [DecryptionMixin, CommonFunctionMixin],
  props: {
    // p_columns: {
    //   type: String,
    //   required: true,
    // },
    // filter_type: {
    //   type: String,
    //   required: true,
    // },
  },
  components: {
    // DateRange,
  },
  created() {
    // this.Columns = JSON.parse(this.p_columns);
    // this.FilterType = JSON.parse(this.filter_type);
    // this.busy = true;
    // this.loadData(1);
  },
  methods: {
    setCanCloseAC(uuid) {
      const self = this;
      axios
        .post("api/Client/setCanClose", {
          uuid: uuid,
        })
        .then((res) => {
          console.log(res);
          self.data = [];
          self.busy = true;
          self.loadData(1);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    cancelCanCloseAC(uuid) {
      const self = this;
      axios
        .post("api/Client/cancelCanCloseAC", {
          uuid: uuid,
        })
        .then((res) => {
          console.log(res);
          self.data = [];
          self.busy = true;
          self.loadData(1);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    query() {
      const self = this;
      self.busy = true;
      let data = {
        客户姓名: self.filters["客户姓名"],
        證件號碼: self.filters["證件號碼"],
        手機號碼: self.filters["手機號碼"],
        郵箱: self.filters["郵箱"],
        AE: self.filters["AE"],
      };
      if (self.filters["更新時間"] && self.filters["更新時間"].length == 2) {
        data["由更新時間"] = self.filters["更新時間"][0];
        data["至更新時間"] = self.filters["更新時間"][1];
      }
      axios
        .get("api/ClientProgress", {
          params: data,
        })
        .then((res) => {
          console.log(res);
          self.Columns = res.data.columns;
          self.FilterType = res.data.filter_type;
          self.data = res.data.data;
          self.totalRows = self.data.length;
          self.busy = false;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    loadData(pageNumber) {
      const self = this;
      axios
        .post("api/ClientProgress/list", {
          perPage: self.perPage,
          pageNumber: pageNumber,
        })
        .then((res) => {
          // const json = self.getDecryptedJsonObject(res.data);
          console.log(res);
          const data = res.data.data;
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
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    },
  },
  computed: {
    filters: {
      get() {
        return this.$store.state.ClientProgress.filters;
      },
      set(value) {
        this.$store.commit("ClientProgress/filters", value);
      },
    },
  },
};
</script>