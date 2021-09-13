const Menu = {
    namespaced: true,
    state: () => ({
        counts: {
            一審資料未審核清單: 0,
            二審資料未審核清單: 0,
            資料駁回清單: 0
        }
    }),
    mutations: {
        counts(state, payload) {
            state.counts = payload;
        }
    }
}
export default Menu;