<template>
    <b-modal :id="id" size="lg" centered>
        <template #modal-header>
            <h3 class="mb-0"><i class="fas fa-sms"></i> 發送至帳戶總覽</h3>
        </template>
        <template #modal-footer="{ cancel }">
            <b-button @click="cancel()">Cancel</b-button>
            <b-button variant="primary" v-b-modal.create>OK</b-button>
        </template>
        <b-row>
            <b-col cols="12" class="my-2">
                <label for="template">樣  板</label>
                <b-form-select id="template" v-model="form.template" :options="template_list"  @change="show_template"></b-form-select>
            </b-col>
            <b-col cols="12" class="my-2" v-if="mode!='group'">
                <label for="receiver">客戶</label>
                <find-a-client id="receiver" ref="receiver" v-model="form.client_id" showbutton="false"></find-a-client>
            </b-col>
            <b-col cols="12" class="my-2" v-if="mode=='group'">
                <label for="receiver">選擇客戶 / 上傳檔案</label>
                <client-chooser v-model="form.groups" :disabled="form.file!==null"></client-chooser>
                <div class="divider">or</div>
                <b-form-file id="file-default" v-model="form.file" :disabled="form.groups.length>0"></b-form-file>
            </b-col>
            <b-col cols="12" class="my-2">
                <label for="title">標題</label>
                <b-input if="title" v-model="form.title"></b-input>
            </b-col>
            <b-col cols="12" class="my-2">
                <label for="content">內容</label>
                <b-form-textarea id="content" rows="10" max-rows="20" v-model="content_by_mode" @focus="written_mode" @blur="preview_mode"></b-form-textarea>
            </b-col>
        </b-row>
        <!-- Create Task -->
        <b-modal id="create" title="提示" @ok="store">
            <p class="my-4" v-if="mode=='group'">您確定要建立任務嗎?</p>
            <p class="my-4" v-else>您確定要送出嗎?</p>
        </b-modal>
    </b-modal>
</template>

<script>
import axios from "../mixins/mixin_post"
export default {
    mixins: [axios],
    props:['id','mode'],
    data(){
        return {
            sending: false,
            content_mode: 'written_mode',
            template_list:[
                {value:1,text:'中籤通知',content:'您申購的新股奈雪的茶，抽中500股。'},
                {value:2,text:'中籤通知2',content:'您申購的新股奈雪的茶，抽中500股。2'},
                {value:3,text:'中籤通知3',content:'您申購的新股奈雪的茶，抽中500股。3'}
            ],
            client_info:{},
            form:{
                client_id: '',
                template:'',
                file:null,
                groups:'',
                title:'',
                content:''
            },
        }
    },
    computed:{
        name(){
            return (this.mode=='')?'notify_client':'notify_group'
        },
        content_by_mode:{
            get(){
                if(this.content_mode=='written_mode') return this.form.content
                else{
                    let s = this.form.content
                    for(const [k,v] of Object.entries(this.client_info)){s=s.replace(k,v)}
                    return s
                }
            },
            set(v){
                this.form.content = v
            }
        }
    },
    created(){
        this.index()
        this.$bus.$on('find_a_client::client',(o)=>this.get_client_info(o))
    },
    methods:{
        get_template_list(){
            let _this = this
            this.myGet(function(response){
                _this.template_list = response
                _this.template_list.unshift({text:'自訂文案',value:0,content:'',blade:null})
            },{mode:(this.mode)?'group_account_overview':'account_overview'},this.url('/template_list'))
        },
        show_template(){
            let item = this.template_list.filter(t => t.value==this.form.template)
            this.form.content = (item[0].value)?item[0].content:''
            if(item.length==1){
                this.form.content = item[0].content
            }
        },
        written_mode(){
            this.content_mode='written_mode'
        },
        preview_mode(){
            this.content_mode='preview_mode'
            this.check_template_id_by_content()
        },
        get_client_info(o){
            let _this = this
            this.myGet(function(response){
                _this.client_info = response
            },{client_id:o.client_id},this.url('/client_info'))
        },
        index(){
            this.get_template_list()
        },
        store(){
            this.sending = true
            let _this = this
            let formdata = this.getFormData();
            this.crudStore(function(response){
                if(response.ok){
                    _this.sending = false
                    _this.$bvModal.hide(_this.id)
                    _this.$emit('close',_this.form.client_id)
                }
            },formdata,'/'+this.name);
        }
    }
}
</script>