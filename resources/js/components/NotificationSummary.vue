<template>
    <div class="my-4">
        <h1 class="text-warning text-center my-3">訊息中心</h1>
        <b-tabs v-model="tabIndex" justified>
            <b-tab title="依客戶檢視" :title-link-class="linkClass(0)" @click="dismissCountDown=5" active>
                <b-alert
                :show="dismissCountDown"
                dismissible
                fade
                class="m-4"
                variant="dark"
                @dismiss-count-down="countDownChanged"
                >
                    <div @click="dismissCountDown=0">
                        <p>使用說明：檢視單一客戶，被通知訊息的方式(簡訊、Email、帳戶總覽訊息)的通知記錄。新增的個人通知會進入列隊等待被執行，可稍後檢視通知結果。</p>
                        <p>產生簡訊的方式有：</p>
                        <ol>
                            <li>中台操作駁回時，由程式自動及時送出。</li>
                            <li>在訊息中心手動發送通知訊息。</li>
                        </ol>
                    </div>
                </b-alert>

                <div class="m-4">
                    <b-row class="filter text-white">
                        <b-col cols="3" class="mb-3">
                            <label for="client_acc_id">帳戶號碼</label>
                            <b-input id="client_acc_id" v-model="filter.client_acc_id" @keyup.enter="index" placeholder="按[ENTER]查詢"></b-input>
                        </b-col>
                        <b-col cols="3" class="mb-3">
                            <label for="client_name">客戶姓名</label>
                            <b-input id="client_name" v-model="filter.name" @keyup.enter="index" placeholder="按[ENTER]查詢"></b-input>
                        </b-col>
                        <b-col cols="3" class="mb-3">
                            <label for="sending_status">發送狀態</label>
                            <b-form-select id="sending_status" :options="status_options" v-model="filter.status" @change="index"></b-form-select>
                        </b-col>
                        <b-col cols="3" class="mb-3">
                            <label for="sending_period">發送時間</label>
                            <date-picker v-model="filter.date" type="date" range placeholder="Select date range"></date-picker>
                        </b-col>
                    </b-row>

                    <hr />

                    <b-row no-gutters>
                        <b-col cols="4">
                            <b-button class="mb-3" variant="success" v-b-modal.sms @click="resetForm('sms')"><i class="fas fa-sms"></i> 發送簡訊</b-button>
                            <b-button class="mb-3" variant="success" v-b-modal.email @click="resetForm('email')"><i class="fas fa-envelope-open"></i> 發送郵件</b-button>
                            <b-button class="mb-3" variant="success" v-b-modal.modify @click="resetForm('email')"><i class="fab fa-app-store-ios"></i> 帳戶總覽訊息</b-button>
                        </b-col>
                        <b-col cols="4">
                            <b-pagination-nav
                                v-model="pagination.current_page"
                                :number-of-pages="pagination.last_page"
                                base-url="#"
                                use-router align="center"
                            ></b-pagination-nav>
                        </b-col>
                        <b-col cols="4">
                        </b-col>
                    </b-row>

                    <b-table class="text-white" :items="items" :fields="fields">
                        <template #cell(data)="row">
                            {{ row.value.start_date }} ~ {{ row.value.end_date }}
                        </template>
                        <template #cell(actions)="row">
                            <b-button size="sm" class="mr-1" @click="info(row.item, row.index, $event.target)">
                                編輯
                            </b-button>
                            <b-button size="sm" class="mr-1" @click="enter(row.item)">
                                進入
                            </b-button>
                            <b-button size="sm" class="mr-1" variant="danger" v-b-modal.del="del" @click="form.id=row.item.id">
                                刪除
                            </b-button>
                        </template>
                    </b-table>
                </div>
            </b-tab>
            <b-tab title="依任務檢視" :title-link-class="linkClass(1)" @click="dismissCountDown=5">
                <b-alert
                :show="dismissCountDown"
                dismissible
                fade
                class="m-4"
                variant="dark"
                @dismiss-count-down="countDownChanged"
                >
                    <div @click="dismissCountDown=0">
                        <p>使用說明：檢索發送任務的記錄，並檢視發送任務的發送狀態。新增的任務通知會進入列隊等待被執行。新增的個人通知會進入列隊等待被執行，可稍後檢視通知結果。</p>
                        <p>產生任務的方式有：</p>
                        <ol>
                            <li>系統排程自動產生。ex: 中籤通知</li>
                            <li>透過匯入名單發送。匯入的名單可傳入變數。</li>
                        </ol>
                    </div>
                </b-alert>

                <div class="m-4">
                    <b-row class="filter text-white">
                        <b-col cols="3" class="mb-3">
                            <label for="client_acc_id">任務名稱</label>
                            <b-input id="client_acc_id" v-model="filter.client_acc_id" @keyup.enter="index" placeholder="按[ENTER]查詢"></b-input>
                        </b-col>
                        <b-col cols="3" class="mb-3">
                            <label for="sending_period">任務時間</label>
                            <date-picker v-model="filter.date" type="date" range placeholder="Select date range"></date-picker>
                        </b-col>
                    </b-row>

                    <hr />

                    <b-row no-gutters>
                        <b-col cols="4">
                            <b-button class="mb-3" variant="success" v-b-modal.modify @click="resetForm('task')"><i class="fas fa-plus-circle"></i> 新增發送任務</b-button>
                        </b-col>
                        <b-col cols="4">
                            <b-pagination-nav
                                v-model="pagination.current_page"
                                :number-of-pages="pagination.last_page"
                                base-url="#"
                                use-router align="center"
                            ></b-pagination-nav>
                        </b-col>
                        <b-col cols="4">
                        </b-col>
                    </b-row>

                    <b-table class="text-white" :items="items" :fields="fields">
                        <template #cell(data)="row">
                            {{ row.value.start_date }} ~ {{ row.value.end_date }}
                        </template>
                        <template #cell(actions)="row">
                            <b-button size="sm" class="mr-1" @click="info(row.item, row.index, $event.target)">
                                編輯
                            </b-button>
                            <b-button size="sm" class="mr-1" @click="enter(row.item)">
                                進入
                            </b-button>
                            <b-button size="sm" class="mr-1" variant="danger" v-b-modal.del="del" @click="form.id=row.item.id">
                                刪除
                            </b-button>
                        </template>
                    </b-table>
                </div>
            </b-tab>
            <b-tab title="系統訊息" :title-link-class="linkClass(2)" @click="dismissCountDown=5">
                <b-alert
                :show="dismissCountDown"
                dismissible
                fade
                class="m-4"
                variant="dark"
                @dismiss-count-down="countDownChanged"
                >
                    <div @click="dismissCountDown=0">
                        <p>使用說明：當定義的檢查需要被警示時，由系統自動發送通知至相關的作業人員，此為顯示通知的記錄。</p>
                    </div>
                </b-alert>

                <div class="m-4">
                    <b-row class="filter text-white">
                        <b-col cols="3" class="mb-3">
                            <label for="sending_status">訊息類別</label>
                            <b-form-select id="sending_status" :options="status_options" v-model="filter.status" @change="index"></b-form-select>
                        </b-col>
                        <b-col cols="3" class="mb-3">
                            <label for="client_acc_id">查詢內容</label>
                            <b-input id="client_acc_id" v-model="filter.client_acc_id" @keyup.enter="index" placeholder="按[ENTER]查詢"></b-input>
                        </b-col>
                        <b-col cols="3" class="mb-3">
                            <label for="sending_period">任務時間</label>
                            <date-picker v-model="filter.date" type="date" range placeholder="Select date range"></date-picker>
                        </b-col>
                        <b-col cols="3" class="mb-3">
                            <label for="client_name">通知人員</label>
                            <multiselect v-model="filter.operator" :options="operator_options" :multiple="true" :taggable="true" @tag="addTag" label="name" track-by="id"></multiselect>
                        </b-col>
                    </b-row>

                    <b-pagination-nav
                        v-model="pagination.current_page"
                        :number-of-pages="pagination.last_page"
                        base-url="#"
                        use-router align="center"
                    ></b-pagination-nav>
                    <hr />

                    <b-table class="text-white" :items="items" :fields="fields">
                        <template #cell(data)="row">
                            {{ row.value.start_date }} ~ {{ row.value.end_date }}
                        </template>
                        <template #cell(actions)="row">
                            <b-button size="sm" class="mr-1" @click="info(row.item, row.index, $event.target)">
                                編輯
                            </b-button>
                            <b-button size="sm" class="mr-1" @click="enter(row.item)">
                                進入
                            </b-button>
                            <b-button size="sm" class="mr-1" variant="danger" v-b-modal.del="del" @click="form.id=row.item.id">
                                刪除
                            </b-button>
                        </template>
                    </b-table>
                </div>
            </b-tab>
        </b-tabs>


        <!-- SMS -->
        <b-modal id="sms" size="lg" centered @ok="modify">
            <template #modal-header>
                <h3 class="mb-0" v-if="route=='sms'"><i class="fas fa-sms"></i> 發送簡訊</h3>
                <h3 class="mb-0" v-if="route=='email'"><i class="fas fa-envelope-open"></i> 發送郵件</h3>
                <h3 class="mb-0" v-if="route=='task'"><i class="fas fa-tasks"></i> 新增發送任務</h3>
            </template>
            <b-row>
                <b-col cols="7" class="my-2">
                    <div class="sms_bg">
                        <div class="phone">
                            <span class="time">{{now}}</span>
                            <b-avatar class="sms_avatar" icon="people-fill"></b-avatar>
                            <span class="sms_sender">CYSS</span>
                            <span v-if="sms_content1!=''" class="sms_message_time">{{zh_datetime}}</span>
                            <div v-if="sms_content1!=''" class="sms_message you">
                                <p v-html="sms_content1"></p>
                            </div>
                            <div v-if="sms_content2!=''" class="sms_message you">
                                <p v-html="sms_content2"></p>
                            </div>
                            <textarea v-model="form.content" maxlength="120" class="sms_content" ref="sms_content" @keyup="autogrow"></textarea>
                            <a class="sms_send" href="#"><i class="fas fa-arrow-circle-up"></i></a>
                        </div>
                    </div>
                </b-col>
                <b-col cols="5" class="my-2">
                    <b-row no-gutters>
                        <b-col cols="12" class="my-2">
                            <label for="template">選擇樣板</label>
                            <b-form-select id="template" v-model="form.template" :options="template_list"></b-form-select>
                        </b-col>
                        <b-col cols="12" class="my-2">
                            <label for="receiver">收件人</label>
                            <find-a-client id="receiver" v-model="form.client_acc_id" showbutton="false"></find-a-client>
                        </b-col>
                    </b-row>
                </b-col>
            </b-row>
        </b-modal>
        <!-- Email -->
        <b-modal id="email" size="lg" centered @ok="modify">
            <template #modal-header>
                <h3 class="mb-0" v-if="route=='sms'"><i class="fas fa-sms"></i> 發送簡訊</h3>
                <h3 class="mb-0" v-if="route=='email'"><i class="fas fa-envelope-open"></i> 發送郵件</h3>
                <h3 class="mb-0" v-if="route=='task'"><i class="fas fa-tasks"></i> 新增發送任務</h3>
            </template>
            <div class="email_bg">
                <a class="send_email" href="#"></a>
                <a class="choose_receiver" href="#"></a>
                <input class="email_receiver" />
                <input class="email_title" />
                <textarea class="email_content"></textarea>
            </div>
            <b-row>
                <b-col cols="12" class="my-2">
                    <label for="template">選擇樣板</label>
                    <b-form-select id="template" v-model="form.template" :options="template_list"></b-form-select>
                </b-col>
                <b-col cols="12" class="my-2">
                    <label for="sender">寄件人</label>
                    <b-form-select id="sender" v-model="form.sender" :options="sender_list"></b-form-select>
                </b-col>
                <b-col cols="12" class="my-2">
                    <label for="receiver">收件人</label>
                    <find-a-client id="receiver" v-model="form.client_acc_id" showbutton="false"></find-a-client>
                </b-col>
                <b-col cols="12" class="my-2">
                    <label for="title">標題</label>
                    <b-input if="title" v-model="form.title"></b-input>
                </b-col>
                <b-col cols="12" class="my-2">
                    <label for="content">內容</label>
                    <b-form-textarea id="content" rows="10" max-rows="20" v-model="form.content"></b-form-textarea>
                </b-col>
            </b-row>
        </b-modal>
        <!-- SMS -->
        <b-modal id="modify" size="lg" centered @ok="modify">
            <template #modal-header>
                <h3 class="mb-0" v-if="route=='sms'"><i class="fas fa-sms"></i> 發送簡訊</h3>
                <h3 class="mb-0" v-if="route=='email'"><i class="fas fa-envelope-open"></i> 發送郵件</h3>
                <h3 class="mb-0" v-if="route=='task'"><i class="fas fa-tasks"></i> 新增發送任務</h3>
            </template>
            <b-row>
                <b-col cols="12" class="my-2">
                    <label for="template">選擇樣板</label>
                    <b-form-select id="template" v-model="form.template" :options="template_list"></b-form-select>
                </b-col>
                <b-col cols="12" class="my-2">
                    <label for="sender">寄件人</label>
                    <b-form-select id="sender" v-model="form.sender" :options="sender_list"></b-form-select>
                </b-col>
                <b-col cols="12" class="my-2">
                    <label for="receiver">收件人</label>
                    <find-a-client id="receiver" v-model="form.client_acc_id" showbutton="false"></find-a-client>
                </b-col>
                <b-col cols="12" class="my-2">
                    <label for="title">標題</label>
                    <b-input if="title" v-model="form.title"></b-input>
                </b-col>
                <b-col cols="12" class="my-2">
                    <label for="content">內容</label>
                    <b-form-textarea id="content" rows="10" max-rows="20" v-model="form.content"></b-form-textarea>
                </b-col>
            </b-row>
        </b-modal>
        <!-- Del panel -->
        <b-modal id="del" title="BootstrapVue" @ok="del">
            <p class="my-4">您確定要刪除 序號為{{form.id}} 的任務嗎?</p>
        </b-modal>
    </div>
</template>

<script>
import axios from "../mixins/mixin_post"
import validator from "../mixins/mixin_validators";
export default {
    mixins:[axios,validator],
    name: 'NotificationSummary',
    data() {
      return {
          // tabs
          tabIndex:0,
          // alert
          dismissCountDown: 5,

          route:'sms',
          status_options:[
              {value:'all', text:'全部'},
              {value:'null', text:'無'},
              {value:'pending', text:'排程中 pending'},
              {value:'success', text:'成功 success'},
              {value:'fail', text:'失敗 fail'}
          ],
          operator_options: [
              { name: 'admin' , id: 2 },
              { name: 'PHOENIXH', id: 1 },
              { name: 'STEVENTAM', id: 3 },
              { name: 'Max', id: 4 },
              { name: 'SYSTEM', id: 0 }
          ],
          fields:[
            { key: 'id', label: '序號', sortable: true },
            { key: 'data', label: '報告期間', sortable: true },
            { key: 'total', label: '發送人數', sortable: true },
            { key: 'sending_progress', label: '發送進度', sortable: true },
            { key: 'success', label: '發送成功', sortable: true },
            { key: 'failure', label: '發送失敗', sortable: true },
            { key: 'actions', label: '操作' }
          ],
          pagination:{
              current_page: 1,
              last_page: 1,
              path: ''
          },
          items:[
            {
                id: 1,
                data:{
                    id:1,
                    ipo_activity_period_id:3,
                    start_date:'2020-09-01',
                    end_date:'2021-06-30',
                    report_make_date:'2021-06-15',
                    performance_fee_date:'2020-09-01',
                    title:'',
                    content:'持續酷熱的天氣，令大家切身感受到「氣候暖化」已迫在眉睫。世界各地不少機構積極以「碳中和」的方案應對氣候問題，所謂碳中和就是指以節能、植林、使用100%可再生能源等方式，來抵銷碳排放量，以達至淨零排放的效果。而作為駕駛者的你，有否想過你也可以透過選用碳中和汽車產品，節省燃油、減少廢氣排放，一同為保護地球出一分力？'
                },
                total:5000,sending_progress:'750封 15%', success:'700封 90%', failure:'50封 10%'
            },
            {
                id: 2,
                data:{
                    id:2,
                    ipo_activity_period_id:3,
                    start_date:'2020-09-01',
                    end_date:'2021-06-30',
                    report_make_date:'2021-06-15',
                    performance_fee_date:'2020-09-01',
                    report:'持續酷熱的天氣，令大家切身感受到「氣候暖化」已迫在眉睫。世界各地不少機構積極以「碳中和」的方案應對氣候問題，所謂碳中和就是指以節能、植林、使用100%可再生能源等方式，來抵銷碳排放量，以達至淨零排放的效果。而作為駕駛者的你，有否想過你也可以透過選用碳中和汽車產品，節省燃油、減少廢氣排放，一同為保護地球出一分力？'
                },
                total:5000,sending_progress:'750封 15%', success:'700封 90%', failure:'50封 10%'
            }
          ],
          filter:{
              status: 'all',
              client_acc_id: '',
              name: '',
              date:[],
              operator: []
          },
          ipo_activity_period_options:[
              {value:1, text: '拳頭打新2019'},
              {value:2, text: '拳頭打新2020'},
              {value:3, text: '拚一手2021'},
          ],
          template_list:[],
          sender_list:[],
          form:{
              client_acc_id: '',
              template:'',
              sender:'',
              client_acc_id:'',
              title:'',
              content:''
          }
      }
    },
    created() {
        this.index();
        this.program();
        this.$bus.$on('find_a_client::client',(client) => this.set_client(client));
    },
    computed:{
        busy(){
            return false
        },
        now(){
            var d = new Date()
            return d.getHours()+':'+d.getMinutes()
        },
        zh_datetime(){
            var d = new Date()
            var arr=['日','一','二','三','四','五','六']
            return d.getMonth() + '月' + d.getDate() + '日 週' + arr[d.getDay()] + ((d.getHours()>12)?'下午'+(d.getHours()-12):'上午'+d.getHours()) + ':' + d.getMinutes()
        },
        sms_content1(){
            if(this.form.content.length<=60) return this.form.content.replaceAll("\n",'<br />')
            return this.form.content.substring(0,60).replaceAll("\n",'<br />')
        },
        sms_content2(){
            if(this.form.content.length<=60) return ''
            return this.form.content.substring(60).replaceAll("\n",'<br />')
        }
    },
    methods: {
        // tabs
        linkClass(idx){
            return (this.tabIndex === idx)?'text-light':'text-secondary'
        },
        // alert
        countDownChanged(dismissCountDown){
            this.dismissCountDown = dismissCountDown
        },
        // multiselect
        addTag (newTag) {
            const tag = {
                name: newTag,
                code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            }
            this.operator_options.push(tag)
            this.filter.operator.push(tag)
        },
        // sms
        autogrow(){
            if(this.form.content.length>120) return
            var obj = this.$refs.sms_content
            var adjustedHeight=obj.clientHeight
            adjustedHeight=Math.max(obj.scrollHeight,adjustedHeight)
            if (adjustedHeight>obj.clientHeight) obj.style.height=adjustedHeight+'px'
        },

        set_client(client){

        },
        info(item, index, button) {
            for ( let k in this.form ) this.form[k] = item.data[k]
            this.$root.$emit('bv::show::modal', 'modify', button)
        },
        resetForm(route){
            this.route = route
            for ( let k in this.form ) this.form[k]=(['id','ipo_activity_period_id'].indexOf(k)===-1)?'':0
        },
        enter(item){
            document.location.href=process.env.MIX_BASE_PATH+'/AccountReportSendingSummary/'+item.data.id
        },
        modify(){
            if(this.form.id===0) this.store()
            else this.update()
            this.index()
        },
        program(){
            let _this = this
            this.myGet(function(response) {
                _this.ipo_activity_period_options = response
            },{},this.url('/AccountReport/program'));
        },
        index(){
            let _this = this
            this.crudIndex(function(response){
                // _this.items = response
            });
        },
        store(){
            let _this = this
            let formdata = this.getFormData();
            this.crudStore(function(response){
                _this.index()
            }, formdata);
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
            });
        },

        find_client(){
            let _this = this
            if(this.search.client_acc_id.length>3){
                this.myPost(function(response){
                    _this.find_client_list = response
                },{acc_no:_this.search.client_acc_id},this.url('/find/client'));
            }
        },
        add_to_list(){
            if(this.search.client_acc_id.length<7) return
            if(this.search.client_acc_id.length>9) return
            let _this = this
            this.crudStore(function(response){
                if(response.ok){
                    console.log(response)
                }else if(response.msg) _this.alertFail(response.msg)
            },this.getFormData(this.search),'/AccountReportSendingSummary/'+this.ipo_activity_period_id+'/'+this.$options.name)
        }
    }
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style>
.sms_bg{
    background-image: url(/images/sms.png);
    width: 463px;
    height: 862px;
    background-repeat: no-repeat;
    background-size: 80%;
    background-position: 59px 20px;
}
.phone{
    position: relative;
    background-image: url(/images/iphone.png);
    width: 100%;
    height: 100%;
}
.time{
    position: relative;
    top: 34px;
    left: 81px;
    font-weight: bold;
    font-size: 12px;
}
.sms_avatar{
    position: relative;
    top: 67px;
    left: 190px;
}
.sms_sender{
    position: relative;
    top: 96px;
    left: 154px;
    font-size: 10px;
}
.sms_message_time{
    position: relative;
    top: 123px;
    left: 95px;
    font-size: 9px;
}
.sms_message{
    display: block;
    padding: 10px;
    position: relative;
    color: #fff;
    font-size: 15px;
    background-color: #2ECC71;
    border-radius: 10px;
    box-shadow: 0 2px 6px rgb(0 0 0 / 30%);
    width: 300px;
    top: 115px;
    left: 100px;
    word-break: break-all;
    margin-bottom: 10px;
}
.sms_message:before {
    content: "";
    position: absolute;
    border-top: 16px solid rgba(0, 0, 0, 0.15);
    border-left: 16px solid transparent;
    border-right: 16px solid transparent;
}
.sms_message:after {
    content: "";
    position: absolute;
    top: 0;
    border-top: 17px solid #2ECC71;
    border-left: 17px solid transparent;
    border-right: 17px solid transparent;
}
.sms_message.you:before {
    margin: -9px -16px 0 0;
    right: 0;
}
.sms_message.you:after {
    content: "";
    right: 0;
    margin: 0 -15px 0 0;
}
.sms_content{
    position: absolute;
    left: 180px;
    width: 233px;
    height: 35px;
    border-radius: 20px;
    outline: none;
    padding: 5px 10px;
    bottom: 117px;
    overflow: hidden;
    resize:none;
}
.sms_send, .sms_send:hover{
    position: absolute;
    bottom: 112px;
    left: 383px;
    font-size: 27px;
    color: #00cb45;
}

.email_bg{
    background-image: url(/images/email.png);
    width: 590px;
    height: 765px;
    background-repeat: no-repeat;
    background-size: cover;
    margin: 0 auto;
}
.send_email{
    width: 50px;
    height: 70px;
    display: block;
    top: 166px;
    left: 8px;
    position: relative;
}
.choose_receiver{
    width: 93px;
    height: 28px;
    display: block;
    top: 96px;
    left: 68px;
    position: relative;
}
.email_receiver{
    position: relative;
    top: 70px;
    left: 173px;
    height: 17px;
    width: 408px;
    border: none;
    outline: none;
}
.email_title{
    position: relative;
    top: 112px;
    left: 173px;
    height: 21px;
    width: 408px;
    border: none;
    outline: none;
}
.email_content{
    width: 550px;
    height: 430px;
    position: relative;
    top: 120px;
    left: 12px;
    border: none;
    padding: 10px;
    outline: none;
}

/* multiselect */
.multiselect__tag{
    margin-top: 6px;
    margin-bottom: 0;
}
.multiselect__tags{
    padding-top: 0;
    border-radius: 0.25rem;
    min-height: 37px;
}
.multiselect__single{
    padding-top: 7px;
}

.multiselect__placeholder{
    padding-left: 10px;
    color: gray;
    padding-top: 7px;
    margin-bottom: 5px;
}
/* datepicker */
.mx-input{
    height: 37px;
}
.mx-datepicker-range{
    width: 100%;
}
</style>
