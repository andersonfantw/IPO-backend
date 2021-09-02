<template>
    <div id="ae_commission_detail">
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
                <p>使用說明：檢視AE業績。可添加非AE人員的業績。</p>
                <p>資金利率設定後，會有營業部及財務部門的確認後，方可使用</p>
            </div>
        </b-alert>

        <div class="m-4">
            <b-row class="filter text-white">
                <b-col cols="3">
                    <div>
                        <!-- <b-button class="mb-3" variant="success" :disabled="dirty"><i class="fas fa-cogs"></i> 重製PDF報表</b-button> -->
                        <b-button class="mb-3" variant="success" :disabled="dirty" @click="downloadCsv"><i class="fas fa-file-csv"></i> 下載當月CSV佣金明細</b-button>
                        <!-- <b-button class="mb-3" variant="success" :disabled="dirty" @click="downloadPdf"><i class="far fa-file-pdf"></i> 下載當月PDF佣金明細</b-button> -->
                    </div>
                </b-col>
                <b-col cols="5">
                    <div class="text-dark">
                        共 {{items.length}} 筆記錄
                    </div>
                </b-col>
                <b-col cols="4">
                    <b-button-group v-if="dirty" class="float-right">
                        <b-button class="mb-3" @click="reset"><i class="fas fa-door-open"></i>取消</b-button>
                        <b-button class="mb-3" variant="success" @click="update"><i class="far fa-save"></i>儲存</b-button>
                    </b-button-group>
                </b-col>
            </b-row>

            <b-table :items="items" :fields="fields" bordered>
                <template #head(cate)>
                    <b-form-select v-model="filter.cate" :options="cate_options"></b-form-select>
                </template>
                <template #head(client_acc_id)>
                    <b-form-select v-model="filter.client_acc_id" :options="client_acc_id_options"></b-form-select>
                </template>
                <template #head(product_id)>
                    <b-form-select v-model="filter.product_id" :options="product_id_options"></b-form-select>
                </template>
                <template #head(dummy)>
                    <b-form-select v-model="filter.dummy" :options="dummy_options"></b-form-select>
                </template>
                <template #cell(seq)>
                    {{++seq}}
                </template>
                <template #cell(application_fee)="row">
                    <v-money :value="row.item.application_fee?row.item.application_fee:0"></v-money>
                </template>
                <template #cell(bonus_application)="row">
                    <v-money :value="row.item.bonus_application?row.item.bonus_application:0"></v-money>
                </template>
                <template #cell(application_cost)="row">
                    <v-money :value="row.item.application_cost?row.item.application_cost:0"></v-money>
                </template>
                <template #cell(ae_application_cost)="row">
                    <v-money :value="row.item.ae_application_cost?row.item.ae_application_cost:0"></v-money>
                </template>
                <template #cell(accumulate_performance)="row">
                    <v-money :value="row.item.accumulate_performance?row.item.accumulate_performance:0"></v-money>
                </template>
            </b-table>
        </div>
    </div>
</template>

<script>
import axios from "../mixins/mixin_post"
export default {
    mixins:[axios],
    name:'ae_commission_summary',
    props: ['uuid','month'],
    data(){
        return {
          // alert
          dismissCountDown: 0,
          dirty: false,
          month_options:[],
          seq:0,
          ae_options:[
              {value:'all', text:'全部'},
              {value:'e550be72-fcb1-4779-980f-f255ff6eb041', text:'梧桐花開'},
              {value:'7fff6132-4bcc-4932-a630-358a21a7bef4', text:'劉素惠'},
          ],
          cate_options:[
              {value:'', text:'項目'},
              {value:'principal', text:'開戶激勵＿專戶'},
              {value:'fee08', text:'申購手續費_現金戶'},
              {value:'fee13', text:'申購手續費_專戶'},
              {value:'interest08', text:'利息收支_現金戶'},
              {value:'interest13', text:'利息收支_專戶'},
              {value:'alloted08', text:'中籤收入_現金戶'},
              {value:'alloted13', text:'中籤收入_專戶'},
              {value:'sell08', text:'二級市場收入_現金戶'},
              {value:'sell13', text:'二級市場收入_專戶'},
          ],
          client_acc_id_options:[],
          product_id_options:[
              {value:'', text:'產品代號'},
          ],
          dummy_options:[
              {value:'', text:'列計算'},
              {value:'0', text:'否'},
              {value:'1', text:'是'},
          ],
          fields:[
              { key:'seq', label:'序號' },
              { key:'cate', label:'項目', sortable: true },
              { key:'buss_date', label:'交易日', sortable: true },
              { key:'allot_date', label:'交收日', sortable: true },
              { key:'client_acc_id', label:'客戶帳號', class: 'text-center', sortable: true },
              { key:'product_id', label:'產品代號', class: 'text-center', sortable: true },
              { key:'application_fee', label:'項目收入', class: 'text-right', sortable: true },
              { key:'application_cost', label:'項目成本', class: 'text-right', sortable: true },
              { key:'accumulate_performance', label:'帳戶累積收入', class: 'text-right', sortable: true },
              { key:'seq', label:'13累積序號', class: 'text-center' },
              { key:'dummy', label:'是否計算佣金', class: 'text-center' },
              { key:'bonus_application1', label:'獎金', class: 'text-center' },
          ],
          items:[
            {
              id: 197,
              cate: 'alloted08',
              ae_code: 'AEWHC',
              buss_date: '2021-03-08',
              client_acc_id: '3392008',
              product_id: '00981:HK',
              application_fee: null,
              bonus_application: null,
              application_cost: null,
              ae_application_const: null,
              accumulate_performance: -4149.9,
              seq: null,
              dummy: 1,
            }
          ],
          has_pdf: true,
          filter:{
              cate: '',
              client_acc_id: '',
              product_id: '',
              dummy: '',
          }
        }
    },
    watch: {
        uuid(){
            this.index()
        },
        month(){
            this.index()
        },
        filter: {
            deep: true,
            handler: function(n,o){
                this.index()
            }
        }
    },
    created() {
        this.index()
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
        },
        reset(){
            this.dirty = false
            for ( let k in this.form ) { this.form[k]='' }
            this.$nextTick(() => this.dirty = false)
        },
        reload(v){
            this.filter.client_id = v
            this.index()
        },
        index(){
            let _this = this
            this.myGet(function(response){
                _this.items = response.data
                _this.seq=0
                _this.product_id_options = response.data.map(o=>o.product_id).filter(function(v,i,s){return s.indexOf(v)===i}).map(o=>{return {value:o, text:o}})
                _this.product_id_options.unshift({value:'',text:'產品代號'})
                _this.client_acc_id_options = response.data.map(o=>o.client_acc_id).filter(function(v,i,s){return s.indexOf(v)===i}).map(o=>{return {value:o, text:o}})
                _this.client_acc_id_options.unshift({value:'',text:'客戶帳號'})
            },Object.assign({},{ uuid:this.uuid, month:this.month},this.filter),this.url('detail'))
        },
        store(){
        },
        edit(){
        },
        update(){
        },
        del(){
        },
        make_option_from_date_row(){

        },
        showPdf(){
            window.open('AeCommissionSummary/ShowPdf/'+this.uuid+'?month='+this.month)
        },
        downloadCsv(){
            window.open('AeCommissionSummary/DownloadDetailCsv?uuid='+this.uuid+'&month='+this.month)
        },
        downloadPdf(){
            window.open('AeCommissionSummary/DownloadDetailPdf?uuid='+this.uuid+'&month='+this.month)
        },
        valid_number(style, val){
            if(val=='' || val===null) return '';
            if(style=='+') return (val>0)?'border-success':'border-danger'
            else if(style=='-') return (val>0)?'border-danger':'border-success'
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
#ae_commission_detail .embed-responsive{
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
}
</style>