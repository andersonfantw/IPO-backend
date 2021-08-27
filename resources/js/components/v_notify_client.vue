<template>
    <div id="notify_client">
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
                <p>使用說明：檢視單一客戶，被通知訊息的方式(簡訊、Email、帳戶總覽訊息)的通知記錄。新增的個人通知會進入列隊等待被執行，可稍後檢視通知結果。</p>
                <p>產生簡訊的方式有：</p>
                <ol>
                    <li>中台操作駁回時，由程式自動及時送出。</li>
                                        <li>使用選擇器。以選擇器選擇收件的人員時，會自動帶入帳號[client_id]、中英文姓名[name]、中文名[zh_name]、英文名[en_name]、地址[addr]、電話[phone]的參數。變數不在上列的請改用匯入方式。</li>
                    <li>在訊息中心手動發送通知訊息。</li>
                </ol>
            </div>
        </b-alert>

        <div class="m-4">
            <b-row class="filter text-white">
                <b-col cols="9" class="mb-3">
                    <b-tabs v-model="tabIndex" class="switch_search">
                        <b-tab title="帳戶號碼" active>
                            <b-input id="client_id" v-model="filter.client_id" @keyup.enter="index" placeholder="帳戶號碼，按[ENTER]查詢"></b-input>
                        </b-tab>
                        <b-tab title="客戶姓名">
                            <b-input id="client_name" v-model="filter.name" @keyup.enter="index" placeholder="客戶姓名，按[ENTER]查詢"></b-input>
                        </b-tab>
                        <b-tab title="手機號碼">
                            <b-input id="phone" v-model="filter.phone" @keyup.enter="index" placeholder="手機號碼，按[ENTER]查詢"></b-input>
                        </b-tab>
                        <b-tab title="電子郵件">
                            <b-input id="email" v-model="filter.email" @keyup.enter="index" placeholder="電子郵件，按[ENTER]查詢"></b-input>
                        </b-tab>
                    </b-tabs>
                </b-col>
                <b-col cols="3" class="mb-3">
                    <label for="sending_period">發送時間</label>
                    <date-picker v-model="filter.date" type="date" @change="index" range placeholder="Select date range"></date-picker>
                </b-col>
            </b-row>

            <hr />

            <b-row no-gutters>
                <b-col cols="8">
                    <b-button class="mb-3" variant="success" v-b-modal.sms><i class="fas fa-sms"></i> 發送簡訊</b-button>
                    <b-button class="mb-3" variant="success" v-b-modal.email><i class="fas fa-envelope-open"></i> 發送郵件</b-button>
                    <b-button class="mb-3" variant="success" v-b-modal.account_overview><i class="fab fa-app-store-ios"></i> 帳戶總覽訊息</b-button>
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

            <b-table
                sort-by="sending_time"
                :sort-desc="true"
                class="text-white"
                :items="items"
                :fields="fields">
                <template #head(route)>
                    <b-form-select id="sending_status" :options="route_options" v-model="filter.route" @change="index"></b-form-select>
                </template>
                <template #head(content)>
                    <b-input id="client_name" v-model="filter.content" @keyup.enter="index" placeholder="檢索內容，按[ENTER]查詢"></b-input>
                </template>
                <template #head(status)>
                    <b-form-select id="sending_status" :options="status_options" v-model="filter.status" @change="index"></b-form-select>
                </template>
                <template #cell(route)="row">
                    <span v-if="row.item.route=='sms'"><i class="fas fa-sms"></i> 簡訊</span>
                    <span v-if="row.item.route=='email'"><i class="fas fa-envelope-open"></i> 郵件</span>
                    <span v-if="row.item.route=='account_overview'"><i class="fab fa-app-store-ios"></i> 帳戶總覽</span>
                </template>
                <template #cell(content)="row">
                    <h5>{{ row.item.title }}</h5>
                    <summary style="white-space: nowrap; text-decoration: underline;" @click="collapse_summary">{{ row.item.content }}</summary>
                </template>
                <template #cell(status)="row">
                    <div v-if="row.item.status=='success'">成功 {{row.item.sending_time}}</div>
                    <div v-else-if="row.item.status=='failure'" class="text-danger">失敗 {{row.item.sending_time}}</div>  
                    <div v-else-if="row.item.status=='pending'">排程中 {{row.item.queue_time}}</div>  
                </template>
                <template #cell(actions)="row">
                    <b-button size="sm" class="mr-1" variant="success" @click="resend(row.item)" :disabled="row.item.status=='success'">
                        <span v-if="row.item.status=='failure'">重新</span>發送
                    </b-button>
                    <b-button size="sm" class="mr-1" variant="danger" v-b-modal.del @click="form.id=row.item.id" v-if="row.item.status!='success'">
                        刪除
                    </b-button>
                </template>
            </b-table>
        </div>

        <!-- del confirm -->
        <b-modal id="del" title="刪除發送任務" @ok="del">
            <p class="my-4">您確定要刪除尚未送出 序號為{{form.id}} 的通知嗎?</p>
        </b-modal>

        <!-- SMS -->
        <send-sms-task id="sms" mode="" :value="filter.client_id" @close="reload"></send-sms-task>
        <!-- Email -->
        <send-email-task id="email" mode="" :value="filter.client_id" @close="reload"></send-email-task>
        <!-- Account Overview -->
        <send-account-overview-task id="account_overview" mode="" :value="filter.client_id" @close="reload"></send-account-overview-task>
    </div>
</template>

<script>
import axios from "../mixins/mixin_post"
import validator from "../mixins/mixin_validators";
export default {
    mixins:[axios,validator],
    name:'notify_client',
    data(){
        return {
          // alert
          dismissCountDown: 0,
          tabIndex: 0,
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
            { key: 'sending_time', label: '發送時間', sortable: true },
            { key: 'route', label: '方式', sortable: false },
            { key: 'content', label: '訊息', sortable: false },
            { key: 'status', label: '狀態', sortable: false },
            { key: 'actions', label: '操作' }
          ],
          pagination:{
              current_page: 1,
              last_page: 1,
              path: ''
          },
          items:[
            {
                id:1,
                route:'簡訊',
                title:'訊息標題',
                content:'持續酷熱的天氣，令大家切身感受到「氣候暖化」已迫在眉睫。世界各地不少機構積極以「碳中和」的方案應對氣候問題，所謂碳中和就是指以節能、植林、使用100%可再生能源等方式，來抵銷碳排放量，以達至淨零排放的效果。而作為駕駛者的你，有否想過你也可以透過選用碳中和汽車產品，節省燃油、減少廢氣排放，一同為保護地球出一分力？',
                created_at:'2020-09-01 23:01:10',
                updated_at:'2020-09-01 23:02:13',
                queue_time:'2020-09-01 23:02:50',
                sending_time:'2020-09-01 23:03:00',
                status:'success'
            },
            {
                id:2,
                route:'帳戶總覽',
                title:'訊息標題',
                content:'持續酷熱的天氣，令大家切身感受到「氣候暖化」已迫在眉睫。世界各地不少機構積極以「碳中和」的方案應對氣候問題，所謂碳中和就是指以節能、植林、使用100%可再生能源等方式，來抵銷碳排放量，以達至淨零排放的效果。而作為駕駛者的你，有否想過你也可以透過選用碳中和汽車產品，節省燃油、減少廢氣排放，一同為保護地球出一分力？',
                created_at:'2020-09-01 23:01:10',
                updated_at:'2020-09-01 23:02:13',
                queue_time:'2020-09-01 23:02:50',
                sending_time:'2020-09-01 23:03:00',
                status:'fail'
            }
          ],
          form:{
              id:0
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
    created() {
        this.index();
        this.$bus.$on('close',(client_id)=>this.index())
    },
    beforeDestroy(){
        this.$bus.$off("close");
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

                // 如果畫面中有未完成的項目，每十秒更新一次
                let result =  _this.items.filter(i => !i.sending_time)
                if(result.length>0) setTimeout(() => _this.index(), 10000)

                _this.pagination.last_page = response.last_page
                _this.pagination.base_url = response.path + '?page='
            },'/'+this.$options.name+'?page='+this.pagination.current_page, this.filterByTag);
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
#notify_client summary{
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 450px;
    min-width: 250px;
}
</style>