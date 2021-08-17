<template>
    <b-modal
    :id="id"
    :title="title"
    size="xl"
    @ok="$emit('ok')"
    @cancel="$emit('cancel')"
    @close="$emit('close')">
        <template #default>
            <b-form-group
                v-if="mode=='import' || edit_model=='upload'"
                label="上傳利率設定:"
                label-cols-sm="2">
                <b-form-file id="file-default"></b-form-file>
            </b-form-group>
            <b-table
                v-if="mode=='import_audit' && edit_model==''"
                sort-by="buss_date"
                :sort-desc="true"
                :items="items"
                :fields="fields">
            </b-table>
            <b-form-textarea
                v-if="mode=='import_audit' && edit_model=='reject'"
            >
            </b-form-textarea>
        </template>
        <template #modal-footer="{ audit, reject }">
            <b-button size="sm" variant="secondary" v-if="mode=='import'" @click="cancel">取消</b-button>
            <b-button size="sm" variant="success" v-if="mode=='import'" @click="$emit('ok')">上傳</b-button>
            <b-button size="sm" variant="secondary" v-if="mode=='import_audit' && edit_model==''" @click="edit_model='reject'">駁回</b-button>
            <b-button size="sm" variant="success" v-if="mode=='import_audit' && edit_model==''" @click="edit_model='upload'">重新上傳</b-button>
            <b-button size="sm" variant="success" v-if="mode=='import_audit' && edit_model==''" @click="audit()">簽名</b-button>
            <b-button size="sm" variant="secondary" v-if="mode=='import_audit' && edit_model=='reject'" @click="edit_model=''">取消</b-button>
            <b-button size="sm" variant="success" v-if="mode=='import_audit' && edit_model=='reject'" @click="reject()">送出</b-button>
            <b-button size="sm" variant="secondary" v-if="mode=='import_audit' && edit_model=='upload'" @click="edit_model=''">取消</b-button>
            <b-button size="sm" variant="success" v-if="mode=='import_audit' && edit_model=='upload'" @click="upload()">送出</b-button>
        </template>
    </b-modal>
</template>

<script>
import axios from "../mixins/mixin_post"
import validator from "../mixins/mixin_validators";
export default {
    mixins:[axios,validator],
    name:'ipo_interest_import',
    props: ['mode','id','title'],
    data(){
        return {
          edit_model: '',
          fields:[
            { key: 'buss_date', label: '申購日期', sortable: false },
            { key: 'product_name', label: '新股名稱', sortable: false },
            { key: 'actions', label: '操作' },
            { key: 'audit08', label: '審核', sortable: false },
            { key: 'channel', label: '資金來源', sortable: false },
            { key: 'interest_cost', label: '手續費', sortable: false },
            { key: 'interest_day', label: '天數', sortable: false },
            { key: 'interest_rate', label: '利率', sortable: false },
            { key: 'audit13', label: '審核', sortable: false },
            { key: 'acc13', label: '全權委託', sortable: false }
          ],
          pagination:{
              current_page: 1,
              last_page: 1,
              path: ''
          },
          items:[
            {
                id:4,
                buss_date:'2021-07-16',
                product_name:'KINDSTAR GLOBAL康聖環球1',
                channel:'CYSS',
                interest_cost: 5,
                interest_day: 7,
                interest_rate: 0.08,
                audit1for08: '',
                audit1for08_date: '',
                audit2for08: '',
                audit2for08_date: '',
                remark_for08: '',
                audit1for13: '',
                audit1for13_date: '',
                audit2for13: '',
                audit2for13_date: '',
                remark_for13: '',
                has13: false,
                created_at:'2020-09-01 23:01:10',
                updated_at:'2020-09-01 23:02:13',
            },
            {
                id:3,
                buss_date:'2021-07-15',
                product_name:'KINDSTAR GLOBAL康聖環球',
                channel:'CYSS',
                interest_cost: 5,
                interest_day: 7,
                interest_rate: 0.08,
                audit1for08: 'Linda',
                audit1for08_date: '2021-08-01',
                audit2for08: '',
                audit2for08_date: '',
                remark_for08: 'test',
                audit1for13: 'Linda',
                audit1for13_date: '2021-08-01',
                audit2for13: '',
                audit2for13_date: '',
                remark_for13: 'test',
                has13: false,
                created_at:'2020-09-01 23:01:10',
                updated_at:'2020-09-01 23:02:13',
            },
            {
                id:2,
                buss_date:'2021-07-14',
                product_name:'MEDLIVE 醫脈通',
                channel:'CYSS',
                interest_cost: 5,
                interest_day: 7,
                interest_rate: 0.08,
                audit1for08: 'Linda',
                audit1for08_date: '2021-08-01',
                audit2for08: '',
                audit2for08_date: '',
                remark_for08: '',
                audit1for13: 'Linda',
                audit1for13_date: '2021-08-01',
                audit2for13: '',
                audit2for13_date: '',
                remark_for13: '',
                has13: true,
                created_at:'2020-09-01 23:01:10',
                updated_at:'2020-09-01 23:02:13',
            },
            {
                id:1,
                buss_date:'2021-07-12',
                product_name:'BRII - B 騰盛博藥-B',
                channel:'CYSS',
                interest_cost: 5,
                interest_day: 7,
                interest_rate: 0.08,
                audit1for08: 'Linda',
                audit1for08_date: '2021-08-01',
                audit2for08: 'Phoenix',
                audit2for08_date: '2021-08-01',
                remark_for08: '',
                audit1for13: 'Linda',
                audit1for13_date: '2021-08-01',
                audit2for13: 'Phoenix',
                audit2for13_date: '2021-08-01',
                remark_for13: '',
                has13: true,
                created_at:'2020-09-01 23:01:10',
                updated_at:'2020-09-01 23:02:13',
            }
          ],
          form:{
            id: 0,
          },
          edit_form:{
              channel: '',
              interest_cost: 0,
              interest_day: 0,
              interest_rate: 0,
              remark: ''
          },
          filter:{
              route: 'all',
              status: 'all',
              client_id: '',
              name: '',
              phone: '',
              email: '',
              content: '',
              date: [],
              operator: []
          },
        }
    },
    watch: {
        mode: function(v){
            this.edit_model=''
        }
    },
    created() {
        this.index();
    },
    methods: {
        // alert
        countDownChanged(dismissCountDown){
            this.dismissCountDown = dismissCountDown
        },
        collapse_summary(e){
            let el = e.currentTarget
            el.setAttribute('style',(el.getAttribute('style').indexOf('nowrap') >= 0)?'white-space: initial':'white-space: nowrap; text-decoration: underline;')
        },
        modify(){
            if(this.form.id===0) this.store()
            else this.update()
            this.index()
        },
        reload(v){
            this.filter.client_id = v
            this.index()
        },
        index(){
            let _this = this
            this.crudIndex(function(response){
                _this.items = response.data

                _this.pagination.last_page = response.last_page
                _this.pagination.base_url = response.path + '?page='
            },'/'+this.$options.name+'?page='+this.pagination.current_page, this.filterByTag)
        },
        store(){
            let _this = this
            let formdata = this.getFormData()
            this.crudStore(function(response){
                _this.index()
            }, formdata);
        },
        update(){
            let formdata = this.getFormData();
            this.crudUpdate(this.form.id, function(response){

            }, formdata);
        },
        show(item){
            ['channel','interest_cost','interest_day','interest_rate','remark'].forEach(i => this.edit_form[i]=item[i])
            this.edit_model=''
        },
        del(){
            let _this = this
            this.crudDestroy(this.form.id,function(response){
                _this.index()
            })
        },
        audit(){

        },
        reject(){

        },
        upload(){

        },
        cancel(){
            this.$emit('cancel')
            this.$bvModal.hide(this.id)
        }
    }
}
</script>

<style>
/* datepicker */
.mx-input{
    height: 37px;
}
.mx-datepicker-range{
    width: 100%;
}

.hint{
    color:gray;
    float: right;
    margin: -20px 3px 0 0;
}
#ipo_interest_list summary{
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 450px;
    min-width: 250px;
}
</style>