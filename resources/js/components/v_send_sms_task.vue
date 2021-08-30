<template>
    <b-modal
    :id="id"
    size="lg"
    @ok="$emit('ok')"
    @cancel="$emit('cancel')"
    @close="$emit('close')"
    centered>
        <template #modal-header>
            <h3 class="mb-0"><i class="fas fa-sms"></i> 發送簡訊</h3>
        </template>
        <template #modal-footer="{ cancel }">
            <b-button @click="cancel()">Cancel</b-button>
            <b-button variant="primary" v-b-modal.create>OK</b-button>
        </template>
        <b-overlay :show="sending" rounded="sm">
            <template #overlay>
                <img src="images/smsg3.gif" width="400" />
            </template>
            <b-row>
                <b-col cols="7" class="my-2">
                    <div class="sms_bg" :style="{'background-image': 'url('+sms_bg+')'}">
                        <div class="phone" :style="{'background-image': 'url('+phone_frame+')'}">
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
                            <textarea v-model="form.content" maxlength="120" class="sms_content" ref="sms_content" @keyup="autogrow" @blur="check_template_id_by_content"></textarea>
                            <a class="sms_send" v-b-modal.create href="javascript:;"><i class="fas fa-arrow-circle-up"></i></a>
                        </div>
                    </div>
                </b-col>
                <b-col cols="5" class="my-2">
                    <b-row no-gutters>
                        <b-col cols="12" class="my-2">
                            <label for="template" class="text-center d-block">樣  板</label>
                            <b-form-select id="template" v-model="form.template" :options="template_list" @change="show_template"></b-form-select>
                        </b-col>
                        <b-col cols="12" class="my-2" v-if="mode!='group'">
                            <label for="receiver" class="text-center d-block">收 件 人</label>
                            <div class="form-row">
                                <div class="form-group col-2 d-flex align-items-center">
                                    客戶
                                </div>
                                <div class="form-group col-10">
                                    <find-a-client id="receiver" v-model="form.client_id" showbutton="false" :disabled="form.mobile!=''"></find-a-client>
                                </div>
                            </div>
                            <div class="divider">or</div>
                            <div class="form-row">
                                <div class="form-group col-2 d-flex align-items-center" style="line-height: 17px;">
                                    手機號碼
                                </div>
                                <div class="form-group col-10">
                                    <b-input id="mobile" v-model="form.mobile" :disabled="form.client_id!=''"></b-input>
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
                                    <b-form-file id="client-list-file" v-model="form.file" :disabled="form.groups.length>0"></b-form-file>
                                </div>
                            </div>
                        </b-col>
                        <b-col cols="12" class="my-2" v-if="mode=='group'">
                            <label for="import_example" class="text-center d-block">格式範例</label>
                            <notification-import-excel-format-example route="sms" :mode="mode"></notification-import-excel-format-example>
                        </b-col>
                    </b-row>
                    <b-alert :show="has_forbidden_words" dismissible fade variant="warning"><p>提示禁用詞不會影響簡訊發送，最終由簡訊系統商驗證簡訊內容。依中國短訊非法字庫預先檢核簡訊內容，亦會突然新增非法詞語而趕不及更新字庫，只可透過短訊狀態錯誤碼得知，並聯絡客戶服務部查詢新增的非法詞語。</p></b-alert>
                </b-col>
            </b-row>
            <!-- Create Task -->
            <b-modal id="create" title="提示" @ok="store">
                <p class="my-4" v-if="mode=='group'">您確定要建立任務嗎?</p>
                <p class="my-4" v-else>您確定要送出嗎?</p>
            </b-modal>
        </b-overlay>
    </b-modal>
</template>

<script>
import axios from "../mixins/mixin_post"
export default {
    name:'send_sms_task',
    mixins: [axios],
    props:['id','mode','value','item'],
    data(){
        return {
            sending: false,
            forbidden_words:['提款'],
            template_list:[{value:1,text:'中籤通知',content:'您申購的新股奈雪的茶，抽中500股。'}],
            client_info:{},
            form:{
                _route:'sms',
                groups:[],
                file:null,
                client_id: this.value,
                template:0,
                mobile:'',
                content:''
            },
        }
    },
    computed:{
        sms_bg(){
            return process.env.MIX_BASE_PATH+'/images/sms.png'
        },
        phone_frame(){
            return process.env.MIX_BASE_PATH+'/images/iphone.png'
        },
        name(){
            return (this.mode=='')?'notify_client':'notify_group'
        },
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
        sms_content(){
            let s = this.form.content
            for(const [k,v] of Object.entries(this.client_info)){s=s.replace(k,v)}
            return s
        },
        sms_content1(){
            if(this.sms_content.length<=60){
                let s = this.mark_forbidden_words(this.sms_content)
                return s.replaceAll("\n",'<br />')
            }
            let s = this.mark_forbidden_words(this.sms_content.substring(0,60))
            return s.replaceAll("\n",'<br />')
        },
        sms_content2(){
            if(this.sms_content.length<=60) return ''
            let s = this.mark_forbidden_words(this.sms_content.substring(60))
            return s.replaceAll("\n",'<br />')
        },
        has_forbidden_words(){
            return (this.sms_content1+this.sms_content2).indexOf('</del>')>-1
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
    beforeDestroy(){
        this.$bus.$off("find_a_client::client");
    },
    methods:{
        autogrow(){
            if(this.form.content.length>120) return
            let obj = this.$refs.sms_content
            let l = this.form.content.split("\n").length
            obj.style.height = (l==1 && this.form.content.length<=18)?'35px':(l*24)+'px'
            let adjustedHeight=Math.max(obj.scrollHeight,obj.clientHeight,obj.offsetHeight,35)
            if (adjustedHeight>obj.clientHeight) obj.style.height=adjustedHeight+'px'
        },
        get_template_list(){
            let _this = this
            this.myGet(function(response){
                _this.template_list = response
                _this.template_list.unshift({text:'自訂文案',value:0})
            },{mode:(this.mode)?'group_sms':'sms'},this.url('/template_list'))
        },
        get_forbidden_words(){
            let _this = this
            this.myGet(function(response){
                _this.forbidden_words = response
            },[],this.url('/forbidden_words'))
        },
        mark_forbidden_words(s){
            this.forbidden_words.forEach(function(item){s=s.replaceAll(item,'<del class="text-danger">'+item+'</del>')})
            return s
        },
        show_template(){
            let item = this.template_list.filter(t => t.value==this.form.template)
            this.form.content = (item[0].value)?item[0].content:''
            this.autogrow()
        },
        check_template_id_by_content(){
            let o = this.template_list.filter(i => i.content==this.form.content)
            this.form.template = (o.length==0)?0:o[0].value
        },
        get_client_info(o){
            let _this = this
            this.myGet(function(response){
                _this.client_info = response
            },{client_id:o.client_id},this.url('/client_info'))
        },
        index(){
            this.get_template_list()
            this.get_forbidden_words()
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
.sms_bg{
    width: 463px;
    height: 862px;
    background-repeat: no-repeat;
    background-size: 80%;
    background-position: 59px 20px;
    margin-left: -16px;
}
.phone{
    position: relative;
    width: 100%;
    height: 100%;
}
.time{
    position: relative;
    top: 24px;
    left: 84px;
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
    border-radius: 20px;
    outline: none;
    padding: 5px 30px 5px 10px;
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
</style>