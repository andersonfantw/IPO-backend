<template>
    <b-container class="p-4" fluid>
        <b-overlay variant="dark" rounded="sm" no-center>
            <template #overlay>
                <div class="d-table m-auto text-center mt-5">
                    <span class="spinner-border my-5"></span>
                    <p class="text-white display-4 ml-3">執行中，請稍待...</p>
                </div>
            </template>
        <b-alert :show="alert.message!==''" :variant="alert.variant" dismissible>{{alert.message}}</b-alert>
        <h1 class="text-warning text-center">年度通知書發送清單</h1>
        <hr />
        <b-row class="filter text-white">
            <b-col cols="3" class="mb-3">
                <label for="sending_status">文件狀態</label>
                <b-form-select id="sending_status" :options="status_options" v-model="filter.make_report_status" @change="index"></b-form-select>
            </b-col>
            <b-col cols="3" class="mb-3">
                <label for="sending_status">發送狀態</label>
                <b-form-select id="sending_status" :options="status_options" v-model="filter.sending_status" @change="index"></b-form-select>
            </b-col>
            <b-col cols="3">
                <label for="client_acc_id">帳戶號碼</label>
                <b-input id="client_acc_id" v-model="filter.client_acc_id" @keyup.enter="index" placeholder="按[ENTER]查詢"></b-input>
            </b-col>
            <b-col cols="3">
                <label for="client_name">客戶姓名</label>
                <b-input id="client_name" v-model="filter.name" @keyup.enter="index" placeholder="按[ENTER]查詢"></b-input>
            </b-col>
        </b-row>

        <b-pagination-nav
            v-model="pagination.current_page"
            :number-of-pages="pagination.last_page"
            base-url="#"
            use-router align="center"
        ></b-pagination-nav>
        <hr />

        <b-row no-gutters>
            <b-col cols="3">
                <b-button-group class="mb-3">
                    <span id="create_selected_pdf" tabindex="0">
                        <b-button size="sm" variant="primary" :disabled="!(all_selected || indeterminate) || busy" @click="create_selected_pdf">
                            <i class="fas fa-file-pdf"></i> &nbsp;製作文件
                        </b-button>
                    </span>
                    <span id="send_test_mail" tabindex="0">
                        <b-button size="sm" :disabled="!(all_selected || indeterminate) || list.length>5 || busy" @click="send_test_mail">
                            <i class="fas fa-envelope-square"></i> &nbsp;發送測試
                        </b-button>
                    </span>
                    <span id="send" tabindex="0">
                        <b-button size="sm" variant="success" :disabled="!(all_selected || indeterminate) || busy" @click="send">
                            <i class="far fa-envelope"></i> &nbsp;發&nbsp;&nbsp;&nbsp;&nbsp;送
                        </b-button>
                    </span>
                    <span id="del" tabindex="0">
                        <b-button v-b-modal.del size="sm" variant="danger" :disabled="!(all_selected || indeterminate) || busy">
                            <i class="fas fa-trash"></i> &nbsp;刪&nbsp;&nbsp;&nbsp;&nbsp;除
                        </b-button>
                    </span>
                </b-button-group>
                <b-tooltip target="create_selected_pdf" placement="bottom">
                    製作選取的人員的報告。如果已經製作過報告，則重新製作。
                </b-tooltip>
                <b-tooltip target="send_test_mail" placement="bottom">
                    將選取的人員的報告寄送到測試信箱，發送前必須先完成文件製作。測試信箱須由工程師設定。一次寄送最多5位客戶的測試信。
                </b-tooltip>
                <b-tooltip target="send" placement="bottom">
                    為選取的人員重新寄送報告，發送前必須先完成文件製作。
                </b-tooltip>
                <b-tooltip target="del" placement="bottom">
                    只可刪除未發送過信件的人員
                </b-tooltip>
            </b-col>
            <b-col cols="2">
                <b-button-group class="mb-3">
                    <span id="create_pdf" tabindex="0">
                    <b-button size="sm" :variant="(buttons.pdf.queue || (buttons.pdf.success+buttons.pdf.fail)===buttons.total)?'danger':'primary'"  @click="create_pdf"
                        @mouseover="buttons2.hover_make_report_pdf=true"
                        @mouseout="buttons2.hover_make_report_pdf=false"
                        :disabled="buttons.email.queue>0 || this.buttons.command>0">
                        <i class="far fa-stop-circle" v-if="buttons.pdf.queue>0"></i>
                        <i class="far fa-file-pdf" v-else></i>
                        &nbsp;
                        <span v-if="(buttons.pdf.success+buttons.pdf.fail)===buttons.total">清除製作記錄</span>
                        <span v-else-if="buttons.pdf.queue>0">停止製作</span>
                        <span v-else>製作文件</span>
                    </b-button>
                    </span>
                    <span id="send_all" tabindex="0">
                    <b-button size="sm" :variant="(buttons.email.queue || (buttons.email.success+buttons.email.fail)===buttons.total)?'danger':'primary'" @click="send_all"
                        @mouseover="buttons2.hover_send_email_button=true"
                        @mouseout="buttons2.hover_send_email_button=false"
                        :disabled="buttons.pdf.queue>0 || this.buttons.command>0">
                        <i class="far fa-stop-circle" v-if="buttons.email.queue>0"></i>
                        <i class="far fa-envelope" v-else></i>
                        &nbsp;
                        <span v-if="(buttons.email.success+buttons.email.fail)===buttons.total">清除發送記錄</span>
                        <span v-else-if="buttons.email.queue>0">停止發送</span>
                        <span v-else>全部發送</span>
                    </b-button>
                    </span>
                </b-button-group>
                <b-tooltip target="create_pdf" placement="bottom">
                    為名單內的每一個人製作年報
                </b-tooltip>
                <b-tooltip target="send_all" placement="bottom">
                    為已產生年報的人寄送報告。完成製作年報後，才可寄送報告
                </b-tooltip>
            </b-col>
            <b-col cols="3">
                <small class="text-white" style="margin-top: -3px;position: absolute;padding: 0 15px;">{{info}}</small>
            </b-col>
            <b-col cols="4">
                <find-a-client></find-a-client>
            </b-col>
        </b-row>

        <b-progress
            :max="buttons.pdf.pending+buttons.pdf.fail+buttons.pdf.success"
            height="5px"
            v-if="buttons.pdf.pending>0 && buttons.pdf.queue>0 && this.buttons.command==0"
            :value="buttons.pdf.success">
        </b-progress>
        <b-progress
            :max="buttons.email.pending+buttons.email.fail+buttons.email.success"
            height="5px"
            v-if="buttons.email.pending>0 && buttons.email.queue>0 && this.buttons.command==0"
            :value="buttons.email.success">
        </b-progress>
        <b-overlay variant="dark" :show="buttons.command>0" rounded="sm">
        <b-table class="text-white" :items="items" :fields="fields" @row-clicked="onRowClicked">
            <template #head(select)>
                <b-form-checkbox name="selected_all" v-model="all_selected" :indeterminate="indeterminate" @change="select_all"></b-form-checkbox>
            </template>
            <template #cell(select)="row">
                <b-form-checkbox name="select" v-model="list" :value="row.item.client_acc_id"></b-form-checkbox>
            </template>
            <template #cell(make_report_status)="row">
                <div v-if="row.item.make_report_status==='pending'">排程中 {{row.item.report_queue_time}}</div>
                <div v-else-if="row.item.make_report_status==='success'">成功 {{row.item.make_report_time}}</div>
                <div v-else-if="row.item.make_report_status==='fail'" class="text-danger">失敗 {{row.item.make_report_time}}<br />{{row.item.remark}}</div>
                <div v-else>{{row.item.make_report_status}}</div>
            </template>
            <template #cell(sending_status)="row">
                <div v-if="row.item.sending_status==='pending'">排程中 {{row.item.sending_queue_time}}</div>
                <div v-else-if="row.item.sending_status==='success'">成功 {{row.item.sending_time}}</div>
                <div v-else-if="row.item.sending_status==='fail'" class="text-danger">失敗 {{row.item.sending_time}}<br />{{row.item.remark}}</div>
                <div v-else>{{row.item.sending_status}}</div>
            </template>
            <template #cell(actions)="row">
                <b-button size="sm" class="mr-1" @click="show_html(row.item)">
                    查看報告書
                </b-button>
                <b-button size="sm" class="mr-1" @click="download_pdf(row.item)" v-if="row.item.make_report_status=='fail'">
                    下載PDF
                </b-button>
                <b-button size="sm" class="mr-1" @click="show_pdf(row.item)" v-else :disabled="row.item.make_report_status!='success'">
                    查看寄出的PDF
                </b-button>
            </template>
        </b-table>
        </b-overlay>

        <b-modal id="del" title="BootstrapVue" @ok="del">
            <p class="my-4">您確定要刪除{{selected_list_client_name}}嗎?</p>
        </b-modal>
        </b-overlay>
    </b-container>
</template>

<script>
import axios from "../mixins/mixin_post"
import validator from "../mixins/mixin_validators";
export default {
    mixins:[axios,validator],
    name: 'AccountReport',
    props:['ipo_activity_period_id'],
    data() {
      return {
          all_selected: false,
          indeterminate: false,
          interval_id: 0,
          status_options:[
              {value:'all', text:'全部'},
              {value:'null', text:'無'},
              {value:'pending', text:'排程中 pending'},
              {value:'success', text:'成功 success'},
              {value:'fail', text:'失敗 fail'}
          ],
          fields:[
              { key: 'select', label: '' },
              { key: 'client_info.client_acc_id', label: '帳號', sortable: true },
              { key: 'client_info.name', label: '客戶姓名', sortable: true },
              { key: 'client_info.email', label: 'Email', sortable: true },
              { key: 'make_report_status', label: '文件狀態', sortable: true },
              { key: 'sending_status', label: '發送狀態', sortable: true },
              { key: 'actions', label: '操作' }
          ],
          pagination:{
              current_page: 1,
              last_page: 1,
              path: ''
          },
          find_client_list:[],
          search:{
              client_acc_id: ''
          },
          items:[
              { id:'1', client_acc_id:'12345678', client_info:{name:'FAN KUN HUA 1', email:'andersonfantw1@gmail.com'}, status:'pending', make_report_time:'2021-06-02 09:26:15', sending_time:'' },
              { id:'2', client_acc_id:'12345670', client_info:{name:'FAN KUN HUA 2', email:'andersonfantw2@gmail.com'}, status:'pending', make_report_time:'', sending_time:'' },
              { id:'3', client_acc_id:'12345671', client_info:{name:'FAN KUN HUA 3', email:'andersonfantw3@gmail.com'}, status:'pending', make_report_time:'', sending_time:'' },
          ],
          filter:{
              make_report_status: 'all',
              sending_status: 'all',
              client_acc_id: '',
              name: ''
          },
          // button status: '' -> process -> done
          buttons: {
              total: 0,
              pdf: { null:0, pending:0, success:0, fail: 0, queue:0, command:0 },
              email: { null:0, pending:0, success:0, fail: 0, queue:0, command:0 },
          },
          buttons2:{
              hover_make_report_pdf:false,
              hover_send_email_button:false,
          },
          // button_status:{
          //     create_pdf: {status:'', progress: ''},
          //     send_all: {status:'', progress: ''}
          // },
          list:[]
      }
    },
    created(){
        this.index()
        this.$bus.$on('find_a_client::add',(o)=>this.add_to_list(o))
    },
    beforeDestroy(){
        this.$bus.$off("find_a_client::add");
    },
    watch: {
        list(n,o) {
            if (n.length === 0) {
                this.indeterminate = false
                this.all_selected = false
            } else if (n.length === this.items.length) {
                this.all_selected = true
            } else {
                this.indeterminate = true
            }
        },
        'pagination.current_page': function(n){
            this.index()
        },
        'search.client_acc_id': function(n){
            let arr = this.find_client_list.filter(function(i){
                return i.client_acc_id==n
            })
            if(arr.length) this.search.client_name = arr[0].name
            else this.search.client_name = ''
        }
    },
    computed:{
        busy(){
            return (this.buttons.pdf.queue>0 || this.buttons.email.queue>0 || this.buttons.command>0)
        },
        info(){
            let s = ''
            if(this.filter.make_report_status!='all') s += '，文件狀態為'+this.filter.make_report_status+'的共'+this.buttons.pdf[this.filter.make_report_status] + '人'
            if(this.filter.sending_status!='all') s += '，'+((this.filter.make_report_status!='all')?'且':'')+'發送狀態為'+this.filter.sending_status+'的共'+this.buttons.email[this.filter.sending_status] +'人'
            if(this.buttons.command>0 && this.buttons.pdf.queue>0) return '添加製作文件任務，剩下'+this.buttons.pdf.null+'個任務...'
            else if(this.buttons.command>0 && this.buttons.email.queue>0) return '添加發送任務，剩下'+this.buttons.email.null+'個任務...'
            else if(this.buttons.pdf.queue>0) return '製作文件執行中 '+(this.buttons.pdf.success+this.buttons.pdf.fail)+' / '+(this.buttons.pdf.pending+this.buttons.pdf.success+this.buttons.pdf.fail)+' 共'+this.buttons.total
            else if(this.buttons.email.queue>0) return '郵件發送中 '+(this.buttons.email.success+this.buttons.email.fail)+' / '+(this.buttons.email.pending+this.buttons.email.success+this.buttons.email.fail)+' 共'+this.buttons.total
            else if(this.buttons2.hover_make_report_pdf) return '製作文件未處理'+ this.buttons.pdf.null+'、排程中'+this.buttons.pdf.pending +'、成功'+this.buttons.pdf.success+ '、失敗'+this.buttons.pdf.fail
            else if(this.buttons2.hover_send_email_button) return '郵件發送未處理'+ this.buttons.email.null+'、排程中'+this.buttons.email.pending +'、成功'+this.buttons.email.success+ '、失敗'+this.buttons.email.fail
            else return '共 '+ this.buttons.total + ' 人、已選取 ' + this.list.length + ' 人'+s;
        },
        selected_list_client_name(){
            let n = (this.list.length>3)?3:this.list.length
            let s=''
            for(let i=0;i<n;i++){
                let o = this.getObjectByValue(this.items,'client_acc_id',this.list[i])
                if(o.length) s += o[0]['client_info']['name'] + ','
            }
            if(n>3) s += '...等'+this.list.length+'人'
            else s += '共'+this.list.length+'人'
            return s
        }
    },
    methods: {
        select_all(checked){
            if(checked){
                let _this = this
                this.items.forEach(function(i){
                    _this.list.push(i.client_acc_id)
                })
            }else{
                this.list = []
            }
        },

        // reflash list
        reload_list(){
            let _this = this
            if(this.interval_id===0) {
                this.interval_id = setInterval(function () {
                    _this.index()
                }, 5000)
            }
        },
        stop_reload(){
            clearInterval(this.interval_id)
            this.interval_id = 0
        },

        // pagination
        linkGen(pageNum) {
            return pageNum === 1 ? '?' : `?page=${pageNum}`
        },
        index(){
            let _this = this
            this.crudIndex(function(response){
                _this.items = response.data
                _this.buttons = response.buttons
                if(_this.buttons.pdf.queue>0 || _this.buttons.email.queue>0) _this.reload_list()

                _this.pagination.last_page = response.last_page
                _this.pagination.base_url = response.path + '?page='
            },'/AccountReportSendingSummary/'+this.ipo_activity_period_id+'/'+this.$options.name+'?page='+this.pagination.current_page, this.filter);
        },
        add_to_list(obj){
            if(obj.client_acc_id.length<7) return
            if(obj.client_acc_id.length>9) return
            let _this = this
            this.crudStore(function(response){
                if(response.ok){
                    console.log(response)
                }else if(response.msg) _this.alertFail(response.msg)
            },this.getFormData(obj),'/AccountReportSendingSummary/'+this.ipo_activity_period_id+'/'+this.$options.name)
        },

        // 選擇項目的功能
        create_selected_pdf(){
            let _this = this
            this.action='create_selected_pdf'
            this.myPost(function(response) {
                _this.list = []
                _this.index()
            },this.getFormData({list:this.list}),this.url('/AccountReport/MakePdf/')+this.ipo_activity_period_id+'/')
        },
        send_test_mail() {
            let _this = this
            this.action='send_test_mail'
            this.myPost(function(response) {
                _this.list = []
                _this.index()
            },this.getFormData({list:this.list}),this.url('/AccountReport/SendTestMail/')+this.ipo_activity_period_id+'/')
        },
        send(){
            let _this = this
            this.action='send'
            this.myPost(function(response) {
                _this.list = []
                _this.index()
            },this.getFormData({list:this.list}),this.url('/AccountReport/SendMail/')+this.ipo_activity_period_id+'/')
        },
        del() {
            let _this = this
            this.action='del'
            this.myPost(function(response) {
                _this.list = []
                _this.index()
            },this.getFormData({ipo_activity_period_id:this.ipo_activity_period_id,list:this.list}),this.url('/AccountReport/RemoveClient/')+this.ipo_activity_period_id+'/')
        },

        // 全部清單的功能
        create_pdf(){
            let _this = this
            this.action='create_all'
            if(this.buttons.pdf.pending){
                this.myPost(function(response) {
                    _this.stop_reload()
                    _this.index()
                },{},this.url('/AccountReport/StopMake/'+this.ipo_activity_period_id+'/'),function(response){
                })
            }else if(this.buttons.pdf.success+this.buttons.pdf.fail===this.buttons.total){
                this.myPost(function(response) {
                    _this.index()
                    _this.reload_list()
                },{},this.url('/AccountReport/ClearMake/'+this.ipo_activity_period_id+'/'),function(response){
                })
            }else{
                this.myPost(function(response) {
                    _this.index()
                    _this.reload_list()
                },{},this.url('/AccountReport/MakeAll/'+this.ipo_activity_period_id+'/'),function(response){
                })
            }
        },
        send_all(){
            let _this = this
            this.action='send_all'
            if(this.buttons.email.pending){
                this.myPost(function(response) {
                    _this.stop_reload()
                    _this.index()
                },{},this.url('/AccountReport/StopSend/'+this.ipo_activity_period_id+'/'),function(response){
                })
            }else if(this.buttons.pdf.success+this.buttons.pdf.fail===this.buttons.total){
                this.myPost(function(response) {
                    _this.index()
                    _this.reload_list()
                },{},this.url('/AccountReport/ClearSend/'+this.ipo_activity_period_id+'/'),function(response){
                })
            }else{
                this.myPost(function(response) {
                    _this.index()
                    _this.reload_list()
                },{},this.url('/AccountReport/SendAll/'+this.ipo_activity_period_id+'/'),function(response){
                })
            }
        },

        show_html(item) {
            window.open(process.env.MIX_BASE_PATH+'/AccountReportSendingSummary/'+this.ipo_activity_period_id+'/ShowHtml/'+item.client_acc_id)
        },
        show_pdf(item) {
            window.open(process.env.MIX_BASE_PATH+'/AccountReportSendingSummary/'+this.ipo_activity_period_id+'/ShowPdf/'+item.client_acc_id)
        },
        download_pdf(item) {
            window.open(process.env.MIX_BASE_PATH+'/AccountReportSendingSummary/'+this.ipo_activity_period_id+'/DownloadPdf/'+item.client_acc_id)
        },

        getObjectByValue(array, key, value){
            return array.filter(function (o) {
                return o[key] === value;
            });
        },

        onRowClicked(item, index, event){
            let i = this.list.indexOf(item.client_acc_id);
            if(i===-1) this.list.push(item.client_acc_id)
            else this.list.splice(i,1)
        }
    }
}
</script>