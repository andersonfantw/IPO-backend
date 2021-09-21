<template>
        <b-modal
        :id="id"
        size="xl"
        @ok="$emit('ok')"
        @cancel="$emit('cancel')"
        @close="$emit('close')"
        @show="reset"
        @hidden="reset"
        centered lazy>
            <template #modal-header>
                <h3 class="mb-0"><i class="fas fa-tools"></i> 發送中籤通知</h3>
            </template>
            <template #modal-footer>
                <b-button @click="close()" :disabled="busy">Cancel</b-button>
                <b-button variant="primary" v-if="step>1" @click="--step" :disabled="busy">上一步</b-button>
                <b-button variant="primary" v-if="step<4" 
                    :disabled="step==2 && (items1.length+items2.length+items3.length)==0"
                    @click="++step">下一步 <b-spinner v-if="form.file!=null && (items1.length+items2.length+items3.length)==0" small label="Loading..."></b-spinner>
                </b-button>
                <b-overlay :show="busy" rounded="sm">
                    <b-button variant="primary" v-if="step==4" @click="store">發送</b-button>
                </b-overlay>
            </template>
            <b-row v-if="step==1">
                <b-col cols="3" v-for="(v,index) in steps" :key="index" :class="(index==(step-1))?'font-weight-bold':''">{{v}}</b-col>
                <b-col cols="12" class="my-2" v-if="mode=='group'">
                    <label for="receiver">選擇客戶 / 上傳檔案</label>
                    <b-form-file id="file-default" v-model="form.file"></b-form-file>
                </b-col>
            </b-row>
            <b-row v-if="step==2">
                <b-col cols="3" v-for="(v,index) in steps" :key="index" :class="(index==(step-1))?'font-weight-bold':''">{{v}}</b-col>
                <b-col cols="12">
                    <br />
                    <b-card no-body>
                        <b-tabs pills card>
                            <b-tab :title="'中籤 '+items1.length" active>
                                <b-card-text>
                                    <b-table :fields="fields" :items="items1"></b-table>
                                </b-card-text>
                            </b-tab>
                            <b-tab :title="'中籤補差額 '+items2.length">
                                <b-card-text>
                                    <b-table :fields="fields" :items="items2"></b-table>
                                </b-card-text>
                            </b-tab>
                            <b-tab :title="'未中籤 '+items3.length">
                                <b-card-text>
                                    <b-table :fields="fields" :items="items3"></b-table>
                                </b-card-text>
                            </b-tab>
                        </b-tabs>
                    </b-card>
                </b-col>
            </b-row>
            <b-row v-if="step==3">
                <b-col cols="3" v-for="(v,index) in steps" :key="index" :class="(index==(step-1))?'font-weight-bold':''">{{v}}</b-col>
                <b-col cols="12">
                    <br />
                    <b-card-group deck>
                        <b-card v-for="(v,k) in template_list" :key="k" :header="'[範例] '+v.text">
                            <b-card-text v-text="replaceParams(v.value,v.content)"></b-card-text>
                        </b-card>
                    </b-card-group>
                </b-col>
            </b-row>
            <b-row v-if="step==4">
                <b-col cols="3" v-for="(v,index) in steps" :key="index" :class="(index==(step-1))?'font-weight-bold':''">{{v}}</b-col>
                <b-col cols="12" class="text-center">
                    <hr />
                    <h3>您確定要建立中籤通知任務嗎?</h3>
                </b-col>
            </b-row>
        </b-modal>
</template>

<script>
import axios from "../mixins/mixin_post"
export default {
    mixins: [axios],
    props:['id','mode'],
    data(){
        return {
            steps:['步驟一: 上傳中籤csv','步驟二: 檢視中籤、中籤補差額、未中籤名單','步驟三: 檢視訊息','步驟四: 確認發送'],
            step: 1,
            fields: ['product_id','product_name','client_id','client_name','ae_code','actual_qty','loan_amt'],
            items1: [],
            items2: [],
            items3: [],
            template_list:[],
            form:{},
            busy: false,
            content_mode: 'written_mode',
        }
    },
    computed:{
        name(){
            return (this.mode=='')?'notify_client':'notify_group'
        },
    },
    watch:{
        'form.file': function(v){
            this.uploadCustomizeNoticeList(v)
        }
    },
    created(){
        this.reset()
    },
    methods:{
        reset(){
            this.items1=[]
            this.items2=[]
            this.items3=[]
            this.form={
                _route:'alloted_notice',
                template:0,
                content:'自主打新的 中籤/中籤有欠款/未中籤 通知',
                file:null
            }
            this.step=1
        },
        get_template_list(){
            let _this = this
            this.myGet(function(response){
                _this.template_list = response
            },{mode:'alloted_notice'},this.url('/template_list'))
        },
        uploadCustomizeNoticeList(v){
            let _this = this
            let formData = this.getFormData()
            this.myPost(function(response){
                _this.items1 = response.alloted
                _this.items2 = response.alloted_margin
                _this.items3 = response.unalloted
                _this.get_template_list()
            },formData,this.url('/notify_group/uploadCustomizeNoticeList'))
        },
        replaceParams(id,msg){
            let s = msg
            let item = {}
            switch(id){
                case 5:
                    if(this.items3.length>0) item = this.items3[0];
                    break;
                case 6:
                    if(this.items2.length>0) item = this.items2[0];
                    if(this.items1.length>0) item = this.items1[0];
                    break; 
            }
            for(const [k,v] of Object.entries(item)){s=s.replace(k,v)}
            return s
        },
        index(){
        },
        store(){
            this.busy = true
            let _this = this
            let formdata = this.getFormData();
            this.crudStore(function(response){
                if(response.ok){
                    _this.busy = false
                    _this.$bvModal.hide(_this.id)
                    _this.$emit('close',_this.form.client_id)
                }
            },formdata,'/'+this.name);
        },
        close(){
            this.reset()
            this.$bvModal.hide(this.id)
        }
    }
}
</script>