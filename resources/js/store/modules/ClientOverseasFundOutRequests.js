const ClientOverseasFundOutRequests = {
    namespaced: true,
    state: () => ({
        filters: {}
    }),
    mutations: {
        filters(state, payload) {
            state.filters = payload;
        }
    }
}
export default ClientOverseasFundOutRequests;