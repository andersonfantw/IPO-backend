import Vue from "vue";
import Vuex from "vuex";
Vue.use(Vuex);
import UnauditedDataList1HongKong from "./modules/UnauditedDataList1HongKong";

export default new Vuex.Store({
	strict: false,
	modules: {
		UnauditedDataList1HongKong: UnauditedDataList1HongKong
	}
});