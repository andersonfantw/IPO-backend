<template>
    <div class="text-right">
        <b-tabs class="notification_import_excel_format_example" v-model="tabIndex" v-if="mode=='group'" justified>
            <b-tab class="px-2" title="客戶帳號" :title-link-class="linkClass(0)" active>
                <b-img fluid src="images/import_example_client_acc_id.png"></b-img>
            </b-tab>
            <b-tab class="px-2" title="手機號碼" :title-link-class="linkClass(1)" v-if="_route=='sms'">
                <b-img fluid src="images/import_example_mobile_no.png"></b-img>
            </b-tab>
            <b-tab class="px-2" title="Email清單" :title-link-class="linkClass(1)" v-if="_route=='email'">
                <b-img fluid src="images/import_example_email.png"></b-img>
            </b-tab>
        </b-tabs>
        <b-link href="/files/example.xls">下載範本</b-link>
    </div>
</template>

<script>
import axios from "../mixins/mixin_post"
export default {
    mixins: [axios],
    props:['route','mode'],
    data(){
        return {
            tabIndex:0
        }
    },
    computed:{
        _route(){
            return this.route?this.route:'sms'
        }
    },
    methods: {
        // tabs
        linkClass(idx){
            return (this.tabIndex === idx)?'text-dark':'text-secondary'
        }
    }
}
</script>

<style>
.notification_import_excel_format_example .nav-tabs .nav-link.active,
.notification_import_excel_format_example .nav-tabs .nav-item.show .nav-link{
    background-color: initial;
    border-color: transparent;
    font-weight: bold;
}
</style>