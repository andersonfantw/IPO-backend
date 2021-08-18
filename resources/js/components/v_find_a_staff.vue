<template>
    <b-input-group :size="_component_size">
        <b-input :id="_id" :ref="_id" :size="_component_size" :list="_id+'client_list'" v-model="find_a_staff.staff_id" @keyup="find_staff" :value="value" @input="$emit('input', find_a_staff.staff_id)" placeholder="四位數字後自動檢索" :disabled="disabled"></b-input>
        <b-input :class="_showbutton?'':'rounded-right'" :size="_component_size" v-model="find_a_staff.staff_name" disabled></b-input>
        <datalist :id="_id+'client_list'">
            <option v-for="client in find_staff_list" :key="client['staff_id']" :value="client['staff_id']">{{ client['name'] }}</option>
        </datalist>
        <b-input-group-append v-if="_showbutton">
            <b-button :size="_component_size" class="w-100" @click="add" variant="primary" :disabled="busy">
                <i class="fas fa-user-plus" variant="secondary"></i> &nbsp;新增人員
            </b-button>
        </b-input-group-append>
    </b-input-group>
</template>

<script>
import axios from "../mixins/mixin_post"
export default {
    mixins: [axios],
    props: ['value','id','size','showbutton','disabled'],
    data(){
        return {
            busy:false,
            find_staff_list:[],
            find_a_staff:{
                staff_id:'',
                staff_name:''
            }
        }
    },
    created(){
        this.find_a_staff.staff_id = this.value
        this.find_staff()
        this.$bus.$on('busy',this.busy)
    },
    beforeDestroy(){
        this.$bus.$off("busy");
    },
    watch:{
        'find_a_staff.staff_id': function(n){
            let arr = this.find_staff_list.filter(function(i){
                return i.staff_id==n
            })
            if(arr.length) this.find_a_staff.staff_name = arr[0].name
            else this.find_a_staff.staff_name = ''
            // 沒有button，選定後用事件回傳
            if(!this._showbutton && this.find_a_staff.staff_name!='') this.$bus.$emit('find_a_staff::staff',this.find_a_staff)
        }
    },
    computed:{
        // prop default
        _id(){ return this.id?this.id:'find_a_staff' },
        _component_size(){ return this.size?this.size:'' },
        _showbutton(){ return !(this.showbutton=='false') }
    },
    methods:{
        add(){
            this.$bus.$emit('find_a_staff::add',this.find_a_staff)
        },
        find_staff(){
            let _this = this
            if(this.find_a_staff.staff_id){
                if(this.find_a_staff.staff_id.length>3){
                    this.myPost(function(response){
                        _this.find_staff_list = response
                    },{acc_no:_this.find_a_staff.staff_id},this.url('/find/client'));
                }
            }
        }
    }
}
</script>