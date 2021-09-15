const Menu = {
    namespaced: true,
    state: () => ({
        counts: {
            一審資料未審核清單: 0,
            一審資料再審核清單: 0,
            資料駁回清單: 0,
            二審資料未審核清單: 0,
            二審資料可投遞清單: 0,
            開戶信發送清單: 0,
            添加銀行卡申請: 0,
            存款申請: 0,
            香港出款申請: 0,
        }
    }),
    mutations: {
        counts(state, payload) {
            state.counts = payload;
        }
    }
}
export default Menu;