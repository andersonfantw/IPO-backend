<template>
  <b-container fluid class="p-0">
    <h1 class="text-warning text-center">
      添加信用卡申請
      <b-spinner v-if="loading" variant="warning"></b-spinner>
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
        <b-input-group prepend="卡號">
          <b-form-input type="search" v-model="filters['卡號']"></b-form-input>
        </b-input-group>
      </b-col>
    </b-row>

    <b-row no-gutters>
      <b-col>
        <DateRange :name="'發送時間'" v-model="filters['發送時間']" />
      </b-col>
      <b-col>
        <DateRange :name="'審批時間'" v-model="filters['審批時間']" />
      </b-col>
    </b-row>

    <b-row no-gutters class="mt-3">
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
      :fields="Columns"
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
            value="ClientCreditCards"
          />
          <b-button
            name="id"
            :value="data.item.id"
            variant="warning"
            type="submit"
            ><h5 class="mb-0"><i class="far fa-edit"></i> 審核</h5></b-button
          >
        </b-form>
        <b-form v-else :action="view_request_url" method="post">
          <input
            type="hidden"
            name="redirect_route"
            value="ClientCreditCards"
          />
          <b-button
            name="id"
            :value="data.item.id"
            variant="success"
            type="submit"
            ><h5 class="mb-0"><i class="far fa-eye"></i> 查看</h5></b-button
          >
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
  </b-container>
</template>
<script>
import axios from "axios";
import { DecryptionMixin } from "../mixins/DecryptionMixin";
import { CommonFunctionMixin } from "../mixins/CommonFunctionMixin";
import DateRange from "./DateRange";
export default {
  data() {
    return {
      Columns: [],
      FilterMatchMode: {},
      loading: false,
      data: [],
      SelectedCreditCards: [],
      FilteredCreditCards: [],
      currentPage: 1,
      perPage: 20,
      FilterType: {},
      totalRows: 0,
    };
  },
  mixins: [DecryptionMixin, CommonFunctionMixin],
  props: {
    columns: {
      type: String,
      required: true,
    },
    filter_type: {
      type: String,
      required: true,
    },
    audit_request_url: String,
    view_request_url: String,
  },
  components: {
    DateRange,
  },
  created() {
    this.Columns = JSON.parse(this.columns);
    this.FilterType = JSON.parse(this.filter_type);
    this.loading = true;
    this.loadData(1);
  },
  methods: {
    selectAll(e) {
      if (e) {
        this.SelectedCreditCards = this.FilteredCreditCards;
      } else {
        this.SelectedCreditCards = [];
      }
    },
    loadData(pageNumber) {
      const self = this;
      axios
        .post("api/ClientCreditCards/all_data", {
          perPage: self.perPage,
          pageNumber: pageNumber,
        })
        .then((res) => {
          console.log(res);
          const data = res.data.data;
          self.data = self.data.concat(data);
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
      this.SelectedCreditCards = [];
      this.FilteredCreditCards = filteredItems;
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    },
  },
  computed: {
    filters: {
      get() {
        return this.$store.state.ClientCreditCards.filters;
      },
      set(value) {
        this.$store.commit("ClientCreditCards/filters", value);
      },
    },
    checked: {
      get() {
        return (
          this.SelectedCreditCards.length == this.FilteredCreditCards.length
        );
      },
      set(value) {},
    },
  },
};
</script>