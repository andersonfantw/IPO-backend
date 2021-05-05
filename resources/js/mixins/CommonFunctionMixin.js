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
    }
}