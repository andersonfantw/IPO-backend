<template>
    <div id="notify_group">
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
                <p>使用說明：檢索發送任務的記錄，並檢視發送任務的發送狀態。新增的任務通知會進入列隊等待被執行。新增的個人通知會進入列隊等待被執行，可稍後檢視通知結果。</p>
                <p>產生任務的方式有：</p>
                <ol>
                    <li>使用選擇器。<p>以選擇器選擇收件的人員時，會自動帶入帳號[client_id]、中英文姓名[name]、中文名[zh_name]、英文名[en_name]、地址[addr]、電話[phone]的參數。變數不在上列的請改用匯入方式。</p></li>
                    <li>透過匯入名單發送。預設抓取第一個sheet，匯入的名單可傳入變數。<p>以匯入方式匯入名單時，第一行必須是欄位名。第一列必須是client，第二列之後為自定義的變數，會以[變數名]的方式帶入至訊息中。ex: 客戶[name]您好 => 送出的訊息為 客戶王某某你好</p></li>
                    <li>系統排程自動產生。ex: 中籤通知</li>
                </ol>
            </div>
        </b-alert>

        <div class="m-4">
            <b-row no-gutters>
                <b-col cols="8">
                    <b-button class="mb-3" variant="success" v-b-modal.group_sms @click="target_item={}"><i class="fas fa-sms"></i> 發送簡訊任務</b-button>
                    <b-button class="mb-3" variant="success" v-b-modal.group_email @click="target_item={}"><i class="fas fa-envelope-open"></i> 發送郵件任務</b-button>
                    <b-button class="mb-3" variant="success" v-b-modal.group_account_overview @click="target_item={}"><i class="fab fa-app-store-ios"></i> 帳戶總覽訊息任務</b-button>
                </b-col>
                <b-col cols="4">
                    <b-pagination-nav
                        v-model="pagination.current_page"
                        :number-of-pages="pagination.last_page"
                        base-url="#"
                        use-router align="right"
                    ></b-pagination-nav>
                </b-col>
            </b-row>

            <b-table class="text-white" :items="items" :fields="fields">
                <template #head(route)>
                    <b-form-select id="route" :options="route_options" v-model="filter.route" @change="index"></b-form-select>
                </template>
                <template #head(title)>
                    <b-input id="content" v-model="filter.content" @keyup.enter="index" placeholder="檢索名稱，按[ENTER]查詢"></b-input>
                </template>
                <template #head(sending_time)>
                    <date-picker v-model="filter.date" type="date" @change="index" range placeholder="發送時間"></date-picker>
                </template>
                <template #cell(title)="row">
                    <summary style="white-space: nowrap; text-decoration: underline;" @click="collapse_summary" v-if="row.item.route=='sms'">{{row.item.content}}</summary>
                    <summary style="white-space: nowrap; text-decoration: underline;" @click="collapse_summary" v-else-if="row.item.route=='email'">{{row.item.title}}</summary>
                    <summary style="white-space: nowrap; text-decoration: underline;" @click="collapse_summary" v-else-if="row.item.route=='account_overview'">{{row.item.title}}</summary>
                </template>
                <template #cell(remark)="row">
                    <div v-if="row.item.success>0 || row.item.failure>0">
                    {{ (parseInt(row.item.success) + parseInt(row.item.failure))*100/row.item.total }}% : 成功 {{ row.item.success }} 失敗 {{ row.item.failure }}
                    </div>
                    <div v-else>未發送</div>
                </template>
                <template #cell(actions)="row">
                    <b-button size="sm" class="mr-1" variant="success" @click="edit(row.item, row.index, $event.target)" :disabled="row.item.success>0">
                        編輯
                    </b-button>
                    <b-button size="sm" class="mr-1" variant="success" v-b-modal.send_all @click="form.id=row.item.id" :disabled="(parseInt(row.item.success)+parseInt(row.item.failure)==row.item.total && row.item.total!=0) || row.item.pending>0">
                        <span v-if="row.item.success>0 && row.item.success!=row.item.total">重新</span>發送<span v-if="row.item.pending>0">中...</span>
                    </b-button>
                    <b-button size="sm" class="mr-1" variant="success" v-b-toggle.sidebar-right @click="show(row.item)">
                        檢視清單
                    </b-button>
                    <b-button size="sm" class="mr-1" variant="danger" v-b-modal.del @click="form.id=row.item.id" v-if="row.item.success==0">
                        刪除
                    </b-button>
                </template>
            </b-table>
        </div>

        <!-- show send list -->
        <b-sidebar id="sidebar-right" title="通知發送清單" width="800px" right shadow lazy>
            <notify-group-client-list :group_id="form.id"></notify-group-client-list>
        </b-sidebar>
        <!-- send all confirm -->
        <b-modal id="send_all" title="發送任務" @ok="send_all">
            <p class="my-4">您確定要發送 序號為{{form.id}} 的任務嗎?</p>
        </b-modal>
        <!-- del confirm -->
        <b-modal id="del" title="刪除發送任務" @ok="del">
            <p class="my-4">您確定要刪除 序號為{{form.id}} 的任務嗎?</p>
        </b-modal>

        <!-- SMS -->
        <send-sms-task id="group_sms" :item="target_item" mode="group" @close="index"></send-sms-task>
        <!-- Email -->
        <send-email-task id="group_email" :item="target_item" mode="group" @close="index"></send-email-task>
        <!-- Account Overview -->
        <send-account-overview-task id="group_account_overview" :item="target_item" mode="group" @close="index"></send-account-overview-task>
    </div>
</template>

<script>
import axios from "../mixins/mixin_post"
import validator from "../mixins/mixin_validators";
export default {
    mixins:[axios,validator],
    name:'notify_group',
    data(){
        return {
          // alert
          dismissCountDown: 0,
          route_options:[
              {value:'all', text:'通知方式'},
              {value:'sms', text:'簡訊'},
              {value:'email', text:'電子郵件'},
              {value:'account_overview', text:'帳戶總覽'}
          ],
          status_options:[
              {value:'all', text:'狀態'},
              {value:'nulls', text:'無'},
              {value:'pending', text:'排程中 pending'},
              {value:'success', text:'成功 success'},
              {value:'failure', text:'失敗 fail'}
          ],
          fields:[
            { key: 'id', label: 'ID', sortable: false },
            { key: 'route', label: '方式', sortable: false },
            { key: 'title', label: '識別名稱', sortable: false },
            { key: 'total', label: '人數', sortable: false },
            { key: 'remark', label: '發送狀態', sortable: false },
            { key: 'sending_time', label: '發送時間', sortable: false },
            { key: 'actions', label: '操作' }
          ],
          pagination:{
              current_page: 1,
              last_page: 1,
              path: ''
          },
          target_item:{},
          items:[
            {
                id:1,
                route:'簡訊',
                title:'訊息標題',
                total: 20,
                success: 10,
                fail: 3,
                sending_time:'2021-07-13 13:50:12'
            },
            {
                id:2,
                route:'帳戶總覽',
                title:'訊息標題1',
                total: 20,
                success: 15,
                fail: 1,
                sending_time:'2021-07-13 13:50:12'
            }
          ],
          filter:{
              content: '',
              route: 'all',
              date:[]
          },
          form:{
              id:0,
              index:0,
              group_name: '',
          }
        }
    },
    created() {
        this.index();
        this.$bus.$on('find_a_client::add',(o)=>this.add_to_list(o))
    },
    beforeDestroy(){
        this.$bus.$off("find_a_client::add");
    },
    watch: {
        'pagination.current_page': function(n){
            this.index()
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
        show(item){
            this.form.id = item.id
            this.form.group_name = item.name
            //document.location.href=process.env.MIX_BASE_PATH+'/AccountReportSendingSummary/'+item.data.id
        },
        edit(item, index){
            this.target_item = item
            this.$bvModal.show('group_'+item.route)
        },
        index(){
            let _this = this
            this.crudIndex(function(response){
                _this.items = response.data

                _this.pagination.last_page = response.last_page
                _this.pagination.base_url = response.path + '?page='
            },'/'+this.$options.name+'?page='+this.pagination.current_page, this.filter);
        },
        del(){
            let _this = this
            this.crudDestroy(this.form.id,function(response){
                _this.index()
            })
        },
        send_all(){
            let _this = this
            this.myPost(function(response){
                _this.index()
            },null,this.url(this.form.id+'/SendAll/'))
        },
        add_to_list(client){
            let _this = this
            this.myPost(function(response){

            },null,this.url(this.form.id+'/store/'+client.client_id+'/'))
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

#notify_group summary{
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 400px;
    min-width: 250px;
}
</style>