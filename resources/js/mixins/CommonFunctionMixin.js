export const CommonFunctionMixin = {
    methods: {
        formateDateTime(datetime) {
            let dt = new Date(datetime);
            let dformat = `${dt.getFullYear().toString().padStart(4, "0")}-${(
                dt.getMonth() + 1
            )
                .toString()
                .padStart(2, "0")}-${dt
                    .getDate()
                    .toString()
                    .padStart(2, "0")} ${dt
                        .getHours()
                        .toString()
                        .padStart(2, "0")}:${dt
                            .getMinutes()
                            .toString()
                            .padStart(2, "0")}:${dt.getSeconds().toString().padStart(2, "0")}`;
            return dformat;
        },
        formateDate(datetime) {
            const dt = new Date(datetime);
            const dformat = `${dt.getFullYear().toString().padStart(4, "0")}-${(
                dt.getMonth() + 1
            )
                .toString()
                .padStart(2, "0")}-${dt
                    .getDate()
                    .toString()
                    .padStart(2, "0")}`;
            return dformat;
        },
        filter(item, filter) {
            let keep = true;
            for (const [key, value] of Object.entries(filter)) {
                if (value) {
                    // keep &= item[key].toUpperCase().startsWith(value.toUpperCase());
                    keep &= this[this.FilterType[key]](item[key], value);
                }
            }
            return keep;
        },
        startsWith(val1, val2) {
            if (val1 && val2) {
                return val1.toUpperCase().startsWith(val2.toUpperCase());
            } else {
                return false;
            }
        },
        betweenDate(val, array) {
            if (array && array.length == 2 && array[0] && array[1]) {
                const date = this.formateDate(val);
                const from = this.formateDate(array[0]);
                const to = this.formateDate(array[1]);
                return date >= from && date <= to;
            } else {
                return true;
            }
        },
        equals(val1, val2) {
            return val1 == val2;
        },
        contains(val1, val2) {
            if (val1 && val2) {
                return val1.includes(val2);
            } else {
                return false;
            }
        },
        checkLogin(res) {
            if (res.response && res.response.status === 401) {
                // redirect to login page
                window.location.href = "login";
            }
        },
        getCounts(axios) {
            const self = this;
            axios
                .get("Counts").then((res) => {
                    self.counts["一審資料未審核清單"] = res.data.CountUnauditedList1;
                    self.counts["一審資料再審核清單"] = res.data.CountReauditList1;
                    self.counts["資料駁回清單"] = res.data.CountRejectedList1;
                    self.counts["二審資料未審核清單"] = res.data.CountUnauditedList2;
                    self.counts["二審資料可投遞清單"] = res.data.CountDeliverableList2;
                    self.counts["開戶信發送清單"] = res.data.CountSendingEmailList;
                    self.counts["添加銀行卡申請"] = res.data.CountClientBankCards;
                    self.counts["存款申請"] = res.data.CountClientFundInRequests;
                    self.counts["香港出款申請"] = res.data.CountClientHKFundOutRequests;
                }).catch((error) => {
                    console.log(error);
                });
        }
    }
}