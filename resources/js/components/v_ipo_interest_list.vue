<template>
    <div id="ipo_interest_list">
        <a href="javascript:;" class="hint" @click="dismissCountDown=20"><i class="fas fa-question-circle"></i></a>

        <b-alert
        :show="dismissCountDown"
        dismissible
        fade
        class="m-4"
        variant="dark"
        @dismiss-count-down="countDownChanged"
        >
            <div @click="dismissCountDown=0">
                <p>使用說明：設定新股申購借貸利率。可對現金帳戶(單檔單一資金來源)及全權委託帳戶(單檔可能有多個資金來源)各別設定。</p>
                <p>現金帳戶的資金設定：需先經過財務審查，再由行政審查，確認後才確認資金使用。</p>
                <p>現金帳戶的資金設定：需先經過行政審查，再由財務審查，確認後才確認資金使用。</p>
                <p>>若對於資金的設定上不同意，可駁回並填寫原因。</p>
                <p>上傳利率人員：[設定/上傳]、[刪除]。 一審：[確認]、[駁回]、[刪除]。二審：[確認]、[駁回]。</p>
                <p>已經進入下一輪審核時，之前的人員不可再對資料做修改</p>
            </div>
        </b-alert>

        <div class="m-4">
            <b-pagination-nav
                v-model="pagination.current_page"
                :number-of-pages="pagination.last_page"
                base-url="#"
                use-router align="center"
            ></b-pagination-nav>

            <b-table
                sort-by="buss_date"
                :sort-desc="true"
                class="text-white"
                :items="items"
                :fields="fields">
                <template #thead-top="">
                    <b-tr>
                        <b-th colspan="3" class="border-top-0 border-right pt-0 pb-2">
                            <b-button variant="success" @click="mode='edit'"><i class="fas fa-pencil-alt"></i> 輸入</b-button>
                            <b-button variant="success" @click="mode='audit1'"><i class="fas fa-edit"></i> 一審</b-button>
                            <b-button variant="success" @click="mode='audit2'"><i class="fas fa-edit"></i> 二審</b-button>
                        </b-th>
                        <b-th colspan="5" class="text-center border-right">現金帳戶</b-th>
                        <b-th colspan="2" class="text-center">全權委託</b-th>
                    </b-tr>
                </template>
                <template #cell(actions)="row">
                    <b-button
                        size="sm" class="mr-1" variant="success"
                        v-b-modal.setting
                        @click="show('setting',row.item)"
                        mode="setting"
                        v-if="['edit','all'].includes(mode)"
                        :disabled="row.item.audit1for08!='' && row.item.remark_for08==''">
                        <i class="fas fa-cog"></i> 設定
                    </b-button>
                    <b-button 
                        size="sm" class="mr-1" variant="success" 
                        v-b-modal.setting_audit 
                        @click="show('setting_audit',row.item)"
                        mode="setting_audit" 
                        v-if="['audit1','audit2','all'].includes(mode)" 
                        :disabled="(mode=='edit')?(row.item.audit1for08!='' && row.item.remark_for08==''):(mode=='audit1')?(row.item.audit2for08!='' && row.item.remark_for08==''):false">
                        <i class="fas fa-edit"></i> 審核
                    </b-button>
                </template>
                <template #cell(audit08)="row">
                    <span class="fa-stack">
                        <i class="far fa-square fa-stack-1x"></i>
                        <i v-if="row.item.audit1for08!='' && row.item.remark_for08==''" class="fas fa-check fa-stack-2x text-success" v-b-tooltip.hover :title="row.item.audit1for08+' '+row.item.audit1for08_date"></i>
                        <i v-if="row.item.audit1for08!='' && row.item.remark_for08!=''" class="fas fa-times fa-stack-2x text-danger" v-b-tooltip.hover :title="row.item.audit1for08+' '+row.item.remark_for08"></i>
                    </span> 財務
                    <span class="fa-stack">
                        <i class="far fa-square fa-stack-1x"></i>
                        <i v-if="row.item.audit2for08!='' && row.item.remark_for08==''" class="fas fa-check fa-stack-2x text-success" v-b-tooltip.hover :title="row.item.audit2for08+' '+row.item.audit2for08_date"></i>
                        <i v-if="row.item.audit2for08!='' && row.item.remark_for08!=''" class="fas fa-times fa-stack-2x text-danger" v-b-tooltip.hover :title="row.item.audit2for08+' '+row.item.remark_for08"></i>                        
                    </span> 運營
                </template>
                <template #cell(audit13)="row">
                    <span class="fa-stack">
                        <i class="far fa-square fa-stack-1x"></i>
                        <i v-if="row.item.audit1for13!='' && row.item.remark_for13==''" class="fas fa-check fa-stack-2x text-success" v-b-tooltip.hover :title="row.item.audit1for13+' '+row.item.audit1for13_date"></i>
                        <i v-if="row.item.audit1for13!='' && row.item.remark_for13!=''" class="fas fa-times fa-stack-2x text-danger" v-b-tooltip.hover :title="row.item.audit1for13+' '+row.item.remark_for13"></i>
                    </span> 運營
                    <!-- <span class="fa-stack">
                        <i class="far fa-square fa-stack-1x"></i>
                        <i v-if="row.item.audit2for13!='' && row.item.remark_for13==''" class="fas fa-check fa-stack-2x text-success" v-b-tooltip.hover :title="row.item.audit2for13+' '+row.item.audit2for13_date"></i>
                        <i v-if="row.item.audit2for13!='' && row.item.remark_for13!=''" class="fas fa-times fa-stack-2x text-danger" v-b-tooltip.hover :title="row.item.audit2for13+' '+row.item.remark_for13"></i>                        
                    </span> 產品部 -->
                </template>
                <template #cell(acc13)="row">
                    <b-button size="sm" class="mr-1" variant="success" v-b-modal.import @click="show_import('import',row.item)" mode="import" v-if="['edit','all'].includes(mode)" :disabled="row.item.audit1for13!='' && row.item.remark_for13==''">
                        <i class="fas fa-cloud-upload-alt"></i> 匯入
                    </b-button>
                    <b-button size="sm" class="mr-1 text-white" variant="info" v-b-modal.import_audit @click="show_import('import_audit',row.item)" mode="import_audit" v-if="['audit1','audit2','all'].includes(mode)" :disabled="row.item.status=='success'">
                        <i class="fas fa-info-circle"></i> 檢視
                    </b-button>
                </template>
            </b-table>
        </div>

        <!-- del confirm -->
        <b-modal id="del" title="刪除發送任務" @ok="del">
            <p class="my-4">您確定要刪除尚未送出 序號為{{form.id}} 的通知嗎?</p>
        </b-modal>
        <!-- audit -->
        <ipo-interest-setting
            :mode="setting_mode"
            :id="setting_mode"
            :title="(setting_mode=='setting')?'現金帳戶資金利率設定 '+target_item.product_name:'現金帳戶資金利率審查 '+target_item.product_name"
            :value="target_item">
        </ipo-interest-setting>
        <!-- import / view -->
        <ipo-interest-import
            :mode="import_mode"
            :id="import_mode"
            :title="(import_mode=='import')?'全權委託資金利率上傳 '+target_item.product_name:'全權委託資金利率審核 '+target_item.product_name"
            :value="target_item">
        </ipo-interest-import>
    </div>
</template>

<script>
import axios from "../mixins/mixin_post"
import validator from "../mixins/mixin_validators";
export default {
    mixins:[axios,validator],
    name:'ipo_interest_list',
    data(){
        return {
          // alert
          dismissCountDown: 0,
          tabIndex: 0,
          mode: 'audit1', //edit, audit1, audit2, all
          setting_mode: '',
          import_mode: '',

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
          target_item:{},
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
    created() {
        this.index();
    },
    watch: {
        'pagination.current_page': function(n){
            this.index()
        }
    },
    computed:{
        filterByTag(){
            let a = ['client_id','name','phone','email']
            let e = a[this.tabIndex]
            let t = {client_id: '',name: '',phone: '',email: ''}
            
            t[e] = this.filter[e]
            return Object.assign({},this.filter,t)
        }
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
        show(mode, item){
            this.target_item=item
            this.setting_mode=mode
            setTimeout(() => this.$bvModal.show(mode), 10)
        },
        show_import(mode, item){
            this.target_item=item
            this.import_mode=mode
            setTimeout(() => this.$bvModal.show(mode), 10)
        },
        del(){
            let _this = this
            this.crudDestroy(this.form.id,function(response){
                _this.index()
            })
        },
        reject(){

        },
        upload(){

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