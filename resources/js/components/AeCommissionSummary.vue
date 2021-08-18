<template>
    <div class="my-4">
        <h1 class="text-warning text-center my-3">AE獎金計算</h1>
        <b-tabs v-model="tabIndex" justified>
            <b-tab title="獎金總覽" lazy :title-link-class="linkClass(0)" @click="dismissCountDown=5" active>
                <ae-commission-summary-list></ae-commission-summary-list>
            </b-tab>
            <b-tab title="設定資金利率" lazy :title-link-class="linkClass(1)" @click="dismissCountDown=5">
                <ipo-interest-list></ipo-interest-list>
            </b-tab>
        </b-tabs>
    </div>
</template>

<script>
import axios from "../mixins/mixin_post"
import validator from "../mixins/mixin_validators";
export default {
    mixins:[axios,validator],
    name: 'ae_commission_summary',
    data() {
      return {
          // tabs
          tabIndex:0,
      }
    },
    methods: {
        index(){

        },
        // tabs
        linkClass(idx){
            return (this.tabIndex === idx)?'text-light':'text-secondary'
        }
    }
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style>
.switch_search .nav-tabs{
    border-bottom: 0;
}
.switch_search .nav-tabs .nav-link.active{
    color: #fff;
}
.switch_search .nav-tabs .nav-link{
    border: transparent;
    padding: 0 2rem 0.5rem 0rem;
    margin-bottom: 0;
    color: #6c757d;
}

.divider {
    text-align: center;
    position: relative;
    font-weight: 400;
    color: rgba(140, 142, 165, 1);
    line-height: 25px;
    margin-bottom: 1rem;
}
.divider:after, .divider:before {
    position: absolute;
    width: 54px;
    height: 0.5px;
    background: #dadada;
    content: '';
    top: 15px;
}
.divider:before {
    right: 25%;
}
.divider:after {
    left: 25%;
}
</style>
