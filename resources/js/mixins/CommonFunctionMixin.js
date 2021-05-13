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
        between(val, array) {
            return val >= array[0] && val <= array[1];
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
        }
    }
}