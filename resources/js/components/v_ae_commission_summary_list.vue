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
                <p>資金利率設定後，會有營業部及財務部門的確認後，方可使用</p>
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

            <b-row class="filter text-white">
                <b-col cols="8">
                    <b-button class="mb-3" variant="success" v-b-modal.add :disabled="filter.month==''"><i class="fas fa-user-plus"></i> 添加員工</b-button>
                    <b-button class="mb-3" variant="success" v-if="has_pdf" :disabled="filter.month==''"><i class="far fa-eye"></i> 檢視PDF報表</b-button>
                    <b-button class="mb-3" variant="success" v-else :disabled="filter.month==''"><i class="fas fa-file-pdf"></i> 製作本月份PDF報表</b-button>
                    <b-button class="mb-3" variant="success" v-if="has_pdf" :disabled="filter.month==''"><i class="fas fa-file-download"></i> 下載佣金總表</b-button>
                </b-col>
                <b-col cols="4">
                </b-col>
            </b-row>

            <b-table
                sort-by="sending_time"
                :sort-desc="true"
                class="text-white"
                :items="items"
                :fields="fields">
                <template #head(route)>
                    <b-form-select id="sending_status" :options="route_options" v-model="filter.route" @change="index"></b-form-select>
                </template>
                <template #head(status)>
                    <b-form-select id="sending_status" :options="status_options" v-model="filter.status" @change="index"></b-form-select>
                </template>

                <template #cell(content)="row">
                    <span v-if="row.item.content!=''">{{ row.item.content }}</span>
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
                                <td>{{ row.item.commission1 }}</td>
                                <td>{{ row.item.commission2 }}</td>
                                <td>{{ row.item.subtitle }}</td>
                                <td>{{ row.item.reservations }}</td>
                            </tr>
                        </tbody>
                    </table>
                </template>
                <template #cell(status)="row">
                    <div v-if="row.item.status=='success'">成功 {{row.item.sending_time}}</div>
                    <div v-else-if="row.item.status=='failure'" class="text-danger">失敗 {{row.item.sending_time}}</div>  
                    <div v-else-if="row.item.status=='pending'">排程中 {{row.item.queue_time}}</div>  
                </template>
                <template #cell(actions)="row">
                    <b-button size="sm" class="mr-1" variant="success" v-b-toggle.detail v-if="row.item.content==''" @click="show(row.item)" :disabled="row.item.status=='success'">
                        <i class="fas fa-info-circle"></i> 詳細
                    </b-button>
                    <b-button size="sm" class="mr-1" variant="danger" v-b-modal.del @click="form.id=row.item.id" v-if="row.item.content!=''">
                        <i class="fas fa-trash-alt"></i> 刪除
                    </b-button>
                </template>
            </b-table>
        </div>

        <!-- add commission -->
        <b-modal id="add" title="添加員工業績" @ok="store">
            <span>職員</span>
            <find-a-staff id="staff" v-model="form.user_id" showbutton="false"></find-a-staff>
            <span>合格開戶數</span>
            <b-form-input type="number" v-model="form.channel" placeholder="請輸入合格開戶數"></b-form-input>
            <span>開戶激勵</span>
            <b-form-input type="number" v-model="form.channel" placeholder="請輸入開戶激勵獎金"></b-form-input>
            <span>說明</span>
            <b-form-textarea></b-form-textarea>
        </b-modal>

        <!-- ae commission confirm -->
        <b-sidebar id="detail" title="AE確認表" shadodw>
            <b-button size="sm" variant="success" class="m-2 float-right"><i class="fas fa-file-download"></i> 下載AE確認表</b-button>
            <b-button size="sm" variant="success" class="m-2 float-right"><i class="far fa-eye"></i> 檢視PDF報表</b-button>
            <b-embed type="iframe" aspect="1by1" scrolling="no" src="AeCommissionSummary/detail/7fff6132-4bcc-4932-a630-358a21a7bef4"></b-embed>
        </b-sidebar>

        <!-- del confirm -->
        <b-modal id="del" title="刪除發送任務" @ok="del">
            <p class="my-4">您確定要刪除尚未送出 序號為{{form.id}} 的記錄嗎?</p>
        </b-modal>
    </div>
</template>

<script>
import axios from "../mixins/mixin_post"
import validator from "../mixins/mixin_validators";
export default {
    mixins:[axios,validator],
    name:'ae_commission_summary',
    data(){
        return {
          // alert
          dismissCountDown: 0,
          tabIndex: 0,
          month_options:[],
          ae_options:[
              {value:'all', text:'全部'},
              {value:'e550be72-fcb1-4779-980f-f255ff6eb041', text:'梧桐花開'},
              {value:'7fff6132-4bcc-4932-a630-358a21a7bef4', text:'劉素惠'},
          ],
          form:{
              month:'2021-07',
              ae:'all',
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
          items:[
            {
                id:1,
                name: '梧桐花開',
                type: '銷售代表',
                month: '2021-08',
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
                name: '劉素惠',
                type: '銷售代表',
                month: '2021-08',
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
                name: '張冬梅',
                type: '持牌員工',
                month: '2021-08',
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
                name: '范焜華',
                type: '非持牌員工',
                month: '2021-08',
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
          filter:{
              month: '2021-07',
              ae: 'all',
          },
          target_item:{}
        }
    },
    created() {
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
        this.myGet(function(response){
            _this.ae_options = response
            _this.ae_options.unshift({value:'all', text:'全部'})
        },'',this.url('/ae_list'))
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
                _this.items = response
            },'/'+this.$options.name, this.filter);
        },
        store(){
            let _this = this
            let formdata = this.getFormData();
            this.crudStore(function(response){
                _this.index()
            }, formdata);
        },
        show(item){
            this.target_item = item
        },
        update(){
            let formdata = this.getFormData();
            this.crudUpdate(this.form.id, function(response){

            }, formdata);
        },
        del(){
            let _this = this
            this.crudDestroy(this.form.id,function(response){
                _this.index()
            })
        },
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
#detail{
    width: 70%;
}
#detail .embed-responsive{
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
}
</style>