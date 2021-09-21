<template>
    <div>
        <b-button v-b-modal.client_chooser class="w-100" :disabled="disabled">{{return_text}}</b-button>
        <b-modal id="client_chooser" size='xl' title="請選擇客戶">
            <b-row>
                <b-col cols="4">
                    <b-form-group label="依業務" v-slot="{ ariaDescribedby }">
                        <b-form-checkbox-group
                            id="ae"
                            v-model="form.selected_ae"
                            :options="ae_options"
                            :aria-describedby="ariaDescribedby"
                            @change="onChange"
                        ></b-form-checkbox-group>
                    </b-form-group>
                </b-col>
                <b-col cols="8">
                    <b-form-group v-for="(v,k) in cate_options" :key="k" :label="k" v-slot="{ ariaDescribedby1 }">
                        <b-form-checkbox-group
                            id="client_cate"
                            v-model="form.selected_cate"
                            :options="v"
                            :aria-describedby="ariaDescribedby1"
                            name="flavour-1"
                            @change="onChange"
                        ></b-form-checkbox-group>
                    </b-form-group>
                </b-col>
            </b-row>
                <b-table :items="items" :fields="fields">

                </b-table>
            <hr />

            <!-- <hr />
            <b-form-group label="地區" v-slot="{ ariaDescribedby2 }">
                <b-form-checkbox-group
                    id="locale"
                    v-model="selected_locale"
                    :options="locale_options"
                    :aria-describedby="ariaDescribedby2"
                ></b-form-checkbox-group>
            </b-form-group> -->
        </b-modal>
    </div>
</template>

<script>
import axios from "../mixins/mixin_post"
export default {
    mixins: [axios],
    props: ['value','disabled'],
    data(){
        return {
            form:{
                selected_ae: [],
                selected_cate: [],
            },
            selected_locale: ['zn','hk','others'],
            ae_options:[],
            cate_options:{
                '依方案':[
                    {text:'現金帳戶',value:'cash'},
                    {text:'拚一手',value:'authorize_deposit'},
                    {text:'拳頭打新',value:'authorize'},
                ],
                '依客戶狀態':[
                    {text:'活躍',value:'active'},
                    {text:'銷戶',value:'closed'},
                    {text:'暫停交易',value:'suspend'},
                    {text:'未完成開戶',value:'opening'},
                ]
            },
            locale_options:[
                {text:'大陸地區',value:'zn'},
                {text:'香港地區',value:'hk'},
                {text:'其他國家',value:'others'},
            ],
            fields:[],
            items:[],
        }
    },
    computed:{
        cate(){
            return this.cate_options['客戶'].concat(this.cate_options['非客戶'])
        },
        return_text(){
            let _this=this
            let a=[]
            this.selected_cate.map(function(v){
                let arr = _this.cate.filter(i=>i.value==v)
                if(arr.length>0) a.push(arr.map(i => i.text))
            })
            return (a.length==0)?'請選擇客戶':a.join(',')
        }
    },
    created(){
        this.selected_cate = this.value
        let _this=this
        this.myGet(function(response){
            _this.ae_options=response
        },null,this.url('/list/ae'))
    },
    methods:{
        onChange(){
            let _this=this
            let formData = this.getFormData();
            this.myPost(function(response){

            },formData,this.url('/list/clients'))
            this.$emit('pick_clients', this.form)
        }
    }
}
</script>