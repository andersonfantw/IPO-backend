<template>
    <span class="money" :class="{'loss-money': isNegative}">{{format_price}}</span>
</template>

<script>
export default {
    props: ['value','format','fractionDigits'],
    computed: {
        format_price: function(){
            let price = parseFloat(this.value);
            let options = {
                maximumFractionDigits: this.fractionDigits?this.fractionDigits:2,
                minimumFractionDigits: this.fractionDigits?this.fractionDigits:2,
                style: this.format?this.format:'currency',
                currency: 'HKD'
            }
            return price.toLocaleString('zh-HK',options);
        },
        isNegative: function(){
            return this.value<0;
        }
    }
}
</script>