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
                    console.log(res);
                    res.data.forEach(element => {
                        self.counts[element.name] = element.count;
                    });
                    // self.counts["???????????????????????????"] = res.data.CountUnauditedList1;
                    // self.counts["???????????????????????????"] = res.data.CountReauditList1;
                    // self.counts["??????????????????"] = res.data.CountRejectedList1;
                    // self.counts["???????????????????????????"] = res.data.CountUnauditedList2;
                    // self.counts["???????????????????????????"] = res.data.CountDeliverableList2;
                    // self.counts["?????????????????????"] = res.data.CountSendingEmailList;
                    // self.counts["?????????????????????"] = res.data.CountClientBankCards;
                    // self.counts["????????????"] = res.data.CountClientFundInRequests;
                    // self.counts["??????????????????"] = res.data.CountClientHKFundOutRequests;
                }).catch((error) => {
                    console.log(error);
                });
        }
    }
}