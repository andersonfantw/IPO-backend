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
                <p>開啟的PDF請下載儲存，系統上的PDF顯示系統中即時的數據，數據會因修改而PDF中的數值有所更動</p>
            </div>
        </b-alert>

        <div class="m-4">
            <b-row class="filter text-white">
                <b-col cols="8">
                    <div>
                        <!-- <b-button class="mb-3" variant="success" :disabled="dirty"><i class="fas fa-cogs"></i> 重製PDF報表</b-button> -->
                        <b-button class="mb-3" variant="success" :disabled="dirty" @click="showConfirmPdf"><i class="far fa-file-pdf"></i> 下載當月確認表</b-button>
                        <b-button class="mb-3" variant="success" :disabled="dirty" @click="showPaymentRequestFormPdf"><i class="far fa-file-pdf"></i> 下載當月PaymentRequestForm</b-button>
                    </div>
                </b-col>
                <b-col cols="4">
                    <b-button-group v-if="dirty" class="float-right">
                        <b-button class="mb-3" @click="reset"><i class="fas fa-door-open"></i>取消</b-button>
                        <b-button class="mb-3" variant="success" @click="update"><i class="far fa-save"></i>儲存</b-button>
                    </b-button-group>
                </b-col>
            </b-row>

            <b-table-simple bordered>
                <b-thead>
                    <b-tr class="bg-secondary">
                        <b-th>產品分類</b-th>
                        <b-th>項目</b-th>
                        <b-th class="text-center" style="width:30%">業績</b-th>
                        <b-th class="text-center" style="width:30%">獎金</b-th>
                        <b-th class="text-center" style="width:200px">說明</b-th>
                    </b-tr>
                </b-thead>
                <b-tbody>
                    <b-tr>
                        <b-th>新股申購(收入項)</b-th>
                        <b-th>申購手續費</b-th>
                        <b-td>
                            <b-row>
                                <b-col class="text-right border-right"><v-money :value="calculate_form.fee"></v-money></b-col>
                                <b-col class="text-right">
                                    <v-money v-if="calculate_form.pay_date && form.fee" :value="form.fee"></v-money>
                                    <b-input-group size="sm" prepend="HK$" v-else-if="!calculate_form.pay_date">
                                        <b-form-input size="sm" class="text-right" v-model="form.fee" placeholder="手動調整" :class="valid_number('+',form.fee)"></b-form-input>
                                    </b-input-group>
                                </b-col>
                            </b-row>
                        </b-td>
                        <b-td>
                            <b-row>
                                <b-col class="text-right border-right"><v-money :value="calculate_form.fee_bonus"></v-money></b-col>
                                <b-col class="text-right"><v-money :value="(form.fee)?form.fee*0.6:calculate_form.fee_bonus"></v-money></b-col>
                            </b-row>
                        </b-td>
                        <b-td></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th></b-th>
                        <b-th>利息收入</b-th>
                        <b-td>
                            <b-row>
                                <b-col class="text-right border-right"><v-money :value="calculate_form.interest"></v-money></b-col>
                                <b-col class="text-right">
                                    <v-money v-if="calculate_form.pay_date && form.interest" :value="form.interest"></v-money>
                                    <b-input-group size="sm" prepend="HK$" v-else-if="!calculate_form.pay_date">
                                        <b-form-input size="sm" class="text-right" v-model="form.interest" placeholder="手動調整" :class="valid_number('+',form.interest)"></b-form-input>
                                    </b-input-group>
                                </b-col>
                            </b-row>
                        </b-td>
                        <b-td>
                            <b-row>
                                <b-col class="text-right border-right"><v-money :value="calculate_form.interest_bonus"></v-money></b-col>
                                <b-col class="text-right"><v-money :value="(form.interest)?form.interest*0.6:calculate_form.interest_bonus"></v-money></b-col>
                            </b-row>
                        </b-td>
                        <b-td></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th></b-th>
                        <b-th>中簽佣金</b-th>
                          <b-td>
                            <b-row>
                                <b-col class="text-right border-right"><v-money :value="calculate_form.alloted"></v-money></b-col>
                                <b-col class="text-right">
                                    <v-money v-if="calculate_form.pay_date && form.alloted" :value="form.alloted"></v-money>
                                    <b-input-group size="sm" prepend="HK$" v-else-if="!calculate_form.pay_date">
                                        <b-form-input size="sm" class="text-right" v-model="form.alloted" placeholder="手動調整" :class="valid_number('+',form.alloted)"></b-form-input>
                                    </b-input-group>
                                </b-col>
                            </b-row>
                        </b-td>
                        <b-td>
                            <b-row>
                                <b-col class="text-right border-right"><v-money :value="calculate_form.alloted_bonus"></v-money></b-col>
                                <b-col class="text-right"><v-money :value="(form.alloted)?form.alloted*0.6:calculate_form.alloted_bonus"></v-money></b-col>
                            </b-row>
                        </b-td>
                        <b-td></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th>新股申購(成本項)</b-th>
                        <b-th>申購成本</b-th>
                        <b-td>
                            <b-row>
                                <b-col class="text-right border-right"><v-money :value="calculate_form.fee_cost"></v-money></b-col>
                                <b-col class="text-right">
                                    <v-money v-if="calculate_form.pay_date && form.fee_cost" :value="form.fee_cost"></v-money>
                                    <b-input-group size="sm" prepend="HK$" v-else-if="!calculate_form.pay_date">
                                        <b-form-input size="sm" class="text-right" v-model="form.fee_cost" placeholder="手動調整" :class="valid_number('-',form.fee_cost)"></b-form-input>
                                    </b-input-group>
                                </b-col>
                            </b-row>
                        </b-td>
                        <b-td>
                            <b-row>
                                <b-col class="text-right border-right"><v-money :value="calculate_form.ae_fee_cost"></v-money></b-col>
                                <b-col class="text-right"><v-money :value="(form.fee_cost)?form.fee_cost*0.6:calculate_form.ae_fee_cost"></v-money></b-col>
                            </b-row>
                        </b-td>
                        <b-td></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th></b-th>
                        <b-th>利息成本</b-th>
                        <b-td>
                            <b-row>
                                <b-col class="text-right border-right"><v-money :value="calculate_form.interest_cost"></v-money></b-col>
                                <b-col class="text-right">
                                    <v-money v-if="calculate_form.pay_date && form.interest_cost" :value="form.interest_cost"></v-money>
                                    <b-input-group size="sm" prepend="HK$" v-else-if="!calculate_form.pay_date">
                                        <b-form-input size="sm" class="text-right" v-model="form.interest_cost" placeholder="手動調整" :class="valid_number('-',form.interest_cost)"></b-form-input>
                                    </b-input-group>
                                </b-col>
                            </b-row>
                        </b-td>
                        <b-td>
                            <b-row>
                                <b-col class="text-right border-right"><v-money :value="calculate_form.ae_interest_cost"></v-money></b-col>
                                <b-col class="text-right"><v-money :value="(form.interest_cost)?form.interest_cost*0.6:calculate_form.ae_interest_cost"></v-money></b-col>
                            </b-row>
                        </b-td>
                        <b-td></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th>二級市場佣金</b-th>
                        <b-th>手續費收入</b-th>
                        <b-td>
                            <b-row>
                                <b-col class="text-right border-right"><v-money :value="calculate_form.sell"></v-money></b-col>
                                <b-col class="text-right">
                                    <v-money v-if="calculate_form.pay_date && form.sell" :value="form.sell"></v-money>
                                    <b-input-group size="sm" prepend="HK$" v-else-if="!calculate_form.pay_date">
                                        <b-form-input size="sm" class="text-right" v-model="form.sell" placeholder="手動調整" :class="valid_number('+',form.sell)"></b-form-input>
                                    </b-input-group>
                                </b-col>
                            </b-row>
                        </b-td>
                        <b-td>
                            <b-row>
                                <b-col class="text-right border-right"><v-money :value="calculate_form.sell_bonus"></v-money></b-col>
                                <b-col class="text-right"><v-money :value="(form.sell)?form.sell*0.6:calculate_form.sell_bonus"></v-money></b-col>
                            </b-row>
                        </b-td>
                        <b-td></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th>專戶開戶獎金</b-th>
                        <b-th>開戶獎金</b-th>
                        <b-td>
                            <b-row>
                                <b-col class="text-right border-right"><v-money :value="calculate_form.principal"></v-money></b-col>
                                <b-col class="text-right">
                                    <v-money v-if="form.principal_number" :value="form.principal_number*450"></v-money>
                                    <v-money v-else :value="calculate_form.principal"></v-money>
                                </b-col>
                            </b-row>
                        </b-td>
                        <b-td>
                            <b-row>
                                <b-col class="text-right border-right"><v-money :value="calculate_form.principal"></v-money></b-col>
                                <b-col class="text-right">
                                    <v-money v-if="form.principal_number" :value="form.principal_number*450"></v-money>
                                    <v-money v-else-if="calculate_form.pay_date && form.principal" :value="calculate_form.principal"></v-money>
                                    <v-money v-else :value="calculate_form.principal"></v-money>
                                </b-col>
                            </b-row>
                        </b-td>
                        <b-td class="text-right">
                            <b-input-group size="sm" append="個帳戶過冷靜期" :prepend="calculate_form.principal_number" v-if="!calculate_form.pay_date">
                                <b-form-input size="sm" class="text-right" v-model="form.principal_number" :class="valid_number('+',form.principal_number)"></b-form-input>
                            </b-input-group>
                            <span v-else>{{(form.principal_number)?form.principal_number:calculate_form.principal_number}}個帳戶過冷靜期</span>
                        </b-td>
                    </b-tr>
                    <b-tr>
                        <b-th>佣金小計</b-th>
                        <b-th></b-th>
                        <b-td></b-td>
                        <b-td>
                            <b-row>
                                <b-col class="text-right border-right"><v-money :value="commission_calculate_subtitle"></v-money></b-col>
                                <b-col class="text-right"><v-money :value="commission_subtitle"></v-money></b-col>
                            </b-row>
                        </b-td>
                        <b-td>
                        </b-td>
                    </b-tr>
                    <b-tr>
                        <b-th>A.</b-th>
                        <b-th>提撥準備數</b-th>
                        <b-td></b-td>
                        <b-td></b-td>
                        <b-td></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th></b-th>
                        <b-th>本期提撥準備</b-th>
                        <b-td class="text-center">10%</b-td>
                        <b-td>
                            <b-row>
                                <b-col class="text-right"><v-money :value="-commission_calculate_subtitle*0.1"></v-money></b-col>
                                <b-col class="text-right"><v-money :value="-commission_subtitle*0.1"></v-money></b-col>
                            </b-row>
                        </b-td>
                        <b-td></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th></b-th>
                        <b-th>上期累計提撥準備金</b-th>
                        <b-td></b-td>
                        <b-td>
                            <b-row>
                                <b-col class="text-right"><v-money :value="calculate_form.accumulated_provision"></v-money></b-col>
                            </b-row>
                        </b-td>
                        <b-td></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th></b-th>
                        <b-th>規定提撥準備上限</b-th>
                        <b-td></b-td>
                        <b-td class="text-right">
                            <v-money value="50000"></v-money>
                        </b-td>
                        <b-td></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th>B.</b-th>
                        <b-th>其他傭金扣減項</b-th>
                        <b-td></b-td>
                        <b-td>
                            <!-- <b-row>
                                <b-col></b-col>
                                <b-col class="text-right">
                                    <b-input-group size="sm" prepend="HK$" v-if="!calculate_form.pay_date">
                                        <b-form-input size="sm" class="text-right" v-model="form.other" :class="valid_number('-',form.other)"></b-form-input>
                                    </b-input-group>
                                    <span v-else>HK${{form.other}}</span>
                                </b-col>
                            </b-row> -->
                        </b-td>
                        <b-td></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th></b-th>
                        <b-th>扣減項小計</b-th>
                        <b-td></b-td>
                        <b-td>
                            <b-row>
                                <b-col></b-col>
                                <b-col class="text-right"><v-money :value="-commission_subtitle*0.1"></v-money></b-col>
                            </b-row>
                        </b-td>
                        <b-td></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th>本期佣金可發放金額</b-th>
                        <b-th></b-th>
                        <b-td></b-td>
                        <b-td>
                            <b-row>
                                <b-col></b-col>
                                <b-col class="text-right"><v-money :value="subtitle"></v-money></b-col>
                            </b-row>
                        </b-td>
                        <b-td></b-td>
                    </b-tr>
                </b-tbody>
            </b-table-simple>
        </div>

        <!-- del confirm -->
        <b-modal id="del" title="刪除發送任務" @ok="del">
            <p class="my-4">您確定要刪除尚未送出 序號為{{form.id}} 的記錄嗎?</p>
        </b-modal>
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
          ae_options:[
              {value:'all', text:'全部'},
              {value:'e550be72-fcb1-4779-980f-f255ff6eb041', text:'梧桐花開'},
              {value:'7fff6132-4bcc-4932-a630-358a21a7bef4', text:'劉素惠'},
          ],
          calculate_form:{
              pay_date: '',
              fee: 0,
              fee_bonus: 0,
              interest: 0,
              interest_bonus: 0,
              alloted: 0,
              alloted_bonus: 0,
              fee_cost: 0,
              ae_fee_cost: 0,
              interest_cost: 0,
              ae_interest_cost: 0,
              sell: 0,
              principal: 0,
              principal_number: '0',
              accumulated_provision: 0
          },
          form:{
              fee: '',
              interest: '',
              alloted: '',
              fee_cost: '',
              interest_cost: '',
              sell: '',
              principal_number: '',
              other: ''
          },

          fields:[
            { key: 'name', label: '銷售代表', sortable: true },
            { key: 'qualified', label: '合格開戶數', sortable: false },
            { key: 'excitation', label: '開戶激勵', sortable: false },
            { key: 'content', label: '說明', sortable: false },
            { key: 'commission', label: '本期可發放金額', sortable: false },
            { key: 'actions', label: '操作' }
          ],
          has_pdf: true,
          filter:{
              month: '2021-07',
              ae: 'all',
          }
        }
    },
    computed: {
        commission_calculate_subtitle(){
            return parseFloat(this.calculate_form.fee_bonus)
                +parseFloat(this.calculate_form.interest_bonus)
                +parseFloat(this.calculate_form.alloted_bonus)
                +parseFloat(this.calculate_form.ae_fee_cost)
                +parseFloat(this.calculate_form.ae_interest_cost)
                +parseFloat(this.calculate_form.sell_bonus)
                +parseFloat(this.calculate_form.principal)
        },
        commission_subtitle(){
            return parseFloat((this.form.fee)?this.form.fee*0.6:this.calculate_form.fee_bonus)
                +parseFloat((this.form.interest)?this.form.interest*0.6:this.calculate_form.interest_bonus)
                +parseFloat((this.form.alloted)?this.form.alloted*0.6:this.calculate_form.alloted_bonus)
                +parseFloat((this.form.fee_cost)?this.form.fee_cost*0.6:this.calculate_form.ae_fee_cost)
                +parseFloat((this.form.interest_cost)?this.form.interest_cost*0.6:this.calculate_form.ae_interest_cost)
                +parseFloat((this.form.sell)?this.form.sell*0.6:this.calculate_form.sell_bonus)
                +parseFloat((this.form.principal_number)?this.form.principal_number*450:this.calculate_form.principal)
        },
        subtitle(){
            return this.commission_subtitle*0.9+parseFloat((this.form.other)?this.form.other:0)
        }
    },
    watch: {
        uuid(){
            this.edit()
        },
        month(){
            this.edit()
        },
        form: {
            deep: true,
            handler: function(n,o){
                this.dirty=true
            }
        }
    },
    created() {
        this.edit()
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
        },
        store(){
            let _this = this
            let formdata = this.getFormData();
            this.crudStore(function(response){
                _this.index()
            }, formdata);
        },
        edit(){
            let _this = this
            this.crudEdit(this.uuid, function(response){
                _this.calculate_form = response.calculate
                _this.form = response.modify
                _this.dirty=false
                _this.$nextTick(() => _this.dirty = false)
            },{month: this.month})
        },
        update(){
            let _this = this
            let formdata = this.getFormData();
            formdata.append('month',this.month)
            this.crudUpdate(this.uuid, function(response){
                if(response.ok) _this.dirty = false
                _this.$bus.$emit('commission_comfirm::update')
            },formdata);
        },
        del(){
            let _this = this
            this.crudDestroy(this.form.id,function(response){
                _this.index()
            })
        },
        showConfirmPdf(){
            window.open('AeCommissionSummary/ShowPdf/'+this.uuid+'?month='+this.month)
        },
        showPaymentRequestFormPdf(){
            window.open('AeCommissionSummary/PaymentRequestForm/'+this.uuid+'?month='+this.month)
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