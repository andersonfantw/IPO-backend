<template>
    <b-modal :id="id" size="lg" centered>
        <template #modal-header>
            <h3 class="mb-0"><i class="fas fa-envelope-open"></i> 發送郵件</h3>
        </template>
        <template #modal-footer="{ cancel }">
            <b-button @click="cancel()">Cancel</b-button>
            <b-button variant="primary" v-b-modal.create>OK</b-button>
        </template>
        <b-overlay :show="sending" rounded="sm">
            <template #overlay>
                <img src="/images/sendemail.gif" />
            </template>
            <b-row>
                <b-col cols="8" class="my-2">
                    <div class="email_bg" :style="{'background-image': 'url('+email_bg+')'}">
                        <a class="send_email" href="javascript:;" v-b-modal.create></a>
                        <a class="choose_receiver" href="javascript:;" @click="choose_receiver"></a>
                        <input class="email_receiver" v-model="email_receiver" :disabled="form.client_id!=''" />
                        <input class="email_title" v-model="form.title" />
                        <textarea class="email_content" v-model="content_by_mode" v-if="!blade" @focus="written_mode" @blur="preview_mode"></textarea>
                        <b-embed type="iframe" v-if="blade" :src="preview_url" ></b-embed>
                    </div>
                </b-col>
                <b-col cols="4" class="my-2 pl-0">
                    <b-row no-gutters>
                        <b-col cols="12" class="my-2">
                            <label for="template" class="text-center d-block">樣  板</label>
                            <b-form-select id="template" v-model="form.template" :options="template_list"  @change="show_template"></b-form-select>
                        </b-col>
                        <b-col cols="12" class="my-2" v-if="mode!='group'">
                            <label for="receiver" class="text-center d-block">收 件 人</label>
                            <div class="form-row">
                                <div class="form-group col-2 d-flex align-items-center">
                                    客戶
                                </div>
                                <div class="form-group col-10">
                                    <find-a-client id="receiver" ref="receiver" v-model="form.client_id" showbutton="false" :disabled="form.email!=''"></find-a-client>
                                </div>
                            </div>
                            <div class="divider">or</div>
                            <div class="form-row">
                                <div class="form-group col-2 d-flex align-items-center" style="line-height: 17px;">
                                    郵件地址
                                </div>
                                <div class="form-group col-10">
                                    <b-input id="email" v-model="form.email" :disabled="form.client_id!=''"></b-input>
                                </div>
                            </div>
                        </b-col>
                        <b-col cols="12" class="my-2" v-if="mode=='group'">
                            <label for="receiver" class="text-center d-block">收 件 人</label>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <client-chooser v-model="form.groups" :disabled="form.file!==null"></client-chooser>
                                </div>
                            </div>
                            <div class="divider">or</div>
                            <div class="form-row">
                                <div class="form-group col-2 d-flex align-items-center" style="line-height: 17px;">
                                    上傳檔案
                                </div>
                                <div class="form-group col-10">
                                    <b-form-file id="file-default" v-model="form.file" :disabled="form.groups.length>0"></b-form-file>
                                </div>
                            </div>
                        </b-col>
                        <b-col cols="12" class="my-2" v-if="mode=='group'">
                            <label for="import_example" class="text-center d-block">格式範例</label>
                            <notification-import-excel-format-example route="email" :mode="mode"></notification-import-excel-format-example>
                        </b-col>
                    </b-row>
                </b-col>
            </b-row>
            <!-- Create Task -->
            <b-modal id="create" title="提示"  @ok="store()">
                <p class="my-4" v-if="mode=='group'">您確定要建立任務嗎?</p>
                <p class="my-4" v-else>您確定要送出嗎?</p>
            </b-modal>
        </b-overlay>
    </b-modal>
</template>

<script>
import axios from "../mixins/mixin_post"
export default {
    mixins: [axios],
    props:['id','mode','value','item'],
    data(){
        return {
            sending: false,
            content_mode: 'written_mode',
            blade: '',
            preview_url: '',
            template_list:[
                {value:1,text:'中籤通知',content:'您申購的新股奈雪的茶，抽中500股。',blade:null},
                {value:2,text:'中籤通知2',content:'您申購的新股奈雪的茶，抽中500股。2',blade:null},
                {value:3,text:'中籤通知3',content:'您申購的新股奈雪的茶，抽中500股。3',blade:null}
            ],
            client_info:{},
            form:{
                _route:'email',
                groups:[],
                file:null,
                client_id: '',
                template:0,
                email:'',
                title:'',
                content:''
            },
        }
    },
    computed:{
        email_bg(){
            return process.env.MIX_BASE_PATH+'/images/email.png'
        },
        name(){
            return (this.mode=='')?'notify_client':'notify_group'
        },
        busy(){
            return false
        },
        email_receiver:{
            get(){
                return (this.form.email=='')?this.form.client_id:this.form.email
            },
            set(v){
                this.form.email = v
            }
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
    watch: {
        value(){
            this.form.client_id = this.value
        },
        item(){
            if(Object.keys(this.item).length === 0){
                this.form.template = 0
                this.form.content = ''
                return {
                    template:0,
                    content:'',
                }
            }else{
                this.form.template = this.item.notification_template_id
                this.form.content = this.item.content
                return {
                    template:this.item.notification_template_id,
                    content:this.item.content,
                }
            }
        },
        'form.client_id': function(nv,ov){
            if(nv.length<ov.length) this.client_info={}
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
            },{mode:(this.mode)?'group_email':'email'},this.url('/api/template_list'))
        },
        choose_receiver(){
            switch(this.mode){
                case 'group':
                    this.$bvModal.show('client_chooser')
                    break;
                case '':
                default:
                    this.$refs.receiver.$refs.receiver.focus()
                    break
                }
        },
        show_template(){
            let item = this.template_list.filter(t => t.value==this.form.template)
            this.form.content = (item[0].value)?item[0].content:''
            if(item.length==1){
                this.form.content = item[0].content
                this.blade = item[0].blade
                this.preview_url = this.url('/preview_email/')+this.form.template+((this.form.client_id)?'?client_id='+this.form.client_id:'')
            }
        },
        written_mode(){
            this.content_mode='written_mode'
        },
        preview_mode(){
            this.content_mode='preview_mode'
            this.check_template_id_by_content()
        },
        check_template_id_by_content(){
            let o = this.template_list.filter(i => i.content==this.form.content)
            this.form.template = (o.length==0)?0:o[0].value
        },
        get_client_info(o){
            let _this = this
            this.myGet(function(response){
                _this.client_info = response
            },{client_id:o.client_id},this.url('/api/client_info'))
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

<style>
.email_bg{
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
.embed-responsive{
    width: 561px;
    height: 431px;
    top: 125px;
    left: 20px;
}
@media (min-width: 992px){
    #email .modal-lg, .modal-xl,
    #group_email .modal-lg, .modal-xl {
        max-width: 950px;
    }
}
</style>