<template>
    <b-modal
    :id="id"
    :title="title"
    @ok="$emit('ok')"
    @cancel="$emit('cancel')"
    @close="$emit('close')">
        <template #default>
            <div v-if="edit_model=='reject'">
                <span>說明</span>
                <b-form-textarea></b-form-textarea>
            </div>
            <div v-else>
                <span>資金來源</span>
                <b-form-input v-model="form.channel" list="channel" placeholder="請輸入資金來源"></b-form-input>
                <datalist id="channel">
                    <option>CYSS</option>
                    <option>CMBI</option>
                </datalist>
                <span>手續費</span>
                <b-form-input type="number" v-model="form.interest_cost" placeholder="請輸入手續費"></b-form-input>
                <span>天數</span>
                <b-form-input type="number" v-model="form.interest_day" placeholder="請輸入天數"></b-form-input>
                <span>利率</span>
                <b-form-input type="number" v-model="form.interest_rate" placeholder="請輸入利率"></b-form-input>
            </div>
        </template>
        <template #modal-footer="{ audit, reject }">
            <b-button size="sm" variant="secondary" v-if="edit_model==''" @click="edit_model='reject'">駁回</b-button>
            <b-button size="sm" variant="success" v-if="edit_model==''" @click="audit()">簽名</b-button>
            <b-button size="sm" variant="secondary" v-if="edit_model=='reject'" @click="edit_model=''">取消</b-button>
            <b-button size="sm" variant="success" v-if="edit_model=='reject'" @click="reject()">送出</b-button>
        </template>
    </b-modal>
</template>

<script>
import axios from "../mixins/mixin_post"
import validator from "../mixins/mixin_validators";
export default {
    mixins:[axios,validator],
    name:'ipo_interest_setting',
    props: ['mode','id','title','value'],
    data(){
        return {
          edit_model: '',
          form:{
              channel: '',
              interest_cost: '',
              interest_day: '',
              interest_rate: '',
              remark: ''
          },
        }
    },
    watch: {
        mode: function(v){
            if(v=='setting') Object.keys(this.form).forEach(i => this.form[i]='')
        },
        value: function(v){
            Object.keys(this.form).forEach(i => this.form[i]=v[i])
        }
    },
    methods: {
        // alert
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
        },
        store(){
            let _this = this
            let formdata = this.getFormData()
            this.crudStore(function(response){
                _this.index()
            }, formdata);
        },
        update(){
            let formdata = this.getFormData();
            this.crudUpdate(this.form.id, function(response){

            }, formdata);
        },
        show(item){
            ['channel','interest_cost','interest_day','interest_rate','remark'].forEach(i => this.edit_form[i]=item[i])
            this.edit_model=''
        },
        del(){
            let _this = this
            this.crudDestroy(this.form.id,function(response){
                _this.index()
            })
        },
        audit(){

        },
        reject(){

        },
        upload(){

        },
        cancel(){
            this.$emit('cancel')
            this.$bvModal.hide(this.id)
        }
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
#ipo_interest_list summary{
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 450px;
    min-width: 250px;
}
</style>