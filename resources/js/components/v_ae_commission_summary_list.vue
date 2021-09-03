<template>
    <div id="ae_commission_summary">
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
                <p>當月獎金發出完畢後，則不可再添加人員，因會影響團體獎金的金額。</p>
                <p>可對每一位AE各別發出獎金。當月最後一位的獎金發出時，會同時計算團體獎金的提撥。每月佣金結算後，畫面上才會顯示總表。</p>
                <p>佣金於每日凌晨計算當月未發出佣金。若發生當月資料缺漏，可用重新計算即刻重算佣金。</p>
            </div>
        </b-alert>

        <div class="m-4">
            <b-row class="filter text-white">
                <b-col cols="3" class="mb-3">
                    <label for="sending_status">獎金月份</label>
                    <b-form-select id="month" :options="month_options" v-model="filter.month" @change="index"></b-form-select>
                </b-col>
                <b-col cols="3" class="mb-3">
                    <label for="sending_status">AE</label>
                    <b-form-select id="ae_code" :options="ae_options" v-model="filter.ae" @change="index"></b-form-select>
                </b-col>
                <b-col cols="3" class="mb-3">
                </b-col>
                <b-col cols="3" class="mb-3">
                </b-col>
            </b-row>

            <hr />

            <div class="m-4" v-if="group_info">
                <b-table-simple bordered>
                    <b-thead>
                        <b-tr class="bg-secondary">
                            <b-th class="text-center">本月業績</b-th>
                            <b-th class="text-center">本月個人傭金總計</b-th>
                            <b-th class="text-center">本月保留數總計</b-th>
                        </b-tr>
                    </b-thead>
                    <b-tbody>
                        <b-tr>
                            <b-td class="text-white text-center"><v-money :value="group_info.application_fee_correction"></v-money></b-td>
                            <b-td class="text-white text-center"><v-money :value="group_info.bonus_application_correction"></v-money></b-td>
                            <b-td class="text-white text-center"><v-money :value="group_info.application_cost_correction"></v-money></b-td>
                        </b-tr>
                    </b-tbody>
                </b-table-simple>

                <br />
                
                <b-table-simple bordered>
                    <b-thead>
                        <b-tr class="bg-secondary">
                            <b-th class="text-center">團體獎金提撥</b-th>
                            <b-th class="text-center">合格開戶數</b-th>
                            <b-th class="text-center">本期提撥金額</b-th>
                            <b-th class="text-center">累計提撥金額</b-th>
                        </b-tr>
                    </b-thead>
                    <b-tbody>
                        <b-tr>
                            <b-th class="text-white text-center">開戶</b-th>
                            <b-td class="text-white text-center">{{group_info.transaction_number_correction}}</b-td>
                            <b-td class="text-white text-center"><v-money :value="group_info.transaction_number_correction*50"></v-money></b-td>
                            <b-td class="text-white text-center"><v-money :value="group_info.total_group_open"></v-money></b-td>
                        </b-tr>
                        <b-tr>
                            <b-th class="text-white text-center">佣金</b-th>
                            <b-td class="text-white text-center"></b-td>
                            <b-td class="text-white text-center"><v-money :value="group_info.ae_application_cost_correction"></v-money></b-td>
                            <b-td class="text-white text-center"><v-money :value="group_info.total_group_commission"></v-money></b-td>
                        </b-tr>
                    </b-tbody>
                </b-table-simple>
            </div>

            <b-row class="filter text-white">
                <b-col cols="8">
                    <b-button class="mb-3" variant="success" :disabled="group_info!=null || filter.month==''" v-b-modal.recalculate><i class="fas fa-calculator"></i> 重新計算當月佣金</b-button>
                    <b-button class="mb-3" variant="success" :disabled="group_info!=null || filter.month==''" v-b-modal.add><i class="fas fa-user-plus"></i> 添加員工</b-button>
                    <b-button class="mb-3" variant="success" :disabled="filter.month==''" @click="showPdf"><i class="far fa-file-pdf"></i> 下載PDF報表</b-button>
                    <b-button class="mb-3" variant="warning" :disabled="group_info!=null" v-b-modal.pay><i class="fas fa-money-check-alt"></i> 確認佣金</b-button>
                </b-col>
                <b-col cols="4">
                </b-col>
            </b-row>

            <b-progress
                max="60"
                height="5px"
                v-if="recalculateCountDown"
                :value="60-recalculateCountDown">
            </b-progress>
            <b-table
                sort-by="sending_time"
                :sort-desc="true"
                class="text-white"
                :items="items"
                :fields="fields">
                <template #cell(pay_date)="row">
                    <b-form-checkbox v-model="selected" v-if="!row.item.pay_date" :value="btoa(row.item.month+'@'+row.item.uuid+'@'+row.item.reservations+'@'+row.item.commission)">確認佣金</b-form-checkbox>
                    <span v-else>已發出 {{row.item.pay_date}}</span>
                </template>
                
                <template #cell(excitation)="row">
                    <v-money :value="row.item.excitation"></v-money>
                </template>
                <template #cell(commission)="row">
                    <v-money :value="row.item.commission"></v-money>
                </template>
                <template #cell(content)="row">
                    <span v-if="row.item.uuid==row.item.codes">{{row.item.content}}</span>
                    <table v-else>
                        <thead>
                            <tr>
                                <th>一級市場佣金</th>
                                <th>二級市場佣金</th>
                                <th>佣金小計</th>
                                <th>保留數</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><v-money :value="row.item.commission1"></v-money></td>
                                <td><v-money :value="row.item.commission2"></v-money></td>
                                <td><v-money :value="row.item.subtitle"></v-money></td>
                                <td><v-money :value="row.item.reservations"></v-money></td>
                            </tr>
                        </tbody>
                    </table>
                </template>
                <template #cell(actions)="row">
                    <b-button size="sm" class="mr-1" variant="danger" v-b-modal.del @click="target_item=row.item" v-if="row.item.codes==row.item.uuid" :disabled="!!row.item.pay_date">
                        <i class="fas fa-trash-alt"></i> 刪除
                    </b-button>
                    <b-button size="sm" class="mr-1" variant="success" v-b-toggle.commission_confirm v-if="row.item.codes!=row.item.uuid" @click="show(row.item)" :disabled="row.item.status=='success'">
                        <i class="fas fa-info-circle"></i> 確認表
                    </b-button>
                    <b-button size="sm" class="mr-1" variant="success" v-b-toggle.commission_detail v-if="row.item.codes!=row.item.uuid" @click="show(row.item)" :disabled="row.item.status=='success'">
                        <i class="fas fa-info-circle"></i> 佣金明細
                    </b-button>
                </template>
            </b-table>
        </div>

        <!-- add commission -->
        <b-modal id="add" title="添加員工業績" @ok="store">
            <b-alert :variant="server_msg.variant" :show="!!server_msg.msg">{{server_msg.msg}}</b-alert>
            <span>職員</span>
            <b-form-select v-model="form.staff" :options="staff_options"></b-form-select>
            <span>合格開戶數</span>
            <b-form-input type="number" class="text-right" v-model="form.num" @keyup="form.bonus=parseInt(form.num)*700" placeholder="請輸入合格開戶數"></b-form-input>
            <span>開戶激勵</span>
            <b-form-input type="number" class="text-right" v-model="form.bonus" placeholder="請輸入開戶激勵獎金"></b-form-input>
            <span>說明</span>
            <b-form-textarea v-model="form.content"></b-form-textarea>
        </b-modal>

        <!-- recalculate commission -->
        <b-modal id="recalculate" title="重新計算當月佣金" @ok="recalculate">
            你確定要計算本月所有業務代表AE的佣金嗎?
        </b-modal>

        <!-- pay commission -->
        <b-modal id="pay" title="確認佣金" @ok="pay">
            <span v-if="selected.length==0" class="text-danger">請先勾選人員!</span>
            <span v-else>你確認勾選人員的佣金金額正確嗎?</span>
        </b-modal>

        <!-- ae commission confirm -->
        <b-sidebar id="commission_confirm" :title="target_item.name + ' AE確認表'" lazy shadodw right>
            <ae-commission-confirm :uuid="target_item.uuid" :month="target_item.month" ></ae-commission-confirm>
        </b-sidebar>
        <!-- ae commission detail -->
        <b-sidebar id="commission_detail" :title="target_item.name + ' AE佣金明細'" lazy shadodw right>
            <ae-commission-detail :uuid="target_item.uuid" :month="target_item.month" ></ae-commission-detail>
        </b-sidebar>

        <!-- del confirm -->
        <b-modal id="del" title="刪除發送任務" @ok="del">
            <p class="my-4">您確定要刪除 {{target_item.name}} {{target_item.month}} 的獎金記錄嗎?</p>
        </b-modal>
    </div>
</template>

<script>
import axios from "../mixins/mixin_post"
export default {
    mixins:[axios],
    name:'ae_commission_summary',
    data(){
        return {
          // alert
          dismissCountDown: 0,
          // recalculate
          recalculateCountDown: 0,
          tabIndex: 0,
          selected:[],
          month_options:[],
          ae_options:[
              {value:'all', text:'全部'},
          ],
          staff_options:[
              {value:'all', text:'全部'},
          ],
          form:{
              staff:'',
              num:0,
              bonus:0,
              content:'',
          },

          fields:[
            { key: 'pay_date', label: '狀態', sortable: true },
            { key: 'name', label: '銷售代表', sortable: true },
            { key: 'qualified', label: '合格開戶數', sortable: false },
            { key: 'excitation', label: '開戶激勵', sortable: false },
            { key: 'content', label: '說明', sortable: false },
            { key: 'commission', label: '本期可發放金額', sortable: false },
            { key: 'actions', label: '操作' }
          ],
          items:[
            {
                id:1,
                pay_date: '2021-08-20',
                name: '梧桐花開',
                type: '銷售代表',
                uuid: 'e550be72-fcb1-4779-980f-f255ff6eb041',
                codes: 'AEWHC1,WHC01,AEWHC',
                month: '2021-07-01',
                qualified: 5,
                excitation: 2250,
                commission1: 11595.39,
                commission2: 2075.87,
                subtitle: 18921,
                reservations: 1892,
                content: '',
                commission: 17029,
                created_at:'2020-09-01 23:01:10',
                updated_at:'2020-09-01 23:02:13',
            },
            {
                id:2,
                pay_date: '',
                name: '劉素惠',
                type: '銷售代表',
                uuid: '7fff6132-4bcc-4932-a630-358a21a7bef4',
                codes: 'AELSH,LSH01',
                month: '2021-07-01',
                qualified: 16,
                excitation: 7200,
                commission1: 201.42,
                commission2: 30,
                subtitle: 7431,
                reservations: 743,
                content: '',
                commission: 6688,
                created_at:'2020-09-01 23:01:10',
                updated_at:'2020-09-01 23:02:13',
            },
            {
                id:3,
                pay_date: '',
                name: '張冬梅',
                type: '持牌員工',
                month: '2021-07-01',
                qualified: 2,
                excitation: 1400,
                commission1: 201.42,
                commission2: 30,
                subtitle: 7431,
                reservations: 743,
                content: '客戶帳號: 20000213/20000513',
                commission: 1400,
                created_at:'2020-09-01 23:01:10',
                updated_at:'2020-09-01 23:02:13',
            },
            {
                id:4,
                pay_date: '',
                name: '范焜華',
                type: '非持牌員工',
                month: '2021-07-01',
                qualified: 1,
                excitation: 700,
                commission1: 201.42,
                commission2: 30,
                subtitle: 7431,
                reservations: 743,
                content: '客戶帳號: 20000313',
                commission: 700,
                created_at:'2020-09-01 23:01:10',
                updated_at:'2020-09-01 23:02:13',
            }
          ],
          group_info:null,
          filter:{
              month: '2021-07',
              ae: 'all',
          },
          target_item:{},
          server_msg:{
              variant:'',
              msg:'',
          },
        }
    },
    created() {
        this.$bus.$on('commission_comfirm::update',this.index)
        let _this=this
        // 由2021-07開始
        for(let y=2021;y<=(new Date()).getFullYear();y++){
            for(let m=((y==2021)?7:1);m<=((y==(new Date()).getFullYear())?(new Date()).getMonth()+1:12);m++){
                let d = y+'-'+('00'+m).substring(m.toString().length,m.toString().length+2)
                this.month_options.push({
                    value:d, text:d
                })
            }
        }
        // 選取倒數第二個項目為預設顯示
        if(this.month_options){
            if(this.month_options.length>1) this.filter.month = this.month_options[this.month_options.length-2]
        }
        this.myGet(function(response){
            _this.ae_options = response
            _this.ae_options.unshift({value:'all', text:'全部'})
        },'',this.url('/list/ae'))
        this.myGet(function(response){
            _this.staff_options = response
            _this.staff_options.unshift({value:'all', text:'全部'})
        },'',this.url('/list/staff'))
        this.index()
    },
    beforeDestroy(){
        this.$bus.$off("commission_comfirm::update");
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
        get_ae_list(){

        },
        get_staff_list(){

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
            this.clear_server_msg()
            this.crudIndex(function(response){
                _this.items = response['data']
                _this.group_info = response['group']
            },'', this.filter);
        },
        store(){
            let _this = this
            let formdata = this.getFormData();
            formdata.append('month',this.filter.month)
            this.crudStore(function(response){
                if(response.ok) _this.index()
                else{
                    _this.server_msg={variant:'danger',msg:response.msg}
                    _this.$bvModal.show('add')
                }
            }, formdata);
        },
        show(item){
            this.target_item = item
        },
        update(){
            let _this = this
            let formdata = this.getFormData();
            this.crudUpdate(this.form.id, function(response){
                if(response.ok) _this.index()
                else _this.server_msg={variant:'danger',msg:response.msg}
            }, formdata);
        },
        del(){
            let _this = this
            this.crudDestroy(this.target_item.id,function(response){
                if(response.ok) _this.index()
                else _this.server_msg={variant:'danger',msg:response.msg}
            })
        },
        makePdf(){

        },
        showPdf(){
            window.open('AeCommissionSummary/ShowSummaryPdf/'+this.filter.month+'-01')
        },
        recalculate(){
            let _this = this
            this.myPost(function(response){
                _this.recalculateCountDown=60
                _this.countdown()
            },{month:this.filter.month},this.url('recalculate'))
        },
        pay(){
            if(this.selected.length>0){
                let _this = this
                let formdata = this.getFormData({selected:this.selected})
                this.myPost(function(response){
                    if(response.ok) _this.index()
                    else _this.server_msg={variant:'danger',msg:response.msg}
                },formdata,this.url('pay'))
            }
        },
        countdown(){
            let _this=this
            setTimeout(function(){
                if(--_this.recalculateCountDown>0) _this.countdown()
                else _this.index()
            },1000)
        },
        clear_server_msg(){
            this.server_msg={variant:'',msg:''}
        },
        btoa($v){
            return btoa($v)
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
#commission_confirm,
#commission_detail{
    width:80%;
}
</style>