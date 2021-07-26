<template>
    <div>
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
                <p>使用說明：當定義的檢查需要被警示時，由系統自動發送通知至相關的作業人員，此為顯示通知的記錄。</p>
            </div>
        </b-alert>

        <div class="m-4">

            <b-pagination-nav
                v-model="pagination.current_page"
                :number-of-pages="pagination.last_page"
                base-url="#"
                use-router align="center"
            ></b-pagination-nav>

            <b-table class="text-white" :items="items" :fields="fields">
                <template #head(route)>
                    <b-form-select id="route" :options="route_options" v-model="filter.route" @change="index"></b-form-select>
                </template>
                <template #head(name)>
                    <b-input id="client_acc_id" v-model="filter.client_acc_id" @keyup.enter="index" placeholder="事件描述，按[ENTER]查詢"></b-input>
                </template>
                <template #head(contact)>
                    <multiselect v-model="filter.operator" :options="operator_options" :multiple="true" :taggable="true" @tag="addTag" label="name" track-by="id" placeholder="聯絡人"></multiselect>
                </template>
                <template #head(sending_time)>
                    <date-picker v-model="filter.date" type="date" range placeholder="發送時間"></date-picker>
                </template>
                <template #head(status)>
                    <b-form-select id="sending_status" :options="status_options" v-model="filter.status" @change="index"></b-form-select>
                </template>
                <template #cell(status)="row">
                    <div v-if="row.item.status=='success'">成功</div>
                    <div v-else-if="row.item.status=='fail'">失敗</div>
                    <div v-else-if="row.item.status=='pending'">排程中</div>
                </template>
            </b-table>
        </div>        
    </div>
</template>

<script>
import axios from "../mixins/mixin_post"
import validator from "../mixins/mixin_validators";
export default {
    mixins:[axios,validator],
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
            { key: 'id', label: '序號', sortable: false },
            { key: 'route', label: '方式', sortable: false },
            { key: 'name', label: '事件', sortable: false },
            { key: 'contact', label: '通知人員', sortable: false },
            { key: 'sending_time', label: '時間', sortable: false },
            { key: 'status', label: '狀態', sortable: false }
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
                name:'訊息標題',
                contact:'admin',
                sending_time:'2020-09-01 23:03:00',
                status:'success'
            },
            {
                id:2,
                route:'簡訊',
                name:'訊息標題',
                contact:'admin',
                sending_time:'2020-09-01 23:03:00',
                status:'success'
            },
          ],
          filter:{
              route: 'all',
              status: 'all',
              client_acc_id: '',
              name: '',
              date:[],
              operator: []
          },
        }
    },
    created() {
        this.index();
    },
    methods: {
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

        index(){
            let _this = this
            this.crudIndex(function(response){
                // _this.items = response
            });
        },
    }
}
</script>


<style>
.hint{
    color:gray;
    float: right;
    margin: -20px 3px 0 0;
}

/* multiselect */
.multiselect{
    min-height:initial;
}
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

.multiselect--active:not(.multiselect--above) .multiselect__current, .multiselect--active:not(.multiselect--above) .multiselect__input, .multiselect--active:not(.multiselect--above) .multiselect__tags{
    padding-top: 7px;
    color:gray;
}
</style>