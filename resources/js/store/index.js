import Vue from "vue";
import Vuex from "vuex";
Vue.use(Vuex);
import UnauditedList1 from "./modules/UnauditedList1";
import UnauditedList2 from "./modules/UnauditedList2";
import RejectedList1 from "./modules/RejectedList1";
import ReauditList1 from "./modules/ReauditList1";
import DeliverableList2 from "./modules/DeliverableList2";
import SendingEmailList from "./modules/SendingEmailList";
import ClientFundInRequests from "./modules/ClientFundInRequests";
import ClientFundInternalTransferRequests from "./modules/ClientFundInternalTransferRequests";
import ClientHKFundOutRequests from "./modules/ClientHKFundOutRequests";
import ClientOverseasFundOutRequests from "./modules/ClientOverseasFundOutRequests";
import ClientCreditCardFundOutRequests from "./modules/ClientCreditCardFundOutRequests";
import ClientBankCards from "./modules/ClientBankCards";

export default new Vuex.Store({
	strict: false,
	modules: {
		UnauditedList1: UnauditedList1,
		RejectedList1: RejectedList1,
		ReauditList1: ReauditList1,
		UnauditedList2: UnauditedList2,
		DeliverableList2: DeliverableList2,
		SendingEmailList: SendingEmailList,
		ClientFundInRequests: ClientFundInRequests,
		ClientFundInternalTransferRequests: ClientFundInternalTransferRequests,
		ClientHKFundOutRequests: ClientHKFundOutRequests,
		ClientOverseasFundOutRequests: ClientOverseasFundOutRequests,
		ClientCreditCardFundOutRequests: ClientCreditCardFundOutRequests,
		ClientBankCards: ClientBankCards,
	}
});