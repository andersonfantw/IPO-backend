<template>
    <b-container class="m-4" fluid>
        <h1 class="text-warning text-center">年度通知書發送清單</h1>
        <hr />
        <b-row class="filter text-white">
            <b-col cols="4" class="mb-3">
                <label for="sending_status">發送狀態</label>
                <b-form-select id="sending_status" :options="status_options"></b-form-select>
            </b-col>
            <b-col cols="4">
                <label for="account_no">帳戶號碼</label>
                <b-input id="account_no"></b-input>
            </b-col>
            <b-col cols="4">
                <label for="client_name">客戶姓名</label>
                <b-input id="client_name"></b-input>
            </b-col>
        </b-row>
        <hr />

        <b-row no-gutters>
            <b-col cols="3">
                <b-button-group class="mb-3">
                    <span id="send" tabindex="0">
                        <b-button size="sm" variant="success" :disabled="!(all_selected || indeterminate)" @click="send">
                            <i class="far fa-envelope"></i> &nbsp;發&nbsp;&nbsp;&nbsp;&nbsp;送
                        </b-button>
                    </span>
                        <span id="send_test_mail" tabindex="0">
                        <b-button size="sm" :disabled="!(all_selected || indeterminate)" @click="send_test_mail">
                            <i class="fas fa-envelope-square"></i> &nbsp;發送測試
                        </b-button>
                    </span>
                    <span id="del" tabindex="0">
                        <b-button v-b-modal.del size="sm" variant="danger" :disabled="!(all_selected || indeterminate)">
                            <i class="fas fa-trash"></i> &nbsp;刪&nbsp;&nbsp;&nbsp;&nbsp;除
                        </b-button>
                    </span>
                </b-button-group>
                <b-tooltip target="send" placement="bottom">
                    為選取的人員重新寄送報告
                </b-tooltip>
                <b-tooltip target="send_test_mail" placement="bottom">
                    將選取的人員的報告寄送到測試信箱。測試信箱須由工程師設定
                </b-tooltip>
                <b-tooltip target="del" placement="bottom">
                    只可刪除未發送過信件的人員
                </b-tooltip>
            </b-col>
            <b-col cols="2">
                <b-button-group class="mb-3">
                    <span id="create_pdf" tabindex="0">
                    <b-button size="sm" variant="success" :disabled="button_status.create_pdf.status=='done'" @click="create_pdf">
                        <i class="far fa-file-pdf" v-if="['','done'].indexOf(button_status.create_pdf.status)>=0"></i>
                        <b-spinner small label="Loading..."  v-else></b-spinner>
                        &nbsp;製作年報 <span v-if="button_status.create_pdf.progress">{{button_status.create_pdf.progress}}</span>
                    </b-button>
                    </span>
                    <span id="send_all" tabindex="0">
                    <b-button size="sm" variant="success" :disabled="button_status.create_pdf.status!='done'" @click="send_all">
                        <i class="far fa-envelope" v-if="['','done'].indexOf(button_status.send_all.status)>=0"></i>
                        <b-spinner small label="Loading..."  v-else></b-spinner>
                        &nbsp;全部發送
                    </b-button>
                    </span>
                </b-button-group>
                <b-tooltip target="create_pdf" placement="bottom">
                    為選取名單內的每一個人製作年報
                </b-tooltip>
                <b-tooltip target="send_all" placement="bottom">
                    為已產生年報的人寄送報告。完成製作年報後，才可寄送報告
                </b-tooltip>
            </b-col>
            <b-col cols="2">
                <p class="text-white">共 {{count}} 人、已選取 {{list.length}} 人</p>
            </b-col>
            <b-col cols="5">
                <b-input-group size="sm">
                    <b-input size="sm" v-model="search.account_no"></b-input>
                    <b-input size="sm" disabled></b-input>
                    <b-input-group-append>
                        <b-button size="sm" class="w-100" @click="add_people" variant="primary">
                            <i class="fas fa-user-plus" variant="secondary"></i> &nbsp;新增人員
                        </b-button>
                    </b-input-group-append>
                </b-input-group>
            </b-col>
        </b-row>

        <b-table class="text-white" :items="items" :fields="fields">
            <template #head(select)>
                <b-form-checkbox name="selected_all" v-model="all_selected" :indeterminate="indeterminate" @change="select_all"></b-form-checkbox>
            </template>
            <template #cell(select)="row">
                <b-form-checkbox name="select" v-model="list" :value="row.item.account_no"></b-form-checkbox>
            </template>
            <template #cell(actions)="row">
                <b-button size="sm" class="mr-1" @click="show_html(row.item)">
                    查看報告書
                </b-button>
                <b-button size="sm" class="mr-1" @click="show_pdf(row.item)" :disabled="row.item.make_report_time==''">
                    查看寄出的報告書
                </b-button>
            </template>
        </b-table>

        <b-modal id="del" title="BootstrapVue" @ok="del">
            <p class="my-4">您確定要刪除{{selected_list_client_name}}嗎?</p>
        </b-modal>
    </b-container>
</template>

<script>
import axios from "../mixins/mixin_post"
import validator from "../mixins/mixin_validators";
export default {
    mixins:[axios,validator],
    props:['ipo_activity_period_id'],
    data() {
      return {
          all_selected: false,
          indeterminate: false,
          status_options:[
              {value:'all', text:'全部'},
              {value:'pending', text:'排程中'},
              {value:'success', text:'發送成功'},
              {value:'fail', text:'發送失敗'}
          ],
          fields:[
              { key: 'select', label: '' },
              { key: 'name', label: '客戶姓名', sortable: true },
              { key: 'email', label: 'Email', sortable: true },
              { key: 'status', label: '發送狀態', sortable: true },
              { key: 'make_report_time', label: '文件製作時間', sortable: true },
              { key: 'sending_time', label: '寄出時間', sortable: true },
              { key: 'actions', label: '操作' }
          ],
          items:[
              { id:'1', account_no:'12345678',name:'FAN KUN HUA 1', email:'andersonfantw1@gmail.com', status:'pending', make_report_time:'2021-06-02 09:26:15', sending_time:'' },
              { id:'2', account_no:'12345670',name:'FAN KUN HUA 2', email:'andersonfantw2@gmail.com', status:'pending', make_report_time:'', sending_time:'' },
              { id:'3', account_no:'12345671',name:'FAN KUN HUA 3', email:'andersonfantw3@gmail.com', status:'pending', make_report_time:'', sending_time:'' },
          ],
          search:{
              account_no: ''
          },
          // button status: '' -> process -> done
          button_status:{
              create_pdf: {status:'', progress: ''},
              send_all: {status:'', progress: ''}
          },
          list:[]
      }
    },
    watch: {
        list(n,o) {
            if (n.length === 0) {
                this.indeterminate = false
                this.all_selected = false
            } else if (n.length === this.items.length) {
                this.indeterminate = false
                this.all_selected = true
            } else {
                this.indeterminate = true
                this.all_selected = false
            }
        }
    },
    computed:{
        count(){
            return this.items.length
        },
        selected_list_client_name(){
            let n = (this.list.length>3)?3:this.list.length
            let s=''
            for(let i=0;i<n;i++){
                let o = this.getObjectByValue(this.items,'account_no',this.list[i])
                s += o[0].name + ','
            }
            if(n>3) s += '...等'+n+'人'
            else s += '共'+n+'人'
            return s
        }
    },
    methods: {
        select_all(checked){
            if(checked){
                let _this = this
                this.items.forEach(function(i){
                    _this.list.push(i.account_no)
                })
            }else{
                this.list = []
            }
        },
        add_people(){

        },
        send(){

        },
        create_pdf(){
            let o = {
                '': {status: 'process', progress: '50%'},
                process: {status: 'done', progress: ''}
            }
            if(this.button_status.create_pdf.status!='done') this.button_status.create_pdf = o[this.button_status.create_pdf.status]
        },
        send_all(){
            let o = {
                '': {status: 'process', progress: '50%'},
                process: {status: 'done', progress: ''}
            }
            if(this.button_status.send_all.status!='done') this.button_status.send_all = o[this.button_status.send_all.status]
        },
        send_test_mail() {

        },
        del() {
        },

        show_html(item) {
            window.open('/AccountReportSendingSummary/'+this.ipo_activity_period_id+'/ShowHtml/'+item.account_no)
        },
        show_pdf(item) {
            window.open('/AccountReportSendingSummary/'+this.ipo_activity_period_id+'/ShowPdf/'+item.account_no)
        },

        getObjectByValue(array, key, value){
            return array.filter(function (o) {
                return o[key] === value;
            });
        }
    }
}
</script>

<style>
#add_person{
    margin-right: 0px;
}

#add_person input{
    border-radius: 0.2rem 0 0 0.2rem;
}
</style>