<template>
    <div>
        <b-button v-b-modal.client_chooser class="w-100" :disabled="disabled">{{text}}</b-button>
        <b-modal id="client_chooser" title="請選擇客戶">
            <b-form-group label="選擇客戶類別" v-slot="{ ariaDescribedby }">
                <b-form-radio-group
                    id="client_type"
                    v-model="selected_type"
                    :options="type_options"
                    :aria-describedby="ariaDescribedby"
                ></b-form-radio-group>
            </b-form-group>
            <hr />
            <b-form-group :label="selected_type" v-slot="{ ariaDescribedby1 }">
                <b-form-checkbox-group
                    id="client_cate"
                    v-model="selected_cate"
                    :options="cate_options[selected_type]"
                    :aria-describedby="ariaDescribedby1"
                    name="flavour-1"
                    @change="$emit('input', selected_cate_by_type)"
                ></b-form-checkbox-group>
            </b-form-group>
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
            selected_type: '客戶',
            selected_cate: [],
            selected_locale: ['zn','hk','others'],
            type_options:[
                {text:'客戶',value:'客戶'},
                {text:'非客戶',value:'非客戶'},
            ],
            cate_options:{
                '客戶':[
                    {text:'現金帳戶',value:'cash'},
                    {text:'全權委託有入金',value:'authorize_deposit'},
                    {text:'全權委託無入金',value:'authorize'},
                    {text:'暫停交易',value:'suspend'},
                ],
                '非客戶':[
                    {text:'未完成開戶系統客戶',value:'open'},
                    {text:'銷戶客戶',value:'cancel'}
                ]
            },
            locale_options:[
                {text:'大陸地區',value:'zn'},
                {text:'香港地區',value:'hk'},
                {text:'其他國家',value:'others'},
            ]
        }
    },
    computed:{
        selected_cate_by_type(){
            let arr = this.cate_options[this.selected_type].map(i => i.value)
            return arr.filter(i => this.selected_cate.indexOf(i)!==-1)
        },
        text(){
            let arr = this.cate_options[this.selected_type].filter(i => this.selected_cate_by_type.indexOf(i.value)!==-1)
            return (this.selected_cate_by_type.length>0)?arr.map(i => i.text).join(','):'請選擇客戶'
        }
    },
    created(){
        this.selected_cate = this.value
    }
}
</script>