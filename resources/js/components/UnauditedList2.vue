<template>
  <b-row no-gutters class="justify-content-center text-warning">
    <b-col cols="2">
      <slot name="menu"></slot>
    </b-col>
    <b-col cols="10">
      <b-container fluid>
        <h1 class="text-warning text-center">二審資料未審核清單</h1>
        <b-row class="mb-3">
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
              <b-form-input type="search" v-model="filters['郵箱']" />
            </b-input-group>
          </b-col>
        </b-row>
        <b-row>
          <b-col>
            <!-- <DateRange :name="'提交時間'" v-model="filters['提交時間']" /> -->
            <date-picker
              name="'提交時間'"
              v-model="filters['提交時間']"
              range
              placeholder="提交時間"
            />
          </b-col>
          <b-col>
            <b-input-group prepend="AE">
              <b-form-select v-model="filters['AE']" :options="aes">
              </b-form-select>
            </b-input-group>
          </b-col>
          <b-col>
            <b-input-group prepend="已入金">
              <b-form-select v-model="filters['已入金']" :options="已入金">
              </b-form-select>
            </b-input-group>
          </b-col>
          <b-col> </b-col>
        </b-row>
        <b-row v-if="loading" class="mt-3">
          <b-col>
            <b-progress :max="100" show-progress animated variant="success">
              <b-progress-bar
                :value="progress"
                :label="`${progress.toFixed(2)}%`"
              ></b-progress-bar>
            </b-progress>
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
          <template #cell(操作)="data">
            <b-form :action="audit_client_url" method="post">
              <input
                type="hidden"
                name="redirect_route"
                value="UnauditedList2"
              />
              <input type="hidden" name="next_status" value="audited2" />
              <b-button
                name="uuid"
                :value="data.item.uuid"
                variant="warning"
                type="submit"
                ><h5 class="mb-0">
                  <i class="far fa-edit"></i> 審核
                </h5></b-button
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
        <b-pagination
          v-if="totalRows > 0"
          v-model="currentPage"
          :total-rows="totalRows"
          :per-page="perPage"
          align="center"
        >
        </b-pagination>
      </b-container>
    </b-col>
  </b-row>
</template>
<script>
// import DateRange from "./DateRange";
import axios from "axios";
import { DecryptionMixin } from "../mixins/DecryptionMixin";
import { CommonFunctionMixin } from "../mixins/CommonFunctionMixin";
export default {
  data() {
    return {
      columns: [],
      filterMatchMode: {},
      loading: false,
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
      progress: 0,
    };
  },
  mixins: [DecryptionMixin, CommonFunctionMixin],
  props: {
    p_columns: {
      type: String,
      required: true,
    },
    filter_type: {
      type: String,
      required: true,
    },
    audit_client_url: String,
  },
  components: {
    // DateRange,
  },
  created() {
    this.columns = JSON.parse(this.p_columns);
    this.FilterType = JSON.parse(this.filter_type);
    this.loading = true;
    this.loadData(1);
  },
  methods: {
    loadData(pageNumber) {
      const self = this;
      axios
        .post("api/UnauditedList2/list", {
          perPage: self.perPage,
          pageNumber: pageNumber,
        })
        .then((res) => {
          console.log(res);
          const data = res.data.data;
          const total = res.data.total;
          self.data = self.data.concat(data);
          self.totalRows = self.data.length;
          if (total <= self.perPage) {
            self.progress = 100;
          } else {
            self.progress += (self.perPage / total) * 100;
          }
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
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    },
  },
  computed: {
    filters: {
      get() {
        return this.$store.state.UnauditedList2.filters;
      },
      set(value) {
        this.$store.commit("UnauditedList2/filters", value);
      },
    },
  },
  watch: {},
};
</script>
<style>
</style>