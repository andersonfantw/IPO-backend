<template>
    <div class="group_clients px-3 py-2">
        <find-a-client id="receiver" v-model="form.client_acc_id" v-if="form.import==0"></find-a-client>
        <b-row>
            <b-col cols="12">
                <b-pagination-nav
                    class="bg-wite"
                    v-model="pagination.current_page"
                    :number-of-pages="pagination.last_page"
                    base-url="#"
                    use-router align="center"
                ></b-pagination-nav>
            </b-col>
        </b-row>
        <b-table :items="items" :fields="route_fields[form.route]">
            <template #head(client_id)>
                <b-input id="client_id" v-model="filter.client_id" @keyup.enter="index" placeholder="檢索帳號，按[ENTER]查詢"></b-input>
            </template>
            <template #head(name)>
                <b-input id="client_id" v-model="filter.name" @keyup.enter="index" placeholder="檢索姓名，按[ENTER]查詢"></b-input>
            </template>
            <template #head(email)>
                <b-input id="client_id" v-model="filter.email" @keyup.enter="index" placeholder="檢索郵件，按[ENTER]查詢"></b-input>
            </template>
            <template #head(sms)>
                <b-input id="client_id" v-model="filter.sms" @keyup.enter="index" placeholder="檢索手機，按[ENTER]查詢"></b-input>
            </template>
            <template #head(status)>
                <b-form-select id="status" :options="status_options" v-model="filter.status" @change="index"></b-form-select>
            </template>
            <template #cell(index)="row">
                {{ (pagination.current_page-1)*pagination.per_page + row.index + 1 }}
            </template>
            <template #cell(status)="row">
                <div v-if="row.item.status=='success'">成功</div>
                <div v-else-if="row.item.status=='fail'">失敗</div>
                <div v-else-if="row.item.status=='pending'">排程中</div>
                <div v-else>未發送</div>
            </template>
            <template #cell(actions)="row">
                <b-button size="sm" class="mr-1" variant="danger" v-b-modal.del @click="form.client_acc_id=row.item.client_acc_id" v-if="row.item.status!='success'">
                    刪除
                </b-button>
            </template>
        </b-table>
        <!-- Del panel -->
        <b-modal id="del" title="BootstrapVue" @ok="del">
            <p class="my-4">您確定要刪除 {{form.client_acc_id}} 嗎?</p>
        </b-modal>
    </div>
</template>

<script>
import axios from "../mixins/mixin_post"
import validator from "../mixins/mixin_validators";
export default {
    mixins:[axios,validator],
    props:['group_id'],
    data(){
        return {
          name: 'notify_group',
          busy:false,
          status_options:[
              {value:'all', text:'狀態'},
              {value:'nulls', text:'無'},
              {value:'pending', text:'排程中 pending'},
              {value:'success', text:'成功 success'},
              {value:'failure', text:'失敗 fail'}
          ],
          route_fields:{
            'sms':[
                'index',
                { key: 'client_id', label: '客戶帳號', sortable: false },
                { key: 'name', label: '姓名', sortable: false },
                { key: 'sms', label: '手機號', sortable: false },
                { key: 'status', label: '狀態', sortable: false },
                { key: 'actions', label: '操作' }
            ],
            'email':[
                'index',
                { key: 'client_id', label: '客戶帳號', sortable: false },
                { key: 'name', label: '姓名', sortable: false },
                { key: 'email', label: '電子郵件', sortable: false },
                { key: 'status', label: '狀態', sortable: false },
                { key: 'actions', label: '操作' }
            ],
            'account_overview':[
                'index',
                { key: 'client_id', label: '客戶帳號', sortable: false },
                { key: 'name', label: '姓名', sortable: false },
                { key: 'status', label: '狀態', sortable: false },
                { key: 'actions', label: '操作' }
            ]
          },
          items:[
            {
                client_id:'20000013',
                name:'圈圈圈',
                sms: '55984928',
                email: 'anderson.fan@chinayss.hk',
                status: 'success',
                sending_time:'2021-07-13 13:50:12'
            },
            {
                client_id:'20000013',
                name:'圈圈圈',
                sms: '55984928',
                email: 'anderson.fan@chinayss.hk',
                status: 'success',
                sending_time:'2021-07-13 13:50:12'
            }
          ],
          pagination:{
              current_page: 1,
              last_page: 1,
              per_page: 20,
              path: ''
          },
          form:{
              route:'email',
              import:0,
          },
          filter:{
              client_id: '',
              name:'',
              email:'',
              sms:'',
              status:'all',
          }
        }
    },
    created() {
        this.show()
        this.index()
    },
    watch: {
        'pagination.current_page': function(n){
            this.index()
        }
    },
    methods: {
        show(){
            let _this = this
            this.crudShow(this.group_id, function(response){
                _this.form = response
                console.log(response)
            },{},'/'+this.name)
        },
        index(){
            let _this = this
            this.crudIndex(function(response){
                _this.items = response.data

                _this.pagination.last_page = response.last_page
                 _this.pagination.per_page = response.per_page
                _this.pagination.base_url = response.path + '?page='
            },'/'+this.name+'/'+this.group_id+'/list/?page='+this.pagination.current_page, this.filter);
        },
        del(){
            let _this = this
            this.crudDestroy(this.form.id,function(response){
                _this.index()
            });
        },
    }
}
</script>

<style>
.group_clients .page-link{
    color: #343a40 !important;
    background-color: #fff !important;
}
</style>