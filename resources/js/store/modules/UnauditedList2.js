const UnauditedList2 = {
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
export default UnauditedList2;