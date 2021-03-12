const UnauditedDataList1HongKong = {
    namespaced: true,
    state: () => ({
        clientInfo: {}
    }),
    mutations: {
        clientInfo(state, payload) {
            state.clientInfo = payload;
        }
    }
}
export default UnauditedDataList1HongKong;