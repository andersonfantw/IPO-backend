<template>
    <div>
        <b-button v-b-modal.client_chooser class="w-100" :disabled="disabled">{{return_text}}</b-button>
        <b-modal id="client_chooser" size='xl' title="請選擇客戶">
            <b-row>
                <b-col cols="4">
                    <b-form-group label="依方案" v-slot="{ ariaDescribedby }">
                        <b-form-checkbox-group
                            id="plan"
                            v-model="form.selected_plan"
                            :options="cate_options['依方案']"
                            :aria-describedby="ariaDescribedby"
                            @change="onChange"
                            :disabled="form.selected_not_client!=''"
                        ></b-form-checkbox-group>
                    </b-form-group>
                    <b-form-group label="依客戶狀態" v-slot="{ ariaDescribedby }">
                        <b-form-checkbox-group
                            id="client_status"
                            v-model="form.selected_status"
                            :options="cate_options['依客戶狀態']"
                            :aria-describedby="ariaDescribedby"
                            name="flavour-1"
                            @change="onChange"
                            :disabled="form.selected_not_client!=''"
                        ></b-form-checkbox-group>
                    </b-form-group>
                    <b-form-group label="帳戶類別" v-slot="{ ariaDescribedby }">
                        <b-form-checkbox-group
                            id="client_cate"
                            v-model="form.selected_cate"
                            :options="cate_options['帳戶類別']"
                            :aria-describedby="ariaDescribedby"
                            name="flavour-1"
                            @change="onChange"
                            :disabled="form.selected_not_client!=''"
                        ></b-form-checkbox-group>
                    </b-form-group>
                </b-col>
                <b-col cols="6">
                    <b-form-group label="依業務" v-slot="{ ariaDescribedby }">
                        <b-form-checkbox-group
                            id="ae"
                            v-model="form.selected_ae"
                            :options="ae_options"
                            :aria-describedby="ariaDescribedby"
                            @change="onChange"
                            :disabled="form.selected_plan!='plan1'"
                        ></b-form-checkbox-group>
                    </b-form-group>
                    <b-form-group label="風險承受等級" v-slot="{ ariaDescribedby }">
                        <b-form-checkbox-group
                            id="client_risk"
                            v-model="form.selected_risk"
                            :options="cate_options['風險承受等級']"
                            :aria-describedby="ariaDescribedby"
                            name="flavour-1"
                            @change="onChange"
                            :disabled="form.selected_plan!='plan2'"
                        ></b-form-checkbox-group>
                    </b-form-group>
                    <b-form-group label="非客戶" v-slot="{ ariaDescribedby }">
                        <b-form-checkbox-group
                            id="opening"
                            v-model="form.selected_not_client"
                            :options="cate_options['非客戶']"
                            :aria-describedby="ariaDescribedby"
                            @change="onChange"
                        ></b-form-checkbox-group>
                    </b-form-group>
                </b-col>
                <b-col cols="2">
                    <b-button variant="info" class="text-white" @click="reset">重設條件</b-button>
                </b-col>
            </b-row>
            <b-row no-gutters>
                <b-col>
                    <b-pagination-nav
                        v-model="pagination.current_page"
                        :number-of-pages="pagination.last_page"
                        base-url="#"
                        use-router align="center"
                    ></b-pagination-nav>
                </b-col>
            </b-row>
            <b-row no-gutters>
                <b-col>
                    <span>選取{{pagination.total}}個客戶</span>
                    <b-table :items="items" :fields="fields" sticky-header></b-table>
                </b-col>
            </b-row>
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
            form:{},
            selected_locale: ['zn','hk','others'],
            ae_options:[],
            cate_options:{
                '依方案':[
                    {text:'拚一手',value:'plan1'},
                    {text:'拳頭打新',value:'plan2'},
                ],
                '依客戶狀態':[
                    {text:'暫停交易',value:'S'},
                    {text:'銷戶',value:'C'},
                ],
                '帳戶類別':[
                    {text:'委託帳戶',value:'authorize'},
                    {text:'現金帳戶',value:'cash'},
                ],
                '風險承受等級':[
                    {text:'高',value:'HH'},
                    {text:'中高',value:'MH'},
                    {text:'中',value:'MM'},
                    {text:'中低',value:'LM'},
                ],
                '非客戶':[
                    {text:'未完成開戶',value:'opening'}
                ],
            },
            locale_options:[
                {text:'大陸地區',value:'zn'},
                {text:'香港地區',value:'hk'},
                {text:'其他國家',value:'others'},
            ],
            pagination:{
                current_page: 1,
                last_page: 1,
                total: 0,
                path: ''
            },
            fields:[
                {key: 'client_id', label: '帳號'},
                {key: 'name', label: '姓名'},
                {key: 'phone', label: '電話'},
            ],
            items:[],
        }
    },
    computed:{
        cate(){
            return this.cate_options['客戶'].concat(this.cate_options['非客戶'])
        },
        return_text(){
            return (this.pagination.total==0)?'請選擇客戶':'已選擇'+this.pagination.total+'人'
        }
    },
    watch: {
        'pagination.current_page': function(n){
            this.onChange()
        }
    },
    created(){
        this.reset()
        let _this=this
        this.myGet(function(response){
            _this.ae_options=response
        },null,this.url('/list/ae'))

        this.selected_cate = this.value
    },
    methods:{
        reset(){
            this.form={
                selected_plan: [],
                selected_ae: [],
                selected_not_client: [],
                selected_status: [],
                selected_cate: [],
                selected_risk: [],
            }
            this.onChange()
        },
        onChange(){
            this.$bus.$emit('pick_clients', this.form)

            let _this=this
            let formData = this.getFormData();
            this.myPost(function(response){
                _this.items = response.data
                _this.pagination.total = response.total
                _this.pagination.last_page = response.last_page
                _this.pagination.base_url = response.path + '?page='               
            },formData,this.url('/list/clients?page='+this.pagination.current_page))
        }
    }
}
</script>
<style>
#client_chooser .page-item .page-link{
    background-color: #fff;
}
#client_chooser .page-item.active .page-link{
    color: #3490dc;
}
#client_chooser .table.b-table > thead > tr > .table-b-table-default{
    background-color: #fff;
}
</style>